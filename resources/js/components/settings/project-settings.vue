<template>
    <div>
        <div class="heading-container">
            <div class="heading-title">
                <h5 v-if="project.id">Project Settings</h5>
                <h5 v-if="!project.id">Add Project</h5>
            </div>

            <b-button variant="primary" v-if="project.id" v-bind:href="'/projects/' + project.uuid + '/changelogs'">
                Changelogs
            </b-button>
        </div>
        <hr/>

        <b-form @submit.stop.prevent="submitForm" class="mb-5">
            <b-form-group label="Name *">
                <b-form-input
                    placeholder="Name of this project"
                    v-model="project.name"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group label="URL *" description="e.g. http://www.your-domain.com">
                <b-form-input
                    placeholder="URL of this project"
                    v-model="project.url"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group label="Logo" v-if="project.id">
                <b-card
                    v-bind:img-src="projectLogo"
                    img-alt="Logo"
                    img-top
                    tag="article"
                    style="max-width: 20rem;"
                    class="mb-2 text-center"
                >
                    <avatar-cropper
                        @uploading="handleUploading"
                        @uploaded="handleUploaded"
                        @completed="handleCompleted"
                        @error="handlerError"
                        trigger="#pick-avatar"
                        v-bind:upload-url="'/project/' + project.uuid + '/logo'"
                        :labels="{submit: 'Upload', cancel: 'Cancel'}"
                        v-bind:withCredentials="true"
                    />

                    <button class="btn btn-primary btn-sm" id="pick-avatar" :disabled="uploadingLogo">
                        {{ uploadingLogo ? 'Uploading...' : 'Select a new image' }}
                    </button>
                </b-card>
            </b-form-group>

            <div v-if="project.id">
                <b-form-group label="Project UUID">
                    <b-input-group>
                        <b-form-input
                            name="uuid"
                            v-model="project.uuid"
                            placeholder="Your project uuid"
                            disabled
                        ></b-form-input>
                        <b-input-group-append>
                            <b-button variant="info"
                              v-clipboard:copy="project.uuid"
                              v-clipboard:success="onUuidCopy"
                              v-clipboard:error="onUuidCopyError"
                            ><font-awesome-icon :icon="['far', 'copy']" /></b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>

                <h6 class="mt-5 text-muted">Public Page</h6>
                <hr/>

                <b-form-group label="Entries Per Page Limit">
                    <b-form-input
                        v-model="project.page_entry_limit"
                        placeholder="No. of changelogs to be shown per page"
                        required
                    ></b-form-input>
                </b-form-group>

                <b-form-group label="URL">
                    <b-input-group>
                        <b-form-input
                            v-bind:value=" serverUrl + '/'+ project.uuid +'/changelogs'"
                            placeholder="Public page changelog URL"
                            disabled
                        ></b-form-input>
                        <b-input-group-append>
                            <b-button variant="info" v-bind:href="'/'+ project.uuid +'/changelogs'" target="_blank">Open</b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </div>

            <div v-if="project.id">
                <h6 class="mt-5 text-muted">Widget</h6>
                <hr/>
                <b-form-group label="Entries Limit">
                    <b-form-input
                        v-model="project.widget_entry_limit"
                        placeholder="No. of changelogs to be shown in the widget"
                        required
                    ></b-form-input>
                </b-form-group>
            </div>
            <b-button type="submit" variant="primary" :disabled="submissionInProgress">
                <font-awesome-icon :icon="['fas', 'check']" v-if="!submissionInProgress" />
                <b-spinner small v-if="submissionInProgress" ></b-spinner>
                {{ submissionInProgress ? 'Please wait..' : 'Submit' }}
            </b-button>
        </b-form>

        <div v-if="project.id" class="mb-5">
            <b-list-group>
                <b-list-group-item class="d-flex justify-content-between" variant="danger">
                    <div>
                        <h6 class="mt-1">Delete this project</h6>
                    </div>

                    <b-button type="submit" variant="danger" size="sm" :disabled="deletionInProgress" v-on:click="deleteProject">
                        <font-awesome-icon :icon="['fas', 'trash']" v-if="!deletionInProgress" />
                        <b-spinner small v-if="deletionInProgress" ></b-spinner>
                    </b-button>
                </b-list-group-item>

            </b-list-group>
        </div>

        <div v-if="project.id">
            <widget-settings-component :project="project"></widget-settings-component>
        </div>
    </div>
