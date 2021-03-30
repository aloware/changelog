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
                <b-button-group v-if="users.length > 1">
                    <b-button variant="danger" size="sm" v-on:click="removeUser(user, index)" :disabled="deletionInProgress && deleteButtonIndexClicked === index">
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

export default {
    name: "team-list",
    props : {
        user_data : Array
    },
    computed :{
        ...mapGetters(['users']),
    },
    data(){
        return {
            deletionInProgress : !1,
            deleteButtonIndexClicked : null
        }
    },
    methods : {
        ...mapActions(['deleteUser']),
        addUser : function(){
            this.$bvModal.show('user-form-modal')
        },
        editUser : function(user){

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
                            this.deletionInProgress = false;
                        });
                    }
                }
            });
        },
    },
    mounted : function(){
        this.$store.commit('setUsers', this.user_data);
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
