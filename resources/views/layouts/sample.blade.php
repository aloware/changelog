
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Orbiter is a bootstrap minimal & clean admin template">
    <meta name="keywords" content="admin, admin panel, admin template, admin dashboard, responsive, bootstrap 4, ui kits, ecommerce, web app, crm, cms, html, sass support, scss">
    <meta name="author" content="Themesbox">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Logbook</title>
    <!-- Fevicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- Start css -->
    <!-- Switchery css -->
    <link href="assets/plugins/switchery/switchery.min.css" rel="stylesheet">
    <!-- Apex css -->
    <link href="assets/plugins/apexcharts/apexcharts.css" rel="stylesheet">
    <!-- Slick css -->
    <link href="assets/plugins/slick/slick.css" rel="stylesheet">
    <link href="assets/plugins/slick/slick-theme.css" rel="stylesheet">
    <link href="{{ mix('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/flag-icon.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <!-- End css -->
</head>
<body class="vertical-layout">
<!-- Start Infobar Setting Sidebar -->
<div id="infobar-settings-sidebar" class="infobar-settings-sidebar">
    <div class="infobar-settings-sidebar-head d-flex w-100 justify-content-between">
        <h4>Settings</h4><a href="javascript:void(0)" id="infobar-settings-close" class="infobar-settings-close"><img src="assets/images/svg-icon/close.svg" class="img-fluid menu-hamburger-close" alt="close"></a>
    </div>
    <div class="infobar-settings-sidebar-body">
        <div class="custom-mode-setting">
            <div class="row align-items-center pb-3">
                <div class="col-8"><h6 class="mb-0">Payment Reminders</h6></div>
                <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-first" checked /></div>
            </div>
            <div class="row align-items-center pb-3">
                <div class="col-8"><h6 class="mb-0">Stock Updates</h6></div>
                <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-second" checked /></div>
            </div>
            <div class="row align-items-center pb-3">
                <div class="col-8"><h6 class="mb-0">Open for New Products</h6></div>
                <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-third" /></div>
            </div>
            <div class="row align-items-center pb-3">
                <div class="col-8"><h6 class="mb-0">Enable SMS</h6></div>
                <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-fourth" checked /></div>
            </div>
            <div class="row align-items-center pb-3">
                <div class="col-8"><h6 class="mb-0">Newsletter Subscription</h6></div>
                <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-fifth" checked /></div>
            </div>
            <div class="row align-items-center pb-3">
                <div class="col-8"><h6 class="mb-0">Show Map</h6></div>
                <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-sixth" /></div>
            </div>
            <div class="row align-items-center pb-3">
                <div class="col-8"><h6 class="mb-0">e-Statement</h6></div>
                <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-seventh" checked /></div>
            </div>
            <div class="row align-items-center">
                <div class="col-8"><h6 class="mb-0">Monthly Report</h6></div>
                <div class="col-4 text-right"><input type="checkbox" class="js-switch-setting-eightth" checked /></div>
            </div>
        </div>
    </div>
