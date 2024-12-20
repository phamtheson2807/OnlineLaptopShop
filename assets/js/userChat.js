$(document).ready(function() {
    // Add loader HTML after the chat-box
    $('#chat-box').after(`
        <div id="message-loader" style="display:none;" class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">--</span>
            </div>
        </div>
    `);

    // Add file preview handler
    document.getElementById('attachment').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('file-preview');
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                if (file.type.startsWith('image/')) {
                    preview.innerHTML = `
                        <div>
                            <img src="${e.target.result}" class="preview-image">
                            <i class="fas fa-times remove-file" onclick="removeFile()"></i>
                        </div>`;
                } else {
                    preview.innerHTML = `
                        <div>
                            <i class="fas fa-file"></i> ${file.name}
                            <i class="fas fa-times remove-file" onclick="removeFile()"></i>
                        </div>`;
                }
                preview.style.display = 'block';
            };
            
            reader.readAsDataURL(file);
        }
    });

    // Add remove file function
    window.removeFile = function() {
        document.getElementById('attachment').value = '';
        document.getElementById('file-preview').style.display = 'none';
    };

    function markMessagesAsRead() {
        $.ajax({
            url: '../../backend/userFUNCTIONS/userFetchMessages.php',
            method: 'POST',
            data: { mark_read: true, sender_id: 2 },
            success: function(response) {
                // Refresh unread badge in sidebar
                if (typeof checkUnreadMessages === 'function') {
                    checkUnreadMessages();
                }
            }
        });
    }

    function fetchMessages() {
        // Store scroll info before refresh
        const chatBox = $('#chat-box');
        const wasAtBottom = (chatBox.scrollTop() + chatBox.innerHeight() + 30 >= chatBox[0].scrollHeight);

        $.ajax({
            url: '../../backend/userFUNCTIONS/userFetchMessages.php',
            method: 'GET',
            data: { receiver_id: 2 },
            dataType: 'json',
            success: function(messages) {
                $('#chat-box').html('');
                messages.forEach(message => {
                    const isReceiver = message.receiver_id === 2;
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
                    $('#chat-box').append(messageHtml);
                });
                
                // Only scroll if user was at bottom
                if (wasAtBottom) {
                    chatBox.scrollTop(chatBox[0].scrollHeight);
                }

                // Mark messages as read after loading them
                markMessagesAsRead();
            }
        });
    }

    $('#chat-form').submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('receiver_id', 2);
        
        // Show loader
        $('#message-loader').show();
        $('#chat-form button[type="submit"]').prop('disabled', true);
        
        $.ajax({
            url: '../../backend/userFUNCTIONS/userFetchMessages.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === 'success') {
                    $('#message_text').val('');
                    $('#attachment').val('');
                    $('#file-preview').hide();
                    fetchMessages();
                }
            },
            error: function() {
                alert('Error sending message');
            },
            complete: function() {
                // Hide loader and enable submit button
                $('#message-loader').hide();
                $('#chat-form button[type="submit"]').prop('disabled', false);
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

    // Initial load
    fetchMessages();
    markMessagesAsRead();
    
    setInterval(fetchMessages, 3000);
});