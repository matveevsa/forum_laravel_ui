<template>
    <div class="alert alert-success alert-flash" role="alert" v-show="show">
        <strong>Success!</strong> {{ body }}
    </div>
</template>

<script>
    export default {
        props: {
            message: {
                type: String
            }
        },
        data() {
            return {
                body: '',
                show: false,
            }
        },
        created() {
            if (this.message) {
                this.flash(this.message);
            }

            window.events.$on('flash', (message) => this.flash(message));
        },
        methods: {
            flash(message) {
                if (this.message) {
                    this.body = message;
                    this.show = true;

                    this.hide();
                }
            },

            hide() {
                setTimeout(() => this.show = false, 3000);
            }
        }
    }
</script>

<style scoped>
    .alert-flash {
        width: 25%;
        position: fixed;
        bottom: 50px;
        right: 0;
    }
</style>>
