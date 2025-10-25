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
            min-width: 600px;
        }
        .info-section {
            flex: 0 0 300px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .info-section h3 {
            margin-top: 0;
            color: #333;
        }
        .item-info {
            margin: 8px 0;
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .item-info:last-child {
            border-bottom: none;
        }
        .no-selection {
            color: #888;
            font-style: italic;
        }
        .critical-stock {
            color: #d32f2f;
            font-weight: bold;
        }
        .low-stock {
            color: #ff9800;
            font-weight: bold;
        }
        .good-stock {
            color: #4caf50;
            font-weight: bold;
        }
        .legend {
            margin-top: 15px;
            padding: 10px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            margin: 5px 0;
        }
        .legend-color {
            width: 20px;
            height: 3px;
            margin-right: 8px;
            border-radius: 2px;
        }
    </style>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        var chartData;
        var itemsData = [];

        function drawChart() {
            // Prepare data from database
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Item');
            data.addColumn('number', 'Current Stock');
            data.addColumn({id:'min', type:'number', role:'interval'});
            data.addColumn({id:'max', type:'number', role:'interval'});
            data.addColumn({id:'low', type:'number', role:'interval'});
            data.addColumn({id:'high', type:'number', role:'interval'});

            // Add data from Laravel backend
            @php $index = 0; @endphp
            @foreach($items as $item)
                @php
                    $currentStock = $item->quantity;
                    $minStock = $item->minimum_stock ?? 0;
                    $maxStock = $currentStock * 1.5; // 50% above current as max
                    $lowInterval = max(0, $currentStock - ($currentStock * 0.1)); // 10% below
                    $highInterval = $currentStock + ($currentStock * 0.1); // 10% above
                @endphp
                
                data.addRow([
                    '{{ $item->item_name }}',
                    {{ $currentStock }},
                    {{ $minStock }},
                    {{ $maxStock }},
                    {{ $lowInterval }},
                    {{ $highInterval }}
                ]);

                // Store item data for click events
                itemsData[{{ $index }}] = {
                    id: {{ $item->id ?? 0 }},
                    item_name: '{{ $item->item_name }}',
                    quantity: {{ $currentStock }},
                    minimum_stock: {{ $minStock }},
                    category: '{{ $item->category ?? "N/A" }}',
                    price: {{ $item->price ?? 0 }},
                    location: '{{ $item->location ?? "N/A" }}',
                    supplier: '{{ $item->supplier ?? "N/A" }}'
                };

                @php $index++; @endphp
            @endforeach

            var options = {
                title: 'Inventory Stock Levels with Intervals',
                titleTextStyle: {
                    fontSize: 18,
                    bold: true
                },
                hAxis: {
                    title: 'Items',
                    titleTextStyle: {fontSize: 14, bold: true}
                },
                vAxis: {
                    title: 'Stock Quantity',
                    titleTextStyle: {fontSize: 14, bold: true},
                    minValue: 0
                },
                curveType: 'function',
                lineWidth: 3,
                intervals: { 
                    'style': 'area',
                    'color': 'lightblue',
                    'opacity': 0.3
                },
                colors: ['#2196F3'],
                legend: { position: 'top', maxLines: 3 },
                backgroundColor: '#fafafa',
                chartArea: {
                    left: 80,
                    top: 80,
                    width: '75%',
                    height: '70%'
                },
                pointSize: 7,
                tooltip: {
                    isHtml: true
                }
            };

            chartData = data;
            var chart = new google.visualization.LineChart(document.getElementById('chart_lines'));

            // Add click event listener
            google.visualization.events.addListener(chart, 'select', function() {
                var selectedItem = chart.getSelection()[0];
                
                if (selectedItem && selectedItem.row !== null) {
                    var itemIndex = selectedItem.row;
                    var itemInfo = itemsData[itemIndex];
                    showItemDetails(itemInfo);
                }
            });

            chart.draw(data, options);
        }

        function showItemDetails(item) {
            var detailsHtml = '';
            detailsHtml += '<div class="item-info"><strong>Item:</strong> ' + item.item_name + '</div>';
            detailsHtml += '<div class="item-info"><strong>Current Stock:</strong> ' + item.quantity + '</div>';
            detailsHtml += '<div class="item-info"><strong>Minimum Stock:</strong> ' + item.minimum_stock + '</div>';
            
            // Stock status
            var stockStatus = '';
            if (item.quantity <= item.minimum_stock) {
                stockStatus = '<div class="item-info critical-stock">🚨 CRITICAL: Restock Immediately!</div>';
            } else if (item.quantity <= item.minimum_stock * 1.2) {
                stockStatus = '<div class="item-info low-stock">⚠️ LOW: Consider Restocking</div>';
            } else {
                stockStatus = '<div class="item-info good-stock">✅ GOOD: Stock Level OK</div>';
            }
            detailsHtml += stockStatus;

            detailsHtml += '<div class="item-info"><strong>Category:</strong> ' + item.category + '</div>';
            
            if (item.price > 0) {
                detailsHtml += '<div class="item-info"><strong>Price:</strong> $' + parseFloat(item.price).toFixed(2) + '</div>';
                detailsHtml += '<div class="item-info"><strong>Stock Value:</strong> $' + (parseFloat(item.price) * item.quantity).toFixed(2) + '</div>';
            }
            
            detailsHtml += '<div class="item-info"><strong>Location:</strong> ' + item.location + '</div>';
            detailsHtml += '<div class="item-info"><strong>Supplier:</strong> ' + item.supplier + '</div>';

            // Recommendations
            if (item.quantity <= item.minimum_stock) {
                detailsHtml += '<div class="item-info critical-stock"><strong>Recommendation:</strong> Order ' + (item.minimum_stock * 2 - item.quantity) + ' units immediately</div>';
            }

            document.getElementById('itemDetails').innerHTML = detailsHtml;
        }
    </script>
</head>
<body>
    <h2>Dynamic Inventory Stock Level Analysis</h2>
    
    <div class="container">
        <div class="chart-section">
            <div id="chart_lines" style="width: 600px; height: 500px;"></div>
    </div>
</body>
</html>