<template>
    <div>
        <div v-for="(reply, i) in items" :key="i">
            <reply :data="reply" @deleted="remove(i)"></reply>
        </div>
    </div>
</template>

<script>
import Reply from './Reply.vue';

export default {
    components: { Reply },

    props: ['data'],

    data() {
        return {
            items: this.data
        }
    },

    methods: {
        remove(i) {
            this.items.splice(i, 1);

            this.$emit('remove');

            flash('Reply was deleted');
        }
    }
}
</script>