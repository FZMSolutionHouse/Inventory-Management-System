// Two-Step Verification Toggle Handler
function handleVerificationToggle(checkbox) {
    const form = document.getElementById('verification-form-toggle');
    const input = document.getElementById('verification-input-hidden');
    
    if (checkbox.checked) {
        input.value = '1';
        if(confirm('Are you sure you want to enable Two-Step Verification?\n\nYou will need to enter a verification code sent to your email each time you log in.')) {
            form.submit();
        } else {
            checkbox.checked = false;
        }
    } else {
        input.value = '0';
        if(confirm('Are you sure you want to disable Two-Step Verification?\n\nThis will make your account less secure.')) {
            form.submit();
        } else {
            checkbox.checked = true;
        }
    }
}

// Auto-hide alerts after 6 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.verification-notification-success, .verification-notification-error');
    alerts.forEach(function(alert) {
        if (alert.querySelector('.verification-notification-dismiss')) {
            setTimeout(function() {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.3s ease';
                setTimeout(function() {
                    alert.remove();
                }, 300);
            }, 6000);
        }
    });

    // Navigation between sections
    const navItems = document.querySelectorAll('.settings-nav-item');
    const contentSections = document.querySelectorAll('.content-section');
    
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const targetPage = this.dataset.page;
            
            // Remove active class from all nav items
            navItems.forEach(nav => nav.classList.remove('active'));
            
            // Add active class to clicked nav item
            this.classList.add('active');
            
            // Hide all content sections
            contentSections.forEach(section => section.classList.remove('active'));
            
            // Show target section
            const targetSection = document.getElementById(targetPage + '-section');
            if (targetSection) {
                targetSection.classList.add('active');
            }
            
            // Update URL without page reload
            if (history.pushState) {
                const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                window.history.pushState({path: newUrl}, '', newUrl);
            }
        });
    });

    // Email Recipients Management
    let selectedRecipients = [];
    const employees = typeof window.employees !== 'undefined' ? window.employees : [];
    const recipientSearch = document.getElementById('recipientSearch');
    const recipientsDropdown = document.getElementById('recipientsDropdown');
    const selectedRecipientsContainer = document.getElementById('selectedRecipients');
    const hiddenRecipients = document.getElementById('hiddenRecipients');
    
    if (recipientSearch) {
        recipientSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            if (searchTerm.length === 0) {
                recipientsDropdown.style.display = 'none';
                return;
            }
            
            const filteredEmployees = employees.filter(emp => 
                emp.name.toLowerCase().includes(searchTerm) || 
                emp.email.toLowerCase().includes(searchTerm)
            ).filter(emp => !selectedRecipients.find(selected => selected.email === emp.email));
            
            if (filteredEmployees.length > 0) {
                recipientsDropdown.innerHTML = filteredEmployees.map(emp => `
                    <div class="recipient-option" data-email="${emp.email}" data-name="${emp.name}">
                        <div class="recipient-avatar">${emp.avatar || emp.name.charAt(0).toUpperCase()}</div>
                        <div>
                            <div style="font-weight: 500;">${emp.name}</div>
                            <div style="font-size: 12px; color: #6b7280;">${emp.email}</div>
                        </div>
                    </div>
                `).join('');
                
                if (validateEmail(searchTerm)) {
                    recipientsDropdown.innerHTML += `
                        <div class="recipient-option manual-entry" data-email="${searchTerm}" data-name="${searchTerm}">
                            <div class="recipient-avatar">${searchTerm.charAt(0).toUpperCase()}</div>
                            <div>
                                <div style="font-weight: 500;">Add: ${searchTerm}</div>
                                <div style="font-size: 12px; color: #6b7280;">External email address</div>
                            </div>
                        </div>
                    `;
                }
                recipientsDropdown.style.display = 'block';
            } else if (validateEmail(searchTerm)) {
                recipientsDropdown.innerHTML = `
                    <div class="recipient-option manual-entry" data-email="${searchTerm}" data-name="${searchTerm}">
                        <div class="recipient-avatar">${searchTerm.charAt(0).toUpperCase()}</div>
                        <div>
                            <div style="font-weight: 500;">Add: ${searchTerm}</div>
                            <div style="font-size: 12px; color: #6b7280;">External email address</div>
                        </div>
                    </div>
                `;
                recipientsDropdown.style.display = 'block';
            } else {
                recipientsDropdown.style.display = 'none';
            }
        });

        recipientSearch.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const email = this.value.trim();
                if (validateEmail(email) && !selectedRecipients.find(r => r.email === email)) {
                    addRecipient({ email: email, name: email });
                    this.value = '';
                    recipientsDropdown.style.display = 'none';
                }
            }
        });
        
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('recipient-option') || e.target.closest('.recipient-option')) {
                const option = e.target.classList.contains('recipient-option') ? e.target : e.target.closest('.recipient-option');
                const email = option.dataset.email;
                const name = option.dataset.name;
                addRecipient({ email: email, name: name });
                recipientSearch.value = '';
                recipientsDropdown.style.display = 'none';
            }
            
            if (!recipientsDropdown.contains(e.target) && e.target !== recipientSearch) {
                recipientsDropdown.style.display = 'none';
            }
        });
    }
    
    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
    
    function addRecipient(recipient) {
        if (!selectedRecipients.find(r => r.email === recipient.email)) {
            selectedRecipients.push(recipient);
            updateRecipientsDisplay();
        }
    }
    
    function removeRecipient(email) {
        selectedRecipients = selectedRecipients.filter(r => r.email !== email);
        updateRecipientsDisplay();
    }
    
    function updateRecipientsDisplay() {
        selectedRecipientsContainer.innerHTML = selectedRecipients.map(recipient => `
            <div class="recipient-tag">
                <span>${recipient.name}</span>
                <span class="remove-recipient" onclick="removeRecipient('${recipient.email}')">×</span>
            </div>
        `).join('');
        
        hiddenRecipients.value = selectedRecipients.map(r => r.email).join(',');
    }
    
    // Make removeRecipient available globally
    window.removeRecipient = removeRecipient;

    // Email Templates
    const templateButtons = document.querySelectorAll('.template-btn');
    const emailContent = document.getElementById('emailContent');
    const emailSubject = document.getElementById('email_subject');
    
    const templates = {
        meeting: {
            subject: 'Meeting Invitation',
            content: `Dear Team,\n\nYou are invited to attend an important meeting.\n\nDate: [Date]\nTime: [Time]\nLocation: [Location/Link]\nAgenda: [Meeting Agenda]\n\nPlease confirm your attendance.\n\nBest regards,\nManagement`
        },
        announcement: {
            subject: 'Important Announcement',
            content: `Dear Team,\n\nWe would like to announce the following:\n\n[Announcement Details]\n\nThis will take effect from [Date].\n\nIf you have any questions, please feel free to reach out.\n\nBest regards,\nManagement`
        },
        reminder: {
            subject: 'Friendly Reminder',
            content: `Dear Team,\n\nThis is a friendly reminder about:\n\n[Reminder Details]\n\nDeadline: [Date]\n\nPlease ensure this is completed on time.\n\nThank you for your attention.\n\nBest regards,\nManagement`
        }
    };
    
    templateButtons.forEach(button => {
        button.addEventListener('click', function() {
            const templateType = this.dataset.template;
            const template = templates[templateType];
            
            if (template) {
                emailSubject.value = template.subject;
                emailContent.value = template.content;
                
                // Visual feedback
                this.style.background = '#f0fdf4';
                this.style.borderColor = '#10b981';
                setTimeout(() => {
                    this.style.background = '';
                    this.style.borderColor = '';
                }, 1000);
            }
        });
    });

    // Profile Image Upload Preview
    const settingsImageInput = document.getElementById('settingsImageInput');
    const settingsProfileImage = document.getElementById('settingsProfileImage');
    
    if (settingsImageInput) {
        settingsImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = settingsProfileImage.querySelector('img');
                    const span = settingsProfileImage.querySelector('span');
                    
                    if (img) {
                        img.src = e.target.result;
                        img.style.display = 'block';
                        if (span) span.style.display = 'none';
                    } else {
                        const newImg = document.createElement('img');
                        newImg.src = e.target.result;
                        newImg.alt = 'Profile Image';
                        settingsProfileImage.insertBefore(newImg, settingsProfileImage.firstChild);
                        if (span) span.style.display = 'none';
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Email Form Validation
    const emailForm = document.getElementById('emailForm');
    if (emailForm) {
        emailForm.addEventListener('submit', function(e) {
            if (selectedRecipients.length === 0) {
                e.preventDefault();
                alert('Please add at least one recipient.');
                return false;
            }
            
            const subject = emailSubject.value.trim();
            const content = emailContent.value.trim();
            
            if (!subject || !content) {
                e.preventDefault();
                alert('Please fill in both subject and message.');
                return false;
            }
        });
    }
});