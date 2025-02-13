<?php $__env->startSection('title', 'About'); ?>

<?php $__env->startSection('content'); ?>
    <section id="about" class="about-section py-5">
        <div class="container">
            <h2 class="section-title text-center mb-5 fw-bold mt-5" data-aos="fade-up">About Our System</h2>
            <p class="text-center mb-5 lead" data-aos="fade-up" data-aos-delay="200">
                Our system is designed to simplify property management, making it easier for landlords and tenants to
                interact seamlessly. Explore the features that make our platform stand out.
            </p>

            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card h-100 shadow-sm hover-effect text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-people-fill fs-1 text-primary"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Tenant Management</h4>
                        <p class="text-secondary mb-0">Efficiently manage tenant information, contracts, and documentation
                            in one place. Simplify communication and ensure compliance with lease agreements.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card h-100 shadow-sm hover-effect text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-house-door-fill fs-1 text-primary"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Room Management</h4>
                        <p class="text-secondary mb-0">Track room availability, maintenance schedules, and occupancy rates
                            in real-time. Optimize space utilization and reduce vacancies.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="feature-card h-100 shadow-sm hover-effect text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-credit-card-fill fs-1 text-primary"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Payment Processing</h4>
                        <p class="text-secondary mb-0">Streamline rent collection with automated billing and payment
                            tracking. Ensure timely payments and reduce manual errors.</p>
                    </div>
                </div>
            </div>

            <div class="row mt-5 g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="feature-card h-100 shadow-sm hover-effect text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-wallet-fill fs-1 text-primary"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Payment Integration</h4>
                        <p class="text-secondary mb-0">Seamlessly integrate with popular payment gateways like PayPal,
                            GCash, and credit feature-cards for hassle-free transactions.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="800">
                    <div class="feature-card h-100 shadow-sm hover-effect text-center p-4">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-bar-chart-fill fs-1 text-primary"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Analytics & Reporting</h4>
                        <p class="text-secondary mb-0">Gain insights into your property performance with detailed analytics
                            and reports. Make data-driven decisions effortlessly.</p>
                    </div>
                </div>
            </div>

        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\boardinghouse\resources\views\main\about.blade.php ENDPATH**/ ?>