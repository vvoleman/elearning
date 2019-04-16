<div class="col-md-3 col-lg-2 sidebar">
    <div class="name" style="padding-top:10px">
        {{$c->name}}
        <a href="{{route('course.course',$c->slug)}}" ><span class="small d-block"><h6>zpět do kurzu</h6></span></a>
    </div>
    <hr>
    <div class="m-top-2 list">
        <a href="{{route('course.editCourse',$c->slug)}}">
            <div class="d-flex align-items-center box">
                <div class="col-3 d-flex justify-content-center">
                    <i class="fas fa-home "></i>
                </div>
                <span class="offset-0">Úvod</span>
            </div>
        </a>
        <a href="{{route('course.editLectors',$c->slug)}}">
            <div class="d-flex align-items-center box">
                <div class="col-3 d-flex justify-content-center">
                    <i class="fas fa-chalkboard-teacher "></i>
                </div>
                <span class="offset-0">Lektoři</span>
            </div>
        </a>
        <a href="{{route('course.editGroups',$c->slug)}}">
            <div class="d-flex align-items-center box">
                <div class="d-flex justify-content-center col-3">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <span class="offset-0">Třídy</span>
            </div>
        </a>
        <a href="{{route('course.editSettings',$c->slug)}}">
            <div class="d-flex align-items-center box">
                <div class="d-flex justify-content-center col-3">
                    <i class="fas fa-cog"></i>
                </div>
                <span class="offset-0">Nastavení</span>
            </div>
        </a>
    </div>
</div>
