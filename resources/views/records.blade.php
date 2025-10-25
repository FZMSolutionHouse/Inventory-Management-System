@extends('layouts.adminmaster')

@section('content')
    
@include('admininventory')

    <br>
    <div class="container-fluid p-4">
        <!-- Search and Filter Section -->
        <div class="search-filter-section">
            <div class="row">
                <div class="col-md-6">
                    <div class="search-box">
                        <input type="text" class="form-control" placeholder="Search items or suppliers..." id="searchInput">
                        <svg class="search-icon" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select filter-select" id="categoryFilter">
                        <option value="">All Categories</option>
                        @if(isset($items) && $items->count() > 0)
                            @php
                                $categories = $items->pluck('category')->unique()->filter();
                             @endphp
                            @foreach($categories as $category)
                                <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                            @endforeach
                        @else
                            <option value="Furniture">Furniture</option>
                            <option value="Electronics">Electronics</option>
                            <option value="Office Supplies">Office Supplies</option>
                            <option value="Appliances">Appliances</option>
                            <option value="Self product">Self product</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select filter-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="In Stock">In Stock</option>
                        <option value="Low Stock">Low Stock</option>
                        <option value="Out of Stock">Out of Stock</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-cards">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon green">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $inStockCount ?? 0 }}</div>
                            <div class="stat-label">In Stock</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $lowStockCount ?? 0 }}</div>
                            <div class="stat-label">Low Stock</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon red">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $outOfStockCount ?? 0 }}</div>
                            <div class="stat-label">Out of Stock</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                            </svg>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $totalItems ?? 0 }}</div>
                            <div class="stat-label">Total Items</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Card Container -->
        <div class="table-card-container">
            <table class="table modern-table">
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Item Name</th>
                        <th>Requisition ID</th>
                        <th>Category</th>
                        <th>Category Type</th>
                        <th>Location</th>
                        <th>Quantity</th>
                        <th>Min Stock</th>
                        <th>Price</th>
                        <th>Issue</th>
                        <th>Supplier</th>
                        <th>Status</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($items) && $items->count() > 0)
                        @foreach($items as $itemadd)
                            @php
                                // Calculate status based on quantity and minimum stock
                                $status = 'In Stock';
                                $statusClass = 'in-stock';
                                
                                if ($itemadd->quantity <= 0) {
                                    $status = 'Out of Stock';
                                    $statusClass = 'out-of-stock';
                                } elseif ($itemadd->quantity <= $itemadd->minimum_stock) {
                                    $status = 'Low Stock';
                                    $statusClass = 'low-stock';
                                }
                                
                                // Category badge class
                                $categoryClass = 'category-' . strtolower(str_replace([' ', '_'], '-', $itemadd->category));
                                
                                // Handle category_type display properly
                                $categoryTypeDisplay = '';
                                if (isset($itemadd->category_type)) {
                                    if (is_string($itemadd->category_type)) {
                                        // If stored as JSON string, decode it
                                        $decoded = json_decode($itemadd->category_type, true);
                                        $categoryTypeDisplay = is_array($decoded) ? implode(', ', $decoded) : $itemadd->category_type;
                                    } elseif (is_array($itemadd->category_type)) {
                                        // If already an array, just join
                                        $categoryTypeDisplay = implode(', ', $itemadd->category_type);
                                    } else {
                                        $categoryTypeDisplay = $itemadd->category_type;
                                    }
                                }
                            @endphp
                            
                            <tr class="table-row" 
                              data-item-id="{{ strtolower($itemadd->id) }}" 
                                data-item_name="{{ strtolower($itemadd->item_name) }}" 
                                data-supplier="{{ strtolower($itemadd->supplier) }}" 
                                data-category="{{ $itemadd->category }}" 
                                data-status="{{ $status }}">
                                
                                <!-- Item ID Column -->
                                <td>
                                    <span class="item-id">#{{ str_pad($itemadd->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                
                                <!-- Item Name Column -->
                                <td>
                                    <div class="item-title">{{ $itemadd->item_name }}</div>
                                </td>
                                
                                <!-- Requisition ID Column (Fixed spelling) -->
                                <td>
                                    <span class="category-badge {{ $categoryClass }}">{{ $itemadd->requisition_id ?? 'N/A' }}</span>
                                </td>
                                
                                <!-- Category Column -->
                                <td>
                                    <span class="category-badge {{ $categoryClass }}">{{ $itemadd->category }}</span>
                                </td>
                                
                                <!-- Category Type Column -->
                                <td>
                                    <span class="category-badge {{ $categoryClass }}">{{ $categoryTypeDisplay ?: 'N/A' }}</span>
                                </td>
                                
                                <!-- Location Column -->
                                <td>
                                    <span class="category-badge {{ $categoryClass }}">{{ $itemadd->location ?? 'N/A' }}</span>
                                </td>
                                
                                <!-- Quantity Column -->
                                <td class="quantity">{{ $itemadd->quantity }}</td>
                                
                                <!-- Min Stock Column -->
                                <td>{{ $itemadd->minimum_stock }}</td>
                                
                                <!-- Price Column -->
                                <td class="price">${{ number_format($itemadd->price, 0) }}</td>
                                
                                <!-- Issue Column -->
                                <td>
                                    <span class="category-badge {{ $categoryClass }}">{{ $itemadd->issue ?? 'N/A' }}</span>
                                </td>
                                
                                <!-- Supplier Column -->
                                <td class="supplier">{{ $itemadd->supplier }}</td>
                                
                                <!-- Status Column -->
                                <td>
                                    <span class="status-badge {{ $statusClass }}">{{ $status }}</span>
                                </td>
                                
                                <!-- Last Updated Column -->
                                <td class="last-updated">{{ \Carbon\Carbon::parse($itemadd->updated_at)->format('Y-m-d') }}</td>
                                
                                <!-- Actions Column -->
                                <td class="actions">
                                    <!-- Edit Record -->
                                    <a href="/edit_record/{{$itemadd->id}}" class="btn-action edit" title="Edit" data-id="{{ $itemadd->id }}">
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708L6.5 13.207a.5.5 0 0 1-.708 0L2.5 9.914a.5.5 0 0 1 0-.708L11.793.146zm-1.207 2.061L2.207 11.207l2.586 2.586L13.793 4.793l-2.854-2.586z"/>
                                            <path d="M1 13.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5z"/>
                                        </svg>
                                    </a>
                                         
                                    <!-- Delete function -->
                                    <a href="/delete_record/{{ $itemadd->id }}" class="btn-action delete" title="Delete">
                                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </a>
                                           
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="14" class="text-center py-5">
                                <div class="empty-state-inline">
                                    <h4>No items found</h4>
                                    <p>No inventory items available in the database.</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Search and Filter Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const categoryFilter = document.getElementById('categoryFilter');
            const statusFilter = document.getElementById('statusFilter');
            const tableRows = document.querySelectorAll('.table-row');

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const categoryValue = categoryFilter.value;
                const statusValue = statusFilter.value;

                let visibleCount = 0;

                tableRows.forEach(row => {
                    const itemName = row.dataset.itemName || '';
                    const supplier = row.dataset.supplier || '';
                    const category = row.dataset.category || '';
                    const status = row.dataset.status || '';

                    const matchesSearch = itemName.includes(searchTerm) || supplier.includes(searchTerm);
                    const matchesCategory = !categoryValue || category === categoryValue;
                    const matchesStatus = !statusValue || status === statusValue;

                    if (matchesSearch && matchesCategory && matchesStatus) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Show/hide empty state for filtered results
                updateEmptyState(visibleCount);
            }

            function updateEmptyState(visibleCount) {
                const existingEmptyState = document.querySelector('.empty-state');
                const tableContainer = document.querySelector('.table-card-container');
                
                if (visibleCount === 0 && !existingEmptyState && tableRows.length > 0) {
                    const emptyDiv = document.createElement('div');
                    emptyDiv.className = 'empty-state';
                    emptyDiv.innerHTML = ` 
                        <h4>No items found</h4>
                        <p>Try adjusting your search criteria or filters.</p>
                    `;
                    tableContainer.after(emptyDiv);
                } else if (visibleCount > 0 && existingEmptyState) {
                    existingEmptyState.remove();
                }
            }

            searchInput.addEventListener('input', filterTable);
            categoryFilter.addEventListener('change', filterTable);
            statusFilter.addEventListener('change', filterTable);

            // Action buttons functionality
            document.querySelectorAll('.btn-action.edit').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    // Add your edit functionality here
                    console.log('Edit item with ID:', id);
                    // Example: redirect to edit page
                    // window.location.href = `/inventory/edit/${id}`;
                });
            });

         
        });
    </script>

@endsection