</div>
<div class="infobar-settings-sidebar-overlay"></div>
<!-- End Infobar Setting Sidebar -->
<!-- Start Containerbar -->
<div id="containerbar">
    <!-- Start Leftbar -->
    <div class="leftbar">
        <!-- Start Sidebar -->
        <div class="sidebar">
            <!-- Start Logobar -->
            <div class="logobar">
                <a href="index.html" class="logo logo-large"><img src="assets/images/logo.svg" class="img-fluid" alt="logo"></a>
                <a href="index.html" class="logo logo-small"><img src="assets/images/small_logo.svg" class="img-fluid" alt="logo"></a>
            </div>
            <!-- End Logobar -->
            <!-- Start Navigationbar -->
            <div class="navigationbar">
                <ul class="vertical-menu">
                    <li>
                        <a href="javaScript:void();">
                            <img src="assets/images/svg-icon/dashboard.svg" class="img-fluid" alt="dashboard"><span>Dashboard</span><i class="feather icon-chevron-right pull-right"></i>
                        </a>
                        <ul class="vertical-submenu">
                            <li><a href="index.html">CRM</a></li>
                            <li><a href="dashboard-ecommerce.html">eCommerce</a></li>
                            <li><a href="dashboard-hospital.html">Hospital</a></li>
                            <li><a href="dashboard-crypto.html">Crypto</a></li>
                            <li><a href="dashboard-school.html">School</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javaScript:void();">
                            <img src="assets/images/svg-icon/basic.svg" class="img-fluid" alt="basic"><span>Basic UI</span><i class="feather icon-chevron-right pull-right"></i>
                        </a>
                        <ul class="vertical-submenu">
                            <li><a href="basic-ui-kits-alerts.html">Alerts</a></li>
                            <li><a href="basic-ui-kits-badges.html">Badges</a></li>
                            <li><a href="basic-ui-kits-buttons.html">Buttons</a></li>
                            <li><a href="basic-ui-kits-cards.html">Cards</a></li>
                            <li><a href="basic-ui-kits-carousel.html">Carousel</a></li>
                            <li><a href="basic-ui-kits-collapse.html">Collapse</a></li>
                            <li><a href="basic-ui-kits-dropdowns.html">Dropdowns</a></li>
                            <li><a href="basic-ui-kits-embeds.html">Embeds</a></li>
                            <li><a href="basic-ui-kits-grids.html">Grids</a></li>
                            <li><a href="basic-ui-kits-images.html">Images</a></li>
                            <li><a href="basic-ui-kits-media.html">Media</a></li>
                            <li><a href="basic-ui-kits-modals.html">Modals</a></li>
                            <li><a href="basic-ui-kits-paginations.html">Paginations</a></li>
                            <li><a href="basic-ui-kits-popovers.html">Popovers</a></li>
                            <li><a href="basic-ui-kits-progressbars.html">Progress Bars</a></li>
                            <li><a href="basic-ui-kits-spinners.html">Spinners</a></li>
                            <li><a href="basic-ui-kits-tabs.html">Tabs</a></li>
                            <li><a href="basic-ui-kits-toasts.html">Toasts</a></li>
                            <li><a href="basic-ui-kits-tooltips.html">Tooltips</a></li>
                            <li><a href="basic-ui-kits-typography.html">Typography</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javaScript:void();">
                            <img src="assets/images/svg-icon/advanced.svg" class="img-fluid" alt="advanced"><span>Advanced UI</span><i class="feather icon-chevron-right pull-right"></i>
                        </a>
                        <ul class="vertical-submenu">
                            <li><a href="advanced-ui-kits-image-crop.html">Image Crop</a></li>
                            <li><a href="advanced-ui-kits-jquery-confirm.html">jQuery Confirm</a></li>
                            <li><a href="advanced-ui-kits-nestable.html">Nestable</a></li>
                            <li><a href="advanced-ui-kits-pnotify.html">Pnotify</a></li>
                            <li><a href="advanced-ui-kits-range-slider.html">Range Slider</a></li>
                            <li><a href="advanced-ui-kits-ratings.html">Ratings</a></li>
                            <li><a href="advanced-ui-kits-session-timeout.html">Session Timeout</a></li>
                            <li><a href="advanced-ui-kits-sweet-alerts.html">Sweet Alerts</a></li>
                            <li><a href="advanced-ui-kits-switchery.html">Switchery</a></li>
                            <li><a href="advanced-ui-kits-toolbar.html">Toolbar</a></li>
                            <li><a href="advanced-ui-kits-tour.html">Tour</a></li>
                            <li><a href="advanced-ui-kits-treeview.html">Tree View</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javaScript:void();">
                            <img src="assets/images/svg-icon/apps.svg" class="img-fluid" alt="apps"><span>Apps</span><i class="feather icon-chevron-right pull-right"></i>
                        </a>
                        <ul class="vertical-submenu">
                            <li><a href="apps-calender.html">Calender</a></li>
                            <li><a href="apps-chat.html">Chat</a></li>
                            <li>
                                <a href="javaScript:void();">Email<i class="feather icon-chevron-right pull-right"></i></a>
                                <ul class="vertical-submenu">
                                    <li><a href="apps-email-inbox.html">Inbox</a></li>
                                    <li><a href="apps-email-open.html">Open</a></li>
                                    <li><a href="apps-email-compose.html">Compose</a></li>
                                </ul>
                            </li>
                            <li><a href="apps-kanban-board.html">Kanban Board</a></li>
                            <li><a href="apps-onboarding-screens.html">Onboarding Screens</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javaScript:void();">
                            <img src="assets/images/svg-icon/form_elements.svg" class="img-fluid" alt="form_elements"><span>Forms</span><i class="feather icon-chevron-right pull-right"></i>
                        </a>
                        <ul class="vertical-submenu">
                            <li><a href="form-inputs.html">Basic Elements</a></li>
                            <li><a href="form-groups.html">Groups</a></li>
                            <li><a href="form-layouts.html">Layouts</a></li>
                            <li><a href="form-colorpickers.html">Color Pickers</a></li>
                            <li><a href="form-datepickers.html">Date Pickers</a></li>
                            <li><a href="form-editors.html">Editors</a></li>
                            <li><a href="form-file-uploads.html">File Uploads</a></li>
                            <li><a href="form-input-mask.html">Input Mask</a></li>
                            <li><a href="form-maxlength.html">MaxLength</a></li>
                            <li><a href="form-selects.html">Selects</a></li>
                            <li><a href="form-touchspin.html">Touchspin</a></li>
                            <li><a href="form-validations.html">Validations</a></li>
                            <li><a href="form-wizards.html">Wizards</a></li>
                            <li><a href="form-xeditable.html">X-editable</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javaScript:void();">
                            <img src="assets/images/svg-icon/chart.svg" class="img-fluid" alt="chart"><span>Charts</span><i class="feather icon-chevron-right pull-right"></i>
                        </a>
                        <ul class="vertical-submenu">
                            <li><a href="chart-apex.html">Apex</a></li>
                            <li><a href="chart-c3.html">C3</a></li>
                            <li><a href="chart-chartistjs.html">Chartist</a></li>
                            <li><a href="chart-chartjs.html">Chartjs</a></li>
                            <li><a href="chart-flot.html">Flot</a></li>
                            <li><a href="chart-knob.html">Knob</a></li>
                            <li><a href="chart-morris.html">Morris</a></li>
                            <li><a href="chart-piety.html">Piety</a></li>
                            <li><a href="chart-sparkline.html">Sparkline</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javaScript:void();">
                            <img src="assets/images/svg-icon/icons.svg" class="img-fluid" alt="icons"><span>Icons</span><i class="feather icon-chevron-right pull-right"></i>
                        </a>
                        <ul class="vertical-submenu">
                            <li><a href="icon-svg.html">SVG</a></li>
                            <li><a href="icon-dripicons.html">Dripicons</a></li>
                            <li><a href="icon-feather.html">Feather</a></li>
                            <li><a href="icon-flag.html">Flag</a></li>
                            <li><a href="icon-font-awesome.html">Font Awesome</a></li>
                            <li><a href="icon-ionicons.html">Ion</a></li>
                            <li><a href="icon-line-awesome.html">Line Awesome</a></li>
                            <li><a href="icon-material-design.html">Material Design</a></li>
                            <li><a href="icon-simple-line.html">Simple Line</a></li>
                            <li><a href="icon-socicon.html">Socicon</a></li>
                            <li><a href="icon-themify.html">Themify</a></li>
                            <li><a href="icon-typicons.html">Typicons</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="javaScript:void();">
                            <img src="assets/images/svg-icon/tables.svg" class="img-fluid" alt="tables"><span>Tables</span><i class="feather icon-chevron-right pull-right"></i>
                        </a>
                        <ul class="vertical-submenu">
                            <li><a href="table-bootstrap.html">Bootstrap</a></li>
                            <li><a href="table-datatable.html">Datatable</a></li>
                            <li><a href="table-editable.html">Editable</a></li>
                            <li><a href="table-footable.html">Foo</a></li>
                            <li><a href="table-rwdtable.html">RWD</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="javaScript:void();">
                            <img src="assets/images/svg-icon/maps.svg" class="img-fluid" alt="maps"><span>Maps</span><i class="feather icon-chevron-right pull-right"></i>
                        </a>
                        <ul class="vertical-submenu">
                            <li><a href="map-google.html">Google</a></li>
                            <li><a href="map-vector.html">Vector</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="widgets.html">
                            <img src="assets/images/svg-icon/widgets.svg" class="img-fluid" alt="widgets"><span>Widgets</span><span class="badge badge-success pull-right">New</span>
                        </a>
                    </li>
                    <li>
                        <a href="javaScript:void();">
                            <img src="assets/images/svg-icon/pages.svg" class="img-fluid" alt="pages"><span>Pages</span><i class="feather icon-chevron-right pull-right"></i>
                        </a>
                        <ul class="vertical-submenu">
                            <li>
                                <a href="javaScript:void();">Basic<i class="feather icon-chevron-right pull-right"></i></a>
                                <ul class="vertical-submenu">
                                    <li><a href="page-starter.html">Starter</a></li>
                                    <li><a href="page-blog.html">Blog</a></li>
                                    <li><a href="page-faq.html">FAQ</a></li>
                                    <li><a href="page-gallery.html">Gallery</a></li>
                                    <li><a href="page-invoice.html">Invoice</a></li>
                                    <li><a href="page-pricing.html">Pricing</a></li>
                                    <li><a href="page-timeline.html">Timeline</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javaScript:void();">Authentications<i class="feather icon-chevron-right pull-right"></i></a>
                                <ul class="vertical-submenu">
                                    <li><a href="user-login.html">Login</a></li>
                                    <li><a href="user-register.html">Register</a></li>
                                    <li><a href="user-forgotpsw.html">Forgot Password</a></li>
                                    <li><a href="user-lock-screen.html">Lock Screen</a></li>
                                    <li><a href="error-comingsoon.html">Coming Soon</a></li>
                                    <li><a href="error-maintenance.html">Maintenance</a></li>
                                    <li><a href="error-404.html">Error 404</a></li>
                                    <li><a href="error-500.html">Error 500</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javaScript:void();">
                            <img src="assets/images/svg-icon/ecommerce.svg" class="img-fluid" alt="ecommerce"><span>eCommerce</span><i class="feather icon-chevron-right pull-right"></i>
                        </a>
                        <ul class="vertical-submenu">
                            <li><a href="ecommerce-product-list.html">Product List</a></li>
                            <li><a href="ecommerce-product-detail.html">Product Detail</a></li>
                            <li><a href="ecommerce-order-list.html">Order List</a></li>
                            <li><a href="ecommerce-order-detail.html">Order Detail</a></li>
                            <li><a href="ecommerce-shop.html">Shop</a></li>
                            <li><a href="ecommerce-single-product.html">Single Product</a></li>
                            <li><a href="ecommerce-cart.html">Cart</a></li>
                            <li><a href="ecommerce-checkout.html">Checkout</a></li>
                            <li><a href="ecommerce-thankyou.html">Thank You</a></li>
                            <li><a href="ecommerce-myaccount.html">My Account</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- End Navigationbar -->
        </div>
        <!-- End Sidebar -->
    </div>
    <!-- End Leftbar -->
    <!-- Start Rightbar -->
    <div class="rightbar">
        <!-- Start Topbar Mobile -->
        <div class="topbar-mobile">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="mobile-logobar">
                        <a href="index.html" class="mobile-logo"><img src="assets/images/logo.svg" class="img-fluid" alt="logo"></a>
                    </div>
                    <div class="mobile-togglebar">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <div class="topbar-toggle-icon">
                                    <a class="topbar-toggle-hamburger" href="javascript:void();">
                                        <img src="assets/images/svg-icon/horizontal.svg" class="img-fluid menu-hamburger-horizontal" alt="horizontal">
                                        <img src="assets/images/svg-icon/verticle.svg" class="img-fluid menu-hamburger-vertical" alt="verticle">
                                    </a>
                                </div>
                            </li>
                            <li class="list-inline-item">
                                <div class="menubar">
                                    <a class="menu-hamburger" href="javascript:void();">
                                        <img src="assets/images/svg-icon/collapse.svg" class="img-fluid menu-hamburger-collapse" alt="collapse">
                                        <img src="assets/images/svg-icon/close.svg" class="img-fluid menu-hamburger-close" alt="close">
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Start Topbar -->
        <div class="topbar">
            <!-- Start row -->
            <div class="row align-items-center">
                <!-- Start col -->
                <div class="col-md-12 align-self-center">
                    <div class="togglebar">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <div class="menubar">
                                    <a class="menu-hamburger" href="javascript:void();">
                                        <img src="assets/images/svg-icon/collapse.svg" class="img-fluid menu-hamburger-collapse" alt="collapse">
                                        <img src="assets/images/svg-icon/close.svg" class="img-fluid menu-hamburger-close" alt="close">
                                    </a>
                                </div>
                            </li>
                            <li class="list-inline-item">
                                <div class="searchbar">
                                    <form>
                                        <div class="input-group">
                                            <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
                                            <div class="input-group-append">
                                                <button class="btn" type="submit" id="button-addon2"><img src="assets/images/svg-icon/search.svg" class="img-fluid" alt="search"></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="infobar">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <div class="settingbar">
                                    <a href="javascript:void(0)" id="infobar-settings-open" class="infobar-icon">
                                        <img src="assets/images/svg-icon/settings.svg" class="img-fluid" alt="settings">
                                    </a>
                                </div>
                            </li>
                            <li class="list-inline-item">
                                <div class="notifybar">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle infobar-icon" href="#" role="button" id="notoficationlink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/images/svg-icon/notifications.svg" class="img-fluid" alt="notifications">
                                            <span class="live-icon"></span></a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notoficationlink">
                                            <div class="notification-dropdown-title">
                                                <h4>Notifications</h4>
                                            </div>
                                            <ul class="list-unstyled">
                                                <li class="media dropdown-item">
                                                    <span class="action-icon badge badge-primary-inverse"><i class="feather icon-dollar-sign"></i></span>
                                                    <div class="media-body">
                                                        <h5 class="action-title">$135 received</h5>
                                                        <p><span class="timing">Today, 10:45 AM</span></p>
                                                    </div>
                                                </li>
                                                <li class="media dropdown-item">
                                                    <span class="action-icon badge badge-success-inverse"><i class="feather icon-file"></i></span>
                                                    <div class="media-body">
                                                        <h5 class="action-title">Project X prototype approved</h5>
                                                        <p><span class="timing">Yesterday, 01:40 PM</span></p>
                                                    </div>
                                                </li>
                                                <li class="media dropdown-item">
                                                    <span class="action-icon badge badge-danger-inverse"><i class="feather icon-eye"></i></span>
                                                    <div class="media-body">
                                                        <h5 class="action-title">John requested to view wireframe</h5>
                                                        <p><span class="timing">3 Sep 2019, 05:22 PM</span></p>
                                                    </div>
                                                </li>
                                                <li class="media dropdown-item">
                                                    <span class="action-icon badge badge-warning-inverse"><i class="feather icon-package"></i></span>
                                                    <div class="media-body">
                                                        <h5 class="action-title">Sports shoes are out of stock</h5>
                                                        <p><span class="timing">15 Sep 2019, 02:55 PM</span></p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-inline-item">
                                <div class="languagebar">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" id="languagelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag flag-icon-us flag-icon-squared"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languagelink">
                                            <a class="dropdown-item" href="#"><i class="flag flag-icon-us flag-icon-squared"></i>English</a>
                                            <a class="dropdown-item" href="#"><i class="flag flag-icon-de flag-icon-squared"></i>German</a>
                                            <a class="dropdown-item" href="#"><i class="flag flag-icon-bl flag-icon-squared"></i>France</a>
                                            <a class="dropdown-item" href="#"><i class="flag flag-icon-ru flag-icon-squared"></i>Russian</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="list-inline-item">
                                <div class="profilebar">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" id="profilelink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="assets/images/users/profile.svg" class="img-fluid" alt="profile"><span class="feather icon-chevron-down live-icon"></span></a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profilelink">
                                            <div class="dropdown-item">
                                                <div class="profilename">
                                                    <h5>John Doe</h5>
                                                </div>
                                            </div>
                                            <div class="userbox">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="media dropdown-item">
                                                        <a href="#" class="profile-icon"><img src="assets/images/svg-icon/user.svg" class="img-fluid" alt="user">My Profile</a>
                                                    </li>
                                                    <li class="media dropdown-item">
                                                        <a href="#" class="profile-icon"><img src="assets/images/svg-icon/email.svg" class="img-fluid" alt="email">Email</a>
                                                    </li>
                                                    <li class="media dropdown-item">
                                                        <a href="#" class="profile-icon"><img src="assets/images/svg-icon/logout.svg" class="img-fluid" alt="logout">Logout</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- End col -->
            </div>
            <!-- End row -->
        </div>
        <!-- End Topbar -->
        <!-- Start Breadcrumbbar -->
        <div class="breadcrumbbar">
            <div class="row align-items-center">
                <div class="col-md-8 col-lg-8">
                    <h4 class="page-title">School</h4>
                    <div class="breadcrumb-list">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">School</li>
                        </ol>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="widgetbar">
                        <button class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>Actions</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbbar -->
        <!-- Start Contentbar -->
        <div class="contentbar">
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12 col-xl-3">
                    <!-- Start row -->
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-lg-6 col-xl-12">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-5">
                                            <span class="action-icon badge badge-primary-inverse mr-0"><i class="feather icon-user"></i></span>
                                        </div>
                                        <div class="col-7 text-right">
                                            <h5 class="card-title font-14">Students</h5>
                                            <h4 class="mb-0">2585</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <span class="font-13">Updated Today</span>
                                        </div>
                                        <div class="col-4 text-right">
                                            <span class="badge badge-success"><i class="feather icon-trending-up mr-1"></i>25%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-6 col-xl-12">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-5">
                                            <span class="action-icon badge badge-success-inverse mr-0"><i class="feather icon-award"></i></span>
                                        </div>
                                        <div class="col-7 text-right">
                                            <h5 class="card-title font-14">Teachers</h5>
                                            <h4 class="mb-0">263</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <span class="font-13">Updated 1 Day ago</span>
                                        </div>
                                        <div class="col-4 text-right">
                                            <span class="badge badge-warning"><i class="feather icon-trending-down mr-1"></i>23%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-6 col-xl-12">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-5">
                                            <span class="action-icon badge badge-warning-inverse mr-0"><i class="feather icon-briefcase"></i></span>
                                        </div>
                                        <div class="col-7 text-right">
                                            <h5 class="card-title font-14">Staffs</h5>
                                            <h4 class="mb-0">45</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <span class="font-13">Updated 3 Day ago</span>
                                        </div>
                                        <div class="col-4 text-right">
                                            <span class="badge badge-success"><i class="feather icon-trending-up mr-1"></i>15%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-6 col-xl-12">
                            <div class="card m-b-30">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-5">
                                            <span class="action-icon badge badge-secondary-inverse mr-0"><i class="feather icon-book-open"></i></span>
                                        </div>
                                        <div class="col-7 text-right">
                                            <h5 class="card-title font-14">Course</h5>
                                            <h4 class="mb-0">93</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <span class="font-13">Updated 5 Day ago</span>
                                        </div>
                                        <div class="col-4 text-right">
                                            <span class="badge badge-warning"><i class="feather icon-trending-down mr-1"></i>10%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                    </div>
                    <!-- End row -->
                </div>
                <!-- End col -->
                <!-- Start col -->
                <div class="col-lg-12 col-xl-9">
                    <!-- Start row -->
                    <div class="row">
                        <!-- Start col -->
                        <div class="col-lg-12 col-xl-8">
                            <div class="card m-b-30">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-9">
                                            <h5 class="card-title mb-0">Student Performance</h5>
                                        </div>
                                        <div class="col-3">
                                            <div class="dropdown">
                                                <button class="btn btn-link p-0 font-18 float-right" type="button" id="widgetStudent" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-horizontal-"></i></button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="widgetStudent">
                                                    <a class="dropdown-item font-13" href="#">Refresh</a>
                                                    <a class="dropdown-item font-13" href="#">Export</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-0 pl-0 pr-2">
                                    <div id="apex-area-chart"></div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-12 col-xl-4">
                            <div class="card m-b-30 quote-bg">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col-2">
                                            <span class=""><i class="mdi mdi-format-quote-open text-black font-20"></i></span>
                                        </div>
                                        <div class="col-10">
                                            <h5 class="card-title mb-0 text-right">Quote of the Day</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <img src="assets/images/general/school_quote.svg" class="img-fluid my-3" width="150" alt="school quote">
                                    <h5 class="text-primary font-italic my-3">Be the change, You wish<br/> to see in the World.</h5>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-12 col-xl-6">
                            <div class="card m-b-30">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Course</h5>
                                </div>
                                <div class="card-body text-center">
                                    <div class="course-slider">
                                        <div class="course-slider-item">
                                            <h4 class="my-0">Mathematics</h4>
                                            <div class="row align-items-center my-4 py-3">
                                                <div class="col-4 p-0">
                                                    <h4>24</h4>
                                                    <p class="mb-0">Faculty</p>
                                                </div>
                                                <div class="col-4 py-3 px-0 bg-primary-rgba rounded">
                                                    <h4 class="text-primary">543</h4>
                                                    <p class="text-primary mb-0">Students</p>
                                                </div>
                                                <div class="col-4 p-0">
                                                    <h4>09</h4>
                                                    <p class="mb-0">Class</p>
                                                </div>
                                            </div>
                                            <div class="progress mb-2" style="height: 5px;">
                                                <div class="progress-bar" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="row align-items-center">
                                                <div class="col-6 text-left">
                                                    <span class="font-13">80% Completed</span>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <span class="font-13">19/25 Module</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="course-slider-item">
                                            <h4 class="my-0">Science</h4>
                                            <div class="row align-items-center my-4 py-3">
                                                <div class="col-4 p-0">
                                                    <h4>22</h4>
                                                    <p class="mb-0">Faculty</p>
                                                </div>
                                                <div class="col-4 py-3 px-0 bg-success-rgba rounded">
                                                    <h4 class="text-success">350</h4>
                                                    <p class="text-success mb-0">Students</p>
                                                </div>
                                                <div class="col-4 p-0">
                                                    <h4>05</h4>
                                                    <p class="mb-0">Class</p>
                                                </div>
                                            </div>
                                            <div class="progress mb-2" style="height: 5px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="row align-items-center">
                                                <div class="col-6 text-left">
                                                    <span class="font-13">70% Completed</span>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <span class="font-13">17/25 Module</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="course-slider-item">
                                            <h4 class="my-0">English</h4>
                                            <div class="row align-items-center my-4 py-3">
                                                <div class="col-4 p-0">
                                                    <h4>18</h4>
                                                    <p class="mb-0">Faculty</p>
                                                </div>
                                                <div class="col-4 py-3 px-0 bg-secondary-rgba rounded">
                                                    <h4 class="text-secondary">470</h4>
                                                    <p class="text-secondary mb-0">Students</p>
                                                </div>
                                                <div class="col-4 p-0">
                                                    <h4>15</h4>
                                                    <p class="mb-0">Class</p>
                                                </div>
                                            </div>
                                            <div class="progress mb-2" style="height: 5px;">
                                                <div class="progress-bar bg-secondary" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="row align-items-center">
                                                <div class="col-6 text-left">
                                                    <span class="font-13">60% Completed</span>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <span class="font-13">15/25 Module</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                        <!-- Start col -->
                        <div class="col-lg-12 col-xl-6">
                            <div class="card m-b-30">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Parents Feedback</h5>
                                </div>
                                <div class="card-body">
                                    <div class="parents-slider">
                                        <div class="parents-slider-item">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-4">
                                                    <img src="assets/images/general/parent_01.png" class="img-fluid" alt="parent">
                                                </div>
                                                <div class="col-12 col-md-8">
                                                    <p class="mb-4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                                                    <h5 class="card-title mb-1">Ms. Jessica Matthew</h5>
                                                    <p class="mb-0 font-14 font-italic">Mother of Larry Matthew, Class 6</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="parents-slider-item">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-4">
                                                    <img src="assets/images/general/parent_02.png" class="img-fluid" alt="parent">
                                                </div>
                                                <div class="col-12 col-md-8">
                                                    <p class="mb-4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                                                    <h5 class="card-title mb-1">Ms. John Doe</h5>
                                                    <p class="mb-0 font-14 font-italic">Father of Mila Doe, Class 5</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="parents-slider-item">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-4">
                                                    <img src="assets/images/general/parent_03.png" class="img-fluid" alt="parent">
                                                </div>
                                                <div class="col-12 col-md-8">
                                                    <p class="mb-4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                                                    <h5 class="card-title mb-1">Ms. Maria Andrew</h5>
                                                    <p class="mb-0 font-14 font-italic">Mother of Will Andrew, Class 1</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End col -->
                    </div>
                    <!-- End row -->
                </div>
                <!-- End col -->
            </div>
            <!-- End row -->
            <!-- Start row -->
            <div class="row">
                <!-- Start col -->
                <div class="col-lg-12 col-xl-6">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-6 col-lg-9">
                                    <h5 class="card-title mb-0">Top Students</h5>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <select class="form-control font-12">
                                        <option value="class1">Class 1</option>
                                        <option value="class2">Class 2</option>
                                        <option value="class3">Class 3</option>
                                        <option value="class4">Class 4</option>
                                        <option value="class5" selected>Class 5</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Std</th>
                                        <th>Maths</th>
                                        <th>Science</th>
                                        <th>English</th>
                                        <th>%</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>John Doe</td>
                                        <td>5</td>
                                        <td>99</td>
                                        <td>99</td>
                                        <td>99</td>
                                        <td>99%</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Jimmy Simpson</td>
                                        <td>5</td>
                                        <td>98</td>
                                        <td>98</td>
                                        <td>98</td>
                                        <td>98%</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>Lorea Johnson</td>
                                        <td>5</td>
                                        <td>97</td>
                                        <td>97</td>
                                        <td>97</td>
                                        <td>97%</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Merry Aniston</td>
                                        <td>5</td>
                                        <td>96</td>
                                        <td>96</td>
                                        <td>96</td>
                                        <td>96%</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>Jessica Perry</td>
                                        <td>5</td>
                                        <td>95</td>
                                        <td>95</td>
                                        <td>95</td>
                                        <td>95%</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>Maria Salkova</td>
                                        <td>5</td>
                                        <td>94</td>
                                        <td>94</td>
                                        <td>94</td>
                                        <td>94%</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End col -->
                <!-- Start col -->
                <div class="col-lg-12 col-xl-6">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h5 class="card-title mb-0">Head of Department</h5>
                                </div>
                                <div class="col-3">
                                    <div class="dropdown">
                                        <button class="btn btn-link p-0 font-18 float-right" type="button" id="widgetHod" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="feather icon-more-horizontal-"></i></button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="widgetHod">
                                            <a class="dropdown-item font-13" href="#">Refresh</a>
                                            <a class="dropdown-item font-13" href="#">Export</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <thead>
                                    <tr>
                                        <th>Pic</th>
                                        <th>Name</th>
                                        <th>Degree</th>
                                        <th>Experience</th>
                                        <th>Department</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><img src="assets/images/users/men.svg" class="img-fluid" width="40" alt="hod"></td>
                                        <td>Mr. Rony Samson</td>
                                        <td>B.Com (Maths)</td>
                                        <td>10+ Years</td>
                                        <td><span class="badge badge-primary-inverse py-2 px-3 font-12">MATHEMATICS</span></td>
                                    </tr>
                                    <tr>
                                        <td><img src="assets/images/users/women.svg" class="img-fluid" width="40" alt="hod"></td>
                                        <td>Mr. Andrew Garfield</td>
                                        <td>B.Sc (Chemistry)</td>
                                        <td>8+ Years</td>
                                        <td><span class="badge badge-success-inverse py-2 px-3 font-12">SCIENCE</span></td>
                                    </tr>
                                    <tr>
                                        <td><img src="assets/images/users/boy.svg" class="img-fluid" width="40" alt="hod"></td>
                                        <td>Mr. Naomi Wattson</td>
                                        <td>B.Ed (English)</td>
                                        <td>5+ Years</td>
                                        <td><span class="badge badge-warning-inverse py-2 px-3 font-12">ENGLISH</span></td>
                                    </tr>
                                    <tr>
                                        <td><img src="assets/images/users/girl.svg" class="img-fluid" width="40" alt="hod"></td>
                                        <td>Mr. Mark Wahlberg</td>
                                        <td>B.A (Sports)</td>
                                        <td>3+ Years</td>
                                        <td><span class="badge badge-secondary-inverse py-2 px-3 font-12">SPORTS</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End col -->
            </div>
            <!-- End row -->
        </div>
        <!-- End Contentbar -->
        <!-- Start Footerbar -->
        <div class="footerbar">
            <footer class="footer">
                <p class="mb-0">© 2020 Orbiter - All Rights Reserved.</p>
            </footer>
        </div>
        <!-- End Footerbar -->
    </div>
    <!-- End Rightbar -->
</div>
<!-- End Containerbar -->
<!-- Start js -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/modernizr.min.js"></script>
<script src="assets/js/detect.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/vertical-menu.js"></script>
<!-- Switchery js -->
<script src="assets/plugins/switchery/switchery.min.js"></script>
<!-- Apex js -->
<script src="assets/plugins/apexcharts/apexcharts.min.js"></script>
<script src="assets/plugins/apexcharts/irregular-data-series.js"></script>
<!-- Slick js -->
<script src="assets/plugins/slick/slick.min.js"></script>
<!-- Custom Dashboard js -->
<script src="assets/js/custom/custom-dashboard-school.js"></script>
<!-- Core js -->
<script src="assets/js/core.js"></script>
<script src="{{ mix('js/app.js') }}"></script>
<!-- End js -->
</body>
</html>
