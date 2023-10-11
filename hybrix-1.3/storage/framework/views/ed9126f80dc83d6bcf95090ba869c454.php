<?php $__env->startSection('title'); ?>
    Login
<?php $__env->stopSection(); ?>

<section class="auth-bg-cover min-vh-100 p-4 p-lg-5 d-flex align-items-center justify-content-center">
    <div class="bg-overlay"></div>
    <div class="container-fluid px-0">
        <div class="row g-0">
            <div class="col-xl-8 col-lg-6">
                <div class="h-100 mb-0 p-4 d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <img src="<?php echo e(URL::asset('build/images/logo-light-full.png')); ?>" alt=""
                                height="32" />
                        </div>
                    </div>

                    <div class="text-white mt-4">
                        <p class="mb-0">&copy;
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Hybrix. Crafted with <i class="mdi mdi-heart text-danger"></i> by
                            Themesbrand
                        </p>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xl-4 col-lg-6">
                <div class="card mb-0 py-5">
                    <div class="card-body p-4 p-sm-5 m-lg-2">
                        <div class="text-center mt-2">
                            <h5 class="text-primary fs-22">Welcome Back !</h5>
                            <p class="text-muted">Sign in to continue to Hybrix.</p>
                        </div>
                        <!-- __BLOCK__ --><?php if(session()->has('error')): ?>
                            <div class="alert alert-borderless alert-danger alert-dismissible mb-2 mx-2">
                                <?php echo e(session('error')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        <?php endif; ?> <!-- __ENDBLOCK__ -->
                        <!-- __BLOCK__ --><?php if(session()->has('success')): ?>
                            <div class="alert alert-borderless alert-success alert-dismissible mb-2 mx-2">
                                <?php echo e(session('success')); ?>

                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        <?php endif; ?> <!-- __ENDBLOCK__ -->
                        <div class="p-2 mt-3">
                            <form method="POST" wire:submit="submit">
                                <?php echo csrf_field(); ?>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input id="email" type="email"
                                        class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" wire:model.live="email"
                                        value="<?php echo e(old('email', 'admin@themesbrand.com')); ?>" required autocomplete="email" autofocus placeholder="Enter your email">
                                    <!-- __BLOCK__ --><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> <!-- __ENDBLOCK__ -->
                                </div>

                                <div class="mb-3">
                                    <div class="float-end">
                                        <!-- __BLOCK__ --><?php if(Route::has('password.reset')): ?>
                                            <a class="text-muted" href="<?php echo e(route('password.reset')); ?>">
                                                <?php echo e(__('Forgot Your Password?')); ?>

                                            </a>
                                        <?php endif; ?> <!-- __ENDBLOCK__ -->
                                    </div>
                                    <label class="form-label" for="password-input">Password <span
                                            class="text-danger">*</span></label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                        <input id="password" type="password"
                                            class="form-control pe-5 password-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            wire:model.live="password" id="password-input" required value="12345678"
                                            autocomplete="current-password" placeholder="Enter your password">
                                        <button
                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                            type="button" id="password-addon"><i
                                                class="ri-eye-fill align-middle"></i></button>
                                    </div>
                                    <!-- __BLOCK__ --><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> <!-- __ENDBLOCK__ -->
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>

                                <div class="mt-4">
                                    <button class="btn btn-primary w-100" type="submit">Sign In</button>
                                </div>

                                <div class="mt-4 pt-2 text-center">
                                    <div class="signin-other-title">
                                        <h5 class="fs-13 mb-4 title">Sign In with</h5>
                                    </div>
                                    <div class="pt-2 hstack gap-2 justify-content-center">
                                        <button type="button" class="btn btn-soft-primary btn-icon"><i
                                                class="ri-facebook-fill fs-16"></i></button>
                                        <button type="button" class="btn btn-soft-danger btn-icon"><i
                                                class="ri-google-fill fs-16"></i></button>
                                        <button type="button" class="btn btn-soft-dark btn-icon"><i
                                                class="ri-github-fill fs-16"></i></button>
                                        <button type="button" class="btn btn-soft-info btn-icon"><i
                                                class="ri-twitter-fill fs-16"></i></button>
                                    </div>
                                </div>
                            </form>

                            <div class="text-center mt-5">
                                <p class="mb-0">Don't have an account ? <a href="<?php echo e(url('register')); ?>"
                                        class="fw-semibold text-secondary text-decoration-underline"> Sign Up</a> </p>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end conatiner-->
</section>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('build/js/pages/password-addon.init.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php /**PATH /Users/enriquemartinez/php-projects/hybrix-1.3/resources/views/livewire/auth/login.blade.php ENDPATH**/ ?>