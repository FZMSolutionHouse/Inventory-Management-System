@extends('layouts.adminmaster')

@section('content')
    <div class="contact-main-container">
        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach 
            </div>
        @endif

        <main class="form-container">
            <h1>Contact Form</h1>
            <header>
                <button class="back-button" onclick="window.history.back()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5"></path>
                        <path d="M12 19l-7-7 7-7"></path>
                    </svg>
                    Back
                </button>
            </header>
            
            <form class="contact-form" action="{{ route('uploadfile.create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" class="@error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="designation">Designation</label>
                    <input type="text" id="designation" class="@error('designation') is-invalid @enderror" value="{{ old('designation') }}" name="designation" required>
                    @error('designation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" class="@error('subject') is-invalid @enderror" value="{{ old('subject') }}" name="subject" required>
                    @error('subject')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="upload">Upload File</label>
                    <div class="upload-container" id="uploadContainer">
                        <input type="file" id="upload" name="upload" accept=".pdf,.doc,.docx,.txt,.jpg,.png,.jpeg">
                        <div class="upload-placeholder" id="uploadPlaceholder">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17,8 12,3 7,8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            <span id="uploadText">Choose file or drag here</span>
                        </div>
                        <div class="selected-file" id="selectedFile" style="display: none;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"></path>
                            </svg>
                            <span id="fileName"></span>
                            <button type="button" class="remove-file" onclick="removeFile(event)">&times;</button>
                        </div>
                    </div>
                    @error('upload')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="submit-button">Submit</button>
            </form>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('upload');
            const uploadContainer = document.getElementById('uploadContainer');
            const placeholder = document.getElementById('uploadPlaceholder');
            const selectedFile = document.getElementById('selectedFile');
            const fileName = document.getElementById('fileName');
            const uploadText = document.getElementById('uploadText');

            // File input change handler
            fileInput.addEventListener('change', function(e) {
                handleFileSelect(e.target.files);
            });

            // Handle file selection
            function handleFileSelect(files) {
                if (files.length > 0) {
                    const file = files[0];
                    
                    // Check file size (limit to 10MB)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('File size must be less than 10MB');
                        clearFileInput();
                        return;
                    }
                    
                    // Show selected file
                    placeholder.style.display = 'none';
                    selectedFile.style.display = 'flex';
                    fileName.textContent = file.name;
                    
                    console.log('File selected:', file.name);
                } else {
                    clearFileInput();
                }
            }

            // Clear file input
            function clearFileInput() {
                placeholder.style.display = 'block';
                selectedFile.style.display = 'none';
                fileName.textContent = '';
                fileInput.value = '';
            }

            // Make clearFileInput available globally
            window.removeFile = function(event) {
                event.preventDefault();
                event.stopPropagation();
                clearFileInput();
            }

            // Drag and drop functionality
            uploadContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadContainer.classList.add('drag-over');
            });

            uploadContainer.addEventListener('dragenter', function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadContainer.classList.add('drag-over');
            });

            uploadContainer.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Only remove drag-over class if we're leaving the container entirely
                if (!uploadContainer.contains(e.relatedTarget)) {
                    uploadContainer.classList.remove('drag-over');
                }
            });

            uploadContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadContainer.classList.remove('drag-over');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    // Set files to the input
                    fileInput.files = files;
                    handleFileSelect(files);
                }
            });

            // Click to select file
            placeholder.addEventListener('click', function() {
                fileInput.click();
            });

            // Form submission with loading state
            const form = document.querySelector('.contact-form');
            const submitButton = document.querySelector('.submit-button');
            
            form.addEventListener('submit', function(e) {
                // Add loading state
                submitButton.classList.add('loading');
                submitButton.disabled = true;
                
                // For demo purposes - remove this in production
                setTimeout(() => {
                    submitButton.classList.remove('loading');
                    submitButton.disabled = false;
                }, 2000);
            });

            // Input validation and styling
            const inputs = document.querySelectorAll('input[required]');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    const formGroup = this.closest('.form-group');
                    if (this.value.trim() === '') {
                        formGroup.classList.add('error');
                        formGroup.classList.remove('success');
                    } else {
                        formGroup.classList.remove('error');
                        formGroup.classList.add('success');
                    }
                });

                input.addEventListener('input', function() {
                    const formGroup = this.closest('.form-group');
                    if (this.value.trim() !== '') {
                        formGroup.classList.remove('error');
                        formGroup.classList.add('success');
                    }
                });
            });
        });
    </script>
@endsection