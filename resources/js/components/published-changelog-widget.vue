<template>
    <div>
        <h6 class="text-center header-label">Latest Changes</h6>
        <div class="changelogs-container scrollable">
            <published-changelog-widget-list-component :changelog="changelog" v-for="(changelog, index) in changelogs" :key="changelog.id"></published-changelog-widget-list-component>
        </div>
        <div class="changelog-widget-footer">
            <h6 class="text-center" style="font-size: 0.75rem;"><a v-bind:href="'/'+ project.slug + '/changelogs'" class="text-muted" target="_blank">Read more...</a></h6>
        </div>
    </div>
</template>

<script>
export default {
    name: "published-changelog-widget",
    props : ['changelogs', 'project'],
}
</script>

<style scoped>

</style>
