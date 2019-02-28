$(document).ready(function () {
    $('#search_page_table').DataTable(
        {
            "lengthChange": false,
            "order": [[0, "asc"]],
            "lengthMenu": [[50], [50]],
            "language": {
                "zeroRecords": "Pas de resultat",
                "info": "Page _PAGE_ sur _PAGES_",
                "infoEmpty": "Pas de resultat",
                "infoFiltered": "(filtré sur _MAX_ resultats)"
            }
        }
    );
});