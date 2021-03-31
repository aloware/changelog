<template>
    <div>
        <span>{{ fullName }} <small class="text-muted" v-if="!user.email_verified_at">(Pending Verification)</small></span>
<!--        <b-badge variant="primary"></b-badge>-->
    </div>
</template>

<script>
    export default {
        name: "team.vue",
        props : {
            user : Object
        },
        computed : {
            fullName : function(){
                return this.user.first_name + ' ' + this.user.last_name;
            }
        }
    }
</script>

<style scoped>

</style>
