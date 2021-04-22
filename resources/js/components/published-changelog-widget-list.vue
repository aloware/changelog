<template>
    <div class="callout">
        <div class="callout-header">
            <div class="callout-subheader mb-2">
                <div>
                    <h4 class="mb-0 changelog-title">{{ changelog.title }}</h4>
                    <small class="text-muted date-container">
                        <relative-time-component :from_time="changelog.created_at" :humanized="true" :update_interval="60000"></relative-time-component>
                    </small>
                </div>
                <span class="badge " v-bind:style="{backgroundColor: changelog.category.bg_color, color : changelog.category.text_color}">{{ changelog.category.label }}</span>

            </div>
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

    .callout-subheader {
        display: flex;
        justify-content: space-between;
    }

    .badge {
        height: 20px !important;
    }
</style>
