@extends('layouts.adminmaster')

@section('content')


<div class="dashboard-wrapper">
    <div class="dashboard-container">
        <!-- Navigation Bar -->
        <div class="dashboard-nav">
            <div class="nav-title">Inventory Management Dashboard</div>
            <div class="nav-links">
                <!-- FIXED: Using specific class to avoid sidebar CSS conflicts -->
                <a href="{{ route('balance-sheet.index') }}" class="balance-sheet-btn">
                    📊 Balance Sheet
                </a>
            </div>
        </div>

        {{-- Display error or info messages --}}
        @if(isset($error))
            <div class="error-message">
                {{ $error }}
            </div>
        @endif

        @if(isset($message))
            <div class="info-message">
                {{ $message }}
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="stats-container-pro">
            <div class="stat-card-pro">
                <div class="card-icon-wrapper" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <svg class="card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div class="card-content">
                    <p class="card-title">Total Items</p>
                    <p class="card-value">{{ $totalItems ?? '0' }}</p>
                    <p class="card-subtitle">Across all categories</p>
                </div>
            </div>

            <div class="stat-card-pro">
                <div class="card-icon-wrapper" style="background: linear-gradient(135deg, #38ef7d 0%, #11998e 100%);">
                    <svg class="card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div class="card-content">
                    <p class="card-title">Total Value</p>
                    <!-- FIXED: Proper total calculation using quantity * price -->
                   <p class="card-value">${{ isset($chartData) && count($chartData) > 0 ? number_format(collect($chartData)->sum('price'), 2) : '0.00' }}</p>
                    <p class="card-subtitle">Current inventory value</p>
                </div>
            </div>

            <div class="stat-card-pro">
                <div class="card-icon-wrapper" style="background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);">
                    <svg class="card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 18.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div class="card-content">
                    <p class="card-title">Low Stock Alerts</p>
                    <p class="card-value" style="color: #f59e0b;">{{ $lowStockItemsCount ?? '0' }}</p>
                    <p class="card-subtitle">Items need attention</p>
                </div>
            </div>

            <div class="stat-card-pro">
                <div class="card-icon-wrapper" style="background: linear-gradient(135deg, #5ee7df 0%, #b490ca 100%);">
                    <svg class="card-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div class="card-content">
                    <p class="card-title">Categories</p>
                    <p class="card-value">{{ $categories ?? '0' }}</p>
                    <p class="card-subtitle">Product categories</p>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-grid">
            <!-- Stock Level Analysis Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title">Stock Level Analysis</div>
                    <div class="chart-subtitle">Inventory levels with intervals</div>
                </div>
                <div class="chart-content">
                    <div id="chart_lines" style="width: 100%; height: 300px;"></div>
                    <div class="details-panel">
                        <h3>Item Details</h3>
                        <div id="itemDetails" class="no-selection">
                            Click on data point for details
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title">Quantity Distribution</div>
                    <div class="chart-subtitle">Items by quantity</div>
                </div>
                <div class="chart-content">
                    <div id="piechart" style="width: 100%; height: 300px;"></div>
                    <div class="details-panel">
                        <h3>Selected Item</h3>
                        <div id="pieItemDetails" class="no-selection">
                            Click on slice for details
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="chart-card full-width">
                <div class="chart-header">
                    <div class="chart-title">Inventory Data Table</div>
                    <div class="chart-subtitle">Complete inventory overview</div>
                </div>
                <div class="chart-content">
                    <div id="table_div" style="width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
  @auth
    <script src="{{ asset('assets/javascript/session-timeout.js') }}"></script>
    @endauth
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
window.addEventListener('error', function(e) {
        console.error('Chart Error:', e.message);
    });

    // Check if Google Charts loaded
    if (typeof google === 'undefined' || typeof google.charts === 'undefined') {
        console.error('Google Charts library failed to load');
        document.getElementById('chart_lines').innerHTML = '<p class="error-message">Charts failed to load. Please refresh the page.</p>';
    }

    google.charts.load('current', {'packages':['corechart', 'table']});
    google.charts.load('current', {'packages':['corechart', 'table']});
    google.charts.setOnLoadCallback(drawAllCharts);

    var itemsData = [];

    function drawAllCharts() {
        drawIntervalChart();
        drawPieChart();
        drawTable();
    }

    // Line Chart with Intervals
    function drawIntervalChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Item');
        data.addColumn('number', 'Current Stock');
        data.addColumn({id:'min', type:'number', role:'interval'});
        data.addColumn({id:'max', type:'number', role:'interval'});

        var hasData = false;
        
        @if(isset($chartData) && count($chartData) > 0)
            @php $index = 0; @endphp
            @foreach($chartData as $item)
                @php
                    $currentStock = (int)($item['quantity'] ?? 0);
                    $minStock = (int)($item['minimumStock'] ?? 0);
                    $maxStock = max($currentStock * 1.5, $minStock * 2, 10);
                @endphp
                
                data.addRow([
                    '{{ addslashes($item['itemName'] ?? "Item") }}',
                    {{ $currentStock }},
                    {{ $minStock }},
                    {{ $maxStock }}
                ]);

                itemsData[{{ $index }}] = {
                    id: {{ $index }},
                    item_name: '{{ addslashes($item['itemName'] ?? "N/A") }}',
                    quantity: {{ $currentStock }},
                    minimum_stock: {{ $minStock }},
                    category: '{{ addslashes($item['category'] ?? "N/A") }}',
                    price: {{ $item['price'] ?? 0 }}
                };

                @php $index++; @endphp
                hasData = true;
            @endforeach
        @endif

        if (!hasData) {
            data.addRow(['No Items Available', 0, 0, 0]);
        }

        var options = {
            title: '',
            hAxis: { 
                title: 'Items',
                textStyle: { fontSize: 10 }
            },
            vAxis: {
                title: 'Stock Quantity',
                minValue: 0
            },
            curveType: 'function',
            lineWidth: 2,
            intervals: { 
                style: 'area',
                color: '#e3f2fd',
                opacity: 0.3
            },
            colors: ['#2196F3'],
            legend: { position: 'none' },
            backgroundColor: 'transparent',
            chartArea: {
                left: 50,
                top: 20,
                width: '85%',
                height: '70%'
            },
            pointSize: 6
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_lines'));

        google.visualization.events.addListener(chart, 'select', function() {
            var selectedItem = chart.getSelection()[0];
            if (selectedItem && selectedItem.row !== null) {
                var itemIndex = selectedItem.row;
                var itemInfo = itemsData[itemIndex] || {};
                showItemDetails(itemInfo);
            }
        });

        chart.draw(data, options);
    }

    // Pie Chart
    function drawPieChart() {
        var hasData = false;
        var data;
        
        @if(isset($chartData) && count($chartData) > 0)
            data = google.visualization.arrayToDataTable([
                ['Item Name', 'Quantity'],
                @foreach($chartData as $item)
                    ['{{ addslashes($item['itemName'] ?? "Item") }}', {{ $item['quantity'] ?? 0 }}],
                @endforeach
            ]);
            hasData = true;
        @else
            data = google.visualization.arrayToDataTable([
                ['Status', 'Count'],
                ['No Items', 1]
            ]);
        @endif

        var options = {
            title: '',
            colors: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
            legend: { 
                position: 'bottom',
                textStyle: { fontSize: 10 }
            },
            pieSliceText: hasData ? 'percentage' : 'label',
            backgroundColor: 'transparent',
            chartArea: { width: '90%', height: '70%' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        if (hasData) {
            google.visualization.events.addListener(chart, 'select', function() {
                var selectedItem = chart.getSelection()[0];
                if (selectedItem) {
                    var itemName = data.getValue(selectedItem.row, 0);
                    var quantity = data.getValue(selectedItem.row, 1);
                    showPieItemDetails(itemName, quantity);
                }
            });
        }

        chart.draw(data, options);
    }

    // Data Table
    function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Item Name');
        data.addColumn('number', 'Quantity');
        data.addColumn('number', 'Price');
        data.addColumn('string', 'Category');
        data.addColumn('number', 'Min Stock');

        @if(isset($chartData) && count($chartData) > 0)
            data.addRows([
                @foreach($chartData as $item)
                    ['{{ addslashes($item['itemName'] ?? "Item") }}', 
                     {{ $item['quantity'] ?? 0 }}, 
                     {{ $item['price'] ?? 0 }}, 
                     '{{ addslashes($item['category'] ?? "N/A") }}',
                     {{ $item['minimumStock'] ?? 0 }}],
                @endforeach
            ]);
        @else
            data.addRows([
                ['No Items Available', 0, 0, 'N/A', 0]
            ]);
        @endif

        var options = {
            showRowNumber: true,
            width: '100%',
            height: 'auto',
            page: 'enable',
            pageSize: 8
        };

        var table = new google.visualization.Table(document.getElementById('table_div'));
        table.draw(data, options);
    }

    function showItemDetails(item) {
        var detailsHtml = '';
        detailsHtml += '<div class="item-info"><strong>Item:</strong> ' + (item.item_name || 'N/A') + '</div>';
        detailsHtml += '<div class="item-info"><strong>Current Stock:</strong> ' + (item.quantity || 0) + '</div>';
        detailsHtml += '<div class="item-info"><strong>Minimum Stock:</strong> ' + (item.minimum_stock || 0) + '</div>';
        
        var stockStatus = '';
        if (item.quantity <= 0) {
            stockStatus = '<div class="item-info critical-stock">⚠ OUT OF STOCK!</div>';
        } else if (item.quantity <= item.minimum_stock) {
            stockStatus = '<div class="item-info critical-stock">🚨 CRITICAL: Restock Now!</div>';
        } else if (item.quantity <= item.minimum_stock * 1.2) {
            stockStatus = '<div class="item-info low-stock">⚠️ LOW: Consider Restocking</div>';
        } else {
            stockStatus = '<div class="item-info good-stock">✅ GOOD: Stock OK</div>';
        }
        detailsHtml += stockStatus;

        if (item.category && item.category !== 'N/A') {
            detailsHtml += '<div class="item-info"><strong>Category:</strong> ' + item.category + '</div>';
        }
        
        if (item.price > 0) {
            detailsHtml += '<div class="item-info"><strong>Price:</strong> $' + parseFloat(item.price).toFixed(2) + '</div>';
            detailsHtml += '<div class="item-info"><strong>Stock Value:</strong> $' + (parseFloat(item.price) * item.quantity).toFixed(2) + '</div>';
        }

        document.getElementById('itemDetails').innerHTML = detailsHtml;
    }

    function showPieItemDetails(itemName, quantity) {
        @if(isset($chartData) && count($chartData) > 0)
            var allItems = {!! json_encode($chartData) !!};
            var selectedItem = allItems.find(item => item.itemName === itemName);
            
            var detailsHtml = '';
            detailsHtml += '<div class="item-detail"><strong>Item:</strong> ' + itemName + '</div>';
            detailsHtml += '<div class="item-detail"><strong>Quantity:</strong> ' + quantity + '</div>';
            
            if (selectedItem) {
                detailsHtml += '<div class="item-detail"><strong>Category:</strong> ' + selectedItem.category + '</div>';
                detailsHtml += '<div class="item-detail"><strong>Price:</strong> $' + parseFloat(selectedItem.price).toFixed(2) + '</div>';
                detailsHtml += '<div class="item-detail"><strong>Min Stock:</strong> ' + selectedItem.minimumStock + '</div>';
            }
        @else
            var detailsHtml = '<div class="item-detail">No item data available</div>';
        @endif
        
        document.getElementById('pieItemDetails').innerHTML = detailsHtml;
    }

    // Page load animations
    document.addEventListener('DOMContentLoaded', function() {
        const statCards = document.querySelectorAll('.stat-card-pro');
        statCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });

        const chartCards = document.querySelectorAll('.chart-card');
        chartCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.8s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 600 + (index * 200));
        });
    });
</script>

@endsection