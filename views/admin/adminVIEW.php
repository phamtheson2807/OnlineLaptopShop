<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../../assets/css/adminVIEW.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Home</title>

</head>

<body>
    <div class="wrapper">
        <!-- Include Sidebar here -->
        <?php include 'adminSIDEBAR.php'; ?>

        <div class="main-content">
            <?php include 'adminHEADER.php'; ?>
            <div class="container my-3">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h4>Image ( <span id="count"></span> )</h4>
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addImage">
                                Add New Laptop
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-section">
                <div class="search-container">
                    <div class="search-bar">
                        <input type="text" id="search" class="form-control" placeholder="Search...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>CPU</th>
                                <th>GPU</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Image</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="image-data"></tbody>
                    </table>
                </div>
            </div>

            <!-- The Modal for Adding Image -->
            <div class="modal fade" id="addImage">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Add Image</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <form action="" id="save">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" id="name" class="form-control form-control-lg">
                                </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea name="description" id="description" class="form-control form-control-lg"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">CPU</label>
                                    <input type="text" name="cpu" id="cpu" class="form-control form-control-lg">
                                </div>
                                <div class="form-group">
                                    <label for="">GPU</label> 
                                    <input type="text" name="gpu" id="gpu" class="form-control form-control-lg">
                                </div>
                                <div class="form-group">
                                    <label for="">Price</label>
                                    <input type="text" name="price" id="price" class="form-control form-control-lg">
                                </div>
                                <div class="form-group">
                                    <label for="">Stock</label>
                                    <input type="text" name="stock" id="stock" class="form-control form-control-lg">
                                </div>
                                <div class="form-group">
                                    <label for="">Image</label>
                                    <input type="file" name="image" id="image" class="form-control form-control-lg">
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Save</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- The Modal for Updating Image -->
            <div class="modal fade" id="updateImage">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Update Image</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <form action="" id="update" enctype="multipart/form-data">
                            <div id="edit-image"></div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Update</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteConfirmModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Delete Confirmation</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete this item?</p>
                            <input type="hidden" id="delete_id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../assets/js/jquery.js"></script>
    <script src="../../assets/js/bootstrap.js"></script>
    <script src="../../assets/js/adminCRUD.js"></script>
</body>

</html>