<template>
    <photo class="gallery-photo" :link="fullSizePath()" :path="path"></photo>
</template>

<script>
    export default {
        props: [
            'path',
        ],
        methods: {
            fullSizePath: function () {
                return window.location.pathname + this.path + '-2000.jpg';
            },
        },
    }
</script>
