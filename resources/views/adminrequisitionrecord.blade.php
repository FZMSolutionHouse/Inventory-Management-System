@extends('layouts.adminmaster')

@section('content')
    <!-- Add CSRF token meta tag in head section -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <div class="admin-requisition-container">
        <!-- Error Message -->
        @if(isset($error_message))
            <div class="error-alert">
                <strong>Error!</strong> {{ $error_message }}
            </div>
        @endif

        <!-- Header Section -->
        <div class="admin-header">
            <div class="admin-header-content">
                <div class="admin-title-section">
                    <h1>Admin Requisition Management</h1>
                    <div class="admin-actions">
                        <button class="admin-refresh-btn" onclick="refreshData()">
                            <svg class="admin-refresh-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Refresh
                        </button>
                    </div>
                </div>
                <p>Review, approve, or reject requisition requests from users.</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="admin-stats-grid">
            <div class="admin-stat-card">
                <div class="admin-stat-icon total">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="admin-stat-content">
                    <h3>{{ $stats['total'] ?? 0 }}</h3>
                    <p>Total Requests</p>
                </div>
            </div>
            <div class="admin-stat-card">
                <div class="admin-stat-icon pending">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="admin-stat-content">
                    <h3>{{ $stats['pending'] ?? 0 }}</h3>
                    <p>Pending Requests</p>
                </div>
            </div>
            <div class="admin-stat-card">
                <div class="admin-stat-icon approved">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="admin-stat-content">
                    <h3>{{ $stats['approved'] ?? 0 }}</h3>
                    <p>Approved</p>
                </div>
            </div>
            <div class="admin-stat-card">
                <div class="admin-stat-icon rejected">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="admin-stat-content">
                    <h3>{{ $stats['rejected'] ?? 0 }}</h3>
                    <p>Rejected</p>
                </div>
            </div>
        </div>

        <!-- Main Table Section -->
        <div class="admin-table-container">
            <div class="admin-table-header">
                <h2>Requisition Details</h2>
                <div class="admin-table-actions">
                    <input type="text" class="admin-search-input" placeholder="Search requisitions..." onkeyup="searchTable()">
                    <select class="admin-filter-select" onchange="filterTable()">
                        <option value="all">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                    <button class="admin-bulk-btn" onclick="showBulkModal()">Bulk Actions</button>
                </div>
            </div>

            <div class="admin-table-wrapper">
                <table class="admin-requisition-table" id="requisitionTable">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)">
                            </th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Subject</th>
                            <th>File</th>
                            <th>Content</th>
                            <th>Created</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requisitions as $requisition)
                            <tr data-status="{{ $requisition->status }}" data-req-id="{{ $requisition->req_id }}">
                                <td>
                                    <input type="checkbox" class="row-checkbox" value="{{ $requisition->req_id }}">
                                </td>
                                <td><span class="req-id">REQ-{{ str_pad($requisition->req_id, 4, '0', STR_PAD_LEFT) }}</span></td>
                                <td><span class="req-name">{{ $requisition->name ?? 'N/A' }}</span></td>
                                <td><span class="designation">{{ $requisition->designation ?? 'N/A' }}</span></td>
                                <td><span class="req-subject">{{ Str::limit($requisition->subject ?? 'No Subject', 30) }}</span></td>
                                <td>
                                    @if($requisition->file_path)
                                        <a href="{{ asset('uploads/' . $requisition->file_path) }}" class="file-link" target="_blank">
                                            <svg class="file-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            View File
                                        </a>
                                    @else
                                        <span class="no-file">No file</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="content-preview">
                                        {{ $requisition->content ? Str::limit(strip_tags($requisition->content), 40) : 'No content' }}
                                    </span>
                                </td>
                                <td><span class="date">{{ $requisition->created_at ? \Carbon\Carbon::parse($requisition->created_at)->format('M d, Y') : 'N/A' }}</span></td>
                                <td>
                                    <span class="status-badge {{ $requisition->status }}" id="status-{{ $requisition->req_id }}">
                                        {{ ucfirst($requisition->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="current-remarks" id="remarks-{{ $requisition->req_id }}">
                                        {{ $requisition->remarks ?: 'No remarks' }}
                                    </span>
                                </td>
                                <td>
                                    <button class="action-btn edit-btn" onclick="openEditModal({{ $requisition->req_id }}, '{{ $requisition->status }}', '{{ addslashes($requisition->remarks) }}')">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Update
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center no-data">No requisitions found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Single Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Update Requisition Status</h3>
                <span class="close" onclick="closeEditModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="updateForm">
                    @csrf
                    <input type="hidden" id="modalReqId" name="requisition_id">
                    
                    <div class="form-group">
                        <label for="modalStatus">Status</label>
                        <select id="modalStatus" name="status" class="form-control" required>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="modalRemarks">Remarks</label>
                        <textarea id="modalRemarks" name="remarks" class="form-control" rows="4" placeholder="Enter your remarks here..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="updateRequisition()">Update Status</button>
            </div>
        </div>
    </div>

    <!-- Bulk Actions Modal -->
    <div id="bulkModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Bulk Update Status</h3>
                <span class="close" onclick="closeBulkModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div class="bulk-info">
                    <p>Selected Items: <span id="selectedCount">0</span></p>
                </div>
                <form id="bulkUpdateForm">
                    @csrf
                    <div class="form-group">
                        <label for="bulkStatus">Status</label>
                        <select id="bulkStatus" name="status" class="form-control" required>
                            <option value="pending">Pending</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="bulkRemarks">Remarks</label>
                        <textarea id="bulkRemarks" name="remarks" class="form-control" rows="4" placeholder="Enter remarks for all selected items..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeBulkModal()">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="bulkUpdateRequisitions()">Update All Selected</button>
            </div>
        </div>
    </div>

    <style>
        .admin-requisition-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .error-alert {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #991b1b;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .admin-header {
            background:white;
            border-radius: 12px;
            color: white;
            padding: 30px;
            margin-bottom: 30px;
        }

        .admin-title-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .admin-actions {
            display: flex;
            gap: 10px;
        }

        .admin-refresh-btn, .admin-bulk-btn {
            background: green;
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .admin-refresh-btn:hover, .admin-bulk-btn:hover {
            background:darkgreen;
            transform: translateY(-2px);
        }

        .admin-refresh-icon {
            width: 16px;
            height: 16px;
        }

        .admin-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .admin-stat-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-left: 4px solid;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform 0.3s ease;
        }

        .admin-stat-card:hover {
            transform: translateY(-2px);
        }

        .admin-stat-card:nth-child(1) { border-left-color: #3b82f6; }
        .admin-stat-card:nth-child(2) { border-left-color: #f59e0b; }
        .admin-stat-card:nth-child(3) { border-left-color: #10b981; }
        .admin-stat-card:nth-child(4) { border-left-color: #ef4444; }

        .admin-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .admin-stat-icon.total { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
        .admin-stat-icon.pending { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
        .admin-stat-icon.approved { background: rgba(16, 185, 129, 0.1); color: #10b981; }
        .admin-stat-icon.rejected { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

        .admin-stat-content h3 {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
            color: #1f2937;
        }

        .admin-stat-content p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }

        .admin-table-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .admin-table-header {
            padding: 20px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-table-actions {
            display: flex;
            gap: 12px;
        }

        .admin-search-input, .admin-filter-select {
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
        }

        .admin-table-wrapper {
            overflow-x: auto;
        }

        .admin-requisition-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-requisition-table th {
            background: #f1f5f9;
            padding: 12px 8px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        .admin-requisition-table td {
            padding: 12px 8px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
            vertical-align: top;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .admin-requisition-table tr:hover {
            background-color: #f8fafc;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: capitalize;
            white-space: nowrap;
        }

        .status-badge.pending {
            background: rgba(245, 158, 11, 0.1);
            color: #d97706;
        }

        .status-badge.approved {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
        }

        .status-badge.rejected {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        .action-btn {
            padding: 6px 10px;
            border: none;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s ease;
        }

        .edit-btn {
            background: #3b82f6;
            color: white;
        }

        .edit-btn:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }

        .req-id {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            color: #6366f1;
            font-size: 12px;
        }

        .file-link {
            color: #3b82f6;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
        }

        .file-link:hover {
            text-decoration: underline;
        }

        .no-file {
            color: #9ca3af;
            font-style: italic;
            font-size: 12px;
        }

        .content-preview {
            color: #4b5563;
            font-size: 12px;
        }

        .current-remarks {
            color: #6b7280;
            font-size: 12px;
            font-style: italic;
        }

        .no-data {
            color: #6b7280;
            font-style: italic;
            text-align: center;
            padding: 40px;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
            color: #1f2937;
        }

        .close {
            color: #9ca3af;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .close:hover {
            color: #374151;
        }

        .modal-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #374151;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.2s ease;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .modal-footer {
            padding: 20px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .bulk-info {
            background: #f3f4f6;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Success/Error Messages */
        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin: 10px 0;
            border: 1px solid;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-color: #22c55e;
        }

        .alert-error {
            background: #fee2e2;
            color: #dc2626;
            border-color: #ef4444;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .admin-requisition-container {
                padding: 10px;
            }
            
            .admin-title-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .admin-stats-grid {
                grid-template-columns: 1fr;
            }
            
            .admin-table-header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .admin-table-actions {
                width: 100%;
                flex-direction: column;
            }
            
            .admin-search-input, .admin-filter-select {
                width: 100%;
            }

            .admin-requisition-table th,
            .admin-requisition-table td {
                padding: 8px 4px;
                font-size: 12px;
            }
        }
    </style>

    <script>
        // Setup CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Alternative method - get CSRF token from meta tag
        function getCSRFToken() {
            const token = document.querySelector('meta[name="csrf-token"]');
            return token ? token.getAttribute('content') : '';
        }

        // Search functionality
        function searchTable() {
            const input = document.querySelector('.admin-search-input');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('requisitionTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                let found = false;
                const cells = rows[i].getElementsByTagName('td');
                
                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].textContent.toLowerCase().includes(filter)) {
                        found = true;
                        break;
                    }
                }
                
                rows[i].style.display = found ? '' : 'none';
            }
        }

        // Filter functionality
        function filterTable() {
            const select = document.querySelector('.admin-filter-select');
            const filter = select.value;
            const rows = document.querySelectorAll('[data-status]');

            rows.forEach(row => {
                if (filter === 'all' || row.dataset.status === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Open Edit Modal
        function openEditModal(reqId, currentStatus, currentRemarks) {
            document.getElementById('modalReqId').value = reqId;
            document.getElementById('modalStatus').value = currentStatus;
            document.getElementById('modalRemarks').value = currentRemarks || '';
            document.getElementById('editModal').style.display = 'block';
        }

        // Close Edit Modal
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Close Bulk Modal
        function closeBulkModal() {
            document.getElementById('bulkModal').style.display = 'none';
        }

        // Show messages
        function showMessage(message, type = 'info') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.innerHTML = `
                <strong>${type === 'success' ? 'Success!' : 'Error!'}</strong> ${message}
                <button type="button" onclick="this.parentElement.remove()" style="float: right; background: none; border: none; font-size: 18px; cursor: pointer;">&times;</button>
            `;
            
            // Insert at the top of the container
            const container = document.querySelector('.admin-requisition-container');
            container.insertBefore(alertDiv, container.firstChild);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentElement) {
                    alertDiv.remove();
                }
            }, 5000);
        }

        // Update individual requisition - FIXED VERSION
        function updateRequisition() {
            const reqId = document.getElementById('modalReqId').value;
            const status = document.getElementById('modalStatus').value;
            const remarks = document.getElementById('modalRemarks').value;

            if (!status) {
                showMessage('Please select a status', 'error');
                return;
            }

            // Show loading
            const btn = document.querySelector('.modal-footer .btn-primary');
            const originalText = btn.textContent;
            btn.textContent = 'Updating...';
            btn.disabled = true;

            // Create form data with CSRF token
            const formData = new FormData();
            formData.append('requisition_id', reqId);
            formData.append('status', status);
            formData.append('remarks', remarks);
            formData.append('_token', getCSRFToken());

            // Send AJAX request
            fetch('/admin/requisitions/update-status', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                btn.textContent = originalText;
                btn.disabled = false;
                
                if (data.success) {
                    showMessage(data.message, 'success');
                    closeEditModal();
                    
                    // Update the UI without full page reload
                    updateRowStatus(reqId, status, remarks);
                } else {
                    showMessage(data.message || 'Update failed', 'error');
                }
            })
            .catch(error => {
                btn.textContent = originalText;
                btn.disabled = false;
                console.error('Error:', error);
                showMessage('Network error occurred. Please try again.', 'error');
            });
        }

        // Update row status in the table
        function updateRowStatus(reqId, newStatus, newRemarks) {
            const statusElement = document.getElementById(`status-${reqId}`);
            const remarksElement = document.getElementById(`remarks-${reqId}`);
            const row = document.querySelector(`tr[data-req-id="${reqId}"]`);
            
            if (statusElement) {
                statusElement.className = `status-badge ${newStatus}`;
                statusElement.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
            }
            
            if (remarksElement) {
                remarksElement.textContent = newRemarks || 'No remarks';
            }
            
            if (row) {
                row.setAttribute('data-status', newStatus);
            }
        }

        // Toggle select all
        function toggleSelectAll(selectAllCheckbox) {
            const checkboxes = document.querySelectorAll('.row-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            updateSelectedCount();
        }

        // Update selected count
        function updateSelectedCount() {
            const selected = document.querySelectorAll('.row-checkbox:checked');
            const countElement = document.getElementById('selectedCount');
            if (countElement) {
                countElement.textContent = selected.length;
            }
        }

        // Show bulk modal
        function showBulkModal() {
            const selected = document.querySelectorAll('.row-checkbox:checked');
            if (selected.length === 0) {
                showMessage('Please select at least one requisition', 'error');
                return;
            }
            updateSelectedCount();
            document.getElementById('bulkModal').style.display = 'block';
        }

        // Bulk update requisitions - FIXED VERSION
        function bulkUpdateRequisitions() {
            const selected = document.querySelectorAll('.row-checkbox:checked');
            const ids = Array.from(selected).map(cb => cb.value);
            const status = document.getElementById('bulkStatus').value;
            const remarks = document.getElementById('bulkRemarks').value;

            if (!status) {
                showMessage('Please select a status', 'error');
                return;
            }

            if (ids.length === 0) {
                showMessage('Please select requisitions', 'error');
                return;
            }

            // Show loading
            const btn = document.querySelector('#bulkModal .btn-primary');
            const originalText = btn.textContent;
            btn.textContent = 'Updating...';
            btn.disabled = true;

            // Create form data with CSRF token
            const formData = new FormData();
            ids.forEach(id => formData.append('requisition_ids[]', id));
            formData.append('status', status);
            formData.append('remarks', remarks);
            formData.append('_token', getCSRFToken());

            // Send AJAX request
            fetch('/admin/requisitions/bulk-update-status', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                btn.textContent = originalText;
                btn.disabled = false;
                
                if (data.success) {
                    showMessage(data.message, 'success');
                    closeBulkModal();
                    
                    // Update all selected rows
                    ids.forEach(id => {
                        updateRowStatus(id, status, remarks);
                    });
                    
                    // Clear selections
                    document.querySelectorAll('.row-checkbox:checked').forEach(cb => cb.checked = false);
                    document.getElementById('selectAll').checked = false;
                } else {
                    showMessage(data.message || 'Bulk update failed', 'error');
                }
            })
            .catch(error => {
                btn.textContent = originalText;
                btn.disabled = false;
                console.error('Error:', error);
                showMessage('Network error occurred. Please try again.', 'error');
            });
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const editModal = document.getElementById('editModal');
            const bulkModal = document.getElementById('bulkModal');
            
            if (event.target == editModal) {
                closeEditModal();
            }
            if (event.target == bulkModal) {
                closeBulkModal();
            }
        }

        // Refresh page
        function refreshData() {
            location.reload();
        }

        // Add event listeners when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Add change event to checkboxes to update count
            document.querySelectorAll('.row-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedCount);
            });
        });
    </script>
@endsection