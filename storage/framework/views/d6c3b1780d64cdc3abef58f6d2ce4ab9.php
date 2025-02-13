<?php $__env->startSection('title', 'Payment History'); ?>
<?php $__env->startSection('content'); ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

                <div class="container mt-4">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h4>Payment History</h4>
                        </div>
                        <div class="card-body mt-3">
                            <?php if($payments->isEmpty()): ?>
                                <p class="text-center text-muted mt-4">No payment history available.</p>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Room Name</th>
                                                <th>Amount</th>
                                                <th>Partial Payment</th>
                                                <th>Description</th>
                                                <th>Payment Due Date</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($index + 1); ?></td>
                                                    <td><?php echo e($payment->room_name); ?></td>
                                                    <td>₱<?php echo e(number_format($payment->amount, 2)); ?></td>
                                                    <td>₱<?php echo e(number_format($payment->partial_amount, 2)); ?></td>
                                                    <td><?php echo e($payment->description); ?></td>
                                                    <td><?php echo e(\Carbon\Carbon::parse($payment->payment_due_date)->format('F d, Y')); ?></td>
                                                    <td>
                                                        <?php if($payment->status == 'pending'): ?>
                                                            <span class="badge bg-warning">Pending</span>
                                                        <?php elseif($payment->status == 'partial'): ?>
                                                            <span class="badge bg-primary">Partial</span>
                                                        <?php elseif($payment->status == 'paid'): ?>
                                                            <span class="badge bg-success">Paid</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo e($payment->created_at->format('F d, Y h:i A')); ?></td>
                                                    <td>
                                                        <button class="btn btn-primary btn-sm view-receipt" data-bs-toggle="modal"
                                                            data-bs-target="#receiptModal" data-name="<?php echo e($payment->first_name); ?> <?php echo e($payment->last_name); ?>"
                                                            data-room="<?php echo e($payment->room_name); ?>" data-amount="₱<?php echo e(number_format($payment->amount, 2)); ?>"
                                                            data-partial="₱<?php echo e(number_format($payment->partial_amount, 2)); ?>"
                                                            data-description="<?php echo e($payment->description); ?>"
                                                            data-due="<?php echo e(\Carbon\Carbon::parse($payment->payment_due_date)->format('F d, Y')); ?>"
                                                            data-status="<?php echo e(ucfirst($payment->status)); ?>"
                                                            data-date="<?php echo e($payment->created_at->format('F d, Y h:i A')); ?>">
                                                            View Receipt
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            <!-- Improved Modal Structure -->
            <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <h4 class="modal-title fw-bold">
                                <i class="fas fa-receipt"></i> Payment Receipt
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <!-- Receipt Content -->
                            <div id="receipt-content">
                                <div class="text-center mb-4">
                                    <h3 class="fw-bold text-uppercase text-primary">Boarding House Payment Receipt</h3>
                                    <hr class="w-50 mx-auto">
                                </div>

                                <div class="p-4 bg-light rounded">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="d-flex gap-1 flex-wrap">
                                                <strong>Boarder's Name:</strong> <span id="receipt-name"></span>
                                            </p>
                                            <p class="d-flex gap-1 flex-wrap">
                                                <strong>Room:</strong> <span id="receipt-room"></span>
                                            </p>
                                            <p class="d-flex gap-1 flex-wrap">
                                                <strong>Amount Paid:</strong> <span id="receipt-amount"></span>
                                            </p>
                                            <p class="d-flex gap-1 flex-wrap">
                                                <strong>Partial Payment:</strong> <span id="receipt-partial"></span>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="d-flex gap-1 flex-wrap">
                                                <strong>Description:</strong> <span id="receipt-description"></span>
                                            </p>
                                            <p class="d-flex gap-1 flex-wrap">
                                                <strong>Payment Due Date:</strong> <span id="receipt-due"></span>
                                            </p>
                                            <p class="d-flex gap-1 flex-wrap">
                                                <strong>Date:</strong> <span id="receipt-date"></span>
                                            </p>
                                            <p class="d-flex gap-1 flex-wrap">
                                                <strong>Status:</strong>
                                                <span id="receipt-status" class="badge bg-success text-white px-3 py-2"></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Thank You Message -->
                                <div class="text-center mt-4">
                                    <h5 class="fw-bold text-success">Thank You for Your Payment!</h5>
                                    <p>Your transaction has been successfully recorded.</p>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Close
                            </button>
                            <button class="btn btn-success" onclick="generatePDF()">
                                <i class="fas fa-file-pdf"></i> Download Receipt
                            </button>
                        </div>
                    </div>
                </div>
            </div>



            <style>
                #receipt-content {
                    width: 100%;
                    max-width: 800px;
                    margin: auto;
                    padding: 25px;
                    background: #fff;
                    color: #000;
                    font-family: Arial, sans-serif;
                    border: 2px solid #000;
                    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
                    font-size: 16px;
                }

                #receipt-content h3,
                #receipt-content p {
                    text-align: center;
                    margin-bottom: 15px;
                }

                #receipt-content table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 15px;
                    font-size: 16px;
                }

                #receipt-content th,
                #receipt-content td {
                    border: 2px solid #000;
                    padding: 10px;
                    text-align: center;
                }

                #receipt-content th {
                    background: #f4f4f4;
                }

                .badge {
                    font-size: 14px;
                    font-weight: bold;
                }
                @media (max-width: 576px) {
                    .d-flex.flex-wrap {
                        display: block !important;
                    }
                }

            </style>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // View Receipt Button Handler
                document.querySelectorAll(".view-receipt").forEach(button => {
                    button.addEventListener("click", function () {
                        document.getElementById("receipt-name").textContent = this.getAttribute("data-name");
                        document.getElementById("receipt-room").textContent = this.getAttribute("data-room");
                        document.getElementById("receipt-amount").textContent = this.getAttribute("data-amount");
                        document.getElementById("receipt-partial").textContent = this.getAttribute("data-partial");
                        document.getElementById("receipt-description").textContent = this.getAttribute("data-description");
                        document.getElementById("receipt-due").textContent = this.getAttribute("data-due");
                        document.getElementById("receipt-status").textContent = this.getAttribute("data-status");
                        document.getElementById("receipt-date").textContent = this.getAttribute("data-date");
                    });
                });

                window.generatePDF = async function () {
                    try {
                        if (typeof window.jspdf === 'undefined') {
                            throw new Error('jsPDF library not loaded');
                        }

                        const { jsPDF } = window.jspdf;
                        const element = document.getElementById('receipt-content');
                        const downloadBtn = document.querySelector('.btn-success');

                        downloadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating...';
                        downloadBtn.disabled = true;

                        await document.fonts.ready;

                        const canvas = await html2canvas(element, {
                            scale: window.innerWidth < 768 ? 2 : 3,
                            useCORS: true,
                            backgroundColor: '#ffffff',
                            logging: false,
                        });

                        const imgData = canvas.toDataURL('image/png');
                        const pdf = new jsPDF('p', 'mm', 'a4');

                        const pageWidth = pdf.internal.pageSize.getWidth();
                        const pageHeight = pdf.internal.pageSize.getHeight();
                        const imgWidth = pageWidth - 20; // Leaves margin
                        const imgHeight = (canvas.height * imgWidth) / canvas.width;

                        if (imgHeight > pageHeight - 20) {
                            pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, pageHeight - 20);
                        } else {
                            pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);
                        }

                        const timestamp = new Date().toISOString().replace(/[-T:]/g, '').slice(0, 14);
                        const filename = `receipt_${timestamp}.pdf`;

                        pdf.save(filename);

                    } catch (error) {
                        console.error('PDF Generation Error:', error);
                        alert('Error generating PDF: ' + error.message);
                    } finally {
                        const downloadBtn = document.querySelector('.btn-success');
                        downloadBtn.innerHTML = '<i class="fas fa-file-pdf"></i> Download Receipt';
                        downloadBtn.disabled = false;
                    }
                };

            });
        </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.boarderportal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\boardinghouse\resources\views\boarders\payments-history.blade.php ENDPATH**/ ?>