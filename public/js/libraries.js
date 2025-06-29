$(document).on('click', '.libraries-delete-btn', function(){
    if(confirm('Are you sure to delete this data ?'))
    {
        $('form[action="'+$(this).data('url')+'"]').submit()
    }
})

$(document).ready(function(){
    $('.select2').select2({
        theme: 'bootstrap-5'
    });

    $('.libraries-file-upload').change(function(){
        var targetInput = this.dataset.target
        var file = this.files[0]; // Get the first selected file
        if (file) {
            var formData = new FormData();
            formData.append('file', file); // 'myFile' matches the name attribute in HTML
            formData.append('_token', $('meta[name=csrf-token]').attr('content')); // 'myFile' matches the name attribute in HTML
            fetch('/cms/upload-media', {
                method: 'POST',
                'content-type': 'multipart/form-data',
                body: formData
            })
            .then(res => res.json())
            .then(res => {
                $('[name='+targetInput+']').val(res.data)
            })
            .catch(error => {

            })
        }
    })
})

tinymce.init({
    selector: 'textarea.text-editor',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
});