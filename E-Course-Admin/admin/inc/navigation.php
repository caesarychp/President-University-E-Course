<aside class="main-sidebar sidebar-dark-primary bg-navy elevation-4 sidebar-no-expand">
    <!-- Brand Logo -->
    <a href="<?php echo base_url ?>admin" class="brand-link bg-primary text-sm">
        <img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="Store Logo" class="brand-image img-circle elevation-3" style="width: 1.7rem;height: 1.7rem;max-height: unset">
        <span class="brand-text font-weight-light"><?php echo $_settings->info('short_name') ?></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
        <div class="os-resize-observer-host observed">
            <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
        </div>
        <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer"></div>
        </div>
        <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
        <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
                <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                    <!-- Sidebar user panel (optional) -->
                    <div class="clearfix"></div>
                    <!-- Sidebar Menu -->
                    <nav class="mt-4">
                        <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item dropdown">
                                <a href="./" class="nav-link nav-home">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link nav-courses">
                                    <i class="nav-icon fa fa-fw fa-book-open"></i>
                                    <p>
                                        Course
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo base_url ?>admin/?page=course" class="nav-link nav-course_list">
                                            <i class="nav-icon fas fa-list-ul"></i>
                                            <p>Course List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url ?>admin/?page=courses_content" class="nav-link courses_content">
                                            <i class="fas fa-book-reader nav-icon"></i>
                                            <p>Courses Content</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link nav-sales">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>
                                        Sales
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo base_url ?>admin/?page=sales_order" class="nav-link nav-sales_order">
                                            <i class="fas fa-file-invoice-dollar nav-icon"></i>
                                            <p>Sales Order</p>
                                        </a>
                                    </li>
                                </ul>

                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo base_url ?>admin/?page=invoice" class="nav-link Invoice">
                                            <i class="fas fa-file-invoice nav-icon"></i>
                                            <p>Invoice</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link nav-sales">
                                    <i class="nav-icon fa fa-fw fa-wallet"></i>
                                    <p>
                                        Finance
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item dropdown">
                                        <a href="#" class="nav-link nav-sales">
                                            <i class="nav-icon fa fa-fw fa-file-alt"></i>
                                            <p>
                                                Report
                                                <i class="right fas fa-angle-left"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="<?php echo base_url ?>admin/?page=reports/account_payable" class="nav-link nav-ap">
                                                    <i class="fas fa-money-bill nav-icon"></i>
                                                    <p>Account Payable</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo base_url ?>admin/?page=reports/account_receiveable" class="nav-link nav-ar">
                                                    <i class="fas fa-money-bill nav-icon"></i>
                                                    <p>Account Receiveable</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo base_url ?>admin/?page=reports/expenditure" class="nav-link nav-expenditure">
                                                    <i class="fas fa-money-bill nav-icon"></i>
                                                    <p>Expenditure</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?php echo base_url ?>admin/?page=reports/budget" class="nav-link nav-budget">
                                                    <i class="fas fa-piggy-bank nav-icon"></i>
                                                    <p>Budget</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url ?>admin/?page=Payment" class="nav-link Payment">
                                            <i class="fas fa-file-invoice nav-icon"></i>
                                            <p>Payment</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url ?>admin/?page=expense" class="nav-link nav-expense">
                                            <i class="fas fa-list-ol g nav-icon"></i>
                                            <p>Expenditure</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url ?>admin/?page=budget" class="nav-link nav-budget">
                                            <i class="fas fa-list-ul nav-icon"></i>
                                            <p>Budget</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link nav-procurement">
                                    <i class="nav-icon fas fa-truck-loading"></i>
                                    <p>
                                        Procurement
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?php echo base_url ?>admin/?page=purchase_orders" class="nav-link nav-purchase_orders">
                                            <i class="fas fa-file-signature nav-icon"></i>
                                            <p>Purchase Orders</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url ?>admin/?page=vendor" class="nav-link nav-vendor">
                                            <i class="fas fa-handshake nav-icon"></i>
                                            <p>Vendors</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url ?>admin/?page=received_goods" class="nav-link nav-received_goods">
                                            <i class="fas fa-dolly-flatbed nav-icon"></i>
                                            <p>Receive Goods</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url ?>admin/?page=items" class="nav-link nav-material">
                                            <i class="fas fa-dolly-flatbed nav-icon"></i>
                                            <p>Material</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link nav-procurement">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Employees
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item dropdown">
                                        <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-Employee_list">
                                            <i class="nav-icon fas fa-user-friends"></i>
                                            <p>
                                                Employees List
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url ?>admin/?page=employes" class="nav-link nav-Sales_Departement">
                                            <i class="fas fa-file-signature nav-icon"></i>
                                            <p>Sales Departement</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo base_url ?>admin/?page=employee2" class="nav-link nav-Purchase_Department">
                                            <i class="fas fa-handshake nav-icon"></i>
                                            <p>Purchase Department</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <?php if ($_settings->userdata('type') == 1) : ?>
                                <li class="nav-header">Maintenance</li>
                                <li class="nav-item dropdown">
                                    <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-Employee_list">
                                        <i class="nav-icon fas fa-user-friends"></i>
                                        <p>
                                            Employees List
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a href="<?php echo base_url ?>admin/?page=system_info" class="nav-link nav-system_info">
                                        <i class="nav-icon fas fa-sliders-h"></i>
                                        <p>
                                            Settings
                                        </p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <!--  /.sidebar -->
</aside>

<!-- Place this script inside your HTML file, preferably at the end of the <body> tag -->
<script>
    $(document).ready(function() {
        // Get the current page and segment
        var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
        var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
        page = page.split('/');
        page = page[0];
        if (s != '') {
            page = page + '_' + s;
        }

        // Optimize selectors for better performance
        var navLink = $('.nav-link.nav-' + page);

        // Add 'active' class to the appropriate elements
        if (navLink.length > 0) {
            navLink.addClass('active');
        }
    });
</script>