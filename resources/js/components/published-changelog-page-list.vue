<template>
    <div class="container mt-5">
        <div class="row changelogs-container">
            <div class="col-12 changelog-list" v-for="(changelog, index) in changelogs" :key="changelog.id">

                <div class="badge-container">
                    <b-badge v-bind:style="{ backgroundColor : changelog.category.bg_color, color : changelog.category.text_color }">{{ changelog.category.label }}</b-badge>
                    <small class="text-muted d-md-none">
                        <font-awesome-icon :icon="['far', 'clock']" />
                        <relative-time-component class="inline-date changelog-date" :from_time="changelog.created_at" :humanized="true" :update_interval="60000"></relative-time-component>
                    </small>
                </div>
                <div class="floating-date text-muted d-none d-md-block d-md-block">
                    <font-awesome-icon :icon="['far', 'clock']" />
                    <relative-time-component class="changelog-date" :from_time="changelog.created_at" :humanized="true" :update_interval="60000"></relative-time-component>
                </div>
                <span class="changelog-title">{{ changelog.title }}</span>
                <div class="changelog-body" v-html="changelog.body"></div>
            </div>
            <div class="col-12 text-center" v-if="pagination && pagination.current_page !== pagination.last_page">
                <span v-if="loading" class="text-muted"><b-spinner></b-spinner> <br/>Working on previous changelogs...</span>
                <a href="#" @click="nextPage" class="pt-5 pb-5 text-muted" v-if="!loading">Show previous changelogs</a>
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
            loading : false
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
            this.loading = true;
            this.$store.dispatch('getPublishedChangelogs', { vm : this, projectUuid : project.uuid, page : nextPage });
            e.preventDefault();
        }
    },
    mounted() {
        this.setInitialChangelogsData(this.getJsonParsedInitialData);
    }
}
</script>

<style scoped>
    .changelogs-container {
        overflow: hidden;
        height: 100%;
    }


    @media (min-width: 768px) {
        .changelogs-container {
            padding-left: 10vw;
        }
    }

    span.changelog-date {
        position: relative;
        font-size: 0.75rem;
        text-align: right;
    }
    span.inline-date {
        top: 0 !important;
    }

    div.floating-date {
        top: 12px;
        left: -976px;
        text-align: right;
        position: absolute;
        width: 100%;
    }

    .floating-date .changelog-date {
        top: -1px;
    }
    .floating-date .fa-clock {
        margin-right: 4px;
    }

    .badge-container {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px!important;
    }

    .changelog-list {
        padding: 10px;
        border-radius: 10px;
    }

    .changelog-list:hover {
        background: hsl(240deg 20% 98%);
    }

    .changelog-list:not(:last-child) {
        margin-bottom: 25px;
    }
</style>
