<template>
    <div>
        <div class="heading-container">
            <h5 v-if="project.id">Project Settings</h5>
            <h5 v-if="!project.id">New Project</h5>
            <b-button v-if="project.id" v-bind:href="'/company/' + project.company_id + '/project/new'" type="button" variant="primary">Add Project</b-button>
        </div>
        <hr/>

        <b-form @submit.stop.prevent="submitForm">
            <b-form-group label="Name">
                <b-form-input
                    v-model="project.name"
                    placeholder="Name of this project"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group label="URL">
                <b-form-input
                    v-model="project.url"
                    placeholder="URL of this project"
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
                            v-bind:value="'/'+ project.slug +'/changelogs'"
                            placeholder="Public page changelog URL"
                            disabled
                        ></b-form-input>
                        <b-input-group-append>
                            <b-button variant="info" v-bind:href="'/'+ project.slug +'/changelogs'" target="_blank">Open</b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </div>

          <div v-if="project.id">
              <h6 class="mt-5 text-muted">Widget</h6>
              <hr/>

              <b-form-group>
                  <small class="text-muted">Your widget code</small>
                  <b-card class="pb-5">
                      <b-card-text>
                          <code>
                              &lt;script&gt;
                              <br/>  let changelog_config = {
                              <br/>&emsp;     container : '__REPLACE_WITH_YOUR_WIDGET_DOM_CONTAINER',
                              <br/>&emsp;        uuid : '{{ project.uuid }}',
                              <br/>&emsp;        translations : {
                              <br/>&emsp;&ensp;           placeholderLabel : 'Release Notes',
                              <br/>&emsp;        }
                              <br/>    }
                              <br/>&lt;/script&gt;
                              <br/>&lt;script async src="http://localhost/js/widget.js"&gt;&lt;/script&gt;
                              <br/>
                          </code>
                      </b-card-text>
                  </b-card>
              </b-form-group>
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
    </div>
</template>

<script>
import VSwatches from 'vue-swatches'
import 'vue-swatches/dist/vue-swatches.css'
import AvatarCropper from "vue-avatar-cropper"

export default {
    name: "ProjectComponent",
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
            projectLogo : undefined,
            uploadingLogo : !1
        }
    },
    mounted (){
        if (this.project.id && this.project.logo) {
            this.projectLogo = '/api/project/' + this.project.uuid + '/logo';
        }
    },
    methods : {
        submitForm : function()
        {
            if (this.project.id) {
                this.updateProject();
            } else {
                this.createProject()
            }
        },
        createProject : function(){
            this.submissionInProgress = true;

            axios.post('/company/'+ this.company_id +'/project/new', this.project).then(response => {
                if (response.data.status === 'success') {
                    window.location.href = '/projects/' + response.data.project.name + '/changelogs'
                } else {
                    this.$toastr.e("Error", response.data.message);
                }
            }).catch(error => {
                this.$toastr.e("Error", 'An error was encountered while processing your request. Please try again.');
            }).then(() => {
                this.submissionInProgress = false;
            });
        },
        updateProject : function() {
            this.submissionInProgress = true;
            axios.put('/project/' + this.project.uuid, this.project).then(response => {
                if (response.data.status === 'success') {
                    this.$toastr.s("Success", response.data.message);
                } else {
                    this.$toastr.e("Error", response.data.message);
                }
            }).catch(error => {
                this.$toastr.e("Error", 'An error was encountered while processing your request. Please try again.');
            }).then(() => {
                this.submissionInProgress = false;
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
        }
    }
}
</script>

<style scoped>
    .heading-container {
        display: flex;
        justify-content: space-between;
    }
</style>