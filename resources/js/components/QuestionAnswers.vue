<template>
    <div style="text-align: center" v-if="is_load"><img src="/image/load.gif" alt=""></div>
    <div v-else>
        <ul class="list-unstyled">
            <li v-for="answer in answers" style="margin: 30px 30px">
                <div class="" style="width: 100%">
                    <a href="">
                        <img :src="answer.user.avatar" width="30px"
                             class="align-self-start mr-3"
                             :alt="answer.user.name"></a>
                    <a href=""> {{ answer.user.name }}</a>
                    <span class="float-right">{{ answer.created_at }}</span>
                </div>
                <div style="padding-left: 30px">
                    <p v-html="answer.body"></p>
                </div>
                <ul class="list-group list-group-horizontal">
                    <li class="list-group-item"><i class="fa fa-thumbs-o-up"></i>{{ like_counts }}</li>
                    <li class="list-group-item"><a v-on:click="like()"><i
                        v-bind:class="isLike(answer.votes)?'question-unlike':'question-like'"
                        class="fa fa-heart"></i>{{ text }}</a></li>
                    <li class="list-group-item">回复</li>
                    <li class="list-group-item">举报</li>
                </ul>
            </li>
        </ul>

    </div>

</template>

<script>
export default {
    name: "QuestionAnswers",
    props: ['question'],
    data() {
        return {
            answers: [],
            "is_load": true,
            "like_counts": 0,
        };
    },
    mounted() {
        this.selectAll();
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
                this.selectAll();
            }).catch(function (error) {

            });
        },
        selectAll: function () {
            var like = this;
            axios.get('/api/answers?question=' + like.question)
                .then(function (response) {
                    like.is_load = false;
                    like.answers = response.data;
                    console.log(response);
                }).catch(function (error) {

            });
        },
        isLike: function (votes) {
            console.log(typeof votes);
            if (typeof (votes) == 'object') {
                return votes.length > 0 ? true : false;
            }
        }
    }

}
</script>

<style scoped>

</style>
