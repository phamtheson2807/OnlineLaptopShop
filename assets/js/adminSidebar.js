$(document).ready(function() {
    function checkAdminUnreadMessages() {
        $.ajax({
            url: '../../backend/adminFUNCTIONS/adminFetchMessages.php',
            method: 'GET',
            data: { get_unread: true },
            dataType: 'json',
            success: function(response) {
                try {
                    const messageBadge = $('.admin-message-badge');
                    console.log('Raw response:', response);
                    
                    const unreadCount = response['admin Sidebar unread_count'];
                    console.log('Admin Messages Unread count:', unreadCount);
                    
                    if (unreadCount > 0) {
                        console.log('Unread messages:', unreadCount);
                        messageBadge.css('display', 'block');
                    } else {
                        messageBadge.css('display', 'none');
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
    checkAdminUnreadMessages();
    setInterval(checkAdminUnreadMessages, 3000);
});