<template>
    <ul class="categories">
        <li v-for="category in categories"><a :href="'/category/' + category.slug" :title="'View posts from ' + category.title">{{ category.title }}</a></li>
    </ul>
</template>

<style lang="scss">
    .categories {

        list-style: none;

        li {

            background: rgb(240, 240, 240);
            border-bottom: 1px solid rgb(230, 230, 230);

            &:last-child {
                border-bottom: 0;
            }

            a {
                display: block;
                font-size: 1.1em;
                padding: 0.75em 1em;
                text-decoration: none;
            }

        }

    }
</style>

<script>
    export default {
        data: function () {
            return {
                categories: [],
            };
        },
        mounted: function () {
            var _this = this;
            this.$http.get('/api/category').then(function (response) {
                _this.categories = response.body.categories;
            }, function () {
                // Error, unable to load categories
            });
        },
    }
</script>
