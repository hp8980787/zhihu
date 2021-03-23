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
                    <li class="list-group-item"><i class="fa fa-thumbs-o-up"></i>{{ answer.votes_count }}</li>
                    <li class="list-group-item">
                        <a v-on:click="like(answer.id)">
                            <i v-bind:class="isLike(answer.id)?'question-unlike':'question-like'"
                               v-text="isLike(answer.id)?'取消关注':'喜欢'"
                               class="fa fa-heart"></i></a></li>
                    <li class="list-group-item">回复</li>
                    <li class="list-group-item">举报</li>
                    <li v-on:click="answerDel(answer.id)" v-if="userId==answer.user.id?true:false"
                        class="list-group-item">删除回复
                    </li>
                </ul>
            </li>
        </ul>

    </div>

</template>

<script>
export default {
    name: "QuestionAnswers",
    props: ['question', 'user'],
    data() {
        return {
            answers: [],
            "is_load": true,
            "like_counts": 0,
            likes: [],

        };
    },
    mounted() {
        this.selectAll();
    },
    computed: {
        imgLikePath() {
            return this.is_like ? '/image/liked.png' : '/image/like.png';
        },
        userId() {

            return this.user?JSON.parse(this.user).id:false;
        }
    }, methods: {
        async like(answer) {

            let {data} = await axios.post('/api/answer-like', {
                answer_id: answer,
                question: this.question,
            });
            let {answers, likes} = data;
            this.answers = answers;
            this.likes = likes;
            console.log(data);
        },
        async selectAll() {
            let {data} = await axios.get('/api/answers?question=' + this.question);
            if (data.answers.length > 0) {
                this.is_load = false;
            }
            let {answers, likes} = data;
            this.answers = answers;
            this.likes = likes;
            this.is_load = false;

        },
        async answerDel(answer) {
            let {data} = await axios.delete('/api/answers/'+answer,{
                params:{
                    user_id:this.userId
                }
            });
           return this.selectAll();
            console.log(data);
        },

        isLike(answer_id) {

            var data = this.likes;
            if (typeof (data) == 'object') {
                for (var i in data) {
                    if (data[i] == answer_id) {
                        return true;
                    }
                }
            }
            return false;
        },

    }

}
</script>

<style scoped>

</style>
