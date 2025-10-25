<html>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .chart-section {
            flex: 1;
            min-width: 500px;
        }
        .details-section {
            flex: 0 0 300px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .details-section h3 {
            margin-top: 0;
            color: #333;
        }
        .item-detail {
            margin: 8px 0;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .item-detail:last-child {
            border-bottom: none;
        }
        .no-selection {
            color: #888;
            font-style: italic;
        }
        .low-stock {
            color: #d32f2f;
            font-weight: bold;
        }
        .good-stock {
            color: #388e3c;
            font-weight: bold;
        }
    </style>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Dynamic data from database
            var data = google.visualization.arrayToDataTable([
                ['Item Name', 'Quantity'],
                @foreach($items as $item)
                    ['{{ $item->item_name }}', {{ $item->quantity }}],
                @endforeach
            ]);

            var options = {
                title: 'Inventory Items by Quantity',
                titleTextStyle: {
                    fontSize: 18,
                    bold: true
                },
                colors: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
                legend: {
                    position: 'bottom',
                    textStyle: {
                        fontSize: 12
                    }
                },
                pieSliceText: 'percentage',
                tooltip: {
                    text: 'both'
                }
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            // Add click event for interactivity
            google.visualization.events.addListener(chart, 'select', function() {
                var selectedItem = chart.getSelection()[0];
                
                if (selectedItem) {
                    var itemName = data.getValue(selectedItem.row, 0);
                    var quantity = data.getValue(selectedItem.row, 1);
                    
                    // Show item details
                    showItemDetails(itemName, quantity);
                }
            });

            chart.draw(data, options);
        }

        function showItemDetails(itemName, quantity) {
            // Make AJAX call to get full item details
            $.ajax({
                url: '/item-details/' + encodeURIComponent(itemName),
                type: 'GET',
                success: function(response) {
                    displayItemInfo(response);
                },
                error: function() {
                    // Fallback to basic info
                    var basicInfo = {
                        item_name: itemName,
                        quantity: quantity
                    };
                    displayItemInfo(basicInfo);
                }
            });
        }

        function displayItemInfo(item) {
            var detailsHtml = '';
            detailsHtml += '<div class="item-detail"><strong>Item:</strong> ' + item.item_name + '</div>';
            detailsHtml += '<div class="item-detail"><strong>Quantity:</strong> ' + item.quantity + '</div>';
            
            if (item.category) {
                detailsHtml += '<div class="item-detail"><strong>Category:</strong> ' + item.category + '</div>';
            }
            
            if (item.price) {
                detailsHtml += '<div class="item-detail"><strong>Price:</strong> $' + parseFloat(item.price).toFixed(2) + '</div>';
            }
            
            if (item.location) {
                detailsHtml += '<div class="item-detail"><strong>Location:</strong> ' + item.location + '</div>';
            }
            
            if (item.supplier) {
                detailsHtml += '<div class="item-detail"><strong>Supplier:</strong> ' + item.supplier + '</div>';
            }

            if (item.minimum_stock) {
                detailsHtml += '<div class="item-detail"><strong>Min Stock:</strong> ' + item.minimum_stock + '</div>';
                
                if (item.quantity <= item.minimum_stock) {
                    detailsHtml += '<div class="item-detail low-stock">⚠️ Low Stock Alert!</div>';
                } else {
                    detailsHtml += '<div class="item-detail good-stock">✅ Stock Level OK</div>';
                }
            }

            document.getElementById('itemDetails').innerHTML = detailsHtml;
        }
    </script>
</head>
<body>
    <h2>Dynamic Inventory Chart</h2>
    
    <div class="container">
        <div class="chart-section">
            <div id="piechart" style="width: 900px; height: 500px;"></div>
        </div>
        
        <div class="details-section">
            <h3>Item Details</h3>
            <div id="itemDetails" class="no-selection">
                Click on any slice to view item details
            </div>
        </div>
    </div>
</body>
</html>