<template>
    <ul class="pagination" v-if="shoudlPaginate">
        <li v-show="prevUrl">
            <!--will prevent all click-->
            <a class="page-link" href="#" @click.prevent="page--">Prev</a>
        </li>
        <li v-show="nextUrl">
            <a class="page-link" href="#" @click.prevent="page++">Next</a>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['dataSet'],

        data() {
            return {
                page: 1,
                prevUrl: false,
                nextvUrl: false
            }
        },

        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;

            },

            page() {
                this.broadcast().updateUrl();
            }
        },

        computed: {
            shoudlPaginate() {
                return !! this.prevUrl || !!this.nextUrl;
            }
        },
        
        methods: {
            broadcast() {
                return this.$emit('changed', this.page);
            },

            updateUrl() {
                history.pushState(null, null, '?page=' + this.page);
            }

        }
    }
</script>