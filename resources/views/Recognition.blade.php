@extends('layouts.adminmaster')

@section('content')

    <div class="recognition-container">
        <h1>Create a Recognition</h1>
        <p>"Smarter Inventory. Stronger Business."</p>
        <a href="/RecognitionPage" class="recognition-back-btn">← Back</a>
        <div id="errorMessage" class="recognition-error-message"></div>
        <div id="successMessage" class="recognition-success-message"></div>
        
        {{-- Laravel success message --}}
        @if(session('success'))
            <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif
        
        <form action="{{ route('recognition.store') }}" method="POST" id="postForm">
            @csrf

            <div class="recognition-form-group">
                <label for="title">Name:</label>
                <input type="text" 
                       class="@error('Name') is-invalid @enderror" 
                       id="title" 
                       value="{{ old('Name') }}" 
                       name="name" 
                       placeholder="Enter Name" 
                       maxlength="100">
                @error('Name')
                    <span class="invalid-feedback" style="color: #dc3545; font-size: 0.875em;">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            
           <div class="recognition-form-group">
                <label for="title">Designation:</label>
                <input type="text" 
                       class="@error('designation') is-invalid @enderror" 
                       id="title" 
                       value="{{ old('designation') }}" 
                       name="designation" 
                       placeholder="Enter designation" 
                       maxlength="100">
                @error('designation')
                    <span class="invalid-feedback" style="color: #dc3545; font-size: 0.875em;">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="recognition-form-group">
                <label for="title">Subject:</label>
                <input type="text" 
                       class="@error('subject') is-invalid @enderror" 
                       id="title" 
                       value="{{ old('subject') }}" 
                       name="subject" 
                       placeholder="Enter Subject" 
                       maxlength="100">
                @error('subject')
                    <span class="invalid-feedback" style="color: #dc3545; font-size: 0.875em;">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            
            <div class="recognition-form-group">
                <label for="content">Content:</label>
                <textarea id="content" 
                          class="@error('content') is-invalid @enderror" 
                          name="content" 
                          placeholder="Enter Recognition content here...">{{ old('content') }}</textarea>
                <div class="recognition-char-count" id="charCount">0 characters</div>
                @error('content')
                    <span class="invalid-feedback" style="color: #dc3545; font-size: 0.875em;">
                        {{ $message }}
                    </span>
                @enderror
            </div>
            
            <div class="recognition-btn-container">
                <button type="submit" class="recognition-btn">Submit</button>
            </div>
        </form>
    </div>

    <!-- CKEditor 4 from CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.22.1/ckeditor.js"></script>
    
    <script>
        const titleInput = document.getElementById('title');
        const charCount = document.getElementById('charCount');
        const form = document.getElementById('postForm');
        const errorMessage = document.getElementById('errorMessage');
        const successMessage = document.getElementById('successMessage');
        let editor;

        // Function to show messages
        function showMessage(element, message, duration = 5000) {
            element.textContent = message;
            element.style.display = 'block';
            setTimeout(() => {
                element.style.display = 'none';
            }, duration);
        }

        // Initialize CKEditor with comprehensive toolbar
        CKEDITOR.replace('content', {
            height: 300,
            toolbar: [
                { name: 'document', items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates'] },
                { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
                { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'] },
                '/',
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
                '/',
                { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak'] },
                { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                { name: 'colors', items: ['TextColor', 'BGColor'] },
                { name: 'tools', items: ['Maximize', 'ShowBlocks'] }
            ],
            // Additional configuration options
            removeButtons: 'Flash,Iframe', // Remove Flash and Iframe for security
            extraPlugins: 'justify',
            allowedContent: true,
            enterMode: CKEDITOR.ENTER_P,
            shiftEnterMode: CKEDITOR.ENTER_BR
        });

        // Handle CKEditor initialization
        CKEDITOR.on('instanceReady', function(evt) {
            editor = evt.editor;
            
            // Update character count on content change
            editor.on('change', function() {
                updateCharCount();
            });
            
            editor.on('key', function() {
                setTimeout(updateCharCount, 100);
            });

            editor.on('paste', function() {
                setTimeout(updateCharCount, 100);
            });
            
            // Initial character count
            updateCharCount();
            
            showMessage(successMessage, 'CKEditor loaded successfully!', 3000);
        });

        // Handle CKEditor loading errors
        CKEDITOR.on('error', function(evt) {
            showMessage(errorMessage, 'Error loading CKEditor: ' + evt.data.message);
        });

        function updateCharCount() {
            if (editor) {
                const content = editor.getData().replace(/<[^>]*>/g, '').trim();
                charCount.textContent = content.length + ' characters';
            }
        }

        // Handle title input for character count on title field
        titleInput.addEventListener('input', function() {
            const remaining = 100 - this.value.length;
            if (remaining < 20) {
                titleInput.style.borderColor = remaining < 0 ? '#dc3545' : '#ffc107';
            } else {
                titleInput.style.borderColor = '#e1e5e9';
            }
        });

        // Form submission - let Laravel handle validation, remove JS validation
        form.addEventListener('submit', function(e) {
            // Update CKEditor content before submission
            if (editor) {
                editor.updateElement();
            }
        });
    </script>
@endsection