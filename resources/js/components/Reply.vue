<script>
    export default {
        props: {
            attributes: Object
        },

        data() {
            return {
                body: this.attributes.body,
                editing: false
            }
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.attributes.id, {
                    body: this.body
                });

                this.editing = false;

                flash('Updated!');
            },

            destroy() {
                axios.delete('/replies/' + this.attributes.id);

                $(this.$el).fadeOut(300, () => {
                    flash('Reply has been deleted!');
                })
            }
        }
    }
</script>