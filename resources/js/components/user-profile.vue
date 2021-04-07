<template>
    <div>
        <div class="heading-container">
            <div class="heading-title">
                <h5>Profile Settings</h5>
            </div>
        </div>
        <hr/>

        <b-form @submit.stop.prevent="submitForm" class="mb-5">
            <b-row>
                <b-col md="3" sm="12" class="text-center" v-if="enableAvatarUploading">
                    <b-img v-model="avatar" v-bind="avatarProps" rounded alt="Rounded image"></b-img>

                    <avatar-cropper
                        @uploading="handleUploading"
                        @uploaded="handleUploaded"
                        @completed="handleCompleted"
                        @error="handlerError"
                        trigger="#pick-avatar"
                        v-bind:upload-url="'/user/' + user.uuid + '/avatar/upload'"
                        :labels="{submit: 'Upload', cancel: 'Cancel'}"
                        v-bind:withCredentials="true"
                    />

                    <button class="btn btn-primary btn-sm mt-2" id="pick-avatar" :disabled="uploadingAvatar">
                        {{ uploadingLogo ? 'Uploading...' : 'Select image' }}
                    </button>
                </b-col>
                <b-col md="12" sm="12">
                    <b-form-row>
                        <b-col sm="12" md="6">
                            <b-form-group label="Firstname *">
                                <b-form-input
                                    placeholder="Firstname"
                                    v-model="$v.user.first_name.$model"
                                    :state = "validateState('first_name')"
                                ></b-form-input>
                            </b-form-group>
                            <b-form-invalid-feedback id="name-live-feedback" v-if="!$v.user.first_name.required">
                                Enter your firstname of the user.
                            </b-form-invalid-feedback>
                        </b-col>

                        <b-col sm="12" md="6">
                            <b-form-group label="Lastname *">
                                <b-form-input
                                    placeholder="Lastname"
                                    v-model="$v.user.last_name.$model"
                                    :state = "validateState('last_name')"
                                ></b-form-input>
                                <b-form-invalid-feedback id="name-live-feedback" v-if="!$v.user.last_name.required">
                                    Enter your lastname of the user.
                                </b-form-invalid-feedback>
                            </b-form-group>
                        </b-col>
                    </b-form-row>

                    <b-form-group label="Email Address *" description="e.g. your_email@your-domain.com">
                        <b-form-input
                            placeholder="Email Address"
                            v-model="$v.user.email.$model"
                            :state="validateState('email')"
                        ></b-form-input>
                        <b-form-invalid-feedback id="email-live-feedback" v-if="!$v.user.email.required">
                            Enter your email of the user.
                        </b-form-invalid-feedback>

                        <b-form-invalid-feedback id="email-live-feedback" v-if="!$v.user.email.email">
                            Enter a valid email address.
                        </b-form-invalid-feedback>
                    </b-form-group>

                    <b-form-group id="published">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="change_password" name="change_password" v-model="hasChangePassword">
                            <label class="custom-control-label" for="change_password">Change Password</label>
                        </div>
                    </b-form-group>

                    <b-form-row v-if="hasChangePassword">
                        <b-col sm="12" md="6">
                            <b-form-group label="Password *">
                                <b-form-input
                                    placeholder="Password"
                                    v-model="$v.user.password.$model"
                                    :state="validateState('password')"
                                    type="password"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>

                        <b-col sm="12" md="6">
                            <b-form-group label="Confirm Password *">
                                <b-form-input
                                    placeholder="Confirm Password"
                                    v-model="$v.user.password_confirmation.$model"
                                    :state="validateState('password_confirmation')"
                                    type="password"
                                ></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-form-row>

                    <b-button type="submit" variant="primary" :disabled="submissionInProgress">
                        <font-awesome-icon :icon="['fas', 'check']" v-if="!submissionInProgress" />
                        <b-spinner small v-if="submissionInProgress" ></b-spinner>
                        {{ submissionInProgress ? 'Please wait..' : 'Save Changes' }}
                    </b-button>
                </b-col>
            </b-row>

        </b-form>
    </div>
</template>

<script>
    import AvatarCropper from "vue-avatar-cropper"
    import {validationMixin} from "vuelidate";
    import {error_handling_mixin} from "../mixins";
    import {required, email, sameAs, requiredIf} from "vuelidate/lib/validators";
    import changelogApi from '../api'
    export default {
        name: "user-profile",
        mixins: [validationMixin, error_handling_mixin],
        components : { AvatarCropper },
        props : {
            user_data : String
        },
        computed : {
            profile : function(){
                let data = JSON.parse(this.user_data);
                return Object.keys(data).length < 1 ? {
                  id : '',
                  uuid : '',
                  first_name : '',
                  last_name : '',
                  email : ''
                } : data
            }
        },
        data : function(){
            return {
                enableAvatarUploading : false,
                avatar : undefined,
                submissionInProgress : !1,
                uploadingAvatar : !1,
                avatarProps: { blank: true, blankColor: '#777', width: 200, height: 200, class : 'mt-3' },
                hasChangePassword : false,
                user : {
                    id : '',
                    uuid : '',
                    first_name : '',
                    last_name : '',
                    email : '',
                    password : '',
                    password_confirmation : ''
                }
            }
        },
        validations : {

            user : {
                first_name : { required },
                last_name : { required },
                email : { required, email },
                password :  {
                    required : requiredIf(function (){
                        return this.hasChangePassword
                    })
                },
                password_confirmation :  {
                    required : requiredIf(function(){
                        return this.hasChangePassword
                    }),
                    sameAsPassword : sameAs('password')
                }
            }
        },
        methods : {
            presetUserData : function(){
                this.user.first_name = this.profile.first_name;
                this.user.last_name = this.profile.last_name;
                this.user.email = this.profile.email;
                this.user.id = this.profile.id;
                this.user.uuid = this.profile.uuid;
            },
            validateState(input){
                const { $dirty, $error } = this.$v.user[input];
                return $dirty ? !$error : null;
            },
            submitForm : function() {
                this.$v.user.$touch();
                if (this.$v.user.$anyError) {
                    return;
                }
                this.submissionInProgress = !0;
                changelogApi.user.update(this.user).then(response => {
                    if (response.data.status === 'success') {
                        this.$toastr.s("Success", response.data.message);
                        location.reload();
                    } else {
                        this.handleErrors(response);
                    }
                }).catch(error => {
                    this.handleSubmissionFailure(error);
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
                this.uploadingAvatar = false
                //this.message = "upload completed.";
            },
            handlerError(message, type, xhr) {
                //this.message = "Oops! Something went wrong...";
            },
        },
        mounted() {
            this.presetUserData();
        }
    }
</script>

<style scoped>

</style>
