<template>
    <div class="container" v-bind:class="{ openEditor : activeEditor }">
        <div class="row changelogs-container">
            <div class="col-12">
                <b-button variant="outline-primary" v-on:click="createChangelog" v-if="!activeEditor">Create Changelog</b-button>
                <hr v-if="!activeEditor">
                <changelog-component :changelog="changelog" v-if="activeEditor"></changelog-component>
                <div v-for="(item, index) in changelogs.slice().reverse()" :key="item.id">
                    <changelog-component :changelog="item" v-if="item.id !== changelog.id"></changelog-component>
                </div>

                <b-card class="text-center" v-if="changelogs.length < 1 && !activeEditor">
                    <b-card-text class="text-strong">
                        Time to start a changelog!
                    </b-card-text>

                    <b-card-text class="text-muted">
                        Surely there's much to tell your users about the new things or even updates and fixes in your application.
                    </b-card-text>
                </b-card>
            </div>
        </div>
        <div>
            <changelog-form-component></changelog-form-component>
        </div>
    </div>

</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    name : "ChangelogComponent.vue",
    props : {
        projectuuid : String,
        companyid : String
    },
    data : function(){
        return {

        }
    },
    computed : mapGetters(['changelogs', 'changelog', 'activeEditor']),
    methods : {
        ...mapActions(['getChangelogs', 'addChangelog', 'toggleEditor', 'getCategories', 'setProjectUuid']),
        createChangelog : function(){
            this.addChangelog();
        }
    },
    mounted() {
        this.setProjectUuid(this.projectuuid);
        this.getCategories(this.companyid);
        this.getChangelogs(this.projectuuid);
    }
}
</script>

<style scoped>
    .card {
        margin-bottom : 1.875rem;
    }
    .card-body {
        font-family: 'Lato', sans-serif;
    }

    .openEditor .changelogs-container {
        width: 40vw;
    }
</style>
