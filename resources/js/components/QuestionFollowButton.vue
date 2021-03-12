<template>
    <div class="card">
    <div class="card-header" style="text-align: center">
        <h4>{{ followers_count }}</h4>
        <span>关注者</span>
    </div>
    <div class="card-body">
        <button
            class="btn"
            v-text="text"
            v-bind:class="{'btn-success':followed}"
            v-on:click="follow"></button>
        <a href="#">撰写答案</a>
    </div>
    </div>
</template>

<script>
export default {
    name: "QuestionFollowButton",
    props: ['question'],
    mounted() {
        var object = this;
        axios.post('/api/question/follower', {
            question: object.question,

        })
            .then(function (response) {
                object.followed = response.data.followed;
                object.followers_count = response.data.followers_count;
            })
            .catch(function (error) {
                console.log(error);
            });
    }, data() {
        return {
            followed: false,
            followers_count:1,

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
            })
                .then(function (response) {
                    object.followed = response.data.followed;
                    object.followers_count = response.data.followers_count;

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
