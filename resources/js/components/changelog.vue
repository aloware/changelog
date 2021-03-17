<template>
    <b-card>
        <h4 data-v-5573eef4="" class="card-title">{{ changelog.title }}
            <small class="float-right text-muted changelog-date">

            <span v-if="!changelog.published_at"> Draft | </span>
                <relative-time-component :from_time="changelog.created_at" :humanized="true" v-if="changelog.created_at"></relative-time-component>
            </small>
        </h4>
        <b-badge v-bind:style="{ backgroundColor : changelog.category.bg_color, color : changelog.category.text_color }">{{ changelog.category.label }}</b-badge>
        <p v-html="changelog.body" class="mt-3"></p>
        <hr/>
        <div class="footer-container">
            <div></div>
            <b-button-group>
                <b-button variant="outline-success" size="sm" v-if="!showChangelogEditor" v-on:click="editAction">
                    <font-awesome-icon :icon="['fas', 'pencil-alt']" />
                    Edit
                </b-button>
                <b-button variant="outline-danger" size="sm" v-if="!showChangelogEditor" v-on:click="deleteAction">
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
        computed : mapGetters(['categories', 'showChangelogEditor']),
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
    }
</style>
