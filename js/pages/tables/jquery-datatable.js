$(function () {
    $('.js-basic-example').DataTable({
        dom: 'lBfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        pageLength: 50,
        lengthMenu: [50, 100, 200, 500]
    });

    $('.js-basic').DataTable({
        dom: 'lBfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'pdf', 'print'
        ],
        pageLength: 50,
        lengthMenu: [50, 100, 200, 500]
    });

    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'lBfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        pageLength: 50,
        lengthMenu: [50, 100, 200, 500]
    });

    $('.js-exportable-new').DataTable({
        "scrollY": 200,
        "scrollX": true
    });
});