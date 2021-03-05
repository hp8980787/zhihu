import E from 'wangeditor'

const editor = new E('#editor')
// 或者 const editor = new E( document.getElementById('div1') )

const $text1 = $('#text1')
editor.config.onchange = function (html) {
    // 第二步，监控变化，同步更新到 textarea
    $text1.val(html)
}
editor.config.uploadImgServer = '/upload-imgs'
editor.config.uploadImgMaxSize = 2 * 1024 * 1024 // 2M
editor.config.uploadImgAccept = ['jpg', 'jpeg', 'png', 'gif', 'bmp']
editor.config.uploadImgMaxLength = 1
editor.config.uploadFileName = 'images'
let token = document.head.querySelector('meta[name="csrf-token"]');

editor.config.uploadImgParams = {
    '_token':token.content,
}
editor.create()
$text1.val(editor.txt.html())
