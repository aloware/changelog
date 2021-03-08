<template>
    <b-card>
        <h4 data-v-5573eef4="" class="card-title">{{ changelog.title }} <small class="float-right text-muted changelog-date">
            <span v-if="!changelog.published_at"> Draft | </span> {{ changelog.created_at | moment('from', 'now') }}</small>
        </h4>
        <p v-html="changelog.body"></p>
        <hr/>
        <b-badge v-bind:variant="changelog.category_id | categoryVariant(this.categories)">{{ changelog.category_id | categoryLabel(this.categories) }}</b-badge>
        <b-button variant="outline-danger float-right" size="sm" v-if="!activeEditor" v-on:click="deleteAction">Delete</b-button>
        <b-button variant="outline-primary float-right" size="sm" v-if="!activeEditor" v-on:click="editAction">Edit</b-button>
    </b-card>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'
    export default {
        name: "ChangelogComponent",
        props : ['changelog'],
        computed : mapGetters(['categories', 'activeEditor']),
        filters : {
            categoryLabel : function(id, categories) {
                for (let i = 0; i < categories.length ; i++) {
                    if (parseInt(categories[i].id) === id) {
                        return categories[i].label;
                    }
                }
            },
            categoryVariant : function(id, categories){
                //need to do looping later as color will be on category props
                //for (let i = 0; i < categories.length ; i++) {
                let variant;
                switch (id) {
                   case 2:
                       variant = 'success';
                       break;
                   case 3:
                       variant = 'danger';
                       break;
                   case 1:
                   default:
                       variant = 'primary';
                       break;
                }
                //}

                return variant;
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
                this.deleteChangelog(this.changelog).then(function(response){
                    if ( typeof response !== 'undefined' && response.data.status === 'error') {
                        _this.$toastr.e("Error", response.data.message);
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
</style>
