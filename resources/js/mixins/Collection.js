export default {
    data() {
        return {
            items: [],
        };
    },
    
    methods: {
        add(item) {
            this.items.push(item);

            this.$emit('added');
        },

        remove(i) {
            this.items.splice(i, 1);

            this.$emit('remove');
        }
    }
}