<template>
    <div class="container mt-5">
        <div class="row changelogs-container">
            <div class="col-12" v-for="(changelog, index) in changelogs" :key="changelog.id">
                <h5>{{ changelog.title }}</h5>
                <p>
                    <b-badge variant="primary">{{ changelog.category.label }}</b-badge>
                    <span class="text-muted d-md-none inline-date changelog-date">{{ changelog.created_at | moment('from', 'now') }}</span>
                </p>
                <span class="text-muted d-none d-md-block floating-date changelog-date">{{ changelog.created_at | moment('from', 'now') }}</span>
                <div v-html="changelog.body"></div>
                <hr/>
            </div>
            <div class="col-12 text-center" v-if="pagination && pagination.current_page !== pagination.last_page">
                <a href="#" @click="nextPage" class="pt-5 pb-5 text-muted">Show previous changelogs</a>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    name : "PublishedChangelogComponent.vue",
    props : {
        project : String,
        initial_data : String
    },
    data : function(){
        return {

        }
    },
    computed : {
        ...mapGetters(['changelogs', 'pagination']),
        getJsonParsedInitialData : function(){
            return JSON.parse(this.initial_data);
        },
        getJsonParsedProject : function()
        {
            return JSON.parse(this.project);
        }
    },
    methods : {
        ...mapActions(['getPublishedChangelogs', 'getCategories', 'setProject', 'setInitialChangelogsData']),
        nextPage : function(e){
            let project = this.getJsonParsedProject;
            let nextPage = this.pagination.current_page + 1;
            this.$store.dispatch('getPublishedChangelogs', { projectUuid : project.uuid, page : nextPage });
            e.preventDefault();
        }
    },
    mounted() {
        this.setInitialChangelogsData(this.getJsonParsedInitialData);
        //let project = this.getJsonParsedProject;
        //this.$store.dispatch('getPublishedChangelogs', { projectUuid : project.uuid });
    }
}
</script>

<style scoped>
    body {
        font-family: 'Montserrat', sans-serif !important;
    }

    .changelogs-container {
        padding-left: 10vw;
    }

    span.changelog-date {
        position: relative;
        font-size: 0.75rem;
    }

    span.floating-date {
        top: -69px;
        right: 975px;
        text-align: right;
    }
</style>
