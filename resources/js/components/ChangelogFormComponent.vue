<template>
    <div class="editor-container">
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
                    v-model="changelog.category_id"
                    required
                >
                    <option v-for="category in categories" v-bind:value="category.id">
                        {{ category.label }}
                    </option>

                </b-form-select>
            </b-form-group>
            <b-form-group id="published">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="is_published" name="is_published" v-model="is_published">
                    <label class="custom-control-label" for="is_published">Published</label>
                </div>
            </b-form-group>
            <b-form-group description="Select date and time, you can select future date to automatically published your changelog." v-if="is_published">
                <VueCtkDateTimePicker
                    v-model="changelog.published_at"
                    v-bind:right=true
                    position="top"
                />
            </b-form-group>

            <b-button type="submit" variant="primary">Submit</b-button>
            <b-button type="button" variant="danger" v-on:click="cancel">Cancel</b-button>
        </b-form>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'
    import { validationMixin } from 'vuelidate'
    import { required, minLength, maxLength } from 'vuelidate/lib/validators'
    import { VueEditor } from 'vue2-editor'
    import { ImageDrop } from 'quill-image-drop-module'
    import ImageResize from 'quill-image-resize-module'

    export default {
        name: "ChangelogFormComponent",
        mixins: [validationMixin],
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
            ...mapGetters(['categories', 'changelog', 'projectuuid']),
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
                if (this.changelog.id) {
                    this.updateChangelog(this.changelog).then(function(response){
                        if ( typeof response !== 'undefined' && response.data.status === 'error') {
                            _this.$toastr.e("Error", response.data.message);
                        }
                    });
                } else {
                    this.$store.dispatch('storeChangelog', { vm : this, changelog : this.changelog });
                    // this.storeChangelog(this.changelog);
                }
            },
            handleImageAdded : function(file, Editor, cursorLocation, resetUploader){
                let formData = new FormData();
                formData.append('image', file);
                axios.post( '/project/'+ this.projectuuid +'/changelogs/upload/image', formData).then(response => {
                    let url = response.data.url;
                    Editor.insertEmbed(cursorLocation, 'image', url);
                    resetUploader();
                }).catch(error => {
                    //TODO handle error here
                    console.log(error);
                })
            },
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
