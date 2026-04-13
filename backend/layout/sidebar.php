<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User Profile-->
        <div class="user-profile">
            <div class="user-pro-body">
                <div><img src="<?php echo $themeUrl;?>/assets/images/users/2.jpg" alt="user-img" class="img-circle"></div>
                <div class="dropdown">
                    <a href="?page=javascript:void(0)" class="dropdown-toggle u-dropdown link hide-menu" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Steave Gection <span class="caret"></span></a>
                    <div class="dropdown-menu animated flipInY">
                        <!-- text-->
                        <a href="?page=javascript:void(0)" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                        <!-- text-->
                        <a href="?page=javascript:void(0)" class="dropdown-item"><i class="ti-wallet"></i> My Balance</a>
                        <!-- text-->
                        <a href="?page=javascript:void(0)" class="dropdown-item"><i class="ti-email"></i> Inbox</a>
                        <!-- text-->
                        <div class="dropdown-divider"></div>
                        <!-- text-->
                        <a href="?page=javascript:void(0)" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>
                        <!-- text-->
                        <div class="dropdown-divider"></div>
                        <!-- text-->
                        <a href="?page=../" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>
                        <!-- text-->
                    </div>
                </div>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li><a href="?page=dashboard"><i class="mdi mdi-view-dashboard"></i>Dashboard </a></li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-users"></i><span class="hide-menu">Users<span class="badge rounded-pill bg-cyan ms-auto"></span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="?page=user_registration">Add User</a></li>
                        <li><a href="?page=manage_user">Manage Users</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-users"></i><span class="hide-menu">Customer<span class="badge rounded-pill bg-cyan ms-auto"></span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="?page=add_customer">Add Customer</a></li>
                        <li><a href="?page=manage_customer">Manage Customer</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-users"></i><span class="hide-menu">Supplier<span class="badge rounded-pill bg-cyan ms-auto"></span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="?page=add_supplier">Add Supplier</a></li>
                        <li><a href="?page=manage_supplier">Manage Supplier</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-users"></i><span class="hide-menu">Brand<span class="badge rounded-pill bg-cyan ms-auto"></span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="?page=add_brand">Add Brand</a></li>
                        <li><a href="?page=manage_brand">Manage Brand</a></li>
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-layout-grid2"></i><span class="hide-menu">Product Type</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="?page=add_product_type">Add Product Type</a></li>
                        <li><a href="?page=manage_products_type">Manage Product Type</a></li>
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-layout-grid2"></i><span class="hide-menu">Product Sub-Type</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="?page=add_product_subtype">Add Product Sub-Type</a></li>
                        <li><a href="?page=manage_products_subtype">Manage Product Sub-Type</a></li>
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-layout-grid2"></i><span class="hide-menu">Variant Type</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="?page=add_variant_type">Add Variant Type</a></li>
                        <li><a href="?page=manage_variant_type">View Variant Type</a></li>
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-layout-grid2"></i><span class="hide-menu">Variant</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="?page=add_variant">Add Variant</a></li>
                        <li><a href="?page=manage_variant">View All Variants</a></li>
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-layout-grid2"></i><span class="hide-menu">Measurement Unit</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="?page=add_measurement_unit">Add Measurement Unit</a></li>
                        <li><a href="?page=manage_measurement_unit">Manage Measurement Unit</a></li>
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-layout-grid2"></i><span class="hide-menu">Products</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="?page=add_product">Add Product</a></li>
                        <li><a href="?page=manage_products">Manage Product</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-sale"></i><span class="hide-menu">Sales</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="?page=add_sale">Add Sales</a></li>
                        <li><a href="?page=manage_sales">Manage Sales</a></li>
                        <li><a href="?page=sales_report">Sales Report</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-store"></i><span class="hide-menu">Stocks <span class="badge rounded-pill bg-primary text-white ms-auto"></span></span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="?page=add_stock">Add Stock</a></li>
                        <li><a href="?page=manage_stocks">Manage Stock</a></li>
                        <li><a href="?page=stocks_report">Stock Report</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-layout-media-right-alt"></i><span class="hide-menu">Purchase</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="?page=add_purchase">Add Purchase</a></li>
                        <li><a href="?page=manage_purchase">Manage Purchase</a></li>
                        <li><a href="?page=purchase_report">Purchase Report</a></li>
                    </ul>
                </li>

                <li> <a class="has-arrow waves-effect waves-dark" href="" aria-expanded="false"><i class="ti-align-left"></i><span class="hide-menu">Reports</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="?page=sales_report">Sales Report</a></li>
                        <li><a href="?page=purchase_report">Purchase Report</a></li>
                        <li><a href="?page=stocks_report">Stock Report</a></li>
                        <li><a href="?page=custom_report">Custom Report</a></li>
                    </ul>
                </li>
                <li> <a class="waves-effect waves-dark" href="login" aria-expanded="false"><i class="fas fa-sign-in-alt"></i><span class="hide-menu">Log Out</span></a></li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
