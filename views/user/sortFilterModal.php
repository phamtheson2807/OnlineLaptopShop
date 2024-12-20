<!-- FILE: sortFilterModal.php -->
<div class="modal fade" id="sortFilterModal" tabindex="-1" aria-labelledby="sortFilterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sortFilterModalLabel">Sort and Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Sort Options -->
                <h6 class="mb-3">Sort Options</h6>
                <div class="form-group">
                    <label for="priceFilterModal">Sort by Price</label>
                    <select id="priceFilterModal" class="form-control">
                        <option value="">All Prices</option>
                        <option value="low-to-high">Price: Low to High</option>
                        <option value="high-to-low">Price: High to Low</option>
                    </select>
                </div>

                <!-- Filter Options -->
                <h6 class="mt-4 mb-3">Filter Options</h6>
                
                <!-- Brand Filter -->
                <div class="form-group">
                    <label for="brandFilter">Laptop Brand</label>
                    <select id="brandFilter" class="form-control">
                        <option value="">All Brands</option>
                        <option value="Lenovo">Lenovo</option>
                        <option value="Asus">Asus</option>
                        <option value="Acer">Acer</option>
                        <option value="HP">HP</option>
                        <option value="Dell">Dell</option>
                        <option value="MSI">MSI</option>
                    </select>
                </div>

                <!-- CPU Filter -->
                <div class="form-group">
                    <label for="cpuFilter">Processor Type</label>
                    <select id="cpuFilter" class="form-control">
                        <option value="">All Processors</option>
                        <option value="i3">Intel Core i3</option>
                        <option value="i5">Intel Core i5</option>
                        <option value="i7">Intel Core i7</option>
                        <option value="Intel i9">Intel Core i9</option>
                        <option value="Ryzen 3">AMD Ryzen 3</option>
                        <option value="Ryzen 5">AMD Ryzen 5</option>
                        <option value="Ryzen 7">AMD Ryzen 7</option>
                        <option value="Ryzen 9">AMD Ryzen 9</option>
                        <option value="M1">Apple M1</option>
                        <option value="M2">Apple M2</option>
                        <option value="Elite">Snapdragon Elite</option>
                    </select>
                </div>

                <!-- GPU Filter -->
                <div class="form-group">
                    <label for="gpuFilter">Graphics Card</label>
                    <select id="gpuFilter" class="form-control">
                        <option value="">All Graphics Cards</option>
                        <option value="RTX">NVIDIA RTX Series</option>
                        <option value="GTX">NVIDIA GTX Series</option>
                        <option value="Intel Iris">Intel Iris/UHD Graphics</option>
                        <option value="AMD">AMD Radeon Graphics</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="clearFiltersBtn" data-dismiss="modal">Clear All</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>