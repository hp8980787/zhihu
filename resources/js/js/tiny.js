// Core - these two are required :-)
import tinymce from 'tinymce/tinymce'
import 'tinymce/themes/modern/theme'

// Plugins
import 'tinymce/plugins/paste/plugin'
import 'tinymce/plugins/link/plugin'
import 'tinymce/plugins/autoresize/plugin'

// Initialize
tinymce.init({
    selector: '#mytextarea',
    skin: false,
    plugins: ['paste', 'link', 'autoresize',"powerpaste",'image code'],
    toolbar: 'undo redo | styleselect | bold italic | link image|image code',
    paste_data_images: true,
    images_upload_url: 'postAcceptor.php',
    images_upload_base_path: '/some/basepath',
    images_upload_credentials: true,



});

