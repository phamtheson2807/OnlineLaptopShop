<!-- messageUserModal.php -->
<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel">Send Message to Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="messageForm">
                    <input type="hidden" id="recipient_email" name="recipient_email">
                    <input type="hidden" id="order_id" name="order_id">
                    <input type="hidden" id="product" name="product">
                    <input type="hidden" id="quantity" name="quantity">
                    <input type="hidden" id="unitPrice" name="unitPrice">
                    <input type="hidden" id="totalPrice" name="totalPrice">
                    <input type="hidden" id="paymentMethod" name="paymentMethod">
                    <input type="hidden" id="carrier" name="carrier">
                    <div class="mb-3">
                        <label class="form-label">Sending to: <span id="display_email" class="text-primary"></span></label>
                    </div>
                    <div class="mb-3 border p-3 bg-light">
                        <h6 class="border-bottom pb-2">Order Details:</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Product:</strong><span id="display_product"></span></p>
                                <p><strong>Quantity:</strong><span id="display_quantity"></span></p>
                                <p><strong>Unit Price:</strong><span id="display_unitPrice"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Total Price:</strong><span id="display_totalPrice"></span></p>
                                <p><strong>Payment Method:</strong> <span id="display_paymentMethod"></span></p>
                                <p><strong>Carrier:</strong> <span id="display_carrier"></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="message_content" class="form-label">Message</label>
                        <textarea class="form-control" id="message_content" name="message_content" rows="4" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="sendMessageBtn">Send Message</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../assets/js/messageUserMODAL.js"></script>