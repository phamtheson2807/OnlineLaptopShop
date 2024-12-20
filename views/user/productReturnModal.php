<div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="returnModalLabel">Return Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="returnForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="orderSelect" class="form-label">Select Order</label>
                        <select class="form-select" id="orderSelect" name="order_id" required>
                            <option value="">Choose order...</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="returnFile" class="form-label">Attach Image</label>
                        <input type="file" class="form-control" id="returnFile" name="return_file" required>
                    </div>
                    <div class="mb-3">
                        <label for="returnReason" class="form-label">Reason for Return</label>
                        <textarea class="form-control" id="returnReason" name="return_reason" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitReturn">Submit Return</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#returnModal').on('show.bs.modal', function () {
        // Use window.userId set in userMESSAGES.php
        console.log('Modal opened by user:', window.userId);
        
        // Fetch orders for dropdown
        $.ajax({
            url: '../../backend/userFUNCTIONS/fetchProductReturn.php',
            method: 'GET',
            success: function(response) {
                const select = $('#orderSelect');
                select.empty().append('<option value="">Choose order...</option>');
                
                if (response.error) {
                    console.error('Error:', response.error);
                    return;
                }
                
                if (response.orders && response.orders.length > 0) {
                    response.orders.forEach(order => {
                        select.append(`<option value="${order.order_id}">${order.product_name}</option>`);
                    });
                } else {
                    select.append('<option disabled>No delivered orders found</option>');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                $('#orderSelect').empty()
                    .append('<option>Error loading orders</option>');
            }
        });
    });

    $('#submitReturn').click(function() {
        var formData = new FormData($('#returnForm')[0]);
        
        // Confirmation before submit
        Swal.fire({
            title: 'Submit Return Request?',
            text: 'Are you sure you want to submit this return request?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../../backend/userFUNCTIONS/fetchProductReturn.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if(response.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.error,
                                confirmButtonColor: '#3085d6'
                            });
                            return;
                        }
                        if(response.status === 'success') {
                            const product = $('#orderSelect option:selected').text().trim();
                            const reason = $('#returnReason').val().trim();
                            const messageText = `Return Request Details: Product: ${product} | Reason: ${reason}`;

                            const formData = new FormData();
                            formData.append('receiver_id', 2);
                            formData.append('message_text', messageText);
                            formData.append('attachment', $('#returnFile')[0].files[0]);

                            $.ajax({
                                url: '../../backend/userFUNCTIONS/userFetchMessages.php',
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(messageResponse) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: 'Return request submitted successfully, please check order status',
                                        confirmButtonColor: '#3085d6'
                                    }).then(() => {
                                        $('#returnModal').modal('hide');
                                        $('#returnForm')[0].reset();
                                        $('.modal-backdrop').remove();
                                        $('body').removeClass('modal-open');
                                        $('body').css('padding-right', '');
                                    });
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to submit return request: ' + error,
                            confirmButtonColor: '#3085d6'
                        });
                    }
                });
            }
        });
    });
});
</script>