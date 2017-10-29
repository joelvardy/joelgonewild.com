<template>
    <a ref="heroPhoto" :class="'hero-photo ' + imageStatus()" v-bind:href="link"></a>
</template>

<style lang="scss">
    .hero-photo {

        background: no-repeat center center;
        background-size: cover;
        display: block;
        height: 12em;
        margin: -3em -3em 3em;

        &.tall {
            height: 15em;
        }

        &.loading {
            background: rgb(220, 220, 220) url('/assets/loading.svg') no-repeat center;
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
                 _this.$el.setAttribute('style', 'background-image: url("' + _this.responsivePath() + '")');
                _this.loaded = true;
            };
            img.src = this.responsivePath();
        },
        methods: {
            imageStatus: function () {
                return this.loaded ? 'loaded' : 'loading';
            },
            responsivePath: function () {
                if (this.$refs.heroPhoto.clientWidth <= 400) {
                    return this.path + '-400.jpg';
                } else if (this.$refs.heroPhoto.clientWidth <= 800) {
                    return this.path + '-800.jpg';
                } else if (this.$refs.heroPhoto.clientWidth <= 1200) {
                    return this.path + '-1200.jpg';
                } else if (this.$refs.heroPhoto.clientWidth <= 1600) {
                    return this.path + '-1600.jpg';
                }
                return this.path + '-2000.jpg';
            },
        },
    }
</script>
