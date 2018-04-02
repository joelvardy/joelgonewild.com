<template>
    <a class="photo" ref="container" :href="link"><img :src="imagePath"></a>
</template>

<style lang="scss">
    a.photo {
        display: block;
        img {
            max-width: 100%;
        }
    }
</style>

<script>
    export default {
        props: [
            'link',
            'path',
        ],
        data: function () {
            return {
                imagePath: '',
            };
        },
        mounted: function () {
            this.imagePath = this.responsivePath();
        },
        methods: {
            responsivePath: function () {
                if (this.$refs.container.clientWidth <= 400) {
                    return window.location.pathname + this.path + '-800.jpg';
                } else if (this.$refs.container.clientWidth <= 800) {
                    return window.location.pathname + this.path + '-1200.jpg';
                } else if (this.$refs.container.clientWidth <= 1200) {
                    return window.location.pathname + this.path + '-1600.jpg';
                }
                return window.location.pathname + this.path + '-2000.jpg';
            },
        },
    }
</script>
