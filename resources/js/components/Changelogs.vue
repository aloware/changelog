<template>
    <div>
        <b-card title="Zoho Integration" sub-title="3 Days Ago">
            <ul>
                <li>Added : New app ToDo</li>
                <li>Added : New app Contact</li>
                <li>Added : New Bootstrap components toaster, spinner &amp; custom switch</li>
                <li>Updated : Template update &amp; migration steps in documentation</li>
                <li>Updated : Bootstrap v4.3.1</li>
                <li>Updated : js/css plugins/libraries</li>
                <li>Updated : Made chat &amp; email app workable</li>
                <li>Updated : Gradient color palette support to all app</li>
                <li>Updated : Folder structure, Style &amp; Color Customization and JS usage in documentation</li>
                <li>Fixed: Coming soon counter</li>
                <li>Fixed: Menu expands &amp; collapsed effect in md and sm screen while loading the app.</li>
                <li>Fixed: Fullcalender multi language support.</li>
                <li>Removed: Angular Starter-kit.</li>
            </ul>

            <b-badge variant="primary">New</b-badge>
        </b-card>

        <b-card title="Card title" sub-title="Card subtitle">
            <b-card-text>
                Some quick example text to build on the <em>card title</em> and make up the bulk of the card's
                content.
            </b-card-text>

            <b-card-text>A second paragraph of text in the card.</b-card-text>

            <a href="#" class="card-link">Card link</a>
            <b-link href="#" class="card-link">Another link</b-link>
        </b-card>

        <b-card title="Card title" sub-title="Card subtitle">
            <b-card-text>
                Some quick example text to build on the <em>card title</em> and make up the bulk of the card's
                content.
            </b-card-text>

            <b-card-text>A second paragraph of text in the card.</b-card-text>

            <a href="#" class="card-link">Card link</a>
            <b-link href="#" class="card-link">Another link</b-link>
        </b-card>

    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    name: "Changelogs.vue",
    computed : mapGetters(['changelogs']),
    methods : {
        ...mapActions(['getChangelogs'])
    },
    mounted() {
        this.getChangelogs();
    }
}
</script>

<style scoped>
    .card {
        margin-bottom : 1.875rem;
    }
    .card-body {
        font-family: 'Lato', sans-serif;
    }
</style>
