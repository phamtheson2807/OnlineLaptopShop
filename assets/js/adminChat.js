$(document).ready(function() {
    let currentReceiverId = null;

    // Add function to toggle chat interface
    function toggleChatInterface(hasSelectedUser) {
        if (hasSelectedUser) {
            $('.no-user-selected').hide();
            $('.message-form').show();
        } else {
            $('.no-user-selected').show();
            $('.message-form').hide();
            $('#chat-box').html(`
                <div class="no-user-selected">
                    <i class="fas fa-comments mb-3" style="font-size: 3em;"></i>
                    <p>Select a user to start messaging</p>
                </div>
            `);
        }
    }

    // Initialize with no user selected
    toggleChatInterface(false);

    function fetchMessages(receiver_id) {
        // Store scroll info before refresh
        const chatBox = $('#chat-box');
        const wasAtBottom = (chatBox.scrollTop() + chatBox.innerHeight() + 30 >= chatBox[0].scrollHeight);

        $.ajax({
            url: '../../backend/adminFUNCTIONS/adminFetchMessages.php',
            method: 'GET',
            data: { receiver_id },
            dataType: 'json',
            success: function(messages) {
                chatBox.html('');
                messages.forEach(message => {
                    // Match userChat.js logic - compare receiver_id with passed parameter
                    const isReceiver = parseInt(message.receiver_id) === parseInt(receiver_id);
                    let attachmentHtml = '';
                
                    if (message.attachment_link) {
                        const fileExt = message.attachment_link.split('.').pop().toLowerCase();
                        if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExt)) {
                            attachmentHtml = `
                                <div class="mt-2">
                                    <img src="../../${message.attachment_link}" style="max-width: 200px; max-height: 200px; border-radius: 5px;">
                                </div>`;
                        } else {
                            attachmentHtml = `
                                <div class="mt-2">
                                    <a href="../../${message.attachment_link}" class="btn btn-sm btn-light" download>
                                        <i class="fas fa-download"></i> Download Attachment
                                    </a>
                                </div>`;
                        }
                    }

                    messageHtml = `
                        <div style="display: flex; justify-content: ${isReceiver ? 'flex-end' : 'flex-start'}; margin: 10px 0;">
                            <div style="max-width: 70%; padding: 10px; border-radius: 10px; 
                                background-color: ${isReceiver ? '#007bff' : '#e3f2e0'}; 
                                color: ${isReceiver ? 'white' : 'black'};">
                                <div><strong>${isReceiver ? 'You' : message.sender_name}</strong></div>
                                <div>${message.message_text}</div>
                                ${attachmentHtml}
                                <small style="opacity: 0.7;">${message.timestamp}</small>
                            </div>
                        </div>
                    `;
                    chatBox.append(messageHtml);
                });

                // Only scroll to bottom if user was already at bottom
                if (wasAtBottom) {
                    chatBox.scrollTop(chatBox[0].scrollHeight);
                }
            }
        });
    }

    function loadUsersList() {
        $.ajax({
            url: '../../backend/adminFUNCTIONS/adminFetchMessages.php',
            method: 'GET',
            data: { get_users: true },
            success: function(response) {
                const userList = $('#user-list');
                userList.empty();
                
                response.users.forEach(user => {
                    const unreadIndicator = user.unread_count > 0 ? 
                        `<span class="badge bg-danger position-absolute top-0 end-0 translate-middle">
                            <span class="visually-hidden">New message</span>
                        </span>` : '';
                    
                    userList.append(`
                        <li class="list-group-item user-item position-relative" 
                            data-id="${user.user_id}"
                            data-name="${user.first_name} ${user.last_name}">
                            ${user.first_name} ${user.last_name}
                            ${unreadIndicator}
                        </li>
                    `);
                });

                // Add click handler for user selection
                $('.user-item').click(function() {
                    const userName = $(this).data('name');
                    $('#selected-user-name').text(': ' + userName);
                });
            }
        });
    }

    $('#chat-form').submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const receiver_id = $('#receiver_id').val();
        
        $.ajax({
            url: '../../backend/adminFUNCTIONS/adminFetchMessages.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === 'success') {
                    $('#message_text').val('');
                    $('#attachment').val('');
                    $('#file-preview').hide();
                    fetchMessages(receiver_id);
                }
            }
        });
    });

    // Add keypress handler for textarea
    $('#message_text').keypress(function(e) {
        // Check if Enter was pressed without Shift
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault(); // Prevent default line break
            $('#chat-form').submit(); // Submit the form
        }
    });

    // Update user click handler
    $(document).on('click', '.user-item', function() {
        const userId = $(this).data('id');
        // Mark messages as read
        $.get(`../../backend/adminFUNCTIONS/adminFetchMessages.php?mark_read=true&sender_id=${userId}`);
        loadUsersList(); // Refresh list to remove indicator
        const sender_id = $(this).data('id');
        currentReceiverId = sender_id;
        
        const receiver_id = $(this).data('id');
        currentReceiverId = receiver_id;
        /* const userName = $(this).text().trim(); */
        $('#receiver_id').val(receiver_id);
        /* $('#selected-user-name').text('with ' + userName).show(); */
        toggleChatInterface(true);
        fetchMessages(receiver_id);
    });

    // Auto-refresh messages every 3 seconds if a user is selected
    setInterval(function() {
        loadUsersList();
        if (currentReceiverId) {
            fetchMessages(currentReceiverId);
        }
    }, 1000);

    loadUsersList();
});