<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link rel="stylesheet" href="assets/css/admininventory.css">
    <title>Document</title>
</head>
<body>

    <div class="header-container">
        <div class="header-content">
            <h1 class="header-title">Inventory Management</h1>
            <p class="header-subtitle">Manage your inventory items, quantities, and suppliers</p>
        </div>
        
        <div class="button-group">
       
      
            <button class="export-btn" onclick="handleExport()">
                <svg class="export-icon" viewBox="0 0 24 24">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                    <polyline points="7,10 12,15 17,10"></polyline>
                    <line x1="12" y1="15" x2="12" y2="3"></line>
                </svg>
                Export
            </button>
            

          
            <a href="{{route('additem')}}" class="add-btn">
                <svg class="plus-icon" viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add Item
            </a>
        
          
        </div>
    </div>

    <script>
        function handleExport() {
            alert('Export functionality would be implemented here');
        }
    </script>
</body>
</html>

