<template>
    <div class="callout callout-primary">
        <div class="callout-header">
            <h4>{{ changelog.title }}</h4>
            <p>
                <span class="badge " v-bind:style="{backgroundColor: changelog.category.bg_color, color : changelog.category.text_color}">{{ changelog.category.label }}</span>
                <small class="text-muted"><relative-time-component :from_time="changelog.created_at" :humanized="true" :update_interval="60000"></relative-time-component></small>
            </p>
        </div>

        <p class="mt-5" v-html="changelog.body"></p>
    </div>
</template>

<script>
export default {
    name: "published-changelog-widget",
    props : ['changelog']
}
</script>

<style scoped>
    .callout-header {
        border-bottom: 1px solid lightgray;
        padding-bottom: 5px;
    }

    .callout-header p {
        display: flex;
        justify-content: space-between;
        margin: 0;
    }
</style>
