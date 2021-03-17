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
                        v-model="changelog.title"
                        type="text"
                        placeholder="Title"
                        required
                    ></b-form-input>
                </b-form-group>

                <b-form-group id="input-group-comment">
                    <vue-editor
                        useCustomImageHandler
                        :customModules="customModulesForEditor"
                        :editorOptions="editorSettings"
                        @image-added="handleImageAdded"
                        v-model="changelog.body" :editorToolbar="customToolbar">
                    </vue-editor>
                </b-form-group>

                <b-form-group id="input-group-3" label="Category:" label-for="changelog_category">
                    <b-form-select
                        id="changelog_category"
                        v-model="changelog.category"
                        required
                    >
                        <option v-for="category in categories" v-bind:value="category">
                            {{ category.label }}
                        </option>

                    </b-form-select>
                </b-form-group>
                <b-form-group id="published">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" v-on:change="handlePublishedAtToggle" :value="published" v-model="is_published">
                        <label class="custom-control-label" for="is_published">Published at</label>
                    </div>
                </b-form-group>
                <b-form-group description="Select date and time, you can select future date to automatically published your changelog." v-if="is_published">
                    <VueCtkDateTimePicker
                        v-model="changelog.published_at"
                        v-bind:right=true
                        position="top"
                        v-bind:only-date="true"
                        format="YYYY-MM-DD"
                        label="Select date"
                        formatted="YYYY-MM-DD"
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
    import { required, minLength, maxLength } from 'vuelidate/lib/validators'
    import { VueEditor } from 'vue2-editor'
    import { ImageDrop } from 'quill-image-drop-module'
    import ImageResize from 'quill-image-resize-module'
    import { error_handling_mixin } from '../mixins'

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
                showOverlay : false
            }
        },
        validations : {
            changelog : {
                name : { required },
                body : { required },
                category_id : { required },
            }
        },
        computed : {
            ...mapGetters(['categories', 'changelog', 'project']),
            published : function(){
                return (this.changelog && this.changelog.published_at.length > 0)
            }
        },
        methods : {
            ...mapActions(['storeChangelog', 'updateChangelog', 'resetChangelog']),
            cancel : function(){
                this.resetChangelog();
            },
            validateState(input){
                // const { $dirty, $error } = this.$v.changelog[input];
                //
                // return $dirty ? !$error : null;
            },
            submitForm(){
                // this.$v.changelog.$touch();
                // if (this.$v.changelog.$anyError) {
                //     return;
                // }
                let _this = this;
                this.submissionInProgress = true;
                if (this.changelog.id) {
                    this.updateChangelog(this.changelog)
                        .then(function(response){
                            _this.submissionInProgress = false;
                            _this.handleErrors(response);
                    });
                } else {
                    this.storeChangelog(this.changelog).then(response => {
                        _this.submissionInProgress = false;
                        _this.handleErrors(response);
                    });
                }
            },
            handleImageAdded : function(file, Editor, cursorLocation, resetUploader){
                let formData = new FormData();
                formData.append('image', file);
                this.showOverlay = true;
                this.overlayMessage = 'Uploading...';
                axios.post( '/project/'+ this.project.uuid +'/changelogs/upload/image', formData).then(response => {
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


                //console.log(this.$moment().format('YYYY-MM-DD'), this.$moment((this.changelog.published_at)).format('YYYY-MM-DD'))
                //this.changelog.published_at = !this.$moment().format('YYYY-MM-DD').isSame(this.$moment((this.changelog.published_at)).format('YYYY-MM-DD')) && this.is_published ? this.$moment().format('YYYY-MM-DD') : null;
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