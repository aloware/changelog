<template>
    <div>
        <h6 class="text-center header-label">Latest Changes</h6>
        <div class="changelogs-container scrollable">
            <div v-for="(changelog, index) in changelogs" :key="changelog.id">
                <published-changelog-widget-list-component :changelog="changelog" ></published-changelog-widget-list-component>
                <h2 class="hr-line-text" v-if="index !== changelogs.length -1"><span></span></h2>
            </div>
        </div>
        <div class="changelog-widget-footer">
            <h6 class="text-center" style="font-size: 0.75rem;"><a v-bind:href="'/'+ project.slug + '/changelogs'" class="text-muted" target="_blank">Read more...</a></h6>
        </div>
    </div>
</template>

<script>
    import { mapActions } from "vuex";

    export default {
        name: "published-changelog-widget",
        props : ['project', 'changelogs'],
        computed : {
        },
        methods : {
            ...mapActions(['getPublishedChangelogs']),
        },
        mounted() {
        }
    }
</script>
