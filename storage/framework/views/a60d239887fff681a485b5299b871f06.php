<?php $__env->startSection('title', 'Manage Boarders'); ?>
<?php $__env->startSection('content'); ?>

<div class="container mt-4">

    <button type="button" class="btn btn-primary mb-3 fw-bold" data-bs-toggle="modal" data-bs-target="#addBoarderModal">
        Add Boarder
    </button>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="card-title text-white">List of Boarders</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="boarders" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Boarder Name</th>
                            <th>Room Name</th>
                            <th>Phone Number</th>
                            <th>Guardian Name</th>
                            <th>Balance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $boarders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $boarder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($boarder->$index + 1); ?></td>
                                <td><?php echo e($boarder->first_name . " " . $boarder->last_name); ?></td>
                                <td><?php echo e($boarder->room ? $boarder->room->room_name : 'No Room Assigned'); ?></td>
                                <td><?php echo e($boarder->phone_number); ?></td>
                                <td><?php echo e($boarder->guardian_name); ?></td>
                                <td>₱<?php echo e($boarder->balance); ?></td>
                                <td style="white-space: nowrap;">
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editBoarderModal<?php echo e($boarder->id); ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#paymentModal<?php echo e($boarder->id); ?>">
                                        <i class="bi bi-cash-coin"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#deleteBoarderModal<?php echo e($boarder->id); ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#referralsModal<?php echo e($boarder->id); ?>">
                                        <i class="bi bi-people-fill text-white"></i>
                                    </button>
                                </td>

                            </tr>

                            <!-- Referrals & Points Modal -->
                            <div class="modal fade" id="referralsModal<?php echo e($boarder->id); ?>" tabindex="-1" aria-labelledby="referralsModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title"><i class="bi bi-people"></i> Referred People & Points</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h6 class="text-muted">
                                                Total Referrals:
                                                <span class="badge bg-primary"><?php echo e($boarder->totalReferrals); ?></span>
                                            </h6>

                                            <h6 class="text-muted">
                                                Total Points Earned:
                                                <span class="badge bg-warning"><?php echo e($boarder->totalPoints); ?></span>
                                            </h6>

                                            <hr>

                                            <h5 class="mt-3">People You Referred:</h5>
                                            <?php if($boarder->referredPeople->isEmpty()): ?>
                                                <p class="text-muted">No referrals yet. Start referring friends to earn rewards!</p>
                                            <?php else: ?>
                                                <ul class="list-group">
                                                    <?php $__currentLoopData = $boarder->referredPeople; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $referral): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <strong>
                                                                <?php echo e($referral->application->first_name ?? 'Unknown'); ?>

                                                                <?php echo e($referral->application->last_name ?? ''); ?>

                                                            </strong>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            <?php endif; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="editBoarderModal<?php echo e($boarder->id); ?>" tabindex="-1" aria-labelledby="editBoarderModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Boarder</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="<?php echo e(route('boarders.update', $boarder->id)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('PUT'); ?>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="name_<?php echo e($boarder->id); ?>" class="form-label fw-bold">First Name</label>
                                                        <input type="text" id="name_<?php echo e($boarder->id); ?>" class="form-control" name="first_name"
                                                            value="<?php echo e($boarder->first_name); ?>" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="name_<?php echo e($boarder->id); ?>" class="form-label fw-bold">Last Name</label>
                                                        <input type="text" id="name_<?php echo e($boarder->id); ?>" class="form-control" name="last_name"
                                                            value="<?php echo e($boarder->last_name); ?>" required>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="phone_<?php echo e($boarder->id); ?>" class="form-label fw-bold">Phone
                                                            Number</label>
                                                        <input type="text" id="phone_<?php echo e($boarder->id); ?>" class="form-control" name="phone_number"
                                                            value="<?php echo e($boarder->phone_number); ?>" required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="email_<?php echo e($boarder->id); ?>" class="form-label fw-bold">Email</label>
                                                        <input type="email" id="email_<?php echo e($boarder->id); ?>" class="form-control" name="email"
                                                            value="<?php echo e($boarder->email); ?>" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="guardian_name_<?php echo e($boarder->id); ?>" class="form-label fw-bold">Guardian
                                                            Name</label>
                                                        <input type="text" id="guardian_name_<?php echo e($boarder->id); ?>" class="form-control"
                                                            name="guardian_name" value="<?php echo e($boarder->guardian_name); ?>" required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="guardian_phone_<?php echo e($boarder->id); ?>" class="form-label fw-bold">Guardian
                                                            Phone
                                                            Number</label>
                                                        <input type="text" id="guardian_phone_<?php echo e($boarder->id); ?>" class="form-control"
                                                            name="guardian_phone_number" value="<?php echo e($boarder->guardian_phone_number); ?>" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="address_<?php echo e($boarder->id); ?>" class="form-label fw-bold">Address</label>
                                                        <input type="text" id="address_<?php echo e($boarder->id); ?>" class="form-control" name="address"
                                                            value="<?php echo e($boarder->address); ?>" required>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="room_id_<?php echo e($boarder->id); ?>" class="form-label fw-bold">Room</label>
                                                    <select class="form-control" id="room_id_<?php echo e($boarder->id); ?>" name="room_id" required>
                                                        <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($room->id); ?>" <?php echo e($room->id == $boarder->room_id ? 'selected' : ''); ?>>
                                                                <?php echo e($room->room_name); ?> - <?php echo e($room->slots); ?> slots
                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>

                                                <!-- Document Viewer Section -->
                                                <div class="mt-4">
                                                    <h6 class="fw-bold">Uploaded Documents</h6>
                                                    <div class="row">

                                                        <!-- PSA Birth Certificate Card -->
                                                        <div class="col-md-6 mb-3">
                                                            <div class="card">
                                                                <div class="card-body p-3">
                                                                    <label class="form-label fw-bold">Boarder's PSA Birth Certificate</label><br>
                                                                    <?php if($boarder->documents && $boarder->documents->psa_birth_cert): ?>
                                                                        <a href="<?php echo e(asset('storage/documents/' . $boarder->last_name . "/" . $boarder->documents->psa_birth_cert)); ?>" target="_blank" class="btn btn-link">
                                                                            View Boarder’s PSA Birth Certificate (PDF/JPG/PNG)
                                                                        </a>
                                                                        <img src="<?php echo e(asset('storage/documents/' . $boarder->last_name . "/" . $boarder->documents->psa_birth_cert)); ?>" width="330" height="400" alt="">
                                                                    <?php else: ?>
                                                                        <span>No document uploaded</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Boarder's Valid ID Card -->
                                                        <div class="col-md-6 mb-3">
                                                            <div class="card">
                                                                <div class="card-body p-3">
                                                                    <label class="form-label fw-bold">Boarder’s Valid ID</label><br>
                                                                    <?php if($boarder->documents && $boarder->documents->boarder_valid_id): ?>
                                                                        <a href="<?php echo e(asset('storage/documents/' . $boarder->last_name . "/" . $boarder->documents->boarder_valid_id)); ?>" target="_blank" class="btn btn-link">
                                                                            View Boarder’s Valid ID (PDF/JPG/PNG)
                                                                        </a>
                                                                        <img src="<?php echo e(asset('storage/documents/' . $boarder->last_name . "/" . $boarder->documents->boarder_valid_id)); ?>" width="330" height="400" alt="">
                                                                    <?php else: ?>
                                                                        <span>No document uploaded</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Boarder's Selfie Card -->
                                                        <div class="col-md-6 mb-3">
                                                            <div class="card">
                                                                <div class="card-body p-3">
                                                                    <label class="form-label fw-bold">Boarder’s Selfie for Valid ID</label><br>
                                                                    <?php if($boarder->documents && $boarder->documents->boarder_selfie): ?>
                                                                        <a href="<?php echo e(asset('storage/documents/' . $boarder->last_name . "/" . $boarder->documents->boarder_selfie)); ?>" target="_blank" class="btn btn-link">
                                                                            View Boarder’s Selfie for Valid ID (PDF/JPG/PNG)
                                                                        </a>
                                                                        <img src="<?php echo e(asset('storage/documents/' . $boarder->last_name . "/" . $boarder->documents->boarder_selfie)); ?>" width="330" height="400" alt="">
                                                                    <?php else: ?>
                                                                        <span>No document uploaded</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Guardian's Valid ID Card -->
                                                        <div class="col-md-6 mb-3">
                                                            <div class="card">
                                                                <div class="card-body p-3">
                                                                    <label class="form-label fw-bold">Guardian’s Valid ID</label><br>
                                                                    <?php if($boarder->documents && $boarder->documents->guardian_valid_id): ?>
                                                                        <a href="<?php echo e(asset('storage/documents/' . $boarder->last_name . "/" . $boarder->documents->guardian_valid_id)); ?>" target="_blank" class="btn btn-link">
                                                                            View Guardian’s Valid ID (PDF/JPG/PNG)
                                                                        </a>
                                                                        <img src="<?php echo e(asset('storage/documents/' . $boarder->last_name . "/" . $boarder->documents->guardian_valid_id)); ?>" width="330" height="400" alt="">
                                                                    <?php else: ?>
                                                                        <span>No document uploaded</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Guardian's Selfie Card -->
                                                        <div class="col-md-6 mb-3">
                                                            <div class="card">
                                                                <div class="card-body p-3">
                                                                    <label class="form-label fw-bold">Guardian’s Selfie for Valid ID</label><br>
                                                                    <?php if($boarder->documents && $boarder->documents->guardian_selfie): ?>
                                                                        <a href="<?php echo e(asset('storage/documents/' . $boarder->last_name . "/" . $boarder->documents->guardian_selfie)); ?>" target="_blank" class="btn btn-link">
                                                                            View Guardian’s Selfie for Valid ID (PDF/JPG/PNG)
                                                                        </a>
                                                                        <img src="<?php echo e(asset('storage/documents/' . $boarder->last_name . "/" . $boarder->documents->guardian_selfie)); ?>" width="330" height="400" alt="">
                                                                    <?php else: ?>
                                                                        <span>No document uploaded</span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>


                                                <button type="submit" class="btn btn-primary fw-bold">Update Boarder</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteBoarderModal<?php echo e($boarder->id); ?>" tabindex="-1"
                                aria-labelledby="deleteBoarderModalLabel<?php echo e($boarder->id); ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteBoarderModalLabel<?php echo e($boarder->id); ?>">Delete Boarder</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you sure you want to delete the boarder <strong><?php echo e($boarder->name); ?></strong>?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                                            <form action="<?php echo e(route('boarders.destroy', $boarder->id)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
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

<div class="modal fade" id="addBoarderModal" tabindex="-1" aria-labelledby="addBoarderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBoarderModalLabel">Add New Boarder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('boarders.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">+63</div>
                                <input type="text" class="form-control" id="phone_number" name="phone_number"
                                    placeholder="Phone Number" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">@</div>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                                <input type="text" class="form-control" id="guardian_name" name="guardian_name" placeholder="Guardian Name"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">+63</div>
                                <input type="text" class="form-control" id="guardian_phone_number"
                                    name="guardian_phone_number" placeholder="Guardian Phone Number" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-house-fill"></i></div>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Address" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3">
                            <label for="room_id" class="form-label">Room</label>
                            <select class="form-control" id="room_id" name="room_id" required>
                                <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($room->id); ?>">
                                        <?php echo e($room->room_name); ?> - <?php echo e($room->slots); ?> slots
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary fw-bold">Save Boarder</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<?php $__currentLoopData = $boarders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $boarder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="paymentModal<?php echo e($boarder->id); ?>" tabindex="-1"
        aria-labelledby="paymentModalLabel<?php echo e($boarder->id); ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel<?php echo e($boarder->id); ?>">Make Payment for <?php echo e($boarder->first_name); ?> <?php echo e($boarder->last_name); ?>

                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('payments.store')); ?>" method="POST">
                        <input type="hidden" name="boarder_id" value="<?php echo e($boarder->boarder_id); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        value="<?php echo e($boarder->first_name); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        value="<?php echo e($boarder->last_name); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">#</div>
                                    <input type="text" class="form-control" id="room_id" name="room_id"
                                        value="<?php echo e($boarder->room_id); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text"><i class="bi bi-house-door-fill"></i></div>
                                    <input type="text" class="form-control" id="room_name" name="room_name"
                                        value="<?php echo e($boarder->room ? $boarder->room->room_name : 'No Room Assigned'); ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text">₱</div>
                                    <input type="text" class="form-control" id="amount" name="amount"
                                        value="<?php echo e($boarder->room ? $boarder->room->price : 0); ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="input-group">
                                    <div class="input-group-text"><i class="bi bi-pencil"></i></div>
                                    <textarea class="form-control" id="description" name="description"
                                        placeholder="Description" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="payment_due_date" class="mb-1">Payment Due Date</label>
                                <div class="input-group">
                                    <div class="input-group-text"><i class="bi bi-calendar"></i></div>
                                    <input type="date" class="form-control" id="payment_due_date" name="payment_due_date"
                                        required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">Save Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


    <script>
        $(document).ready(function () {
            $('#boarders').DataTable();
        });
    </script>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.niceadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\boardinghouse\resources\views/boarders/index.blade.php ENDPATH**/ ?>