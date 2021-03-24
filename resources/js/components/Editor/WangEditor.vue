<template>
    <div class="editor" style="transition: 0.3s">
        <form action="">

            <h4><span>To</span>:{{ questionuser }}</h4>
            <div id="demo1"></div>


            <textarea style="display: none" name="" id="" cols="170" rows="20" readonly
                      v-model="editorData"></textarea>
            <button type="button" class="btn btn-info">发送</button>
        </form>
    </div>
</template>

<script>
import wangEditor from "wangeditor";

export default {
    name: "WangEditor",
    data() {
        return {
            editor: null,
            editorData: '',
            is_display: true,
            questionuser: '',

        }
    }, mounted() {
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
        editor.config.height = 500;
        // 创建编辑器
        editor.create();
        this.editor = editor;
    }, beforeDestroy() {
        // 销毁编辑器
        this.editor.destroy()
        this.editor = null
    }
}
</script>

<style lang="scss">
.editor {
    height: 400px;
    width: 800px;
}
</style>
