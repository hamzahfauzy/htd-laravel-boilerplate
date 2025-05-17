$(document).on('click', '.libraries-delete-btn', function(){
    if(confirm('Are you sure to delete this data ?'))
    {
        $('form[action="'+$(this).data('url')+'"]').submit()
    }
})