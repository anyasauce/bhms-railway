<?php $__env->startSection('title', 'Rooms'); ?>

<?php $__env->startSection('content'); ?>
    <section id="rooms" class="rooms-section py-5">
        <div class="container">
            <h2 class="section-title text-center mb-5 fw-bold mt-5" data-aos="fade-down">Available Rooms</h2>

            <div class="row mb-4">
                <div class="col-md-6" data-aos="fade-right">
                    <input type="text" class="form-control" placeholder="Search rooms..." id="searchInput">
                </div>
                <div class="col-md-3" data-aos="fade-left">
                    <select class="form-select" id="filterStatus">
                        <option value="">All Statuses</option>
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                    </select>
                </div>
                <div class="col-md-3" data-aos="fade-left">
                    <select class="form-select" id="filterPrice">
                        <option value="">Sort by Price</option>
                        <option value="asc">Low to High</option>
                        <option value="desc">High to Low</option>
                    </select>
                </div>
            </div>

            <div class="row g-4" id="roomsContainer">
                <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 room-card" data-aos="zoom-in" data-aos-delay="200"
                        data-name="<?php echo e(strtolower($room->room_name)); ?>" data-status="<?php echo e(strtolower($room->status)); ?>"
                        data-price="<?php echo e($room->price); ?>">
                        <div class="feature-card h-100 shadow-sm hover-effect">
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <img src="<?php echo e(asset('storage/rooms/' . strtolower(str_replace(' ', '_', $room->room_name)) . '/' . $room->room_image)); ?>"
                                        alt="<?php echo e($room->room_name); ?>" class="img-fluid rounded" style="width: 100%; height: 250px; object-fit: cover;">
                                </div>
                                <h4 class="card-title fw-bold mb-3"><?php echo e($room->room_name); ?></h4>
                                <p class="card-text mb-2"><strong>Slots:</strong> <?php echo e($room->slots); ?></p>
                                <p class="card-text mb-2"><strong>Price:</strong> ₱<?php echo e(number_format($room->price, 2)); ?></p>
                                <p class="card-text mb-3">
                                    <strong>Status:</strong>
                                    <span class="badge <?php echo e($room->status == 'available' ? 'bg-success' : 'bg-danger'); ?>">
                                        <?php echo e(ucfirst($room->status)); ?>

                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

        </div>
    </section>

    <script>
        const searchInput = document.getElementById("searchInput");
        const filterStatus = document.getElementById("filterStatus");
        const filterPrice = document.getElementById("filterPrice");
        const roomsContainer = document.getElementById("roomsContainer");
        let rooms = Array.from(document.querySelectorAll(".room-card"));

        function filterRooms() {
            const searchValue = searchInput.value.toLowerCase();
            const statusValue = filterStatus.value.toLowerCase();

            rooms.forEach(room => {
                const name = room.getAttribute("data-name");
                const status = room.getAttribute("data-status");

                const matchesSearch = name.includes(searchValue);
                const matchesStatus = statusValue === "" || status === statusValue;

                room.style.display = matchesSearch && matchesStatus ? "block" : "none";
            });

            sortRooms();
        }

        function sortRooms() {
            const priceOrder = filterPrice.value;
            if (priceOrder === "") return;

            rooms.sort((a, b) => {
                const priceA = parseFloat(a.getAttribute("data-price"));
                const priceB = parseFloat(b.getAttribute("data-price"));

                return priceOrder === "asc" ? priceA - priceB : priceB - priceA;
            });

            rooms.forEach(room => roomsContainer.appendChild(room));
        }

        searchInput.addEventListener("input", filterRooms);
        filterStatus.addEventListener("change", filterRooms);
        filterPrice.addEventListener("change", sortRooms);
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\boardinghouse\resources\views/main/room.blade.php ENDPATH**/ ?>