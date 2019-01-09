<template>
    <modal>
        <div slot="header">
            <h3>Importovat z ostatních tříd</h3>
            <small>zatím pouze dle kódu</small>
        </div>
        <div slot="body" style="padding:0px">
            <div class="form-group">
                <label class="label">Přidat</label>
                <importsel></importsel>
            </div>
        </div>
    </modal>
</template>

<script>
    import Importsel from "./importsel";
    export default {
        name: "importStudents",
        components: {Importsel}
    }
</script>

<style scoped>

</style>