<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('build/images/logo-sm.png')); ?>" alt="" height="26">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('build/images/logo-dark.png')); ?>" alt="" height="26">
            </span>
        </a>
        <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="<?php echo e(URL::asset('build/images/logo-sm.png')); ?>" alt="" height="26">
            </span>
            <span class="logo-lg">
                <img src="<?php echo e(URL::asset('build/images/logo-light.png')); ?>" alt="" height="26">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
            
                <li class="menu-title"><span data-key="t-menu"><?php echo app('translator')->get('translation.menu'); ?></span></li>
                <li class="nav-item">
                    <a href="index" class="nav-link menu-link"> <i class="bi bi-speedometer2"></i> <span data-key="t-dashboard"><?php echo app('translator')->get('translation.dashboards'); ?></span> </a>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages"><?php echo app('translator')->get('translation.pages'); ?></span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                        <i class="bi bi-person-circle"></i> <span data-key="t-authentication"><?php echo app('translator')->get('translation.authentication'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAuth">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#sidebarSignIn" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSignIn" data-key="t-signin"><?php echo app('translator')->get('translation.signin'); ?>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarSignIn">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-signin-basic" class="nav-link" data-key="t-basic"> <?php echo app('translator')->get('translation.basic'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-signin-basic-2" class="nav-link" data-key="t-basic-2"><?php echo app('translator')->get('translation.basic-2'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-signin-cover" class="nav-link" data-key="t-cover"><?php echo app('translator')->get('translation.cover'); ?> </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarSignUp" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSignUp" data-key="t-signup"> <?php echo app('translator')->get('translation.signup'); ?></a>
                                <div class="collapse menu-dropdown" id="sidebarSignUp">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-signup-basic" class="nav-link" data-key="t-basic"> <?php echo app('translator')->get('translation.basic'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-signup-basic-2" class="nav-link" data-key="t-basic-2"> <?php echo app('translator')->get('translation.basic-2'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-signup-cover" class="nav-link" data-key="t-cover"> <?php echo app('translator')->get('translation.cover'); ?> </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a href="#sidebarResetPass" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarResetPass" data-key="t-password-reset">
                                   <?php echo app('translator')->get('translation.password-reset'); ?>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarResetPass">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-pass-reset-basic" class="nav-link" data-key="t-basic"><?php echo app('translator')->get('translation.basic'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-pass-reset-basic-2" class="nav-link" data-key="t-basic-2"> <?php echo app('translator')->get('translation.basic-2'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-pass-reset-cover" class="nav-link" data-key="t-cover"> <?php echo app('translator')->get('translation.cover'); ?></a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a href="#sidebarchangePass" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarchangePass" data-key="t-password-create">
                                    <?php echo app('translator')->get('translation.password-create'); ?>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarchangePass">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-pass-change-basic" class="nav-link" data-key="t-basic"> <?php echo app('translator')->get('translation.basic'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-pass-change-basic-2" class="nav-link" data-key="t-basic-2"> <?php echo app('translator')->get('translation.basic-2'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-pass-change-cover" class="nav-link" data-key="t-cover"> <?php echo app('translator')->get('translation.cover'); ?> </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a href="#sidebarLockScreen" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLockScreen" data-key="t-lock-screen">
                                     <?php echo app('translator')->get('translation.lock-screen'); ?>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarLockScreen">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-lockscreen-basic" class="nav-link" data-key="t-basic">  <?php echo app('translator')->get('translation.basic'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-lockscreen-basic-2" class="nav-link" data-key="t-basic-2">   <?php echo app('translator')->get('translation.basic-2'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-lockscreen-cover" class="nav-link" data-key="t-cover">  <?php echo app('translator')->get('translation.cover'); ?> </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a href="#sidebarLogout" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLogout" data-key="t-logout"><?php echo app('translator')->get('translation.logout'); ?>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarLogout">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-logout-basic" class="nav-link" data-key="t-basic"> <?php echo app('translator')->get('translation.basic'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-logout-basic-2" class="nav-link" data-key="t-basic-2"> <?php echo app('translator')->get('translation.basic-2'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-logout-cover" class="nav-link" data-key="t-cover"> <?php echo app('translator')->get('translation.cover'); ?> </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarSuccessMsg" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarSuccessMsg" data-key="t-success-message"> <?php echo app('translator')->get('translation.success-message'); ?>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarSuccessMsg">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-success-msg-basic" class="nav-link" data-key="t-basic"> <?php echo app('translator')->get('translation.basic'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-success-msg-basic-2" class="nav-link" data-key="t-basic-2"> <?php echo app('translator')->get('translation.basic-2'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-success-msg-cover" class="nav-link" data-key="t-cover"> <?php echo app('translator')->get('translation.cover'); ?> </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarTwoStep" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarTwoStep" data-key="t-two-step-verification">  <?php echo app('translator')->get('translation.two-step-verification'); ?>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarTwoStep">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-twostep-basic" class="nav-link" data-key="t-basic">  <?php echo app('translator')->get('translation.basic'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-twostep-basic-2" class="nav-link" data-key="t-basic-2">   <?php echo app('translator')->get('translation.basic-2'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-twostep-cover" class="nav-link" data-key="t-cover">  <?php echo app('translator')->get('translation.cover'); ?> </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarErrors" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarErrors" data-key="t-errors"> <?php echo app('translator')->get('translation.errors'); ?>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarErrors">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="auth-404-basic" class="nav-link" data-key="t-404-basic"> <?php echo app('translator')->get('translation.404-basic'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-404-cover" class="nav-link" data-key="t-404-cover"> <?php echo app('translator')->get('translation.404-cover'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-404-alt" class="nav-link" data-key="t-404-alt"> <?php echo app('translator')->get('translation.404-alt'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-500" class="nav-link" data-key="t-500"> <?php echo app('translator')->get('translation.500'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="auth-offline" class="nav-link" data-key="t-offline-page">  <?php echo app('translator')->get('translation.offline-page'); ?> </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarPages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPages">
                        <i class="bi bi-journal-medical"></i> <span data-key="t-pages"><?php echo app('translator')->get('translation.pages'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarPages">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="pages-starter" class="nav-link" data-key="t-starter"> <?php echo app('translator')->get('translation.starter'); ?> </a>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarProfile" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProfile" data-key="t-profile">  <?php echo app('translator')->get('translation.profile'); ?>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarProfile">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="pages-profile" class="nav-link" data-key="t-simple-page"> <?php echo app('translator')->get('translation.simple-page'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="pages-profile-settings" class="nav-link" data-key="t-settings"> <?php echo app('translator')->get('translation.settings'); ?> </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a href="pages-team" class="nav-link" data-key="t-team"> <?php echo app('translator')->get('translation.team'); ?> </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages-timeline" class="nav-link" data-key="t-timeline"> <?php echo app('translator')->get('translation.timeline'); ?> </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages-faqs" class="nav-link" data-key="t-faqs"> <?php echo app('translator')->get('translation.faqs'); ?> </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages-pricing" class="nav-link" data-key="t-pricing">  <?php echo app('translator')->get('translation.pricing'); ?> </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages-maintenance" class="nav-link" data-key="t-maintenance"> <?php echo app('translator')->get('translation.maintenance'); ?> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages-coming-soon" class="nav-link" data-key="t-coming-soon"> <?php echo app('translator')->get('translation.coming-soon'); ?> 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages-sitemap" class="nav-link" data-key="t-sitemap"> <?php echo app('translator')->get('translation.sitemap'); ?>  </a>
                            </li>
                            <li class="nav-item">
                                <a href="pages-search-results" class="nav-link" data-key="t-search-results"> <?php echo app('translator')->get('translation.search-results'); ?>  </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="widgets">
                        <i class="bi bi-hdd-stack"></i> <span data-key="t-widgets"><?php echo app('translator')->get('translation.widgets'); ?></span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="components" target="_blank">
                        <i class="bi bi-layers"></i> <span data-key="t-components"><?php echo app('translator')->get('translation.components'); ?></span>
                    </a>
                </li>
                
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-apps"><?php echo app('translator')->get('translation.apps'); ?></span></li>
                
                <li class="nav-item">
                    <a href="apps-calendar" class="nav-link menu-link"> <i class="bi bi-calendar3"></i> <span data-key="t-calendar"><?php echo app('translator')->get('translation.calendar'); ?></span> </a>
                </li>
                
                <li class="nav-item">
                    <a href="apps-api-key" class="nav-link menu-link"> <i class="bi bi-key"></i> <span data-key="t-api-key"><?php echo app('translator')->get('translation.api-key'); ?></span> </a>
                </li>
                
                <li class="nav-item">
                    <a href="apps-contact" class="nav-link menu-link"> <i class="bi bi-person-square"></i> <span data-key="t-contact"><?php echo app('translator')->get('translation.contact'); ?></span> </a>
                </li>
                
                <li class="nav-item">
                    <a href="apps-leaderboards" class="nav-link menu-link"> <i class="bi bi-gem"></i> <span data-key="t-leaderboard"><?php echo app('translator')->get('translation.leaderboard'); ?></span> </a>
                </li>
                
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-layouts"><?php echo app('translator')->get('translation.layouts'); ?></span></li>
                <li class="nav-item">
                    <a href="layouts-horizontal" class="nav-link menu-link" target="_blank"> <i class="bi bi-window"></i> <span data-key="t-horizontal"><?php echo app('translator')->get('translation.horizontal'); ?></span> </a>
                </li>
                <li class="nav-item">
                    <a href="layouts-detached" class="nav-link menu-link" target="_blank"> <i class="bi bi-layout-sidebar-inset"></i> <span data-key="t-detached"><?php echo app('translator')->get('translation.detached'); ?></span> </a>
                </li>
                <li class="nav-item">
                    <a href="layouts-two-column" class="nav-link menu-link" target="_blank"> <i class="bi bi-layout-three-columns"></i> <span data-key="t-two-column"><?php echo app('translator')->get('translation.two-column'); ?></span> </a>
                </li>
                <li class="nav-item">
                    <a href="layouts-vertical-hovered" class="nav-link menu-link" target="_blank"> <i class="bi bi-layout-text-sidebar-reverse"></i> <span data-key="t-hovered"><?php echo app('translator')->get('translation.hovered'); ?></span> </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarMultilevel" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarMultilevel">
                        <i class="bi bi-share"></i> <span data-key="t-multi-level"><?php echo app('translator')->get('translation.multi-level'); ?></span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarMultilevel">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link" data-key="t-level-1.1"> <?php echo app('translator')->get('translation.level-1.1'); ?></a>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarAccount" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAccount" data-key="t-level-1.2"> <?php echo app('translator')->get('translation.level-1.2'); ?>
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarAccount">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link" data-key="t-level-2.1"> <?php echo app('translator')->get('translation.level-2.1'); ?> </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#sidebarCrm" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarCrm" data-key="t-level-2.2"> <?php echo app('translator')->get('translation.level-2.2'); ?>
                                            </a>
                                            <div class="collapse menu-dropdown" id="sidebarCrm">
                                                <ul class="nav nav-sm flex-column">
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link" data-key="t-level-3.1"> <?php echo app('translator')->get('translation.level-3.1'); ?>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="#" class="nav-link" data-key="t-level-3.2"> <?php echo app('translator')->get('translation.level-3.2'); ?>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div><?php /**PATH /Users/enriquemartinez/php-projects/hybrix-1.3/resources/views/layouts/sidebar.blade.php ENDPATH**/ ?>