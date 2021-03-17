<template>
    <div>
        <b-badge v-bind:style="{ backgroundColor : category.bg_color, color : category.text_color }">{{ category.label }}</b-badge>
    </div>
</template>

<script>
export default {
    name: "CategoryComponent",
    props : {
        category : Object
    },
    mounted : function(){

    }
}
</script>

<style scoped>

</style>
