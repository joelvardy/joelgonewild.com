<template>
    <a :href="link"><img :src="responsivePath()"></a>
</template>

<style lang="scss">
    a img {
        max-width: 100%;
    }
</style>

<script>
    export default {
        props: [
            'link',
            'path',
        ],
        methods: {
            responsivePath: function () {
                return window.location.pathname + '/' + this.path + '/' + (window.innerWidth > 900 ? '1200' : '600') + '.jpg';
            },
        },
    }
</script>
