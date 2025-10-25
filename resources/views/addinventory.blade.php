<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIL Inventory System</title>
    <style>
        /* Responsive styles for the form */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal {
            background: white;
            border-radius: 12px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            margin: 20px;
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 24px;
            color: #9ca3af;
            text-decoration: none;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .close-btn:hover {
            color: #374151;
            background-color: #f3f4f6;
        }

        .modal-title {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 8px 0;
            padding: 30px 30px 0 30px;
        }

        .modal-subtitle {
            color: #6b7280;
            font-size: 16px;
            margin: 0 0 30px 0;
            padding: 0 30px;
        }

        .alert {
            margin: 0 30px 20px 30px;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d1fae5;
            border: 1px solid #10b981;
            color: #047857;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            padding: 0 30px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-input {
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.2s;
            background-color: #ffffff;
        }

        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-input.is-invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .checkbox-group {
            display: flex;
            gap: 15px;
            margin-top: 5px;
            flex-wrap: wrap;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 8px 12px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            transition: all 0.2s;
            background-color: #ffffff;
        }

        .checkbox-label:hover {
            border-color: #d1d5db;
            background-color: #f9fafb;
        }

        .checkbox-label input[type="checkbox"] {
            margin: 0;
            accent-color: #3b82f6;
        }

        .checkbox-label input[type="checkbox"]:checked + .checkbox-text {
            font-weight: 600;
        }

        .checkbox-label:has(input[type="checkbox"]:checked) {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }

        .checkbox-text {
            font-size: 14px;
            color: #374151;
        }

        .form-group span {
            color: #ef4444;
            font-size: 12px;
            margin-top: 4px;
            font-weight: 500;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            padding: 30px;
            border-top: 1px solid #e5e7eb;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        .btn-cancel {
            background-color: #f3f4f6;
            color: #374151;
            border: 2px solid #e5e7eb;
        }

        .btn-cancel:hover {
            background-color: #e5e7eb;
            border-color: #d1d5db;
        }

        .btn-primary {
            background-color: #3b82f6;
            color: white;
            border: 2px solid #3b82f6;
        }

        .btn-primary:hover {
            background-color: #2563eb;
            border-color: #2563eb;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .modal {
                width: 95%;
                margin: 10px;
                max-height: 95vh;
            }

            .modal-title {
                font-size: 24px;
                padding: 20px 20px 0 20px;
            }

            .modal-subtitle {
                padding: 0 20px;
                font-size: 14px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 15px;
                padding: 0 20px;
            }

            .alert {
                margin: 0 20px 15px 20px;
            }

            .button-group {
                padding: 20px;
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .checkbox-group {
                flex-direction: column;
                gap: 10px;
            }

            .checkbox-label {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .modal {
                width: 98%;
                margin: 5px;
            }

            .modal-title {
                font-size: 20px;
                padding: 15px 15px 0 15px;
            }

            .modal-subtitle {
                padding: 0 15px;
            }

            .form-grid {
                padding: 0 15px;
            }

            .alert {
                margin: 0 15px 10px 15px;
            }

            .button-group {
                padding: 15px;
            }

            .form-input {
                font-size: 16px; /* Prevents zoom on iOS */
            }
        }
    </style>
</head>
<body>
    <div class="overlay">
        <div class="modal">
            <a href="/records" class="close-btn" onclick="closeModal()">&times;</a>
            
            <h2 class="modal-title">GIL Add New Inventory Item</h2>
            <p class="modal-subtitle">GIL new inventory system - Fill in the details below to add a new item to your inventory.</p>
            
             @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
             @endif

            <form  id="inventoryForm" action="{{route('additem')}}"  method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="itemName">Item Name</label>
                        <input type="text" value="{{old('itemName')}}" id="itemName" name="itemName" class="form-input @error ('itemName') is-invalid  @enderror">
                        <span>
                            @error('itemName')
                              {{$message}}
                            @enderror
                        </span>
                    </div>
                    
                    <!-- New Requisition ID field added after Item Name -->
                    <div class="form-group">
                        <label class="form-label" for="requisition_id">Requisition ID</label>
                        <input type="text" value="{{old('requisition_id')}}" id="requisition_id" name="requisition_id" class="form-input @error ('requisition_id') is-invalid @enderror">
                        <span>
                            @error('requisition_id')
                              {{$message}}
                            @enderror
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="category">Category</label>
                        <input type="text" value="{{old('category')}}"  id="category" name="category" class="form-input  @error ('category') is-invalid @enderror">
                        <span>
                            @error('category')
                              {{$message}}
                            @enderror
                        </span>
                    </div>
                    
                    <!-- New Category Type field added after Category -->
                    <div class="form-group">
                        <label class="form-label">Category Type</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="category_type[]" value="Fix" 
                                       {{ (is_array(old('category_type')) && in_array('Fix', old('category_type'))) ? 'checked' : '' }}
                                       class="@error('category_type') is-invalid @enderror">
                                <span class="checkbox-text">Fix</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="category_type[]" value="Consumable" 
                                       {{ (is_array(old('category_type')) && in_array('Consumable', old('category_type'))) ? 'checked' : '' }}
                                       class="@error('category_type') is-invalid @enderror">
                                <span class="checkbox-text">Consumable</span>
                            </label>
                        </div>
                        <span>
                            @error('category_type')
                              {{$message}}
                            @enderror
                        </span>
                    </div>
                    
                    <!-- New Location field added after Category Type -->
                    <div class="form-group">
                        <label class="form-label" for="location">Location</label>
                        <input type="text" value="{{old('location')}}" id="location" name="location" class="form-input @error ('location') is-invalid @enderror">
                        <span>
                            @error('location')
                              {{$message}}
                            @enderror
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="quantity">Quantity</label>
                        <input type="number"  value="{{old('quantity')}}"  id="quantity" name="quantity" class="form-input @error ('quantity') is-invalid @enderror">
                        <span>
                          @error('quantity')
                          {{$message}}
                          @enderror
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="minimumStock">Minimum Stock</label>
                        <input type="number" value="{{old('minimumStock')}}" id="minimumStock" name="minimumStock" class="form-input @error ('minimumStock') is-invalid @enderror">
                        <span>
                            @error('minimumStock')
                              {{$message}}
                            @enderror
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="price">Price</label>
                        <input type="number" value="{{old('price')}}" id="price" name="price" class="form-input @error ('price') is-invalid @enderror">
                        <span>
                            @error('price')
                            {{$message}}
                            @enderror
                        </span>
                    </div>
                    
                    <!-- New Issue field added after Price -->
                    <div class="form-group">
                        <label class="form-label" for="issue">Issue</label>
                        <input type="text" value="{{old('issue')}}" id="issue" name="issue" class="form-input @error ('issue') is-invalid @enderror">
                        <span>
                            @error('issue')
                              {{$message}}
                            @enderror
                        </span>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="supplier">Supplier</label>
                        <input type="text" value="{{old('supplier')}}" id="supplier" name="supplier" class="form-input @error ('supplier') is-invalid @enderror">
                        <span>
                            @error('supplier')
                            {{$message}}
                            @enderror
                        </span>
                    </div>
                </div>
                
                <div class="button-group">
                    <button type="button" class="btn btn-cancel" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Item</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        /*
        function closeModal() {
            // In a real application, this would close the modal
            // For demo purposes, we'll just show an alert
            alert('Modal would close here');
        }

        document.getElementById('inventoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Collect form data
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            
            // In a real application, you would send this data to your backend
            console.log('Form submitted with data:', data);
            alert('Item added successfully!\n\n' + JSON.stringify(data, null, 2));
            
            // Reset form
            this.reset();
        });

        // Auto-focus on the first input when page loads
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('itemName').focus();
        });
        */
    </script>
</body>
</html>