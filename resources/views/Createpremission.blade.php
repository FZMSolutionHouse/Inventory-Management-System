<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Premission</title>
    <link rel="stylesheet" href="assets/css/createrole.css">
</head>
<body>
    <div class="role-container">

        <!--  Success Message (Moved Inside)  -->
        @if(session('success'))
        <div class="alert alert-success">
           {{session('success')}}
        </div>  
        @endif
   
        <!-- Error Message (Moved Inside) -->
        @if($errors->any())
        <div class="alert alert-danger">
           @foreach($errors->all() as $error)
               <p>{{$error}}</p>
           @endforeach
        </div>
        @endif

        <h1 class="main-heading">Create Permissions</h1>
        <form action="#" method="POST">
          @csrf
            <div class="checkbox-group" id="roles-options">
                <label><input type="checkbox" name="permissions[]" value="Edit"> Edit</label>
                <label><input type="checkbox" name="permissions[]" value="Delete"> Delete</label>
                <label><input type="checkbox" name="permissions[]" value="Update"> Update</label>
                <label><input type="checkbox" name="permissions[]" value="User Management"> User Management</label>
                <label><input type="checkbox" name="permissions[]" value="Dashboard"> Dashboard</label>
                <label><input type="checkbox" name="permissions[]" value="Inventory Management"> Inventory Management</label>
                <label><input type="checkbox" name="permissions[]" value="Export"> Export</label>
                <label><input type="checkbox" name="permissions[]" value="Add Item"> Add Item</label>
            </div>
            
            <div>
                <label for="selected-roles" style="display: block; margin-bottom: 5px; font-weight: bold;">Selected Permissions:</label>
                <input type="text" id="selected-roles" name="selected-roles" class="form-input" readonly placeholder="Selected options will appear here">
            </div>

            <button type="submit" class="submit-button">Assign Permissions</button>
        </form>
    </div>

   <!-- Your existing script tag is here, no changes needed for it -->
   <script>
    const rolesOptions = document.getElementById('roles-options');
    const selectedRolesInput = document.getElementById('selected-roles');

    rolesOptions.addEventListener('change', () => {
        const checkedBoxes = document.querySelectorAll('input[name="permissions[]"]:checked');
        const selectedValues = Array.from(checkedBoxes).map(checkbox => checkbox.value);
        selectedRolesInput.value = selectedValues.join(', ');
    });
   </script>
</body>
</html>