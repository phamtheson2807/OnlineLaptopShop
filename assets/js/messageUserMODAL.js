function openMessageModal(email, orderId, product, quantity, unitPrice, totalPrice, paymentMethod, carrier) {
    
    $('#display_email').text(email);
    $('#display_product').text(product);
    $('#display_quantity').text(quantity);
    $('#display_unitPrice').text(unitPrice);
    $('#display_totalPrice').text(totalPrice);
    $('#display_paymentMethod').text(paymentMethod);
    $('#display_carrier').text(carrier);

    
    // Store order details in hidden inputs
    $('#recipient_email').val(email);
    $('#order_id').val(orderId);
    $('#product').val(product);
    $('#quantity').val(quantity);
    $('#unitPrice').val(unitPrice);
    $('#totalPrice').val(totalPrice);
    $('#paymentMethod').val(paymentMethod);
    $('#carrier').val(carrier);
    
    $('#messageModal').modal('show');
}

$(document).ready(function() {
    $('#sendMessageBtn').click(function() {
        const formData = {
            recipient_email: $('#recipient_email').val(),
            order_id: $('#order_id').val(),
            message_content: $('#message_content').val(),
            product: $('#product').val(),
            quantity: $('#quantity').val(),
            unit_price: $('#unitPrice').val(),
            total_price: $('#totalPrice').val(),
            payment_method: $('#paymentMethod').val(),
            carrier: $('#carrier').val()
        };

        $.ajax({
            type: 'POST',
            url: '../../includes/sendCustomerMESSAGE.php',
            data: formData,
            success: function(response) {
                // Properly cleanup modal
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').css('padding-right', '');
                $('#messageForm')[0].reset();
                alert('Message sent successfully!');
            },
            error: function(xhr, status, error) {
                alert('Error sending message: ' + error);
            }
        });
    });

    // Add event listener for modal hidden
    $('#messageModal').on('hidden.bs.modal', function () {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        $('body').css('padding-right', '');
    });
});