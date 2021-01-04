<template>
    <button :class="classes" @click="toggle">
        <i class="fas fa-heart"></i>
        <span v-text="count"></span>
    </button>
</template>

<script>
export default {
    props: ['reply'],

    data() {
        return {
            count: this.reply.favoritesCount,
            active: this.reply.isFavorited,
        }
    },

    computed: {
        classes() {
            return [
                'btn',
                this.active ? 'btn-outline-primary' : 'btn-outline-secondary'
            ];
        },

        endpoint() {
            return '/replies/' + this.reply.id + '/favorites';
        }
    },

    methods: {
        toggle() {
            this.active ? this.destroy() : this.create();
        },

        destroy() {
            axios.delete(this.endpoint);

            this.active = false;
            this.count -= 1;
        },

        create() {
            axios.post(this.endpoint);

            this.active = true;
            this.count += 1;
        }
    }
}
</script>

<style scoped>
    .color-gray {
        color: #818181;
    }

</style>