<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Table Example</title>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <style>
        label {
            margin-top: 10px;
            display: block;
        }

        select {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #d3d3d3;
        }

        .dataTables_paginate {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<!-- Dropdown for selecting the table name -->
<label for="tableName">Select Table to View:</label>
<select id="tableName">
    <option value="" selected>Select table to view</option>
    <!-- Options will be populated dynamically using JavaScript -->
</select>

<!-- DataTable to display the results -->
<table id="dataTable" border="1">
    <thead>
    <tr id="tableColumns">
        <!-- Columns will be populated dynamically using JavaScript -->
    </tr>
    </thead>
    <tbody></tbody>
</table>

<script>
    var dataTableInstance;

    // Function to fetch data from the server based on selected values
    function fetchData() {
        // Destroy the existing DataTable instance before reinitializing
        if (dataTableInstance) {
            dataTableInstance.destroy();
        }

        var tableName = $("#tableName").val();
        var rmdate = $("#rmdate").val();
        var cshiftcode = $("#cshiftcode").val();

        // Check if either rmdate or cshiftcode is not selected
        if (!rmdate && !cshiftcode) {
            // Fetch all records without applying any filter
            $.ajax({
                url: 'fetch_all_data.php',
                method: 'GET',
                data: { tableName: tableName },
                dataType: 'json',
                success: function (data) {
                    // Clear existing rows and columns
                    $('#dataTable thead tr#tableColumns').empty();
                    $('#dataTable tbody').empty();

                    // Populate DataTable with new data and columns
                    $.each(data.columns, function (index, columnName) {
                        $('#dataTable thead tr#tableColumns').append('<th>' + columnName + '</th>');
                    });

                    // Initialize DataTable with paging and limiting
                    dataTableInstance = $('#dataTable').DataTable({
                        data: data.rows,
                        columns: data.columns.map(columnName => ({ data: columnName })),
                        paging: true, // Enable paging
                        pageLength: 10 // Set the number of rows per page
                    });
                },
                error: function (error) {
                    console.log('Error fetching all data: ' + error);
                }
            });
        }
    }

    // Populate dropdowns with unique values from the server
    function populateDropdowns() {
        // Make an AJAX request to the server to fetch table names
        $.ajax({
            url: 'fetch_table_names.php', // Replace with the actual server-side script
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // Populate tableName dropdown
                $.each(data.tableNames, function (index, value) {
                    $('#tableName').append($('<option>').text(value).attr('value', value));
                });

                // Populate rmdate dropdown
                $.each(data.dates, function (index, value) {
                    $('#rmdate').append($('<option>').text(value).attr('value', value));
                });

                // Populate cshiftcode dropdown
                $.each(data.shiftCodes, function (index, value) {
                    $('#cshiftcode').append($('<option>').text(value).attr('value', value));
                });
            },
            error: function (error) {
                console.log('Error fetching dropdowns: ' + error);
            }
        });
    }

    // Call the function to populate dropdowns initially
    populateDropdowns();

    // Attach event listeners to dropdowns and table name
    $("#rmdate, #cshiftcode, #tableName").on('change', function () {
        // Fetch data when either dropdown changes or table name changes
        fetchData();
    });

</script>

</body>
</html>
