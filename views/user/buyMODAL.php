<link rel="stylesheet" href="../../assets/css/bootstrap.css">
<link rel="stylesheet" href="../../assets/css/userVIEW.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Proceed to Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="laptop-details"></div>
                <div class="form-group mt-3" id="qtyGroup" style="display: none;">
                    <label for="qty"><i class=""></i>Qty</label>
                    <input type="number" id="qty" name="qty" class="form-control" min="1" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))">
                </div>
                <div class="form-group mt-3">
                    <label for="paymentOption">Payment Option</label>
                    <select class="form-control" id="paymentOption">
                        <option value="Meet Up">Meet Up</option>
                        <option value="Cash on Delivery">Cash on Delivery</option>
                        <option value="Cash on Pickup">Cash on Pickup</option>
                    </select>
                </div>
                <div class="form-group mt-3" id="carrier-group" style="display: none;">
                    <label for="carrier"><i class=""></i>Carrier</label>
                    <select class="form-control" id="carrier">
                        <option value="--">--</option>
                        <option value="LBC">LBC</option>
                        <option value="Lalamove">Lalamove</option>
                        <option value="J and T">J&T</option>
                        <option value="Ninja Express">Ninja Express</option>
                        <option value="Food Panda">Food Panda</option>
                        <option value="Private Driver">Private Driver</option>
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label for="totalAmount">Total Amount: <span id="totalAmount">₱0.00</span></label>
                    <input type="hidden" id="totalAmountInput" name="totalAmount" value="0.00">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="proceedPayment">Proceed to Payment</button>
                </div>
            </div>
            
        </div>
    </div>
</div>
<script src="../../assets/js/jquery.js"></script>
<script src="../../assets/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/your-code.js"></script>
<script src="../../assets/js/userSidebar.js"></script>
<script src="../../assets/js/buyModal.js"></script>