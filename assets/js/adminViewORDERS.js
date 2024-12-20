$(document).ready(function() {
    fetchOrders();

    // Add event listener for the Export PDF button
    $('#exportPdfBtn').on('click', function() {
        exportTableToPDF();
    });

    // Select All Checkbox
    $('#selectAll').on('change', function() {
        $('input[type="checkbox"].order-checkbox').prop('checked', this.checked);
        calculateSelectedTotal();
    });

    // Individual checkbox handler
    $(document).on('change', '.order-checkbox', function() {
        calculateSelectedTotal();
    });

    // Add these event listeners after document.ready
    $('#searchInput').on('keyup', filterOrders);
    $('#statusFilter').on('change', filterOrders);

    function fetchOrders() {
        $.ajax({
            url: '../../backend/adminFUNCTIONS/fetchALLORDERS.php',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                let tableBody = '';
                data.forEach(function(order) {
                    tableBody += `
                        <tr>
                            <td><input type="checkbox" class="order-checkbox" data-order-id="${order.order_id}"></td>
                            <td>${order.location}</td>
                            <td>${order.username}</td>
                            <td>${order.product_name}</td>
                            <td>${order.quantity}</td>
                            <td>₱${parseFloat(order.price).toFixed(2)}</td>
                            <td>₱${(parseFloat(order.price) * parseInt(order.quantity)).toFixed(2)}</td>
                            <td>${order.payment_option}</td>
                            <td>
                                <select class="form-select status-select" data-order-id="${order.order_id}">
                                    <option value="Pending" ${order.status === 'Pending' ? 'selected' : ''}>Pending</option>
                                    <option value="Out for Delivery" ${order.status === 'Out for Delivery' ? 'selected' : ''}>Out for Delivery</option>
                                    <option value="Complete" ${order.status === 'Complete' ? 'selected' : ''}>Complete</option>
                                    <option value="For Returned" ${order.status === 'For Returned' ? 'selected' : ''}>For Returned</option>
                                    <option value="Canceled" ${order.status === 'Canceled' ? 'selected' : ''}>Canceled</option>
                                    <option value="Return Complete" ${order.status === 'Return Complete' ? 'selected' : ''}>Return Complete</option>
                                </select>
                            </td>
                            <td>${order.carrier || '-'}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm message-btn"
                                        data-toggle="modal" 
                                        data-target="#messageModal"
                                        data-email="${order.email}"
                                        data-orderid="${order.order_id}">
                                    <i class="fas fa-envelope"></i> Message
                                </button>
                            </td>
                        </tr>
                    `;
                });
                $('#ordersTableBody').html(tableBody);

                // Add change event listener to status dropdowns
                $('.status-select').on('change', function() {
                    const orderId = $(this).data('order-id');
                    const newStatus = $(this).val();
                    updateOrderStatus(orderId, newStatus);
                });

                // Add click event listener to message buttons
                $('.message-btn').on('click', function() {
                    const email = $(this).data('email');
                    const orderId = $(this).data('orderid');
                    const product = $(this).closest('tr').find('td:nth-child(4)').text();
                    const quantity = $(this).closest('tr').find('td:nth-child(5)').text();
                    const unitPrice = $(this).closest('tr').find('td:nth-child(6)').text();
                    const totalPrice = $(this).closest('tr').find('td:nth-child(7)').text();
                    const paymentMethod = $(this).closest('tr').find('td:nth-child(8)').text();
                    const carrier = $(this).closest('tr').find('td:nth-child(10)').text();
                    
                    $('#recipient_email').val(email);
                    $('#order_id').val(orderId);
                    $('#product').val(product);
                    $('#quantity').val(quantity);
                    $('#unitPrice').val(unitPrice);
                    $('#totalPrice').val(totalPrice);
                    $('#paymentMethod').val(paymentMethod);
                    $('#carrier').val(carrier);

                    $('#display_email').text(email);
                    $('#display_product').text(product);
                    $('#display_quantity').text(quantity);
                    $('#display_unitPrice').text(unitPrice);
                    $('#display_totalPrice').text(totalPrice);
                    $('#display_paymentMethod').text(paymentMethod);
                    $('#display_carrier').text(carrier);
                });
                calculateTotalSums(); // Add this line after table is populated
                calculateSelectedTotal(); // Reset selected total when table refreshes
            },
            error: function(xhr, status, error) {
                console.error('Error fetching orders:', error);
                alert('Error loading orders. Please try again.');
            }
        });
    }

    function updateOrderStatus(orderId, newStatus) {
        $.ajax({
            url: '../../backend/adminFUNCTIONS/updateOrderSTATUS.php',
            type: 'POST',
            data: {
                order_id: orderId,
                status: newStatus
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert('Order status updated successfully!');
                    fetchOrders(); // Refresh table
                } else {
                    alert('Failed to update status: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error updating status:', error);
                alert('Error updating order status. Please try again.');
            }
        });
    }

    function exportTableToPDF() {
        const selectedRows = Array.from(document.querySelectorAll('.order-checkbox:checked')).map(checkbox => {
            return checkbox.closest('tr');
        });

        const data = selectedRows.map(row => {
            const cells = Array.from(row.querySelectorAll('td'));
            const statusSelect = cells[8].querySelector('select');
            return [
                cells[1].textContent.trim(),  // Location
                cells[2].textContent.trim(),  // Customer
                cells[4].textContent.trim(),  // Quantity
                cells[5].textContent.trim(),  // Price
                cells[6].textContent.trim(),  // Total Price
                cells[7].textContent.trim(),  // Mode of Transaction
                statusSelect.options[statusSelect.selectedIndex].text  // Current Status
            ];
        });

        $.ajax({
            url: '../../backend/adminFUNCTIONS/exportPDF.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ data: data }),
            success: function(response) {
                const link = document.createElement('a');
                link.href = 'data:application/pdf;base64,' + response;
                link.download = 'orders.pdf';
                link.click();
            }
        });
    }

    function calculateTotalSums() {
        let totalSum = 0;
        let completedSum = 0;
        
        $('#ordersTableBody tr').each(function() {
            const amount = parseFloat($(this).find('td:nth-child(7)').text().replace('₱', '').replace(/,/g, ''));
            const status = $(this).find('td:nth-child(9) select').val();
            
            if (!isNaN(amount)) {
                totalSum += amount;
                
                // Add to completedSum if status is "Complete"
                if (status === 'Complete') {
                    completedSum += amount;
                }
            }
        });

        // Update both total sums
        $('#totalSum').text(totalSum.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
        
        $('#totalSumCompleted').text(completedSum.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
    }

    function calculateSelectedTotal() {
        let selectedTotal = 0;
        
        $('.order-checkbox:checked').each(function() {
            const row = $(this).closest('tr');
            const amount = parseFloat(row.find('td:nth-child(7)').text()
                                      .replace('₱', '')
                                      .replace(/,/g, ''));
            
            if (!isNaN(amount)) {
                selectedTotal += amount;
            }
        });

        $('#SelectedItemTotal').text(selectedTotal.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }));
    }

    function filterOrders() {
        const searchTerm = $('#searchInput').val().toLowerCase();
        const statusFilter = $('#statusFilter').val();

        $('#ordersTableBody tr').each(function() {
            const $row = $(this);
            const rowData = $row.text().toLowerCase();
            const status = $row.find('.status-select').val();
            
            const matchesSearch = searchTerm === '' || rowData.includes(searchTerm);
            const matchesStatus = statusFilter === '' || status === statusFilter;

            if (matchesSearch && matchesStatus) {
                $row.show();
            } else {
                $row.hide();
            }
        });
        
        calculateTotalSums();
        calculateSelectedTotal();
    }

    // Refresh data every 30 seconds
    setInterval(fetchOrders, 30000);
});