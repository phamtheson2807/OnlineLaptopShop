document.addEventListener('DOMContentLoaded', function() {
    fetchCartItems();

    const paymentOption = document.getElementById('paymentOption');
    const carrierGroup = document.getElementById('carrier-group');
    const carrier = document.getElementById('carrier');
    const cartTotal = document.getElementById('cart-total');
    const totalAmount = document.getElementById('totalAmount');

    paymentOption.addEventListener('change', function() {
        if (this.value === 'Meet Up') {
            carrierGroup.style.display = 'none';
            carrier.value = '--';
        } else {
            carrierGroup.style.display = 'block';
        }
    });

    // Trigger change event on page load to set initial state
    paymentOption.dispatchEvent(new Event('change'));

    // Update total amount in payment modal when cart total changes
    document.getElementById('checkout-btn').addEventListener('click', function() {
        totalAmount.textContent = cartTotal.textContent;
        $('#paymentModal').modal('show');
    });
});

function fetchCartItems() {
    fetch('../../backend/userFUNCTIONS/Cart/fetchCART.php')
        .then(response => response.json())
        .then(data => {
            const cartContainer = document.getElementById('cart-items');
            let total = 0;

            if (data.length === 0) {
                cartContainer.innerHTML = '<p class="text-center">Your cart is empty</p>';
                return;
            }

            let html = '<div class="list-group cart-list">';
            data.forEach(item => {
                const itemTotal = item.price * item.quantity;
                html += `
                    <div class="list-group-item cart-item">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-6 item-info-container">
                                <div class="row align-items-center">
                                    <div class="col-2 col-md-2 checkbox-container">
                                        <input type="checkbox" class="item-checkbox" data-item-id="${item.product_id}" data-item-total="${itemTotal}" onchange="updateTotal()">
                                    </div>
                                    <div class="col-4 col-md-4 image-container">
                                        <img src="../../uploads/${item.image_url}" class="img-fluid" alt="${item.name}">
                                    </div>
                                    <div class="col-6 col-md-6 details-container">
                                        <h5>${item.name}</h5>
                                        <p class="text-muted">₱${item.price}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 item-action-container d-flex justify-content-end align-items-center">
                                <div class="total-container">
                                    <p class="mb-0">₱${itemTotal.toFixed(2)}</p>
                                </div>
                                <div class="quantity-container">
                                    <div class="input-group quantity-control">
                                        <button class="btn btn-outline-secondary" onclick="updateQuantity(${item.product_id}, -1)">-</button>
                                        <input type="number" class="form-control text-center" value="${item.quantity}" readonly>
                                        <button class="btn btn-outline-secondary" onclick="updateQuantity(${item.product_id}, 1)">+</button>
                                    </div>
                                </div>
                                <div class="remove-container">
                                    <button class="btn btn-danger btn-sm" onclick="removeItem(${item.product_id})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            cartContainer.innerHTML = html;

            // Restore checkbox states
            restoreCheckboxStates();
            updateTotal();
        })
        .catch(error => console.error('Error fetching cart:', error));
}

function updateTotal() {
    let total = 0;
    document.querySelectorAll('.item-checkbox:checked').forEach(checkbox => {
        total += parseFloat(checkbox.getAttribute('data-item-total'));
    });
    document.getElementById('cart-total').textContent = total.toFixed(2);
}

function updateQuantity(productId, change) {
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('change', change);

    fetch('../../backend/userFUNCTIONS/Cart/updateCART.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            fetchCartItems();
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Error updating quantity:', error));
}

function removeItem(productId) {
    if (confirm('Are you sure you want to remove this item?')) {
        const formData = new FormData();
        formData.append('product_id', productId);

        fetch('../../backend/userFUNCTIONS/Cart/removeFromCART.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                fetchCartItems();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error removing item:', error));
    }
}

// Store checkbox states in local storage
function storeCheckboxStates() {
    const checkboxStates = {};
    document.querySelectorAll('.item-checkbox').forEach(checkbox => {
        checkboxStates[checkbox.getAttribute('data-item-id')] = checkbox.checked;
    });
    localStorage.setItem('checkboxStates', JSON.stringify(checkboxStates));
}

// Restore checkbox states from local storage
function restoreCheckboxStates() {
    const checkboxStates = JSON.parse(localStorage.getItem('checkboxStates')) || {};
    document.querySelectorAll('.item-checkbox').forEach(checkbox => {
        const itemId = checkbox.getAttribute('data-item-id');
        if (checkboxStates[itemId]) {
            checkbox.checked = true;
        }
    });
}

// Update total and store checkbox states on checkbox change
document.addEventListener('change', function(event) {
    if (event.target.classList.contains('item-checkbox')) {
        updateTotal();
        storeCheckboxStates();
    }
});

document.getElementById('checkout-btn').addEventListener('click', function() {
    const modal = new bootstrap.Modal(document.getElementById('cartPaymentModal'));
    modal.show();
});

// Handle payment option change
document.getElementById('paymentOption').addEventListener('change', function() {
    const carrierGroup = document.getElementById('carrier-group');
    if (this.value === 'Cash on Delivery' || this.value === 'Cash on Pickup') {
        carrierGroup.style.display = 'block';
    } else {
        carrierGroup.style.display = 'none';
    }
});

// Update the proceedCartPayment click handler in userCartVIEW.js
document.getElementById('proceedCartPayment').addEventListener('click', function() {
    const checkedItems = document.querySelectorAll('.item-checkbox:checked');
    
    if (checkedItems.length === 0) {
        alert('Please select items to checkout');
        return;
    }

    const paymentOption = document.getElementById('paymentOption').value;
    const carrier = document.getElementById('carrier').value;
    const totalAmount = parseFloat(document.getElementById('cart-total').textContent);

    // Collect all selected products
    const selectedProducts = [];
    checkedItems.forEach(item => {
        const productId = item.getAttribute('data-item-id');
        const quantityInput = item.closest('.cart-item').querySelector('.quantity-control input');
        const qty = parseInt(quantityInput.value);
        selectedProducts.push({
            productId,
            qty
        });
    });

    // Encode the products array for URL parameters
    const productsParam = encodeURIComponent(JSON.stringify(selectedProducts));

    // Redirect with all products info
    window.location.href = `paypalPAYMENT.php?totalAmount=${totalAmount.toFixed(2)}&products=${productsParam}&paymentOption=${paymentOption}&carrier=${carrier}`;
});