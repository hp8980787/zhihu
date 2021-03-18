<template>
   <li class="list-group-item"><a ><i v-bind:class="is_like?'question-unlike':'question-like'" class="fa fa-heart"></i>{{ text }}</a></li>
</template>

<script>
export default {
    name: "QuestionLikeButton",
    props: ['question_id'],
    data() {
        return {
            "is_like": false,

        };
    },
    mounted() {
        var like = this;
        axios.post('/api/queation-like', {
            'question_id': like.question_id,
        }).then(function (response) {

        }).catch(function (error) {

        });
    },
    computed: {
        imgLikePath() {
            return this.is_like ? '/image/liked.png' : '/image/like.png';
        }, text() {
            return this.is_like ? '取消喜欢' : '喜欢';
        }
    },
}
</script>

<style scoped>

</style>
