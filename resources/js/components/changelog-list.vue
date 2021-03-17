<template>
    <div class="container mt-5" v-bind:class="{ openEditor : showChangelogEditor }">
        <div class="row changelogs-container">
            <div class="col-12">
                <b-button variant="outline-success" v-on:click="createChangelog" v-if="!showChangelogEditor">
                    <font-awesome-icon :icon="['fas', 'plus']"/>
                    Create Changelog
                </b-button>
                <b-button variant="outline-success"  v-bind:href="'/project/' + getParsedProjectData.slug + '/settings'" v-if="!showChangelogEditor">
                    <font-awesome-icon :icon="['fas', 'sliders-h']"/>
                    Project Settings
                </b-button>
                <hr v-if="!showChangelogEditor">
                <changelog-component :changelog="changelog" v-if="showChangelogEditor && !changelog.id"></changelog-component>
                <div v-for="(item, index) in changelogs.slice().reverse()" :key="item.id">
                    <changelog-component :changelog="item"></changelog-component>
                </div>

                <b-card class="text-center" v-if="changelogs.length < 1 && !showChangelogEditor">
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
        unparsed_project : String,
    },
    data : function(){
        return {

        }
    },
    computed : {
        ...mapGetters(['changelogs', 'changelog', 'showChangelogEditor', 'project']),
        getParsedProjectData : function(){
            return JSON.parse(this.unparsed_project);
        }
    },
    methods : {
        ...mapActions(['getChangelogs', 'addChangelog', 'toggleEditor', 'getCategories', 'setProject']),
        createChangelog : function(){
            this.addChangelog();
        }
    },
    mounted() {
        this.setProject(this.getParsedProjectData);
        this.getCategories(this.project.company_id);
        this.getChangelogs(this.project.uuid);
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

    .container.openEditor {
        margin-left: 10px;
    }

    .openEditor .changelogs-container {
        width: 50vw;
    }
</style>
