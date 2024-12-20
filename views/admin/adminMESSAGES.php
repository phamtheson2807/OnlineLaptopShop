<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Chat</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../../assets/css/adminSIDEBAR.css"> <!-- Move before Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="../../assets/js/jquery.js"></script>

    <style>
        .wrapper {
            display: flex;
        }
        .main-content {
            flex: 1;
            margin-left: 250px;
        }
        .chat-container {
            height: calc(100vh - 200px);
            margin: 20px 0;
        }
        .user-list {
            height: 100%;
            overflow-y: auto;
            border-right: 1px solid #dee2e6;
        }
        .user-item {
            cursor: pointer;
            padding: 18px 10px;
            border-bottom: 1px solid #dee2e6;
            position: relative;
        }
        .user-item:hover {
            background-color: #f8f9fa;
        }
        .chat-box {
            height: calc(100vh - 350px);
            overflow-y: auto;
            padding: 10px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }
        .message-form {
            position: relative;
            margin-top: 15px;
            display: none; /* Hidden by default */
        }
        .message-input-container {
            position: relative;
            display: flex;
            align-items: flex-end;
        }
        .attachment-btn {
            position: absolute;
            left: 10px;
            bottom: 10px;
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            z-index: 10;
        }
        .send-btn {
            position: absolute;
            right: 10px;
            bottom: 10px;
            background: none;
            border: none;
            color: #007bff;
            cursor: pointer;
        }
        #message_text {
            padding: 10px 40px;
            resize: none;
            border-radius: 20px;
            min-height: 50px;
        }
        .message-form .input-group {
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }
        .message-form .input-group-text {
            background: none;
            border: none;
            cursor: pointer;
        }
        .message-form .btn {
            border: none;
            border-radius: 0 4px 4px 0;
        }
        #message_text {
            border: none;
            resize: none;
        }
        .message-form .input-group-text:hover {
            background-color: #f8f9fa;
        }
        .file-preview {
            display: none;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            background: #f8f9fa;
            position: relative; /* Added */
        }
        .preview-image {
            max-width: 80px;
            max-height: 80px;
            border-radius: 5px;
        }
        .remove-file {
            position: absolute;
            top: 5px;
            right: 5px;
            color: #dc3545;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.8);
            padding: 5px;
            border-radius: 50%;
            font-size: 12px;
        }
        .no-user-selected {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-size: 1.2em;
        }
        .badge {
            position: absolute;
            top: 5px;
            right: 5px;
            font-size: 0.7em;
            padding: 0.4em 0.6em;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <?php include 'adminSIDEBAR.php'; ?>
    <div class="wrapper">
        <div class="main-content">
            <!-- Header -->
            <?php include 'adminHEADER.php'; ?>
            
            <!-- Main Content -->
            <div class="container-fluid p-4">
                <h2>Admin Chat</h2>
                <div class="row chat-container">
                    <!-- Users List -->
                    <div class="col-md-3 user-list">
                        <h4>Users</h4>
                        <ul id="user-list" class="list-group list-group-flush">
                            <!-- User list will be populated here -->
                        </ul>
                    </div>

                    <!-- Chat Container -->
                    <div class="col-md-9">
                        <div class="conversation-header">
                            <h4>Conversation <span id="selected-user-name"></span></h4>
                        </div>
                        <div id="chat-box" class="chat-box">
                            <!-- Default message -->
                            <div class="no-user-selected">
                                <i class="fas fa-comments mb-3" style="font-size: 3em;"></i>
                                <p>Select a user to start messaging</p>
                            </div>
                        </div>
                        <!-- Update form to include file input -->
                        <form id="chat-form" class="message-form" enctype="multipart/form-data">
                            <input type="hidden" id="receiver_id" name="receiver_id">
                            <div class="message-input-container">
                                <!-- File preview container -->
                                <div id="file-preview" class="file-preview"></div>
                                
                                <input type="file" id="attachment" name="attachment" style="display: none;">
                                <button type="button" class="attachment-btn" onclick="document.getElementById('attachment').click();">
                                    <i class="fas fa-paperclip"></i>
                                </button>
                                
                                <!-- Message textarea -->
                                <textarea id="message_text" name="message_text" class="form-control" placeholder="Type your message..."></textarea>
                                
                                <!-- Send button -->
                                <button type="submit" class="send-btn">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Keep only necessary scripts at bottom -->
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        window.adminId = <?php echo $_SESSION['user_id']; ?>;
    </script>
    <script src="../../assets/js/adminChat.js"></script>
    <script src="../../assets/js/adminCRUD.js"></script>
    <script>
        $(document).ready(function() {
            // Keep only user list functionality
            function fetchUsers() {
                $.get('../../backend/adminFUNCTIONS/fetchUsers.php', function(data) {
                    try {
                        const response = JSON.parse(data);
                        if (response.error) {
                            console.error('Error:', response.error);
                            return;
                        }
                        $('#user-list').html('');
                        response.forEach(user => {
                            const userName = `${user.first_name} ${user.last_name} (${user.username})`;
                            $('#user-list').append(`
                                <li class="list-group-item user-item" data-id="${user.user_id}">
                                </li>
                            `);
                        });
                    } catch (e) {
                        console.error('Parse error:', e, 'Raw data:', data);
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX error:', textStatus, errorThrown);
                });
            }

            fetchUsers();
        });

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

        function removeFile() {
            document.getElementById('attachment').value = '';
            document.getElementById('file-preview').style.display = 'none';
        }

        // Show form and hide default message when user is selected
        $(document).on('click', '.user-item', function() {
            $('.no-user-selected').hide();
            $('.message-form').show();
        });
    </script>
</body>
</html>