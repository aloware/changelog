<template>
    <div class="callout">
        <div class="callout-header">
            <p>
                <span class="badge " v-bind:style="{backgroundColor: changelog.category.bg_color, color : changelog.category.text_color}">{{ changelog.category.label }}</span>
                <small class="text-muted date-container">
                    <font-awesome-icon :icon="['far', 'clock']" />
                    <relative-time-component :from_time="changelog.created_at" :humanized="true" :update_interval="60000"></relative-time-component>
                </small>
            </p>
            <h4 class="mt-2 changelog-title">{{ changelog.title }}</h4>
        </div>

        <p class="changelog-body" v-html="changelog.body"></p>
    </div>
</template>

<script>
export default {
    name: "published-changelog-widget-list",
    props : ['changelog', 'project'],

}
</script>

<style scoped>
    .callout-header p {
        display: flex;
        justify-content: space-between;
        margin: 0;
    }

    .callout-header h4 {
        font-size: 1rem;
    }
</style>
