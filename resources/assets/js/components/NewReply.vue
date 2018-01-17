<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <textarea 
                    name="body"    
                    id="body"
                    class="form-control"
                    placeholder="have something to say?"
                    rows="5"
                    required
                    v-model="body" />
            </div>

            <button
                type="submit"
                class="btn btn-default"
                @click="addReply">Post</button>
        </div>

        <p class="text-center" v-else>
            please <a href="/login">sign in</a> to participate discussion.
        </p>
    </div>
</template>

<script>
    export default {
        props: ['endpoint'],

        data() {
            return {
                body: ''
            };
        },

        computed: {
            signedIn() {
                return window.App.signedIn
            }
        },

        method: {
            addReply() {
                axios.post(this.endpoint, { body: this.body })
                     .then(({data}) => {
                         this.body = '';

                         flash('your reply has been posted');

                         this.$emit('created', data);
                     });
            }
        }

    }
</script>

