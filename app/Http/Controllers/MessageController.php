<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Own\Toolkit;

class MessageController extends Controller
{
    private $toolkit;

    public function __construct()
    {
        $this->toolkit = new Toolkit();
    }
    public function getMessenger()
    {
        $this->getMessagesByAjax();
        return view('messages/messenger');
    }
    private function parseMessages($msgs)
    {
        $pass = [];
        foreach ($msgs as $m) {
            $pass[] = [
                "my_id" => Auth::user()->id_u,
                "msg_id" => $m->id_m,
                "title" => $m->title,
                "receivers" => $this->toolkit->parseUsers($m->receivers),
                "author" => $this->toolkit->parseUsers([User::find($m->author_id)])[0],
                "sent" => strtotime($m->sent_at),
                "message" => $m->message,
                "seen" => (empty($m->pivot->seen)) ? false : true
            ];
        }
        return $pass;
    }
    public function getMessagesByAjax()
    {
        try {
            $data = Auth::user()->messages;
            return response()->json($this->parseMessages($data));
        } catch (\Exception $e) {
            return "This place is protected you scum!";
        }
    }
    public function postMarkAsSeen(Request $r)
    {
        $response = "";
        if (empty($r->msg_id) || empty($r->id) || empty($r->boolean)) {
            $response = 422;
        } else {
            if ($r->id != Auth::user()->id_u) {
                $response = 403;
            } else {
                $message = Auth::user()->messages()->find($r->msg_id);
                if ($r->boolean) {
                    $message->pivot->seen = \DB::raw('CURRENT_TIMESTAMP');
                } else {
                    $message->pivot->seen = null;
                }
                if ($message->pivot->save()) {
                    $response = 200;
                } else {
                    $response = 500;
                }
            }
        }
        return response()->json(["response" => $response]);
    }
    public function postMessage(Request $r)
    {
        $data = $r->data;
        if (empty($data["title"]) || strlen($data["title"]) > 32 || empty($data["message"]) || empty($data["receivers"])) {
            return response()->json(["response"=>422]);
        }
        $msg = new Message();
        $msg->author_id = Auth::user()->id_u;
        $msg->title = $data["title"];
        $msg->message = $data["message"];
        if($msg->save()){
            $msg->receivers()->attach($this->getUserModels($data["receivers"]));
            if($msg->save()){
                return response()->json(["response"=>200]);
            }
        }
        return response()->json(["response"=>500]);


    }
    private function getUserModels($data){
        $temp = [];
        foreach ($data as $d){
            $temp[] = $d["id"];
        }
        return $temp;
    }
    public function postReplyToGetMessenger(Request $r){
        dd($r);
    }
}
