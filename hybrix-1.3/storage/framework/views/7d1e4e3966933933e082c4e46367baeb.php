<div class="top-tagbar">
    <div class="w-100">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-auto col-9">
                <div class="text-white-50 fs-13">
                    <i class="bi bi-clock align-middle me-2"></i> <span id="current-time"></span>
                </div>
            </div>
            <div class="col-md-auto col-6 d-none d-lg-block">
                <div class="d-flex align-items-center justify-content-center gap-3 fs-13 text-white-50">
                    <div>
                        <i class="bi bi-envelope align-middle me-2"></i> support@themesbrand.com
                    </div>
                    <div>
                        <i class="bi bi-globe align-middle me-2"></i> www.themesbrand.com
                    </div>
                </div>
            </div>
            <div class="col-md-auto col-3">
                <div class="dropdown topbar-head-dropdown topbar-tag-dropdown justify-content-end">
                    <button type="button" class="btn btn-icon btn-topbar rounded-circle text-white-50 fs-13" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php switch(Session::get('lang')):
                        case ('ru'): ?>
                        <img src="<?php echo e(URL::asset('build/images/flags/russia.svg')); ?>" class="me-2 rounded-circle" alt="user-image" height="20"><span id="lang-name">русский</span>
                        <?php break; ?>
                        <?php case ('it'): ?>
                        <img src="<?php echo e(URL::asset('build/images/flags/italy.svg')); ?>" class="me-2 rounded-circle" alt="Header Language" height="20"><span id="lang-name">Italiana</span>
                        <?php break; ?>
                        <?php case ('sp'): ?>
                        <img src="<?php echo e(URL::asset('build/images/flags/spain.svg')); ?>" class="me-2 rounded-circle" alt="Header Language" height="20"><span id="lang-name">Española</span>
                        <?php break; ?>
                        <?php case ('ch'): ?>
                        <img src="<?php echo e(URL::asset('build/images/flags/china.svg')); ?>" class="me-2 rounded-circle" alt="Header Language" height="20"><span id="lang-name">中国人</span>
                        <?php break; ?>
                        <?php case ('fr'): ?>
                        <img src="<?php echo e(URL::asset('build/images/flags/french.svg')); ?>" class="me-2 rounded-circle" alt="Header Language" height="20"><span id="lang-name">français</span>
                        <?php break; ?>
                        <?php case ('gr'): ?>
                        <img src="<?php echo e(URL::asset('build/images/flags/germany.svg')); ?>" class="me-2 rounded-circle" alt="Header Language" height="20"><span id="lang-name">Deutsche</span>
                        <?php break; ?>
                        <?php case ('ae'): ?>
                        <img src="<?php echo e(URL::asset('build/images/flags/ae.svg')); ?>" class="me-2 rounded-circle" alt="Header Language" height="20"> <span id="lang-name">عربى<</span>
                        <?php break; ?>
                        <?php default: ?>
                        <img  src="<?php echo e(URL::asset('build/images/flags/us.svg')); ?>" alt="Header Language" height="20" class="rounded-circle me-2"> <span id="lang-name">English</span>
                        <?php endswitch; ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">

                        <!-- item-->
                        <a href="<?php echo e(url('index/en')); ?>" class="dropdown-item notify-item language py-2" data-lang="en" title="English">
                            <img src="<?php echo e(URL::asset('build/images/flags/us.svg')); ?>" alt="user-image" class="me-2 rounded-circle" height="18">
                            <span class="align-middle">English</span>
                        </a>

                        <!-- item-->
                        <a href="<?php echo e(url('index/sp')); ?>" class="dropdown-item notify-item language" data-lang="sp" title="Spanish">
                            <img src="<?php echo e(URL::asset('build/images/flags/spain.svg')); ?>" alt="user-image" class="me-2 rounded-circle" height="18">
                            <span class="align-middle">Española</span>
                        </a>

                        <!-- item-->
                        <a href="<?php echo e(url('index/gr')); ?>" class="dropdown-item notify-item language" data-lang="gr" title="German">
                            <img src="<?php echo e(URL::asset('build/images/flags/germany.svg')); ?>" alt="user-image" class="me-2 rounded-circle" height="18"> <span class="align-middle">Deutsche</span>
                        </a>

                        <!-- item-->
                        <a href="<?php echo e(url('index/it')); ?>" class="dropdown-item notify-item language" data-lang="it" title="Italian">
                            <img src="<?php echo e(URL::asset('build/images/flags/italy.svg')); ?>" alt="user-image" class="me-2 rounded-circle" height="18"><span class="align-middle">Italiana</span>
                        </a>


                        <!-- item-->
                        <a href="<?php echo e(url('index/ru')); ?>" class="dropdown-item notify-item language" data-lang="ru" title="Russian">
                            <img src="<?php echo e(URL::asset('build/images/flags/russia.svg')); ?>" alt="user-image" class="me-2 rounded-circle" height="18">
                            <span class="align-middle">русский</span>
                        </a>

                        <!-- item-->
                        <a href="<?php echo e(url('index/ch')); ?>" class="dropdown-item notify-item language" data-lang="ch" title="Chinese">
                            <img src="<?php echo e(URL::asset('build/images/flags/china.svg')); ?>" alt="user-image" class="me-2 rounded-circle" height="18">
                            <span class="align-middle">中国人</span>
                        </a>

                        <!-- item-->
                        <a href="<?php echo e(url('index/fr')); ?>" class="dropdown-item notify-item language" data-lang="fr" title="French">
                            <img src="<?php echo e(URL::asset('build/images/flags/french.svg')); ?>" alt="user-image" class="me-2 rounded-circle" height="18">
                            <span class="align-middle">français</span>
                        </a>

                        <!-- item-->
                        <a href="<?php echo e(url('index/ae')); ?>" class="dropdown-item notify-item language" data-lang="ar" title="Arabic">
                            <img src="<?php echo e(URL::asset('build/images/flags/ae.svg')); ?>" alt="user-image" class="me-2 rounded-circle" height="18">
                            <span class="align-middle">عربى</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /Users/enriquemartinez/php-projects/hybrix-1.3/resources/views/layouts/top-tagbar.blade.php ENDPATH**/ ?>