@extends('layouts.adminmaster')

@section('content')
    <div class="recognition-main-container">
        <!-- Header -->
        <div class="recognition-header">
            <div class="recognition-header-content">
                <div class="recognition-title-section">
                    <h1>Recognition Form</h1>
                  
                    <a href="/adminrequisitionrecord" class="recognition-admin-btn">
                        <svg class="recognition-admin-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Admin Records
                    </a>

                    <a href="{{ route('my.submissions') }}" class="nav-link">
                         <span class="nav-icon">📋</span>
                      My Submissions
                       </a>
                        
                </div>
                <p>Welcome to Government Innovation Lab we help you to Learn new thing and create something new.</p>
            </div>
        </div>

        <!-- Request Section -->
        <div class="recognition-request-section">
            <h2>Request Inventory Item</h2>
            <p>Download the recognition form, fill it out, and upload it back to request inventory items.</p>
            
            <div class="recognition-button-group">
                <a href="{{route('Requistion_form')}}?v={{time()}}" class="recognition-btn recognition-btn-primary">
                    <svg class="recognition-btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download Form
                </a>
                
                <a href="/uploadfile" class="recognition-btn recognition-btn-primary">
                    <svg class="recognition-btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    Upload Filled Form
                </a>

                <a href="/Recognition" class="recognition-btn recognition-btn-primary">
                    <svg class="recognition-btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Create Recognition
                </a>
            </div>
        </div>
    </div>
    <script>
        // Add loading state to buttons when clicked
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.recognition-btn, .recognition-admin-btn');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // Don't add loading state for hash links or if already loading
                    if (this.href && !this.href.includes('#') && !this.classList.contains('loading')) {
                        this.classList.add('loading');
                        
                        // Remove loading state after 3 seconds (fallback)
                        setTimeout(() => {
                            this.classList.remove('loading');
                        }, 3000);
                    }
                });
            });
        });
    </script>
@endsection