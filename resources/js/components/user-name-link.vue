<template>
    <span>{{ full_name }}</span>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";

    export default {
        name: "user-name-link",
        props : {
            auth_user : Object
        },
        computed : {
            ...mapGetters(['auth']),
            full_name : function(){
                return this.auth.first_name + ' ' + this.auth.last_name;
            }
        },
        methods : {
          ...mapActions(['setAuthUser'])
        },
        mounted() {
            this.setAuthUser(this.auth_user);
        }
    }
</script>
