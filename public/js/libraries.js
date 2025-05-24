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
})