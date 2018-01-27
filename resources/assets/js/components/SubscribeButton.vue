<template>
    <button :class="classes" @click="subscribe">Subscribe</button>
</template>

<script>
    export default {

        data() {
            return {
                active: this.active
            };
        },

        computed: {
            classes() {
                return ['btn', this.active ? 'btn-primary' : 'btn-default'];
            }
        },

        methods: {
            subscribe() {
                axios[(this.active ? 'delete' : 'post')](location.pathname + '/subscriptions');

                this.active = ! this.active;

                flash('Subscribed');
            }
        }
    }
</script>