</template>

<script>
import VSwatches from 'vue-swatches'
import 'vue-swatches/dist/vue-swatches.css'
import AvatarCropper from "vue-avatar-cropper"
import { validationMixin } from 'vuelidate'
import { required, url } from 'vuelidate/lib/validators'
import {error_handling_mixin} from "../../mixins";
import changelogApi from '../../api'

export default {
    name: "project-settings",
    mixins : [validationMixin, error_handling_mixin],
    props : {
        project_data : String,
        company_id : String
    },
    computed : {
        project : function(){
            let data = JSON.parse(this.project_data);
            return Object.keys(data).length < 1 ? { name : '', 'url' : '' } : data
        }
    },
    components: { VSwatches, AvatarCropper },
    data : function(){
        return {
            submissionInProgress : !1,
            deletionInProgress : !1,
            projectLogo : undefined,
            uploadingLogo : !1,
            serverUrl : location.origin
        }
    },
    mounted (){
        if (this.project.id && this.project.logo) {
            this.projectLogo = '/api/project/' + this.project.uuid + '/logo';
        }
    },
    validations : {
        project : {
            name : { required },
            url : { required, url },
        }
    },
    methods : {
        validateState(input){
            const { $dirty, $error } = this.$v.project[input];
            return $dirty ? !$error : null;
        },
        submitForm : function()
        {
            // this.$v.project.$touch();
            // if (this.$v.project.$anyError) {
            //     return;
            // }

            if (this.project.id) {
                this.updateProject();
            } else {
                this.createProject()
            }
        },
        createProject : function(){
            this.submissionInProgress = true;
            changelogApi.project.store(this.company_id, this.project).then(response => {
                if (response.data.status === 'success') {
                    window.location.href = response.data.redirectTo;
                } else {
                    this.handleErrors(response)

                }
            }).catch(error => {
                this.handleSubmissionFailure(error);
            }).then(() => {
                this.submissionInProgress = false;
            });
        },
        updateProject : function() {
            this.submissionInProgress = true;
            changelogApi.project.update(this.project.uuid, this.project).then(response => {
                if (response.data.status === 'success') {
                    this.$toastr.s("Success", response.data.message);
                } else {
                    this.handleErrors(response);
                }
            }).catch(error => {
                this.handleSubmissionFailure(error);
            }).then(() => {
                this.submissionInProgress = false;
            });
        },

        deleteProject : function(){
            this.$confirm({
                message : 'Are you sure you want to delete this project?',
                button: {
                    no: 'No',
                    yes: 'Yes'
                },
                callback: confirm => {
                    if (confirm) {
                        this.deletionInProgress = !0
                        changelogApi.project.delete(this.project.uuid).then(response => {
                            if (response.data.status === 'success') {
                                this.$toastr.s("Success", response.data.message);
                                location.href = response.data.redirectTo;
                            } else {
                                this.handleErrors(response);
                            }
                        }).catch(error => {
                            this.handleSubmissionFailure(error);
                        }).then(() => {
                            this.deletionInProgress = !1;
                        });
                    }
                }
            });
        },

        handleUploaded(response) {
            this.projectLogo = response.url;
        },
        handleUploading(form, xhr) {
            this.uploadingLogo = true
            form.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        },
        handleCompleted(response, form, xhr) {
            this.uploadingLogo = false
            //this.message = "upload completed.";
        },
        handlerError(message, type, xhr) {
            //this.message = "Oops! Something went wrong...";
        },
        onUuidCopy: function (e) {
            this.$toastr.s("Success", 'Project uuid has been copied to the clipboard.');
        },
        onUuidCopyError: function (e) {
            this.$toastr.e("Error", 'Failed to copy project uuid to the clipboard.');
        }
    }
}
</script>

<style scoped>
    .heading-container {
        display: flex;
        justify-content: space-between;
    }
    div.heading-title {
        margin-top: 6px;
    }
</style>
