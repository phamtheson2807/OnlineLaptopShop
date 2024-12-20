document.addEventListener('DOMContentLoaded', function() {
    const paymentOption = document.getElementById('paymentOption');
    const carrierGroup = document.getElementById('carrier-group');
    const qtyInput = document.getElementById('qty');
    const totalAmountSpan = document.getElementById('totalAmount');
    const totalAmountInput = document.getElementById('totalAmountInput');

    // Show qty input
    document.getElementById('qtyGroup').style.display = 'block';

    paymentOption.addEventListener('change', function() {
        if (this.value === 'Cash on Delivery' || this.value === 'Cash on Pickup') {
            carrierGroup.style.display = 'block';
        } else {
            carrierGroup.style.display = 'none';
        }
    });

    // Update total when quantity changes
    qtyInput.addEventListener('input', function() {
        const priceElement = document.getElementById('productPrice');
        const basePrice = parseFloat(priceElement.textContent.replace('₱', '').replace(',', ''));
        const quantity = parseInt(this.value) || 0;
        const total = basePrice * quantity;
        
        totalAmountSpan.textContent = '₱' + total.toFixed(2);
        totalAmountInput.value = total.toFixed(2);
    });

    // Set initial quantity to 1 and trigger calculation
    qtyInput.value = 1;
    qtyInput.dispatchEvent(new Event('input'));
});

function showPaymentModal(productId, productName, productPrice) {
    console.log('Modal opened with:', { productId, productName, productPrice });
    
    const laptopDetails = document.getElementById('laptop-details');
    laptopDetails.innerHTML = `
        <p><strong>Product:</strong> ${productName}</p>
        <p><strong>Price:</strong> ₱<span id="productPrice">${productPrice.toFixed(2)}</span></p>
    `;
    
    // Reset and recalculate total
    const qtyInput = document.getElementById('qty');
    qtyInput.value = 1;
    qtyInput.dispatchEvent(new Event('input'));

    const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
    paymentModal.show();

    document.getElementById('proceedPayment').onclick = function() {
        console.log('Proceed button clicked with productId:', productId);
        proceedToPayment(productId, productName, productPrice);
    };
}

function proceedToPayment(productId, productName, productPrice) {
    console.log('Starting payment process with:', {
        productId: productId,
        productName: productName,
        basePrice: productPrice,
        quantity: document.getElementById('qty').value,
        paymentOption: document.getElementById('paymentOption').value,
        carrier: document.getElementById('carrier').value
    });

    const qty = document.getElementById('qty').value;
    const paymentOption = document.getElementById('paymentOption').value;
    const carrier = document.getElementById('carrier').value;
    const totalAmount = parseFloat(productPrice) * parseInt(qty);

    const products = JSON.stringify([{ productId, productName, productPrice, qty }]);

    console.log('Calculated total amount:', totalAmount);

    // Redirect to PayPal payment page with total amount and other details
    window.location.href = `../../views/user/paypalPAYMENT.php?totalAmount=${totalAmount.toFixed(2)}&products=${encodeURIComponent(products)}&paymentOption=${paymentOption}&carrier=${carrier}`;
}