<template>
    <b-card>
        <div class="badge-container">
            <div>
                <h4 class="card-title mb-0 changelog-title">{{ changelog.title || 'Title' }} </h4>
                <b-badge v-bind:style="{ backgroundColor : changelog.category.bg_color, color : changelog.category.text_color }">{{ changelog.category.label }}</b-badge>
            </div>
            <small class="text-muted changelog-date">
                <span> {{ getInfoText }} </span>
                <relative-time-component :from_time="changelog.created_at" :humanized="true" v-if="changelog.created_at"></relative-time-component>
            </small>
        </div>

        <p v-html="changelog.body || 'Content'" class="mt-2 changelog-body"></p>

        <div class="footer-container" v-if="!showChangelogEditor">
            <div></div>
            <b-button-group>
                <b-button variant="primary" size="sm" v-on:click="editAction">
                    <font-awesome-icon :icon="['fas', 'pencil-alt']" />
                    Edit
                </b-button>
                <b-button variant="danger" size="sm" v-on:click="deleteAction">
                    <b-spinner small v-if="deletionInProgress" ></b-spinner>
                    <font-awesome-icon :icon="['fas', 'trash']" v-if="!deletionInProgress" />
                    Delete
                </b-button>
            </b-button-group>
        </div>

    </b-card>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'
    export default {
        name: "ChangelogComponent",
        props : ['changelog'],
        computed : {
            ...mapGetters(['categories', 'showChangelogEditor']),
            isFuturePublished : function(){

                if (!this.changelog.published_at || this.changelog.published_at.length < 1) {
                    return false;
                }

                return moment().isBefore(moment(this.changelog.published_at));
            },
            getInfoText : function(){
                let infoText;
                switch (true) {
                    case !this.changelog.published_at || (this.changelog.published_at && !this.changelog.id) :
                        infoText = 'Draft' + ((this.showChangelogEditor) ? '' : ' | ');
                        break;
                    case this.isFuturePublished :
                        infoText = 'To be published on ' + moment(this.changelog.published_at).format('MMM DD, YYYY') + ' |';
                        break;
                    default:
                        infoText = '';
                }

                return infoText;
            }
        },
        data(){
            return {
                deletionInProgress : !1,
                deleteButtonIndexClicked : null
            }
        },
        methods : {
            ...mapActions(['editChangelog', 'deleteChangelog']),
            editAction : function(){
                this.editChangelog(this.changelog);
            },
            deleteAction : function()
            {
                let _this = this;
                this.$confirm({
                    message : 'Are you sure you want to delete this changelog?',
                    button: {
                        no: 'No',
                        yes: 'Yes'
                    },
                    callback: confirm => {
                        if (confirm) {
                            this.deletionInProgress = !0
                            this.deleteChangelog(this.changelog).then(function(response){
                                if ( typeof response !== 'undefined' && response.data.status === 'error') {
                                    _this.$toastr.e("Error", response.data.message);
                                }
                            });
                        }
                    }
                });
            }
        }
    }
</script>

<style scoped>
    .badge-container {
        display: flex;
        justify-content: space-between;
    }


    .changelog-date {
        font-size: 0.8rem;
    }

    img {
        height: auto !important;
        width: 100% !important;
    }

    .footer-container {
        display : flex;
        justify-content: space-between;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        padding-top: 5px;
    }
</style>
