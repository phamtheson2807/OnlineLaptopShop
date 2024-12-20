$(document).ready(function() {
    const sidebar = document.querySelector('.sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    
    // Create backdrop if not exists
    if (!document.querySelector('.sidebar-backdrop')) {
        const newBackdrop = document.createElement('div');
        newBackdrop.className = 'sidebar-backdrop';
        document.body.appendChild(newBackdrop);
    }

    const backdrop = $('.sidebar-backdrop');

    // Sidebar toggle
    $('#sidebar-toggle').on('click', function(e) {
        e.stopPropagation();
        sidebar.classList.toggle('show');
        backdrop.toggleClass('show');
    });

    // Backdrop click
    backdrop.on('click', function() {
        sidebar.classList.remove('show');
        backdrop.removeClass('show');
    });

    // Outside click
    $(document).on('click', function(e) {
        if (!sidebar.contains(e.target) && 
            !sidebarToggle.contains(e.target) && 
            sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
            backdrop.removeClass('show');
        }
    });

    // Check messages function
    function checkUnreadMessages() {
        $.ajax({
            url: '../../backend/userFUNCTIONS/userFetchMessages.php',
            method: 'GET',
            data: { check_unread: true },
            dataType: 'json',
            success: function(response) {
                try {
                    const messageBadge = $('.user-message-badge');
                    const mobileBadge = $('.mobile-message-badge');
                    console.log('Raw response:', response);
                    
                    if (typeof response === 'string') {
                        response = JSON.parse(response);
                    }
                    
                    console.log('Parsed response:', response);
                    console.log('User Messages Unread count:', response.unread_count);
                    
                    if (response.unread_count > 0) {
                        console.log('Unread messages:', response.unread_count);
                        messageBadge.show();
                        mobileBadge.show();
                    } else {
                        messageBadge.hide();
                        mobileBadge.hide();
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', {
                    status: status,
                    error: error,
                    response: xhr.responseText
                });
            }
        });
    }

    // Initialize message checking
    checkUnreadMessages();
    setInterval(checkUnreadMessages, 2000);
});