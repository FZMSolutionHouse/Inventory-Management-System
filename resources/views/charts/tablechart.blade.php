<html>
  <head>
    <title>Dynamic Inventory Table (Paginated)</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        /* Basic styling for responsiveness */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }
        #table_div {
            width: 100%; /* Make the container responsive */
            max-width: 900px; /* Max width for larger screens */
            margin: 0 auto; /* Center the table */
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba="0,0,0,0.1)";
            padding: 10px;
            background-color: #fff;
        }
        @media (max-width: 768px) {
            #table_div {
                padding: 5px;
            }
        }
        /* Styles for Google Chart specific elements */
        .google-chart-header-row {
            background-color: #f2f2f2;
        }
        .google-chart-table-cell {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        /* Custom styles for pagination buttons if you want to override defaults */
        /*
        .google-visualization-table-paging-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            margin: 0 2px;
            cursor: pointer;
            border-radius: 3px;
        }
        .google-visualization-table-paging-button:hover {
            background-color: #0056b3;
        }
        */
    </style>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(fetchAndDrawTable);

      function fetchAndDrawTable() {
        fetch('/api/table-data')
          .then(response => response.json())
          .then(data => {
            var dataTable = new google.visualization.DataTable();
            dataTable.addColumn('string', 'Item Name');
            dataTable.addColumn('number', 'Quantity');
            dataTable.addColumn('number', 'Price');

            dataTable.addRows(data);

            var table = new google.visualization.Table(document.getElementById('table_div'));

            // Options for pagination
            table.draw(dataTable, {
                showRowNumber: true,
                width: '100%',
                height: 'auto', // Height will adjust based on pageSize
                page: 'enable', // Enable pagination
                pageSize: 5,   // Show 5 items per page
                pagingButtons: 'auto', // Show 'prev' and 'next' buttons. Can be 'auto' or 'all' or 'prevAndNext'
                cssClassNames: {
                    headerRow: 'google-chart-header-row',
                    tableRow: 'google-chart-table-row',
                    oddTableRow: 'google-chart-odd-table-row',
                    selectedTableRow: 'google-chart-selected-table-row',
                    hoverTableRow: 'google-chart-hover-table-row',
                    headerCell: 'google-chart-header-cell',
                    tableCell: 'google-chart-table-cell',
                    rowNumberCell: 'google-chart-row-number-cell'
                }
            });
          })
          .catch(error => console.error('Error fetching table data:', error));
      }
    </script>
  </head>
  <body>
    <div id="table_div"></div>
  </body>
</html>