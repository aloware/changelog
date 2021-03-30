<template>
    <div class="container mt-5" v-bind:class="{ openEditor : showChangelogEditor }">
        <b-overlay
            :show="showOverlay"
            rounded="sm"
            :opacity="0.42"
        >
            <div class="row changelogs-container">
                <div class="col-12">
                    <div class="module-heading">
                        <h5 class="mt-3">{{ getHeaderLabel }}</h5>
                        <div class="action-buttons" v-if="!showChangelogEditor">
                            <b-button variant="primary" v-on:click="createChangelog">
                                <font-awesome-icon :icon="['fas', 'plus']"/>
                                Create Changelog
                            </b-button>
                            <b-dropdown id="dropdown-1" text="Options" class="m-md-2" right>
                                <b-dropdown-item v-bind:href="'/project/' + getParsedProjectData.uuid + '/settings'">
                                    <font-awesome-icon :icon="['fas', 'cog']"/>
                                    Project Settings</b-dropdown-item>
                                <b-dropdown-item v-bind:href="'/' + getParsedProjectData.uuid + '/changelogs'" target="_blank">
                                    <font-awesome-icon :icon="['fas', 'eye']"/>
                                    View Public Page</b-dropdown-item>
                            </b-dropdown>
                        </div>
                    </div>
                    <hr>
                    <changelog-component :changelog="changelog" v-if="showChangelogEditor && !changelog.id"></changelog-component>
                    <div v-for="(item, index) in changelogs.slice().reverse()" :key="item.id">
                        <changelog-component :changelog="item" v-if="!showChangelogEditor || item.id === changelog.id"></changelog-component>
                    </div>

                    <b-card class="text-center" v-if="changelogs.length < 1 && !showChangelogEditor && fetched">
                        <b-card-text class="text-strong">
                            Time to start a changelog!
                        </b-card-text>

                        <b-card-text class="text-muted">
                            Surely there's much to tell your users about the new things or even updates and fixes in your application.
                        </b-card-text>
                    </b-card>
                </div>
            </div>
            <template #overlay>
                <div class="text-center">
                    <font-awesome-icon :icon="['fas', 'spinner']" spin />
                    <p id="cancel-label">{{ overlayMessage }}</p>
                </div>
            </template>
        </b-overlay>
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
            showOverlay : false,
            overlayMessage : '',
            fetched : false
        }
    },
    computed : {
        ...mapGetters(['changelogs', 'changelog', 'showChangelogEditor', 'project']),
        getParsedProjectData : function(){
            return JSON.parse(this.unparsed_project);
        },

        getHeaderLabel : function(){
            let labelText;
            switch (true) {
                case this.changelog.id && this.showChangelogEditor:
                    labelText = 'Edit Changelog';
                    break;
                case !this.changelog.id && this.showChangelogEditor:
                    labelText = 'Add Changelog';
                    break;
                default:
                    labelText = 'Changelogs';
            }

            return labelText;
        }
    },
    methods : {
        ...mapActions(['getChangelogs', 'addChangelog', 'toggleChangelogEditor', 'getCategories', 'setProject']),
        createChangelog : function(){
            this.addChangelog();
        }
    },
    mounted() {
        this.setProject(this.getParsedProjectData);
        this.getCategories(this.project.company_id);
        this.overlayMessage = 'Getting your changelogs...';
        this.showOverlay = true;
        this.getChangelogs(this.project.uuid).then(response => {
            this.showOverlay = false;
            this.overlayMessage = '';
            this.fetched = true;
        });
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

    .changelogs-container {
        overflow: hidden;
        height: 100%;
    }

    .module-heading {
        display: flex;
        justify-content: space-between;
    }
</style>
