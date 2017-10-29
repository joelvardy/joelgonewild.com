<template>
    <div class="gallery">
        <slot></slot>
    </div>
</template>

<style lang="scss">
    .gallery {

        overflow: hidden;

        .gallery-photo {

            display: block;

            img {
                display: block;
                max-width: 100%;
            }

        }

        &.photos-1 {
            .gallery-photo {
                width: 100%;
            }
        }

        &.photos-2, &.photos-3, &.photos-4, &.photos-5, &.photos-6 {
            .gallery-photo {

                border: 1px solid rgb(220, 220, 220);
                float: left;
                margin-right: 5%;
                padding: 0.5%;

                &:last-child {
                     margin-right: 0;
                 }

            }
        }

        &.photos-2 {
            .gallery-photo {
                width: 47.5%;
            }
        }

        &.photos-3 {
            .gallery-photo {

                width: 30%;

                @media screen and (max-width: 800px) {

                    width: 47.5%;

                    &:nth-child(2) {
                         margin-right: 0;
                     }

                    &:last-child {
                         margin-top: 5%;
                         width: 100%;
                     }

                }

            }
        }

        &.photos-4 {
            .gallery-photo {

                width: 21.25%;

                @media screen and (max-width: 800px) {

                    width: 47.5%;

                    &:nth-child(2) {
                        margin-right: 0;
                    }

                    &:nth-child(3), &:last-child {
                        margin-top: 5%;
                    }

                }

            }
        }

        &.photos-5 {
            .gallery-photo {

                width: 30%;

                &:nth-child(3) {
                    margin-right: 0;
                }

                &:nth-child(4), &:last-child {
                    margin-top: 5%;
                    width: 47.5%;
                }

                @media screen and (max-width: 800px) {

                    width: 47.5%;

                    &:nth-child(3) {
                        margin-right: 5%;
                    }

                    &:nth-child(2), &:nth-child(4) {
                        margin-right: 0;
                    }

                    &:nth-child(3), &:nth-child(3), &:last-child {
                        margin-top: 5%;
                    }

                    &:last-child {
                        width: 100%;
                    }

                }

            }
        }

        &.photos-6 {
            .gallery-photo {

                width: 30%;

                &:nth-child(3), &:last-child {
                    margin-right: 0;
                }

                &:nth-child(4), &:nth-child(5), &:last-child {
                    margin-top: 5%;
                }

                @media screen and (max-width: 800px) {

                    width: 47.5%;

                    &:nth-child(3) {
                        margin-right: 5%;
                    }

                    &:nth-child(2), &:nth-child(4) {
                        margin-right: 0;
                    }

                    &:nth-child(3), &:nth-child(4), &:nth-child(5), &:last-child {
                        margin-top: 5%;
                    }

                }

            }
        }

    }
</style>

<script>
    export default {
        mounted: function () {
            this.$el.classList.add('photos-' + this.$children.length);
        },
    }
</script>
