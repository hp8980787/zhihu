<template>
    <div>
        <user-follow-button :followed_id="followed_id"></user-follow-button>
        <a class="btn btn-info" v-on:click="toShow()" href="javascript:;">发私信</a>

        <div class="messageToUser" style="transition: 0.3s" v-bind:style="is_display?'':'display:none'">
            <form action="">

                <h4><span>To</span>:{{ questionuser }}</h4>
                <div id="demo1"></div>


                <textarea style="display: none" name="" id="" cols="170" rows="20" readonly
                          v-model="editorData"></textarea>
                <button type="button" v-on:click="send()" class="btn btn-info">发送</button>
                <a class="close" href="javascript:;" v-on:click="toShow()">关闭</a>
            </form>
        </div>
    </div>

</template>

<script>

import wangEditor from 'wangeditor'
import Swal from 'sweetalert2'

export default {
    name: "MessagesButton",
    props: ['followed_id', 'user', 'questionuser'],
    mounted() {
        const editor = new wangEditor(`#demo1`)
        editor.config.menus = [
            'bold',
            'head',
            'link',
            'italic',
            'underline'
        ]
        // 配置 onchange 回调函数，将数据同步到 vue 中
        editor.config.onchange = (newHtml) => {
            this.editorData = newHtml
        }
        // 创建编辑器
        editor.create()
        this.editor = editor
    },
    data() {
        return {
            editor: null,
            editorData: '',
            is_display: false
        }
    }, computed: {
        userObject() {
            return JSON.parse(this.user);
        }
    }, methods: {
        getEditorData() {
            // 通过代码获取编辑器内容
            let data = this.editor.txt.html()
        }, toShow() {
            this.is_display = !this.is_display;

            console.log(this.questionuser)
        }, async send() {

            if (!this.user) {
                Swal.fire('您未登录', '请先登录', 'error');

            } else {
                let body = this.editor.txt.html();
                if (body.length == 0) {
                    Swal.fire('发送错误', '发送内容不能为空!', 'error')
                }
                let {data} = await axios.post('/api/messages/store', {

                        to_user_id: this.followed_id,
                        body: body,
                        from_user_id: this.userObject.id,

                })
                if (data.status == 200) {

                    Swal.fire(data.message);
                } else {
                    Swal.fire(data.message);
                }

            }
        }
    },
    beforeDestroy() {
        // 调用销毁 API 对当前编辑器实例进行销毁
        this.editor.destroy()
        this.editor = null
    },


}
</script>

<style lang="scss">
@import "~sweetalert2/src/sweetalert2";

.messageToUser {
    background-color: #ccc;
    width: 500px;
    margin: auto;
    position: fixed;
    left: 33%;
    top: 40%;
    height: 200px;
    z-index: 999;

    .btn {
        position: absolute;
        right: 10px;
        top: 25px;
        padding: 5px 10px;
        cursor: pointer;
    }

    .close {
        position: absolute;
        left: 10px;
        top: 10px;
        font-size: 12px;
        color: #761b18;
    }

    h4 {
        margin: 30px 0 15px;
        padding-left: 5px;

        span {
            color: #6cb2eb;
        }
    }
}
</style>
