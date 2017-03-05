<template>
    <div class="biography">
        <a href="https://joelvardy.com/" title="Learn a little more about me"><img src="/img/joel-vardy.jpg"></a>
        <p>I'm Joel Vardy, a {{ age() }} year old web developer. I've never really blogged (diary style) before, but I'm trying to document some of my trips for the future.</p>
    </div>
</template>

<style lang="scss">
    .biography {

        margin-bottom: 2em;

        img {
            border-radius: 60%;
            display: block;
            margin: 0 auto 1em;
            width: 60%;
        }

        p {
            text-align: center;
        }

    }
</style>

<script>
    export default {
        methods: {
            age: function () {
                return Math.floor(((new Date().getTime() / 1000) - 726624000) / 31557600);
            }
        },
    }
</script>
