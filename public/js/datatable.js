let dataTable = $('.datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: location.href,
    aLengthMenu: [
        [25, 50, 100, 200],
        [25, 50, 100, 200]
    ],
    columnDefs: [
        {
        targets: 0, // index kolom No
        width: '1%',
        className: 'dt-nowrap'
        }
    ]
});