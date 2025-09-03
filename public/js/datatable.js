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

dataTable.on('draw.dt', function (e, settings, json, xhr) {
  [
    { selector:".dt-buttons .btn", classToRemove:"btn-secondary" },
    { selector:".dt-search .form-control", classToRemove:"form-control-sm", classToAdd:"ms-4" },
    { selector:".dt-length .form-select", classToRemove:"form-select-sm" },
    { selector:".dt-layout-table", classToRemove:"row mt-2" },
    { selector:".dt-layout-end", classToAdd:"mt-0" },
    { selector:".dt-layout-end .dt-search", classToAdd:"mt-md-6 mt-0" },
    { selector:".dt-layout-full", classToRemove:"col-md col-12", classToAdd:"table-responsive" }
  ].forEach(({selector, classToRemove, classToAdd}) => {
    document.querySelectorAll(selector).forEach(el => {
      if (classToRemove) classToRemove.split(" ").forEach(c => el.classList.remove(c));
      if (classToAdd) classToAdd.split(" ").forEach(c => el.classList.add(c));
    });
  })
})