<template>
    <div class="home">
        <h3>wangEditor with vue</h3>
        <div id="sample-editor"></div>
        <textarea style="display: none" name="" id="" cols="170" rows="20" readonly v-model="editorData"></textarea>

    </div>
</template>

<script>
// 引入 wangEditor
import wangEditor from 'wangeditor'

export default {
    name: 'WangEditor',
    data() {
        return {
            editor: null,
            editorData: '',
        }
    },
    props: {
        config: {
            menus: [],
            default: () => {
                return {
                    menus: ['bold',
                        'head',
                        'link',
                        'italic',
                        'underline'],
                };
            },
        },
    },
    mounted() {
        const editor = new wangEditor(`#sample-editor`)
        // 配置 onchange 回调函数，将数据同步到 vue 中
        editor.config.onchange = (newHtml) => {
            this.editorData = newHtml
        }
        editor.highlight = 300;

        editor.config.menus = this.config.menus;

        console.log(this.config.menus)
        // 创建编辑器
        editor.create()
        this.editor = editor
    },
    methods: {
        getEditorData() {
            // 通过代码获取编辑器内容
            let data = this.editor.txt.html()
            alert(data)
        }
    },
    beforeDestroy() {
        // 调用销毁 API 对当前编辑器实例进行销毁
        this.editor.destroy()
        this.editor = null
    }
}
</script>

<style lang="scss">
.home {
    width: 400px;
    margin: auto;
    position: relative;
    z-index: 99999;

    .btn {
        position: absolute;
        right: 0;
        top: 0;
        padding: 5px 10px;
        cursor: pointer;
    }

    h3 {
        margin: 30px 0 15px;
    }
}
</style>
