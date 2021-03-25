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
                    <li class="list-group-item"><a v-on:click="selectComments(answer.id)" style="color:#4e555b"
                                                   data-toggle="modal" data-target="#exampleModal"
                                                   href="javascript:;">评论</a></li>
                    <li class="list-group-item">举报</li>
                    <li v-on:click="answerDel(answer.id)" v-if="userId==answer.user.id?true:false"
                        class="list-group-item">删除回复
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            <li class="list-group-item">An item</li>
                            <li class="list-group-item">A second item</li>
                            <li class="list-group-item">A third item</li>
                            <li class="list-group-item">A fourth item</li>
                            <li class="list-group-item">And a fifth one</li>
                        </ul>
                        <form style="text-align: center">
                            <input type="text"  v-model="comment"  name="comment"> <a v-on:click="sendComment()" class="btn btn-info">发送</a>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">submit</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
import WangEditor from "./Editor/WangEditor";

$('#myModal').on('shown.bs.modal', function () {
    $('#myInput').trigger('focus')
})
export default {
    name: "QuestionAnswers",
    components: {WangEditor},
    props: ['question', 'user'],
    data() {
        return {
            answers: [],
            "is_load": true,
            "like_counts": 0,
            likes: [],
            comments: {},
            comment:'',
            comment_answer_id:0,

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

            return this.user ? JSON.parse(this.user).id : false;
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
            let {data} = await axios.delete('/api/answers/' + answer, {
                params: {
                    user_id: this.userId
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
       async selectComments(answer_id) {
           this.comment_answer_id = answer_id;
        },async sendComment() {

            let{data} = await axios.post('/api/comment',{
                type:'answer',
                body:this.comment,
                user_id:this.userId,
                model:this.comment_answer_id,
            })
            console.log(this.comment);
        }

    }

}
</script>

<style scoped>
#exampleModalLabel {
    width: 800px;
}

@media (min-width: 576px) {
    .modal-dialog {
        max-width: 600px;
    }
}
</style>
