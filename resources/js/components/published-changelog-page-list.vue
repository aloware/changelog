<template>
    <div class="container mt-5">
        <b-overlay
            :show="showOverlay"
            rounded="sm"
            :opacity="0.42"
        >
            <div class="row changelogs-container">
                <div v-for="(changelog, index) in changelogs" :key="changelog.id" class="page-list-container">
                    <div class="col-12 changelog-list">

                        <div class="badge-container">
                            <div>
                                <h4 class="changelog-title mb-0">{{ changelog.title }}</h4>
                                <small class="text-muted">
                                    <relative-time-component class="inline-date changelog-date" :from_time="changelog.created_at" :humanized="true" :update_interval="60000"></relative-time-component>
                                </small>
                            </div>
                            <b-badge v-bind:style="{ backgroundColor : changelog.category.bg_color, color : changelog.category.text_color }">{{ changelog.category.label }}</b-badge>
                        </div>

                        <div class="changelog-body" v-html="changelog.body"></div>
                    </div>
                    <h2 class="hr-line-text"><span></span></h2>
                </div>

                <div class="col-12 text-center" v-if="pagination && pagination.current_page !== pagination.last_page">
                    <span v-if="gettingNextPage" class="text-muted"><b-spinner></b-spinner> <br/>Working on previous changelogs...</span>
                    <a href="#" @click="nextPage" class="pt-5 pb-5 text-muted" v-if="!gettingNextPage">Show previous changelogs</a>
                </div>

                <div class="col-12" v-if="changelogs.length < 1 && !showOverlay">
                    <b-alert show variant="info">
                        <p>
                            No changelog available as of the moment. Meanwhile, you can visit our website for more information.
                        </p>
                        <hr>
                        <b-button variant="primary" :href="getJsonParsedProject.url">Take me to the website</b-button>
                    </b-alert>
                </div>
            </div>
            <template #overlay>
                <div class="text-center">
                    <font-awesome-icon :icon="['fas', 'spinner']" spin />
                    <p id="cancel-label">{{ overlayMessage }}</p>
                </div>
            </template>
        </b-overlay>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    name : "PublishedChangelogComponent.vue",
    props : {
        project : String,
    },
    data : function(){
        return {
            gettingNextPage : false,
            showOverlay : false,
            overlayMessage : ''
        }
    },
    computed : {
        ...mapGetters(['changelogs', 'pagination']),
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
            this.gettingNextPage = true;
            this.getPublishedChangelogs({ projectUuid : project.uuid, page : nextPage }).then(response => {
                this.gettingNextPage = false;
            });

            e.preventDefault();
        },

    },
    mounted() {
        this.showOverlay = true;
        this.overlayMessage = 'Preparing your changelogs...';
        this.getPublishedChangelogs({ projectUuid : this.getJsonParsedProject.uuid } ).then(response => {
            this.showOverlay = false;
            this.overlayMessage = '';
        })
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
        top: 5px;
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
        margin-bottom: 0.5rem !important;
    }

    .changelog-list {
        padding: 10px;
        border-radius: 10px;
    }

    .changelog-list:not(:last-child) {
        margin-bottom: 25px;
    }

    .page-list-container {
        width: 100%;
    }

    .changelog-clock-icon {
        margin-right: 3px;
    }

    .changelogs-container .badge {
        height: 20px !important;
    }
</style>
