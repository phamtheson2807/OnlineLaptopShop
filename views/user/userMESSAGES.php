<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../loginPAGE.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Admin</title>
    <link rel="stylesheet" href="../../assets/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Add these scripts -->
    <script src="../../assets/js/jquery.js"></script>
    <script src="../../assets/js/bootstrap.js"></script>
    <script src="../../assets/js/productReturn.js"></script>
    <style>
        .wrapper {
            display: flex;
        }
        .main-content {
            flex: 1;
            margin-left: 250px; /* Sidebar width */
        }
        .chat-container {
            height: calc(100vh - 200px); /* Reduced height */
            margin: 10px 0; /* Reduced margin */
            display: flex;
            flex-direction: column;
        }
        .chat-box {
            flex: 1;
            height: calc(100vh - 320px); /* Adjusted height */
            overflow-y: auto;
            padding: 10px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            margin-bottom: 10px; /* Added margin bottom */
        }
        .message-form {
            position: relative;
            margin-top: 15px;
            padding: 10px;
            background: #fff;
        }
        .conversation-header {
            padding: 10px 0;
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
            max-height: 100px;
        }
        .file-preview {
            display: none;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            background: #f8f9fa;
            position: relative;
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

        @media (max-width: 768px) {
            .chat-box {
                height: calc(100vh - 400px);  /* Adjusted for mobile height */
                overflow-y: auto;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>
        
        <div class="main-content">
            <!-- Header -->
            <?php include 'userHEADER.php'; ?>
            
            <!-- Return Modal -->
            <?php include 'productReturnModal.php'; ?>
            <!-- Chat Content -->
            <div class="container-fluid p-4">
                <h2>Message Admin</h2>
                <div class="row chat-container">
                    <div class="col-md-12">
                        <div id="chat-box" class="chat-box"></div>
                        
                        <!-- Return Button -->
                        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#returnModal">
                            Return Product
                        </button>

                        <form id="chat-form" class="message-form" enctype="multipart/form-data">
                            <input type="hidden" id="receiver_id" value="2">
                            <div class="message-input-container">
                                <div id="file-preview" class="file-preview"></div>
                                
                                <input type="file" id="attachment" name="attachment" style="display: none;">
                                <button type="button" class="attachment-btn" onclick="document.getElementById('attachment').click();">
                                    <i class="fas fa-paperclip"></i>
                                </button>
                                
                                <textarea id="message_text" name="message_text" class="form-control" placeholder="Type your message..."></textarea>
                                
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
    <script src="../../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        window.userId = <?php echo $_SESSION['user_id']; ?>;
    </script>
    <script src="../../assets/js/userChat.js"></script>
    <script src="../../assets/js/productReturn.js"></script>
</body>
</html>