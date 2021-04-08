<template>
    <div>
        <div class="module-heading">
            <h5>Team Management</h5>
            <b-button variant="primary" class="float-right" v-on:click="addUser">
                <font-awesome-icon :icon="['fas', 'plus']" />
                Add a user
            </b-button>
        </div>
        <hr/>

        <b-list-group>
            <b-list-group-item v-for="(user, index) in users" :key="user.id">
                <team-component :user="user"></team-component>
                <b-button-group >
                    <b-button variant="success" size="sm" v-on:click="resendInvitationLink(user, index)" :disabled="invitationLinkSendingInProgress && invitationLinkButtonIndexClicked === index" v-if="!user.email_verified_at">
                        <b-spinner small v-if="invitationLinkSendingInProgress && invitationLinkButtonIndexClicked === index"></b-spinner>
                        <font-awesome-icon :icon="['fas', 'user-check']" v-if="invitationLinkButtonIndexClicked !== index"/>
                        Resend Invitation Link
                    </b-button>
                    <b-button variant="danger" size="sm" v-on:click="removeUser(user, index)" :disabled="deletionInProgress && deleteButtonIndexClicked === index" v-if="user.id !== auth_user.id">
                        <b-spinner small v-if="deletionInProgress && deleteButtonIndexClicked === index"></b-spinner>
                        <font-awesome-icon :icon="['fas', 'trash']" v-if="deleteButtonIndexClicked !== index"/>
                        Delete
                    </b-button>
                </b-button-group>
            </b-list-group-item>
        </b-list-group>
        <team-form-component></team-form-component>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import changelogApi from '../api'
import {error_handling_mixin} from "../mixins";

export default {
    name: "team-list",
    mixins: [error_handling_mixin],
    props : {
        users_data : Array,
        auth_user : Object
    },
    computed :{
        ...mapGetters(['users']),
    },
    data(){
        return {
            deletionInProgress : !1,
            deleteButtonIndexClicked : null,
            invitationLinkSendingInProgress : !1,
            invitationLinkButtonIndexClicked : null
        }
    },
    methods : {
        ...mapActions(['deleteUser']),
        addUser : function(){
            this.$bvModal.show('user-form-modal')
        },
        removeUser : function(user, index){
            this.$confirm({
                message : 'Are you sure you want to delete this user?',
                button: {
                    no: 'No',
                    yes: 'Yes'
                },
                callback: confirm => {
                    if (confirm) {
                        this.deleteButtonIndexClicked = index
                        this.deletionInProgress = !0
                        this.deleteUser(user).then(response => {
                            if (response.status === 200 && response.data.status === 'success') {
                                this.$toastr.s("Success", response.data.message);
                            } else {
                                this.$toastr.e("Error", response.data.message);
                            }

                        }).catch(error => {
                            this.handleSubmissionFailure(error);
                        }).then(res => {
                            this.deletionInProgress = !1;
                        });
                    }
                }
            });
        },
        resendInvitationLink : function(user, index){
            this.invitationLinkButtonIndexClicked = index;
            this.invitationLinkSendingInProgress = !0;
            changelogApi.user.sendInvitationLink(user.id).then(response => {
                if (response.status === 200 && response.data.status === 'success') {
                    this.$toastr.s("Success", response.data.message);
                } else {
                    this.$toastr.e("Error", response.data.message);
                }

            }).catch(error => {
                this.handleSubmissionFailure(error);
            }).then(res => {
                this.invitationLinkSendingInProgress = !1;
            });
        },
        getUsers : function(){
            changelogApi.user.index().then(response => {
               // TODO use this to refresh list of users - if there's a need
            });
        }
    },
    mounted : function(){
        this.$store.commit('setUsers', this.users_data);
        this.$store.commit('setAuthUser', this.auth_user);
    }
}
</script>

<style scoped>
    .module-heading {
        flex-shrink: 0;
        flex-basis: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .list-group-item {
        display: flex;
        justify-content: space-between;
    }

</style>
