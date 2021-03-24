<template>
    <div>
        <div class="module-heading">
            <h5>Categories</h5>
            <b-button variant="primary" class="float-right" v-on:click="addCategory">
                <font-awesome-icon :icon="['fas', 'plus']" />
                Add a category
            </b-button>
        </div>
        <hr/>

        <b-list-group>
            <b-list-group-item v-for="(category, index) in categories" :key="category.id">
                <category-component v-bind:category="category"></category-component>
                <b-button-group>
                    <b-button variant="primary" size="sm" v-on:click="editCategory(category)">
                        <font-awesome-icon :icon="['fas', 'pencil-alt']" />
                        Edit
                    </b-button>
                    <b-button variant="danger" size="sm" v-on:click="deleteCategory(category, index)" :disabled="deletionInProgress && deleteButtonIndexClicked === index">
                        <b-spinner small v-if="deletionInProgress && deleteButtonIndexClicked === index"></b-spinner>
                        <font-awesome-icon :icon="['fas', 'trash']" v-if="!deletionInProgress"/>
                        Delete
                    </b-button>
                </b-button-group>
            </b-list-group-item>
        </b-list-group>
        <category-form-component v-bind:companyid="companyid"></category-form-component>

    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    export default {
        name: "CategoriesComponent",
        props : {
            lists : String,
            companyid : String
        },
        data (){
            return {
                deletionInProgress : !1,
                deleteButtonIndexClicked : null
            }
        },
        computed : {
            ...mapGetters(['showCategoryEditor', 'category', 'categories']),
            getJsonParsedList : function(){
                return JSON.parse(this.lists)
            }
        },
        methods : {
            ...mapActions(['deleteCategory']),
            addCategory : function(){
                this.$store.commit('addCategory', this.$store.state)
                this.$bvModal.show('category-form-modal')
            },
            editCategory : function(category){
                this.$store.state.category = category;
                this.$store.commit('editCategory', category )
                this.$bvModal.show('category-form-modal')
            },
            deleteCategory : function(category, index){
                this.$confirm({
                    message : 'Are you sure you want to delete this category?',
                    button: {
                        no: 'No',
                        yes: 'Yes'
                    },
                    callback: confirm => {
                        if (confirm) {
                            this.deleteButtonIndexClicked = index
                            this.deletionInProgress = !0
                            this.$store.dispatch('deleteCategory', { vm : this, category : category })
                        }
                    }
                });
            }
        },
        mounted : function(){
            this.$store.commit('setCategories', this.getJsonParsedList)
        }
    }
</script>

<style scoped>
    .module-heading {
        flex-shrink: 0;
        flex-basis: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .list-group-item {
        display: flex;
        justify-content: space-between;
    }
</style>
