<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 500px;
            padding: 40px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .header h1 {
            font-size: 32px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .header p {
            color: #6b7280;
            font-size: 16px;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .modal-title {
            font-size: 20px;
            font-weight: 600;
            color: #1a1a1a;
        }
        
        .close-btn {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #6b7280;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .close-btn:hover {
            color: #1a1a1a;
        }
        
        .profile-image-container {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            position: relative;
        }
        
        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            font-weight: 600;
            color: #6b7280;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .profile-image:hover {
            background-color: #d1d5db;
        }
        
        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        
        .camera-icon {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 36px;
            height: 36px;
            background-color: #1a1a1a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 3px solid white;
        }
        
        .camera-icon svg {
            width: 16px;
            height: 16px;
            fill: white;
        }
        
        .file-input {
            display: none;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }
        
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 16px;
            background-color: #f9fafb;
            transition: all 0.2s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .form-input::placeholder {
            color: #9ca3af;
        }
        
        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 16px;
            background-color: #f9fafb;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .form-select:focus {
            outline: none;
            border-color: #3b82f6;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .save-btn {
            width: 100%;
            background-color: #1a1a1a;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 16px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .save-btn:hover {
            background-color: #2d2d2d;
            transform: translateY(-1px);
        }
        
        .save-btn:active {
            transform: translateY(0);
        }
        
        .save-btn svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }
        
        @media (max-width: 640px) {
            .container {
                padding: 20px;
                margin: 10px;
            }
            
            .header h1 {
                font-size: 24px;
            }
            
            .profile-image {
                width: 100px;
                height: 100px;
                font-size: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>User Profile</h1>
            <p>Manage your profile information and settings</p>
        </div>
        
        <div class="modal-header">
            <h2 class="modal-title">Edit Profile</h2>
            <button class="close-btn">×</button>
        </div>
        
        <form id="profileForm">
            <div class="profile-image-container">
                <div class="profile-image" id="profileImage">
                    <div class="camera-icon" onclick="document.getElementById('imageInput').click()">
                        <svg viewBox="0 0 24 24">
                            <path d="M12 15.2l3.536-3.536 1.414 1.414L12 18.028 7.05 13.078l1.414-1.414L12 15.2zm0-2.828l-2.828-2.828L10.586 8.13 12 9.544l1.414-1.414 1.414 1.414L12 12.372z"/>
                            <path d="M9 2l1.55 2H15l1.55-2H20a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h5zm3 15.5A6.5 6.5 0 1 0 12 4a6.5 6.5 0 0 0 0 13zm0-2A4.5 4.5 0 1 1 12 6.5a4.5 4.5 0 0 1 0 9z"/>
                        </svg>
                    </div>
                </div>
                <input type="file" id="imageInput" class="file-input" accept="image/*">
            </div>
            
            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-input" 
                    placeholder="Enter your name"
                >
            </div>
            
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input" 
                    placeholder="Enter your email"
                >
            </div>
            
            <div class="form-group">
                <label for="phone" class="form-label">Phone Number</label>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone" 
                    class="form-input" 
                    placeholder="Enter your phone number"
                >
            </div>
            
           <label for="role" class="form-label">Role</label>
                <input 
                    type="text" 
                    id="role" 
                    name="role" 
                    class="form-input" 
                    placeholder="Enter your Role"
           >
            
            <button type="submit" class="save-btn">
                <svg viewBox="0 0 24 24">
                    <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
                </svg>
                Save Changes
            </button>
        </form>
    </div>

    <script>
        // Image upload and preview functionality
        const imageInput = document.getElementById('imageInput');
        const profileImage = document.getElementById('profileImage');
        let currentImageFile = null;

        // Handle image file selection
        imageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            
            if (file) {
                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Please select a valid image file.');
                    return;
                }
                
                // Validate file size (max 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('Please select an image smaller than 5MB.');
                    return;
                }
                
                currentImageFile = file;
                
                // Create FileReader to preview image
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Clear existing content and add image
                    profileImage.innerHTML = `
                        <img src="${e.target.result}" alt="Profile Image">
                        <div class="camera-icon" onclick="document.getElementById('imageInput').click()">
                            <svg viewBox="0 0 24 24">
                                <path d="M9 2l1.55 2H15l1.55-2H20a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h5zm3 15.5A6.5 6.5 0 1 0 12 4a6.5 6.5 0 0 0 0 13zm0-2A4.5 4.5 0 1 1 12 6.5a4.5 4.5 0 0 1 0 9z"/>
                            </svg>
                        </div>
                    `;
                };
                
                reader.readAsDataURL(file);
            }
        });

        // Handle clicking on the profile image area
        profileImage.addEventListener('click', function(event) {
            // Only trigger if clicking on the main area, not the camera icon
            if (!event.target.closest('.camera-icon')) {
                imageInput.click();
            }
        });

    </script>
</body>
</html>