<template>
    <ul class="list-group list-group-horizontal">
        <li class="list-group-item"><i class="fa fa-thumbs-o-up"></i>{{ like_counts }}</li>
        <li class="list-group-item"><a v-on:click="like()"><i v-bind:class="is_like?'question-unlike':'question-like'"
                                                              class="fa fa-heart"></i>{{ text }}</a></li>
        <li class="list-group-item">回复</li>
        <li class="list-group-item">举报</li>
    </ul>
</template>

<script>
export default {
    name: "AnswerLikeButton",
    props: ['answer'],
    data() {
        return {
            "is_like": false,
            "like_counts": 0,
        };
    },
    mounted() {
        var like = this;
        axios.get('/api/answer-islike?answer_id=' + like.answer)
            .then(function (response) {
            like.is_like = response.data.is_like;
        }).catch(function (error) {

        });
    },
    computed: {
        imgLikePath() {
            return this.is_like ? '/image/liked.png' : '/image/like.png';
        }, text() {
            return this.is_like ? '取消喜欢' : '喜欢';
        }
    }, methods: {
        like: function () {
            var like = this;
            axios.post('/api/answer-like', {
                'answer_id': like.answer,
            }).then(function (response) {
                like.is_like = response.data.is_like;
                like.like_counts = response.data.like_count;

                console.log(response.data);
            }).catch(function (error) {

            });
        }
    }

}
</script>

<style scoped>

</style>
