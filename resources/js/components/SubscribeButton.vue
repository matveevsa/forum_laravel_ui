<template>
    <button :class="classes" @click="subscribe">{{ !this.active ? 'Subscribe' : 'Unsubscribe' }}</button>
</template>

<script>
export default {
    props: ['active'],

    computed: {
        classes() {
            return ['btn', this.active ? 'btn-primary' : 'btn-outline-secondary']
        }
    },

    methods: {
        subscribe() {
            const requestType = this.active ? 'delete' : 'post';

            axios[requestType](location.pathname + '/subscriptions');

            this.active = !this.active;

            flash(this.active ? 'Subscribed!' : 'Unsubscribed!');
        }
    }
}
</script>