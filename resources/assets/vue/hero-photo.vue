<template>
    <a :class="'hero-photo ' + imageStatus()" v-bind:href="link"></a>
</template>

<style lang="scss">
    .hero-photo {

        background: no-repeat center center;
        background-size: cover;
        display: block;
        height: 12em;
        margin: -3em -3em 3em;

        &.loading {
            background: rgb(220, 220, 220) url('/img/loading.svg') no-repeat center;
            background-size: 10%;
        }

    }
</style>

<script>
    export default {
        props: [
            'path',
            'link',
        ],
        data: function () {
            return {
                loaded: false,
            };
        },
        mounted: function () {
            var _this = this;
            var img = new Image();
            img.onload = function () {
                 _this.$el.setAttribute('style', 'background-image: url(' + _this.responsivePath() + ')');
                _this.loaded = true;
            };
            img.src = this.responsivePath();
        },
        methods: {
            imageStatus: function () {
                return this.loaded ? 'loaded' : 'loading';
            },
            responsivePath: function () {
                return this.path + '/' + (window.innerWidth > 900 ? '1200' : '600') + '.jpg';
            },
        },
    }
</script>
