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
                <b-form-textarea
                    id="changelog_body"
                    v-model="changelog.body"
                    rows="3"
                    required
                ></b-form-textarea>
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

    export default {
        name: "ChangelogFormComponent",
        mixins: [validationMixin],
        data : function(){
            return {
                is_published : false,
            }
        },
        validations : {
            changelog : {
                name : { required },
                body : { required },
                category_id : { required },
            }
        },
        computed : mapGetters(['categories', 'changelog']),
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
            }
        }
    }
</script>

<style scoped>
    .editor-container {
        position: fixed;
        right: 0;
        width: 0;
        top: 12vh;
    }

    .openEditor .editor-container {
        width: 40vw;
    }
</style>
