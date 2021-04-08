<template>
    <div class="editor-container">
        <b-overlay
            :show="showOverlay"
            rounded="sm"
            :opacity="0.42"
        >
            <b-form @submit.stop.prevent="submitForm">
                <b-form-group
                    id="input-group-1"
                    label="Title"
                    label-for="changelog_title"
                >
                    <b-form-input
                        id="title"
                        v-model="$v.changelog.title.$model"
                        :state = "validateState('title')"
                        type="text"
                        placeholder="Title"
                    ></b-form-input>
                    <b-form-invalid-feedback id="name-live-feedback" v-if="!$v.changelog.title.required">
                        Give this changelog a title.
                    </b-form-invalid-feedback>
                </b-form-group>

                <b-form-group id="input-group-comment">
                    <vue-editor
                        useCustomImageHandler
                        :customModules="customModulesForEditor"
                        :editorOptions="editorSettings"
                        @image-added="handleImageAdded"
                        v-model="$v.changelog.body.$model"
                        :state = "validateState('body')"
                        :editorToolbar="customToolbar"
                        placeholder="Content">
                    </vue-editor>
                    <b-form-invalid-feedback id="name-live-feedback" v-if="!$v.changelog.body.required">
                        Changelog body is required.
                    </b-form-invalid-feedback>
                </b-form-group>

                <b-form-group id="input-group-3" label="Category:" label-for="changelog_category">
                    <v-select
                        :options="categories"
                        v-model="$v.changelog.category.$model"
                        :state = "validateState('category')"
                        :clearable="false"
                    >
                    </v-select>

                    <b-form-invalid-feedback id="name-live-feedback" v-if="!$v.changelog.category.required">
                        Select a category for this changelog.
                    </b-form-invalid-feedback>
                </b-form-group>
                <b-form-group id="published">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" v-on:change="handlePublishedAtToggle" v-model="is_published">
                        <label class="custom-control-label" for="is_published">Published at</label>
                    </div>
                </b-form-group>
                <b-form-group description="You can select future date to automatically published your changelog." v-if="is_published">
                    <VueCtkDateTimePicker
                        v-model="changelog.published_at"
                        v-bind:right=true
                        position="top"
                        v-bind:only-date="true"
                        format="YYYY-MM-DD"
                        label="Select date"
                        formatted="YYYY-MM-DD"
                        :minDate="today"
                    />
                </b-form-group>

                <b-button type="submit" variant="primary" :disabled="submissionInProgress">
                    <font-awesome-icon :icon="['fas', 'check']" v-if="!submissionInProgress" />
                    <b-spinner small v-if="submissionInProgress" ></b-spinner>
                    {{ submissionInProgress ? 'Please wait..' : 'Submit' }}
                </b-button>
                <b-button type="button" variant="danger" v-on:click="cancel" :disabled="submissionInProgress">
                    <font-awesome-icon :icon="['fas', 'times']" />
                    Cancel
                </b-button>
            </b-form>
            <template #overlay>
                <div class="text-center">
                    <font-awesome-icon :icon="['fas', 'spinner']" spin />
                    <p id="cancel-label">{{ overlayMessage }}</p>
                </div>
            </template>
        </b-overlay>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'
    import { validationMixin } from 'vuelidate'
    import { required } from 'vuelidate/lib/validators'
    import { VueEditor } from 'vue2-editor'
    import { ImageDrop } from 'quill-image-drop-module'
    import ImageResize from 'quill-image-resize-module'
    import { error_handling_mixin } from '../mixins'
    import changelogApi from '../api'
    import moment from "moment";
    export default {
        name: "ChangelogFormComponent",
        mixins: [validationMixin, error_handling_mixin],
        components: {
            VueEditor
        },
        data : function(){
            return {
                is_published : false,
                customToolbar: [
                    [{ 'header': [false, 1, 2, 3, 4, 5, 6, ] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{'align': ''}, {'align': 'center'}, {'align': 'right'}, {'align': 'justify'}],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'image',],
                    ['clean']
                ],
                customModulesForEditor: [
                    { alias: 'imageDrop', module: ImageDrop },
                    { alias: 'imageResize', module: ImageResize }
                ],
                editorSettings: {
                    modules: {
                        imageDrop: true,
                        imageResize: {
                            modules: [ 'Resize', 'DisplaySize', 'Toolbar' ]
                        }
                    }
                },
                submissionInProgress : !1,
                overlayMessage : '',
                showOverlay : false,
                today : moment().format('YYYY-MM-DD')
            }
        },
        validations : {
            changelog : {
                title : { required },
                body : { required },
                category : { required },
            }
        },
        computed : {
            ...mapGetters(['categories', 'changelog', 'project']),
        },
        watch : {
            changelog : function(){
                this.is_published = (this.changelog && this.changelog.published_at && this.changelog.published_at.length > 0);
            }
        },
        methods : {
            ...mapActions(['storeChangelog', 'updateChangelog', 'resetChangelog']),
            cancel : function(){
                this.resetChangelog();
            },
            validateState(input){
                const { $dirty, $error } = this.$v.changelog[input];
                return $dirty ? !$error : null;
            },
            submitForm(){
                this.$v.changelog.$touch();
                if (this.$v.changelog.$anyError) {
                    return;
                }
                let _this = this;
                this.submissionInProgress = true;
                if (this.changelog.id) {
                    this.updateChangelog(this.changelog).then(response => {
                        _this.responseCallback(response);
                    });
                } else {
                    this.storeChangelog(this.changelog).then(response => {
                        _this.responseCallback(response);
                    });
                }
            },
            responseCallback : function(response){
                this.submissionInProgress = false;
                this.$v.$reset();
                if (response.status === 200 && response.data.status === 'error') {
                    this.handleErrors(response);
                }
            },
            handleImageAdded : function(file, Editor, cursorLocation, resetUploader){
                let formData = new FormData();
                formData.append('image', file);
                this.showOverlay = true;
                this.overlayMessage = 'Uploading...';

                changelogApi.changelog.uploadImage(this.project.uuid, formData).then(response => {
                    let url = response.data.url;
                    Editor.insertEmbed(cursorLocation, 'image', url);
                    resetUploader();
                }).catch(error => {
                    //TODO handle error here
                    console.log(error);
                }).then(() => {
                    this.showOverlay = false;
                    this.overlayMessage = '';
                });
            },
            handlePublishedAtToggle : function(e){
                this.changelog.published_at = (this.is_published) ? this.$moment().format('YYYY-MM-DD') : '';
            }
        }
    }
</script>

<style scoped>
    .editor-container {
        position: fixed;
        right: -1px;
        width: 0;
        top: 6vh;

        height: 100%;
        border-left: 1px solid rgba(0, 0, 0, 0.075);
        overflow-x: hidden;
        overflow-y: auto;
        padding-bottom: 5vh;
    }

    .openEditor .editor-container {
        width: 48vw;
    }

    form {
        padding : 20px;
    }
</style>
