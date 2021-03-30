<template>
    <b-modal id="user-form-modal" :title="getModalTitle"
             @hidden="resetModal"
             @ok="handleOk">
        <b-form @submit.stop.prevent="submitForm">
            <b-form-group label="Firstname *">
                <b-form-input
                    v-model="$v.user.first_name.$model"
                    placeholder="Firstname"
                    :state = "validateState('first_name')"
                ></b-form-input>
                <b-form-invalid-feedback id="firstname-live-feedback" v-if="!$v.user.first_name.required">
                    Enter user firstname.
                </b-form-invalid-feedback>
            </b-form-group>

            <b-form-group label="Lastname *">
                <b-form-input
                    v-model="$v.user.last_name.$model"
                    placeholder="Lastname"
                    :state = "validateState('last_name')"
                ></b-form-input>
                <b-form-invalid-feedback id="lastname-live-feedback" v-if="!$v.user.last_name.required">
                    Enter user lastname.
                </b-form-invalid-feedback>
            </b-form-group>

            <b-form-group label="Email *">
                <b-form-input
                    v-model="$v.user.email.$model"
                    placeholder="Email Address"
                    :state = "validateState('email')"
                ></b-form-input>
                <b-form-invalid-feedback id="name-live-feedback" v-if="!$v.user.email.required">
                    Enter user email address.
                </b-form-invalid-feedback>
            </b-form-group>
        </b-form>

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
import {validationMixin} from "vuelidate";
import {error_handling_mixin} from "../mixins";
import {mapActions, mapGetters} from "vuex";
import {required} from "vuelidate/lib/validators";

export default {
    name: "team-form",
    mixins: [validationMixin, error_handling_mixin],
    props : {
        companyid : String,
    },
    computed : {
        ...mapGetters(['user']),
        getModalTitle : function(){
            return ((this.category && this.category.id) ? 'Edit' : 'Add') + ' User'
        }
    },
    data : function(){
        return {
            submissionInProgress : false,
        }
    },
    validations : {
        user : {
            first_name : { required },
            last_name : { required },
            email : { required },
        }
    },
    methods : {
        ...mapActions(['storeUser']),
        validateState(input){
            const { $dirty, $error } = this.$v.user[input];
            return $dirty ? !$error : null;
        },
        submitForm : function(){
            this.$v.user.$touch();
            if (this.$v.user.$anyError) {
                return;
            }

            this.submissionInProgress = true;
            if (this.user.id) {
                //put edit logic here if there is any in the future
            } else {
                this.storeUser(this.user).then(response => {
                    if (response.data.status === 'success') {
                        this.$v.$reset();
                        this.$nextTick(() => {
                            this.$bvModal.hide('user-form-modal')
                        })
                    } else {
                        this.handleErrors(response);
                    }

                }).catch(error => {
                    console.log(error);
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
            this.$nextTick(() => {
                this.$bvModal.hide('user-form-modal')
            })
        }
    },
    mounted (){
        this.$root.$on('bv::modal::show', (bvEvent, modalId) => {
            this.$v.$reset();
        })
    },
}
</script>

<style scoped>

</style>
