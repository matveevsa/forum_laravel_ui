<template>
    <div class="mb-2">
        <div class="card" :id="'reply-' + id">
            <div class="card-header">
                <div class="level">
                    <h5>
                        <a :href="'/profile/' + data.owner.name" v-text="data.owner.name"></a>
                        said <span v-text="ago"></span>
                    </h5>

                    <div v-if="signedIn">
                        <favorite :reply="data"></favorite>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div v-if="editing">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body"></textarea>
                    </div>

                    <button class="btn btn-sm btn-primary" @click="update">Update</button>
                    <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
                </div>

                <div v-else v-text="body"></div>
            </div>

            <div class="card-footer flex" v-if="canUpdate">
                <button class="btn btn-secondary btn-sm  mr-1" @click="editing = true">Edit</button>
                <button class="btn btn-danger btn-sm" @click="destroy">Delete</button>
            </div>
        </div>
    </div>
</template>
<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: {
            data: Object
        },

        components: {
            'favorite': Favorite
        },

        data() {
            return {
                body: this.data.body,
                id: this.data.id,
                editing: false,
            }
        },

        computed: {
            ago() {
                return moment(this.data.created_at).fromNow() + '...';
            },

            signedIn() {
                return window.App.signedIn;
            },

            canUpdate() {
                return this.authorize((user) => this.data.user_id == user.id);
            }
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.id, {
                    body: this.body
                });

                this.editing = false;

                flash('Updated!');
            },

            destroy() {
                axios.delete('/replies/' + this.id, {
                    body: this.body
                });

                this.$emit('deleted', this.id);
            }
        }
    }
</script>