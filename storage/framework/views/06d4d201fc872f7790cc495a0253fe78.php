<?php $__env->startSection('title', 'Manage Rooms'); ?>

<?php $__env->startSection('content'); ?>

    <div class="container mt-4">

        <button type="button" class="btn btn-primary mb-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addRoomModal">
            Add Room
        </button>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="card-title text-white">List of Rooms</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="room" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Room Name</th>
                                <th>Slots</th>
                                <th>Status</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($room->id); ?></td>
                                    <td><?php echo e($room->room_name); ?></td>
                                    <td><?php echo e($room->slots); ?></td>
                                    <td>
                                        <span class="badge <?php echo e($room->status == 'available' ? 'bg-success' : 'bg-danger'); ?>">
                                            <?php echo e(ucfirst($room->status)); ?>

                                        </span>
                                    </td>
                                    <td>₱<?php echo e($room->price); ?></td>
                                    <td style="white-space: nowrap;">
                                        <button class="btn btn-info btn-sm text-white" data-bs-toggle="modal"
                                            data-bs-target="#viewBoardersModal<?php echo e($room->id); ?>">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editRoomModal<?php echo e($room->id); ?>">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteRoomModal<?php echo e($room->id); ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>

                                <div class="modal fade" id="viewBoardersModal<?php echo e($room->id); ?>" tabindex="-1" aria-labelledby="viewBoardersModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">View Boarders for Room: <?php echo e($room->room_name); ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <?php $__empty_1 = true; $__currentLoopData = $room->boarders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $boarder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <div class="col-md-6 mb-3">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <h5 class="card-title"><?php echo e($boarder->name); ?></h5>
                                                                    <p class="card-text">Email: <?php echo e($boarder->email); ?></p>
                                                                    <p class="card-text">Phone: <?php echo e($boarder->phone_number); ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <div class="col-12">
                                                            <p class="text-center">No boarders available for this room.</p>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Edit Room Modal -->
                                <div class="modal fade" id="editRoomModal<?php echo e($room->id); ?>" tabindex="-1"
                                    aria-labelledby="editRoomModalLabel<?php echo e($room->id); ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Room</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="<?php echo e(route('rooms.update', $room->id)); ?>" method="POST" enctype="multipart/form-data">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PUT'); ?>

                                                    <div class="col-md-12 mb-3">
                                                        <label for="room_name<?php echo e($room->id); ?>" class="form-label fw-bold">Room Name</label>
                                                        <input type="text" class="form-control" name="room_name" value="<?php echo e($room->room_name); ?>" required>
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <label for="slots<?php echo e($room->id); ?>" class="form-label fw-bold">Room Slots</label>
                                                        <input type="number" class="form-control" name="slots" value="<?php echo e($room->slots); ?>" required>
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <label for="price<?php echo e($room->id); ?>" class="form-label fw-bold">Room Price</label>
                                                        <input type="number" class="form-control" name="price" value="<?php echo e($room->price); ?>" required>
                                                    </div>

                                                    <!-- Current Room Image Preview -->
                                                    <div class="col-md-12 mb-3 text-center">
                                                        <label class="form-label fw-bold">Current Room Image</label>
                                                        <br>
                                                        <img src="<?php echo e(asset('storage/' . $room->room_image)); ?>"
                                                            alt="<?php echo e($room->room_name); ?>"
                                                            class="img-fluid rounded"
                                                            style="max-width: 150px;">
                                                    </div>

                                                    <!-- Upload New Room Image -->
                                                    <div class="col-md-12 mb-3">
                                                        <label for="room_image<?php echo e($room->id); ?>" class="form-label fw-bold">Update Room Image</label>
                                                        <input type="file" class="form-control" name="room_image" id="room_image<?php echo e($room->id); ?>" accept="image/*">
                                                    </div>

                                                    <button type="submit" class="btn btn-primary">Update Room</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="deleteRoomModal<?php echo e($room->id); ?>" tabindex="-1"
                                    aria-labelledby="deleteRoomModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete Room</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete the room <strong><?php echo e($room->room_name); ?></strong>?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="<?php echo e(route('rooms.destroy', $room->id)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Room Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('rooms.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="col-md-12 mb-3">
                            <input type="text" class="form-control" name="room_name" placeholder="Room Name" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <input type="number" class="form-control" name="slots" placeholder="Number of Slots" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <input type="number" class="form-control" name="price" placeholder="Price" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="room_image" class="form-label">Room Image</label>
                            <input type="file" class="form-control" name="room_image" id="room_image" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Room</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <script>
            $(document).ready(function () {
                $('#room').DataTable();
            });
        </script>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.niceadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\boardinghouse\resources\views\rooms\index.blade.php ENDPATH**/ ?>