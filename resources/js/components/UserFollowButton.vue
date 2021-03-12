<template>
    <a style="width: 50%" class="btn" v-bind:class="btnStyle" v-text="text" v-on:click="follow()"></a>
</template>

<script>
export default {
    name: "UserFollowButton",
    props: ['followed_id'],
    mounted() {
        var follow = this;
        axios.post('/api/user-isfollow', {
            followed_id: follow.followed_id,
        }).then(function (response) {
            follow.is_followed = response.data.is_followed;
            console.log(response);
        }).catch(function (error) {

        });
    },
    data() {
        return {
            is_followed: false,
        }
    },
    computed: {
        text() {
            return this.is_followed ? '已关注' : '+关注';
        },
        btnStyle() {
            return this.is_followed ? 'btn-secondary' : 'btn-success';
        }
    }, methods: {
        follow: function () {
            var follow = this;
            axios.post('/api/user-follow', {
                followed_id: follow.followed_id,
            }).then(function (response) {
                follow.is_followed = response.data.is_followed;
            }).catch(function (error) {

            });
        }
    },
}
</script>

<style scoped>

</style>
