<template>
    <b-modal id="category-form-modal" :title="getModalTitle"
             @hidden="resetModal"
             @ok="handleOk">
        <b-form @submit.stop.prevent="submitForm">
            <b-form-group label="Label *">
                <b-form-input
                    v-model="$v.category.label.$model"
                    placeholder="Label"
                    :state = "validateState('label')"
                ></b-form-input>
                <b-form-invalid-feedback id="name-live-feedback" v-if="!$v.category.label.required">
                    Give this category a label.
                </b-form-invalid-feedback>
            </b-form-group>
            <b-form-row>
                <b-col>
                    <b-form-group
                        label="Background color"
                    >
                        <v-swatches
                            v-model="category.bg_color"
                            show-fallback
                            fallback-input-type="color"
                            popover-x="right"
                        ></v-swatches>
                    </b-form-group>
                </b-col>
                <b-col>
                    <b-form-group
                        label="Text color"
                    >
                        <v-swatches
                            v-model="category.text_color"
                            show-fallback
                            fallback-input-type="color"
                            popover-x="right"
                        ></v-swatches>
                    </b-form-group>
                </b-col>
            </b-form-row>
        </b-form>
        <hr/>
        <category-component v-bind:category="category"></category-component>

        <div slot="modal-footer">
            <b-btn variant="secondary" @click="resetModal" :disabled="submissionInProgress">Cancel</b-btn>
            <b-btn variant="primary" @click="handleOk" :disabled="submissionInProgress">
                <font-awesome-icon :icon="['fas', 'check']" v-if="!submissionInProgress" />
                <b-spinner small v-if="submissionInProgress" ></b-spinner>
                {{ submissionInProgress ? 'Please wait..' : 'Submit' }}
            </b-btn>
        </div>
    </b-modal>
</template>

<script>
    import VSwatches from 'vue-swatches'
    import 'vue-swatches/dist/vue-swatches.css'
    import { mapGetters, mapActions } from 'vuex'
    import { error_handling_mixin } from '../mixins'
    import { validationMixin } from 'vuelidate'
    import { required } from "vuelidate/lib/validators";

    export default {
        name: "CategoryFormComponent",
        mixins: [validationMixin, error_handling_mixin],
        props : {
            companyid : String,
        },
        components: { VSwatches },
        computed : {
            ...mapGetters(['category']),
            getModalTitle : function(){
                return ((this.category && this.category.id) ? 'Edit' : 'Add') + ' Category'
            }
        },
        data : function(){
            return {
                submissionInProgress : false
            }
        },
        validations : {
            category : {
                label : { required },
            }
        },
        methods : {
            ...mapActions(['storeCategory', 'updateCategory']),
            validateState(input){
                const { $dirty, $error } = this.$v.category[input];
                return $dirty ? !$error : null;
            },
            submitForm : function(){
                this.$v.category.$touch();
                if (this.$v.category.$anyError) {
                    return;
                }

                this.submissionInProgress = true;
                if (this.category.id) {
                    this.updateCategory(this.category).then(response => {
                        if (response.data.status === 'success') {
                            this.$nextTick(() => {
                                this.$bvModal.hide('category-form-modal')
                            })
                        } else {
                            this.handleErrors(response);
                        }
                    }).catch(error => {
                        this.handleSubmissionFailure(error);
                    }).then(() => {
                        this.submissionInProgress = false;
                    });
                } else {
                    this.category.company_id = this.companyid
                    this.storeCategory(this.category).then(response => {
                        if (response.data.status === 'success') {
                            this.$nextTick(() => {
                                this.$bvModal.hide('category-form-modal')
                            })
                        } else {
                            this.handleErrors(response);
                        }

                    }).catch(error => {
                        this.handleSubmissionFailure(error);
                    }).then(() => {
                        this.submissionInProgress = false;
                    });
                }
            },
            handleOk(bvModalEvt) {
                // Prevent modal from closing
                bvModalEvt.preventDefault()
                // Trigger submit handler
                this.submitForm()
            },
            resetModal : function(){
                this.$store.commit('cancelCategoryForm', this.$store.state);
                this.$nextTick(() => {
                    this.$bvModal.hide('category-form-modal')
                })
            }
        },
        mounted (){

        },
    }
</script>

<style scoped>

</style>
