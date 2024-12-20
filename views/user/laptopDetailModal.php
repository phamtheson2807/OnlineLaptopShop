<style>
    /* Modal styles with higher specificity */
    #laptopDetailModal.modal .modal-dialog {
        max-width: 600px !important; /* Force override */
        width: 95% !important;
        margin: 1.75rem auto;
    }

    #laptopDetailModal.modal .modal-content {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
    }

    #laptopDetailModal.modal .modal-body {
        padding: 1.5rem;
        max-height: 450px;
        overflow-y: auto;
    }

    #laptopDetailModal.modal .specs-container {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin-top: 1rem;
    }

    #laptopDetailModal.modal #modalLaptopImage {
        max-height: 200px;
        object-fit: contain;
        display: block;
        margin: 0 auto;
    }

    /* Mobile responsive styles */
    @media (max-width: 768px) {
        #laptopDetailModal.modal .modal-dialog {
            max-width: 95% !important;
            margin: 0.5rem auto;
        }
    }

    .specs-container {
        font-size: 0.9rem; /* Reduce text size */
        padding: 0.75rem; /* Reduce padding */
    }

    .specs-container p {
        margin-bottom: 0.5rem; /* Reduce space between specs */
    }

    .modal-footer {
        padding: 0.75rem; /* Reduce footer padding */
    }
</style>

<div class="modal fade" id="laptopDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLaptopName"></h5>
                <button type="button" class="btn-close" data-dismiss="modal">x</button>
            </div>
            <div class="modal-body">
                <img id="modalLaptopImage" src="" alt="" class="img-fluid mb-3">
                <p id="modalLaptopDescription" class="mb-3"></p>
                <div class="specs-container">
                    <p><strong>CPU:</strong> <span id="modalLaptopCPU"></span></p>
                    <p><strong>GPU:</strong> <span id="modalLaptopGPU"></span></p>
                    <p><strong>Price:</strong> ₱<span id="modalLaptopPrice"></span></p>
                    <p><strong>Stock:</strong> <span id="modalLaptopStock"></span></p>
                </div>
            </div>
        </div>
    </div>
</div>