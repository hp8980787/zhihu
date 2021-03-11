<template>
    <button
        class="btn"
        v-text="text"
        v-bind:class="{'btn-success':followed}"
        v-on:click="follow"
    ></button>
</template>

<script>
export default {
    name: "QuestionFollowButton",
    props: ['question', 'user'],
    mounted() {
        console.log(this.question, this.user);
        var object = this;
        axios.post('/api/question/follower', {
            question: object.question,
            user: object.user,
        })
            .then(function (response) {
                object.followed = response.data.followed;
                console.log(response.data.followed);
            })
            .catch(function (error) {
                console.log(error);
            });
    }, data() {
        return {
            followed: false,
        };
    }, computed: {
        text() {
            return this.followed ? '已关注' : '关注该问题';
        }
    }, methods: {
        follow: function () {
            var object = this;
            axios.post('/api/question/follow', {
                question: object.question,
                user: object.user,
            })
                .then(function (response) {
                    object.followed = response.data.followed;
                    console.log(response.data.followed);
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
}
</script>

<style scoped>

</style>
