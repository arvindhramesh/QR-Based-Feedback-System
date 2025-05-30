<!DOCTYPE html>
<html>
<head>
    <title>Scholar Data Grid</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.3.1/js/dataTables.rowGroup.min.js"></script>
    <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Buttons Extension JS -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/rowgroup/1.3.1/css/rowGroup.dataTables.min.css">
    <style>
        table.dataTable tbody tr {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h2>Scholars Data Grid (Grouped by Discipline)</h2>
    <table id="scholarTable" class="display" width="100%">
        <thead>
            <tr>
                <th>REGNO</th>
                <th>SCHOLAR</th>
                <th>REGDT</th>
                <th>GENDER</th>
                <th>TIMESTATUS</th>
                <th>DISCIPLINE</th>
                <th>NAME_INST</th>
                <th>COMMUNITY</th>
                <th>SCH_MOBILE</th>
                <th>SCH_MAIL</th>
                <th>GUIDE</th>
                <th>GUIDE_MOBILE</th>
                <th>GUIDE_MAIL</th>
                <th>UNIVERSITY</th>
                <th>UN_CODE</th>
            </tr>
        </thead>
        <br>
        <tr>
        <br>
        </tr>
    </table>

    <script>
        $(document).ready(function () {
           $('#scholarTable').DataTable({
    ajax: 'fetch_data.php',
    columns: [
        { data: 'REGNO' },
        { data: 'SCHOLAR' },
        { data: 'REGDT' },
        { data: 'GENDER' },
        { data: 'TIMESTATUS' },
        { data: 'DISCIPLINE' },
        { data: 'NAME_INST' },
        { data: 'COMMUNITY' },
        { data: 'SCH_MOBILE' },
        { data: 'SCH_MAIL' },
        { data: 'GUIDE' },
        { data: 'GUIDE_MOBILE' },
        { data: 'GUIDE_MAIL' },
        { data: 'UNIVERSITY' },
        { data: 'UN_CODE' }
    ],
    order: [[5, 'asc']],
    rowGroup: {
        dataSrc: 'DISCIPLINE'
    },
    dom: 'Bfrtip', // Required for buttons
    buttons: [
        {
            extend: 'excelHtml5',
            text: 'Export to Excel',
            title: 'Scholar_Data'
        }
    ],
    initComplete: function () {
        this.api().columns().every(function () {
            var column = this;
            var input = $('<input type="text" placeholder="Search"/> ')
                .appendTo($(column.header()))
                .on('keyup change clear', function () {
                    if (column.search() !== this.value) {
                        column.search(this.value).draw();
                    }
                });
        });
    }
});
		});
    </script>
</body>
</html>
