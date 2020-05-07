<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="<?php echo e(url('public/logo', $general_setting->site_logo)); ?>" />
    <title><?php echo e($general_setting->site_title); ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <!-- Bootstrap CSS-->
    	<link rel="stylesheet" href="<?php echo asset('public/vendor/bootstrap/css/bootstrapCompressed.min.css') ?>" type="text/css">

    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="<?php echo asset('public/vendor/font-awesome/css/font-awesome.min.css') ?>" type="text/css">
    <!-- Fontastic Custom icon font-->
    <!-- Ion icon font-->
    <!-- Google fonts - Roboto -->
    <link href="https://fonts.googleapis.com/css?family=Cairo:200,300,400,600,700,900&amp;subset=arabic" rel="stylesheet">

    <!-- jQuery Circle-->
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="<?php echo asset('public/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') ?>" type="text/css">
    <!-- virtual keybord stylesheet-->
    
    <!-- date range stylesheet-->
    <link rel="stylesheet" href="<?php echo asset('public/vendor/daterange/css/daterangepicker.min.css') ?>" type="text/css">
    <!-- table sorter stylesheet-->
    <link rel="stylesheet" type="text/css" href="<?php echo asset('public/vendor/datatable/dataTableCompressed.css') ?>">
    <!-- theme stylesheet-->
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?php echo asset('public/css/backendCompressed.min.css') ?>" type="text/css">

      <?php if(Session::has('language')): ?>
        <?php if(Session::get('language')=="ar"): ?>
	     <link rel="stylesheet" href="<?php echo asset('public/css/rtl.css') ?>" type="text/css">
		<?php endif; ?>	
	 <?php endif; ?>
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.ico">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

<script type="text/javascript" src="<?php echo asset('public/vendor/jquery/jqueryCompressed.js') ?>"></script>

<script type="text/javascript" src="<?php echo asset('public/vendor/popper.js/umd/popper.min.js') ?>">
</script>


<script type="text/javascript" src="<?php echo asset('public/vendor/bootstrap/js/bootstrapCompressed.js') ?>"></script>


<script type="text/javascript" src="<?php echo asset('public/vendor/jquery.cookie/jquery.cookie.js') ?>">
</script>
<script type="text/javascript" src="<?php echo asset('public/vendor/chart.js/Chart.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/jquery-validation/jquery.validate.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')?>"></script>

<script type="text/javascript" src="<?php echo asset('public/vendor/daterange/js/daterangeCompress.js') ?>"></script>

<script type="text/javascript" src="<?php echo asset('public/vendor/tinymce/js/tinymce/tinymce.min.js') ?>"></script>

<!--
<script type="text/javascript" src="<?php // echo asset('public/vendor/datatable/pdfmake.min.js') ?>"></script>
<script type="text/javascript" src="<?php // echo asset('public/vendor/datatable/vfs_fonts.js') ?>"></script>
--> 

<script type="text/javascript" src="<?php echo asset('public/vendor/datatable/datatableConpressed.js') ?>"></script>
<script type="text/javascript" src="<?php echo asset('public/js/publicCompress.js') ?>"></script>
   
  </head>
  <body>
    <!-- Side Navbar -->
	
 
    <nav class="side-navbar" >
      <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
          <!-- User Info-->
          <div class="sidenav-header-inner text-center">
            <a href="<?php echo e(asset('dashboard')); ?>"><span class="brand-big text-center"><img src="<?php echo e(url('public/logo/logo-home.png')); ?>" ></span></a>
          </div>
          <!-- Small Brand information, appears on minimized sidebar-->
          <div class="sidenav-header-logo"><a href="<?php echo e(asset('dashboard')); ?>" class="brand-small text-center"> <strong><img src="<?php echo e(url('public/logo/logo-home.png')); ?>" style="width:78px;"></strong></a><button class="close" id="hide-dashboard-in-small-size">x</button></div>
        </div>
        <!-- Sidebar Navigation Menus-->
        <div class="main-menu">
          <ul id="side-main-menu" class="side-menu list-unstyled"> 
            <li class="divider-item"><span class="section-divider"><?php echo e(trans('file.fundamentals')); ?></span></li> 		   
			<li><a href="<?php echo e(url('dashboard')); ?>"> <i><img src="<?php echo e(asset('public/images/icons/home.png')); ?>"></i><?php echo e(__('file.dashboard')); ?></a></li>
			<?php 
                          $all_products=DB::table('product_store')
		      ->join('products','products.id','product_store.product_id')
			  ->join('stores','stores.id','product_store.store_id')
			  ->where('products.is_active','1')
			  ->where('products.alert_quantity','>','product_store.qty')
			  ->select('products.*','stores.name as storeName','product_store.qty as sqty')
			  ->get();
			  $alert_product1=0;
			  foreach($all_products as $prod){
				  if($prod->alert_quantity> $prod->sqty){$alert_product1++;}
			  }
                          

                            $total_Request= DB::table('request')->where('status','waiting')->count();
			  $role = DB::table('roles')->find(Auth::user()->role_id);
			  
              $index_permission = DB::table('permissions')->where('name', 'adjustment-in')->first();
                $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>
            <li><a href="<?php echo e(route('qty_adjustment.create')); ?>" > <i><img src="<?php echo e(asset('public/images/icons/instore2.png')); ?>"></i><?php echo e(trans('file.in_store')); ?></a></li>
            <?php endif; ?>
			
			<?php 
			  $role = DB::table('roles')->find(Auth::user()->role_id);
			  
              $index_permission = DB::table('permissions')->where('name', 'adjustment-out')->first();
                $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>
			<li><a href="<?php echo e(route('qty_adjustment.out_store')); ?>"><i><img src="<?php echo e(asset('public/images/icons/outstore2.png')); ?>"></i> <?php echo e(trans('file.out_store')); ?></a></li>
            <?php endif; ?>
			
			<?php 
              $index_permission = DB::table('permissions')->where('name', 'transfers-index')->first();
              $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>
            <li><a href="<?php echo e(route('transfers.index')); ?>" > <i><img src="<?php echo e(asset('public/images/icons/transferstore2.png')); ?>"></i><?php echo e(trans('file.Transfers')); ?></a>
             </li>
            <?php endif; ?>
			
			<?php 
              $index_permission = DB::table('permissions')->where('name', 'sales-index')->first();
              $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>
			<li><a href="<?php echo e(route('sale.index')); ?>"><i><img src="<?php echo e(asset('public/images/icons/orders2.png')); ?>"></i> <?php echo e(trans('file.orders')); ?></a></li>
			<?php endif; ?>
			
			<?php 
              $index_permission = DB::table('permissions')->where('name', 'sales-add')->first();
              $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>
			<li><a href="<?php echo e(asset('offers1')); ?>"><i><img src="<?php echo e(asset('public/images/icons/send2.png')); ?>"></i> <?php echo e(trans('file.send')); ?></a></li>
			<?php endif; ?>
			
			<li><a href="<?php echo e(asset('requests')); ?>"><i><img src="<?php echo e(asset('public/images/icons/send2.png')); ?>"></i><?php echo e(trans('file.online')); ?> <?php echo e(trans('file.orders')); ?></a></li>
                       <li><a href="<?php echo e(asset('requests/rejected')); ?>"><i><img src="<?php echo e(asset('public/images/icons/send2.png')); ?>"></i><?php echo e(trans('file.rejected')); ?> <?php echo e(trans('file.orders')); ?></a></li>
 
			<li class="divider-item"><span class="section-divider"><?php echo e(trans('file.items2')); ?></span></li> 		  
			<?php
              
              $index_permission = DB::table('permissions')->where('name', 'products-index')->first();
                  $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>
            <li><a href="<?php echo e(route('products.index')); ?>"> <i><img src="<?php echo e(asset('public/images/icons/product.png')); ?>"></i><?php echo e(__('file.product')); ?></a></li>
            <li><a href="<?php echo e(asset('variation')); ?>"> <i><img src="<?php echo e(asset('public/images/icons/product.png')); ?>"></i><?php echo e(__('file.varitions')); ?></a></li>
            <?php endif; ?>
			
			<?php
              
              $index_permission = DB::table('permissions')->where('name', 'category-index')->first();
                  $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>
			<li><a href="<?php echo e(route('category.index')); ?>"> <i><img src="<?php echo e(asset('public/images/icons/category.png')); ?>"></i><?php echo e(__('file.categories')); ?></a></li>
            <?php endif; ?>
			
			<?php
              
              $index_permission = DB::table('permissions')->where('name', 'product-price')->first();
                  $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>
			<li><a href="<?php echo e(asset('prices')); ?>"> <i><img src="<?php echo e(asset('public/images/icons/prices.png')); ?>"></i><?php echo e(__('file.prices')); ?></a></li>
			<?php endif; ?>
			
		    <li class="divider-item"><span class="section-divider"><?php echo e(trans('file.reports')); ?></span></li> 		  
 
             <?php
              
              $index_permission = DB::table('permissions')->where('name', 'item_count_store')->first();
                  $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>
			<li><a href="<?php echo e(asset('report/store_qty')); ?>"><i><img src="<?php echo e(asset('public/images/icons/storecount.png')); ?>"></i> <?php echo e(trans('file.item_count_store')); ?></a></li>
			<?php endif; ?>
			
			<?php
              
              $index_permission = DB::table('permissions')->where('name', 'item_movement')->first();
                  $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>
			<li><a href="<?php echo e(route('report.movement')); ?>"><i><img src="<?php echo e(asset('public/images/icons/productmove.png')); ?>"></i> <?php echo e(trans('file.item_movement')); ?></a></li>
			<?php endif; ?>
			
			<?php
              $index_permission = DB::table('permissions')->where('name', 'product-qty-alert')->first();
                  $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>
			<li><a href="<?php echo e(route('report.qtyAlert')); ?>"><i><img src="<?php echo e(asset('public/images/icons/notification.png')); ?>"></i><?php echo e(trans('file.product_allerts')); ?></a></li>
			<?php endif; ?>
			
			<li class="divider-item"><span class="section-divider"><?php echo e(trans('file.settings')); ?></span></li> 		  
              
			  <?php
              $index_permission = DB::table('permissions')->where('name', 'users-index')->first();
                  $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>
			 <li><a href="<?php echo e(route('user.profile', ['id' => Auth::id()])); ?>"><i><img src="<?php echo e(asset('public/images/icons/users.png')); ?>"></i><?php echo e(trans('file.User')); ?></a></li>   
			 <?php endif; ?>
			 
			 <?php
              $index_permission = DB::table('permissions')->where('name', 'role-index')->first();
                  $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>
			 <li><a href="<?php echo e(route('role.index')); ?>"><i><img src="<?php echo e(asset('public/images/icons/permissions.png')); ?>"></i><?php echo e(trans('file.Roles')); ?></a></li>
            <?php endif; ?>

            <?php
              $index_permission = DB::table('permissions')->where('name', 'store_setting')->first();
                  $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>			
			 <li><a href="<?php echo e(route('store.index')); ?>"><i><img src="<?php echo e(asset('public/images/icons/stores.png')); ?>"></i><?php echo e(trans('file.Stores')); ?></a></li>
            <?php endif; ?>

            <?php
              $index_permission = DB::table('permissions')->where('name', 'pos_setting')->first();
                  $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>			
			 <li><a href="<?php echo e(route('setting.pos')); ?>"> <i><img src="<?php echo e(asset('public/images/icons/settings.png')); ?>"></i><?php echo e(trans('file.settings')); ?></a></li>
			<?php endif; ?>

            <?php
              $index_permission = DB::table('permissions')->where('name', 'general_setting')->first();
                  $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>			
			 <li><a href="<?php echo e(route('setting.general')); ?>"> <i><img src="<?php echo e(asset('public/images/icons/settings.png')); ?>"></i> <?php echo e(trans('file.General Setting')); ?></a></li>
	        <?php endif; ?> 
		<li><a href="<?php echo e(route('setting.siteSetting')); ?>"> <i><img src="<?php echo e(asset('public/images/icons/settings.png')); ?>"></i> <?php echo e(trans('file.Site Setting')); ?></a></li>
	
			<li><a href="#company" aria-expanded="false" data-toggle="collapse"> <i class="icon-list"></i><?php echo e(__('file.company')); ?></a>
              <ul id="company" class="collapse list-unstyled ">
                <li><a href="<?php echo e(asset('company/create')); ?>"><?php echo e(__('file.add_company')); ?></a></li>
                <li><a href="<?php echo e(asset('company/all')); ?>"><?php echo e(__('file.all_company')); ?></a></li>
                </ul>
            </li>
			<li><a href="#country" aria-expanded="false" data-toggle="collapse"> <i class="icon-list"></i><?php echo e(__('file.country')); ?></a>
              <ul id="country" class="collapse list-unstyled ">
                <li><a href="<?php echo e(asset('country/create')); ?>"><?php echo e(__('file.add_country')); ?></a></li>
                <li><a href="<?php echo e(asset('country/all')); ?>"><?php echo e(__('file.all_country')); ?></a></li>
                </ul>
            </li>
            
			<li><a href="<?php echo e(asset('pincode/list')); ?>"> <i><img src="<?php echo e(asset('public/images/icons/settings.png')); ?>"></i><?php echo e(trans('file.pincode')); ?></a></li>
			
            <?php 
              $index_permission = DB::table('permissions')->where('name', 'sales-index')->first();
              $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>
            <li style='display:none'><a href="#sale" aria-expanded="false" data-toggle="collapse"> <i class="icon ion-ios-cart-outline"></i><?php echo e(trans('file.Sale')); ?></a>
              <ul id="sale" class="collapse list-unstyled ">
                <?php 
                  $add_permission = DB::table('permissions')->where('name', 'sales-add')->first();
                  $add_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $add_permission->id],
                      ['role_id', $role->id]
                  ])->first();
                ?>
                <?php if($add_permission_active): ?>
                <li><a href="<?php echo e(route('sale.pos')); ?>">POS</a></li>
                <?php endif; ?>
                <li><a href="<?php echo e(route('sale.index')); ?>"><?php echo e(trans('file.Sale')); ?> <?php echo e(trans('file.List')); ?></a></li>
                <li><a href="<?php echo e(route('gift_cards.index')); ?>"><?php echo e(trans('file.Gift Card')); ?> <?php echo e(trans('file.List')); ?></a></li>
                <li><a href="<?php echo e(route('delivery.index')); ?>"><?php echo e(trans('file.Delivery')); ?> <?php echo e(trans('file.List')); ?></a></li>
              </ul>
            </li>
            <?php endif; ?>
            <?php 
              $index_permission = DB::table('permissions')->where('name', 'expenses-index')->first();
              $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>
            <li><a href="#expense" aria-expanded="false" data-toggle="collapse"> <i class="icon ion-calculator"></i><?php echo e(trans('file.Expense')); ?></a>
              <ul id="expense" class="collapse list-unstyled ">
                <li><a href="<?php echo e(route('expense_categories.index')); ?>"><?php echo e(trans('file.Expense Category')); ?></a></li>
                <li><a href="<?php echo e(route('expenses.index')); ?>"><?php echo e(trans('file.Expense')); ?> <?php echo e(trans('file.List')); ?></a></li>
                <?php 
                  $add_permission = DB::table('permissions')->where('name', 'expenses-add')->first();
                  $add_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $add_permission->id],
                      ['role_id', $role->id]
                  ])->first();
                ?>
                <?php if($add_permission_active): ?>
                <li><a id="add-expense" href=""> <?php echo e(trans('file.add')); ?> <?php echo e(trans('file.Expense')); ?></a></li>
                <?php endif; ?>
              </ul>
            </li>
            <?php endif; ?>
            
            <?php 
              $index_permission = DB::table('permissions')->where('name', 'returns-index')->first();
              $index_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $index_permission->id],
                      ['role_id', $role->id]
                  ])->first();
            ?>
            <?php if($index_permission_active): ?>
            <li ><a href="#return" aria-expanded="false" data-toggle="collapse"> <i class="ion-arrow-return-left"></i> <?php echo e(trans('file.return')); ?></a>
              <ul id="return" class="collapse list-unstyled ">
                <li><a href="<?php echo e(route('return.index')); ?>"><?php echo e(trans('file.return')); ?> <?php echo e(trans('file.List')); ?></a></li>
                <?php 
                  $add_permission = DB::table('permissions')->where('name', 'returns-add')->first();
                  $add_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $add_permission->id],
                      ['role_id', $role->id]
                  ])->first();
                ?>
                <?php if($add_permission_active): ?>
                <li><a href="<?php echo e(route('return.create')); ?>"><?php echo e(trans('file.add')); ?> <?php echo e(trans('file.return')); ?></a></li>
                <?php endif; ?>
              </ul>
            </li>
            <?php endif; ?>
            <li><a href="#adjustment" aria-expanded="false" data-toggle="collapse"> <i class="icon ion-ios-settings"></i><?php echo e(trans('file.Quantity')); ?> <?php echo e(trans('file.Adjustment')); ?></a>
              <ul id="adjustment" class="collapse list-unstyled ">
                <li><a href="<?php echo e(route('qty_adjustment.index')); ?>"><?php echo e(trans('file.Adjustment')); ?> <?php echo e(trans('file.List')); ?></a></li>
                <li style='display:none'><a href="<?php echo e(route('qty_adjustment.create')); ?>"><?php echo e(trans('file.add')); ?> <?php echo e(trans('file.Adjustment')); ?></a></li>
              </ul>
            </li>
            <li><a href="#people" aria-expanded="false" data-toggle="collapse"> <i class="icon-user"></i><?php echo e(trans('file.People')); ?></a>
              <ul id="people" class="collapse list-unstyled ">
                <?php $index_permission_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where('name', 'users-index')
                      ->first();
                ?>
                <?php if($index_permission_active): ?>
                <li><a href="<?php echo e(route('user.index')); ?>"><?php echo e(trans('file.User')); ?> <?php echo e(trans('file.List')); ?></a></li>
                <?php $add_permission_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where('name', 'users-add')
                      ->first();
                ?>
                <?php if($add_permission_active): ?>
                <li><a href="<?php echo e(route('user.create')); ?>"><?php echo e(trans('file.add')); ?> <?php echo e(trans('file.User')); ?></a></li>
                <?php endif; ?>
                <?php endif; ?>
                <?php 
                  $index_permission = DB::table('permissions')->where('name', 'customers-index')->first();
                  $index_permission_active = DB::table('role_has_permissions')->where([
                          ['permission_id', $index_permission->id],
                          ['role_id', $role->id]
                      ])->first();
                ?>
                <?php if($index_permission_active): ?>
                <li><a href="<?php echo e(route('customer.index')); ?>"><?php echo e(trans('file.customer')); ?> <?php echo e(trans('file.List')); ?></a></li>
                <?php 
                  $add_permission = DB::table('permissions')->where('name', 'customers-add')->first();
                  $add_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $add_permission->id],
                      ['role_id', $role->id]
                  ])->first();
                ?>
                <?php if($add_permission_active): ?>
                <li><a href="<?php echo e(route('customer.create')); ?>"><?php echo e(trans('file.add')); ?> <?php echo e(trans('file.customer')); ?></a></li>
                <?php endif; ?>
                <?php endif; ?>
                <?php 
                  $index_permission = DB::table('permissions')->where('name', 'suppliers-index')->first();
                  $index_permission_active = DB::table('role_has_permissions')->where([
                          ['permission_id', $index_permission->id],
                          ['role_id', $role->id]
                      ])->first();
                ?>
                <?php if($index_permission_active): ?>
                <li><a href="<?php echo e(route('supplier.index')); ?>"><?php echo e(trans('file.Supplier')); ?> <?php echo e(trans('file.List')); ?></a></li>
                <?php 
                  $add_permission = DB::table('permissions')->where('name', 'suppliers-add')->first();
                  $add_permission_active = DB::table('role_has_permissions')->where([
                      ['permission_id', $add_permission->id],
                      ['role_id', $role->id]
                  ])->first();
                ?>
                <?php if($add_permission_active): ?>
                <li><a href="<?php echo e(route('supplier.create')); ?>"><?php echo e(trans('file.add')); ?> <?php echo e(trans('file.Supplier')); ?></a></li>
                <?php endif; ?>
                <?php endif; ?>
              </ul>
            </li>
            <li style='display:none' ><a href="#report" aria-expanded="false" data-toggle="collapse"> <i class="icon ion-ios-paper-outline"></i><?php echo e(trans('file.Report')); ?>s</a>
              <?php
                $profit_loss_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where('name', 'profit-loss')
                      ->first();
                $best_seller_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where('name', 'best-seller')
                      ->first();
                $product_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where('name', 'product-report')
                      ->first();
                $daily_sale_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where('name', 'daily-sale')
                      ->first();
                $monthly_sale_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where('name', 'monthly-sale')
                      ->first();
                $daily_purchase_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where('name', 'daily-purchase')
                      ->first();
                $monthly_purchase_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where('name', 'monthly-purchase')
                      ->first();
                $purchase_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where('name', 'purchase-report')
                      ->first();
                $sale_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where('name', 'sale-report')
                      ->first();
                $payment_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where('name', 'payment-report')
                      ->first();
                $store_stock_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where('name', 'store-stock-report')
                      ->first();
                $product_qty_alert_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where('name', 'product-qty-alert')
                      ->first();
                $customer_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where('name', 'customer-report')
                      ->first();
                $supplier_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where('name', 'supplier-report')
                      ->first();
                $due_report_active = DB::table('permissions')
                      ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                      ->where('name', 'due-report')
                      ->first();
              ?>
              <ul id="report" class="collapse list-unstyled ">
                <?php if($profit_loss_active): ?>
                <li>
                  <?php echo Form::open(['route' => 'report.profitLoss', 'method' => 'post', 'id' => 'profitLoss-report-form']); ?>

                  <input type="hidden" name="start_date" value="<?php echo e(date('Y-m').'-'.'01'); ?>" />
                  <input type="hidden" name="end_date" value="<?php echo e(date('Y-m-d')); ?>" />
                  <a id="profitLoss-link" href=""><?php echo e(trans('file.Summary Report')); ?></a>
                  <?php echo Form::close(); ?>

                </li>
                <?php endif; ?>
                <?php if($best_seller_active): ?>
                <li>
                  <a href="<?php echo e(url('report/best_seller')); ?>"><?php echo e(trans('file.Best Seller')); ?></a>
                </li>
                <?php endif; ?>
                <?php if($product_report_active): ?>
                <li>
                  <?php echo Form::open(['route' => 'report.product', 'method' => 'post', 'id' => 'product-report-form']); ?>

                  <input type="hidden" name="start_date" value="1988-04-18" />
                  <input type="hidden" name="end_date" value="<?php echo e(date('Y-m-d')); ?>" />
                  <input type="hidden" name="store_id" value="0" />
                  <a id="report-link" href=""><?php echo e(trans('file.product')); ?> <?php echo e(trans('file.Report')); ?> </a>
                  <?php echo Form::close(); ?>

                </li>
                <?php endif; ?>
                <?php if($daily_sale_active): ?>
                <li>
                  <a href="<?php echo e(url('report/daily_sale/'.date('Y').'/'.date('m'))); ?>"><?php echo e(trans('file.Daily Sale')); ?></a>
                </li>
                <?php endif; ?>
                <?php if($monthly_sale_active): ?>
                <li>
                  <a href="<?php echo e(url('report/monthly_sale/'.date('Y'))); ?>"><?php echo e(trans('file.Monthly Sale')); ?></a>
                </li>
                <?php endif; ?>
                <?php if($daily_purchase_active): ?>
                <li>
                  <a href="<?php echo e(url('report/daily_purchase/'.date('Y').'/'.date('m'))); ?>"><?php echo e(trans('file.Daily Purchase')); ?></a>
                </li>
                <?php endif; ?>
                <?php if($monthly_purchase_active): ?>
                <li>
                  <a href="<?php echo e(url('report/monthly_purchase/'.date('Y'))); ?>"><?php echo e(trans('file.Monthly Purchase')); ?></a>
                </li>
                <?php endif; ?>
                <?php if($sale_report_active): ?>
                <li>
                  <?php echo Form::open(['route' => 'report.sale', 'method' => 'post', 'id' => 'sale-report-form']); ?>

                  <input type="hidden" name="start_date" value="1988-04-18" />
                  <input type="hidden" name="end_date" value="<?php echo e(date('Y-m-d')); ?>" />
                  <input type="hidden" name="store_id" value="0" />
                  <a id="sale-report-link" href=""><?php echo e(trans('file.Sale')); ?> <?php echo e(trans('file.Report')); ?></a>
                  <?php echo Form::close(); ?>

                </li>
                <?php endif; ?>
                <?php if($payment_report_active): ?>
                <li>
                  <?php echo Form::open(['route' => 'report.paymentByDate', 'method' => 'post', 'id' => 'payment-report-form']); ?>

                  <input type="hidden" name="start_date" value="1988-04-18" />
                  <input type="hidden" name="end_date" value="<?php echo e(date('Y-m-d')); ?>" />
                  <a id="payment-report-link" href=""><?php echo e(trans('file.Payment')); ?> <?php echo e(trans('file.Report')); ?></a>
                  <?php echo Form::close(); ?>

                </li>
                <?php endif; ?>
                <?php if($purchase_report_active): ?>
                <li>
                  <?php echo Form::open(['route' => 'report.purchase', 'method' => 'post', 'id' => 'purchase-report-form']); ?>

                  <input type="hidden" name="start_date" value="1988-04-18" />
                  <input type="hidden" name="end_date" value="<?php echo e(date('Y-m-d')); ?>" />
                  <input type="hidden" name="store_id" value="0" />
                  <a id="purchase-report-link" href=""><?php echo e(trans('file.Purchase')); ?> <?php echo e(trans('file.Report')); ?></a>
                  <?php echo Form::close(); ?>

                </li>
                <?php endif; ?>
                <?php if($store_stock_report_active): ?>
                <li>
                  <a href="<?php echo e(route('report.storeStock')); ?>"><?php echo e(trans('file.Store')); ?> <?php echo e(trans('file.Stock Chart')); ?></a>
                </li>
                <?php endif; ?>
                <?php if($product_qty_alert_active): ?>
                <li>
                  <a href="<?php echo e(route('report.qtyAlert')); ?>"><?php echo e(trans('file.product')); ?> <?php echo e(trans('file.Quantity')); ?> <?php echo e(trans('file.Alert')); ?></a>
                </li>
				<li>
                  <a href="<?php echo e(route('report.movement')); ?>"><?php echo e(trans('file.movement')); ?>  <?php echo e(trans('file.Report')); ?></a>
                </li>
                <?php endif; ?>
                <?php if($customer_report_active): ?>
                <li>
                  <a id="customer-report-link" href=""><?php echo e(trans('file.customer')); ?> <?php echo e(trans('file.Report')); ?></a>
                </li>
                <?php endif; ?>
                <?php if($supplier_report_active): ?>
                <li>
                  <a id="supplier-report-link" href=""><?php echo e(trans('file.Supplier')); ?> <?php echo e(trans('file.Report')); ?></a>
                </li>
                <?php endif; ?>
                <?php if($due_report_active): ?>
                <li>
                  <?php echo Form::open(['route' => 'report.dueByDate', 'method' => 'post', 'id' => 'due-report-form']); ?>

                  <input type="hidden" name="start_date" value="1988-04-18" />
                  <input type="hidden" name="end_date" value="<?php echo e(date('Y-m-d')); ?>" />
                  <a id="due-report-link" href=""><?php echo e(trans('file.Due')); ?> <?php echo e(trans('file.Report')); ?></a>
                  <?php echo Form::close(); ?>

                </li>
                <?php endif; ?>
              </ul>
            </li>
           
		   <li><a href="#setting" aria-expanded="false" data-toggle="collapse"> <i class="icon ion-ios-gear-outline"></i><?php echo e(trans('file.settings')); ?></a>
              <ul id="setting" class="collapse list-unstyled ">
                <li><a href="<?php echo e(route('role.index')); ?>"><?php echo e(trans('file.Role')); ?></a></li>
                <li><a href="<?php echo e(route('store.index')); ?>"><?php echo e(trans('file.Store')); ?></a></li>
                <li><a href="<?php echo e(route('customer_group.index')); ?>"><?php echo e(trans('file.Customer Group')); ?></a></li>
                <li><a href="<?php echo e(route('brand.index')); ?>"><?php echo e(trans('file.Brand')); ?></a></li>
                <li><a href="<?php echo e(route('tax.index')); ?>"><?php echo e(trans('file.Tax')); ?></a></li>
                <?php 
                    $general_setting_permission = DB::table('permissions')->where('name', 'general_setting')->first();
                    $general_setting_permission_active = DB::table('role_has_permissions')->where([
                        ['permission_id', $general_setting_permission->id],
                        ['role_id', $role->id]
                    ])->first();

                    $mail_setting_permission = DB::table('permissions')->where('name', 'mail_setting')->first();
                    $mail_setting_permission_active = DB::table('role_has_permissions')->where([
                        ['permission_id', $mail_setting_permission->id],
                        ['role_id', $role->id]
                    ])->first();

                    $pos_setting_permission = DB::table('permissions')->where('name', 'pos_setting')->first();
                    $pos_setting_permission_active = DB::table('role_has_permissions')->where([
                        ['permission_id', $pos_setting_permission->id],
                        ['role_id', $role->id]
                    ])->first();
                ?>
                <?php if($general_setting_permission_active): ?>
                <li><a href="<?php echo e(route('setting.general')); ?>"><?php echo e(trans('file.General Setting')); ?></a></li>
                <?php endif; ?>
                <?php if($mail_setting_permission_active): ?>
                <li><a href="<?php echo e(route('setting.mail')); ?>"><?php echo e(trans('file.Mail Setting')); ?></a></li>
                <?php endif; ?>
                <li><a href="<?php echo e(route('user.profile', ['id' => Auth::id()])); ?>"><?php echo e(trans('file.User')); ?> <?php echo e(trans('file.profile')); ?></a></li>
                <?php if($pos_setting_permission_active): ?>
                <li><a href="<?php echo e(route('setting.pos')); ?>">POS <?php echo e(trans('file.settings')); ?></a></li>
                <?php endif; ?>
				<li><a href="<?php echo e(asset('cobuns/cobun_list')); ?>"> <?php echo e(trans('file.coupons')); ?></a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="page">
      <!-- navbar-->
      <header class="header">
        <nav class="navbar">
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
                <span class="show-dashboard-label" style="cursor:pointer;font-size:18px;"  ><?php echo e(trans('file.dashboard')); ?> </span>
			    <span class="fa fa-plus-square" id="show-dashboard-in-small-size"></span>
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                
               <?php if($alert_product > 0): ?> 
                <li class="nav-item">
                      <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-item"><i class="fa fa-bell"></i><span class="badge badge-danger"><?php echo e($alert_product1); ?></span>
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                      </a>
                      <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default notifications" user="menu">
                         <?php if($alert_product > 0): ?> 
						 <li class="notifications">
                            <a href="<?php echo e(route('report.qtyAlert')); ?>" class="btn btn-link"> <i class="fa fa-exclamation-triangle"></i> <?php echo e($alert_product1); ?> product exceeds alert quantity</a>
                          </li>
						 <?php endif; ?>
                      
                      </ul>
                </li>
                <?php endif; ?>
				
				 <?php if($total_Request > 0): ?> 
                <li class="nav-item">
                      <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-item"><i class="fa fa-bell"></i><span class="badge badge-danger"><?php echo e($total_Request); ?></span>
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                      </a>
                      <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default notifications" user="menu">
                         <?php if($total_Request>0): ?>						 
                         <li class="notifications">
                            <a href="<?php echo e(asset('requests')); ?>" class="btn btn-link"> <i class="fa fa-info-circle"></i>  you have <?php echo e($total_Request); ?> Online Orders</a>
                          </li>
						 <?php endif; ?> 
                      </ul>
                </li>
                <?php endif; ?>
                
                <li class="nav-item"> 
                  
                </li>
                <li class="nav-item">
                      <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-item"><i class="fa fa-language"></i> <?php echo e(__('file.language')); ?> <i class="fa fa-angle-down"></i>
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                      </a>
                      <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                          <li>
                            <a href="<?php echo e(url('language_switch/en')); ?>" class="btn btn-link"> English</a>
                          </li>
                          <li>
                            <a href="<?php echo e(url('language_switch/es')); ?>" class="btn btn-link"> Español</a>
                          </li>
                          <li>
                            <a href="<?php echo e(url('language_switch/ar')); ?>" class="btn btn-link"> عربى</a>
                          </li>
                          <li>
                            <a href="<?php echo e(url('language_switch/fr')); ?>" class="btn btn-link"> Français</a>
                          </li>
                          <li>
                            <a href="<?php echo e(url('language_switch/de')); ?>" class="btn btn-link"> Deutsche</a>
                          </li>
                      </ul>
                </li>
                <li class="nav-item">
                      <a rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-item"><i class="fa fa-user"></i> <?php echo e(strtoupper(Auth::user()->name)); ?> <i class="fa fa-angle-down"></i>
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                      </a>
                      <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                          <li> 
                            <a href="<?php echo e(route('user.profile', ['id' => Auth::id()])); ?>"><i class="fa fa-user"></i> <?php echo e(trans('file.profile')); ?></a>
                          </li>
                          <li> 
                            <a href="<?php echo e(route('setting.general')); ?>"><i class="fa fa-cog"></i> <?php echo e(trans('file.settings')); ?></a>
                          </li>
                          <li>
                            <a href="<?php echo e(route('logout')); ?>"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i>
                                <?php echo e(trans('file.logout')); ?>

                            </a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                <?php echo csrf_field(); ?>
                            </form>
                          </li>
                      </ul>
                </li> 
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <!-- modal section -->
      <div id="expense-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.add')); ?> <?php echo e(trans('file.Expense')); ?></h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                  <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                    <?php echo Form::open(['route' => 'expenses.store', 'method' => 'post']); ?>

                    <?php 
                      $ezpos_expense_category_list = DB::table('expense_categories')->where('is_active', true)->get();
                      $ezpos_store_list = DB::table('stores')->where('is_active', true)->get();
                    ?>
                      <div class="form-group">
                          <label><strong><?php echo e(trans('file.date')); ?> *</strong></label>
                          <input type="text" name="date" value="<?php echo e(date('d-m-Y')); ?>" required class="form-control date">
                      </div>
                      <div class="form-group">
                          <label><strong><?php echo e(trans('file.reference')); ?></strong></label>
                          <p><?php echo e('er-' . date("Ymd") . '-'. date("his")); ?></p>
                      </div>
                      <div class="form-group">
                          <label><strong><?php echo e(trans('file.Expense Category')); ?> *</strong></label>
                          <select name="expense_category_id" class="selectpicker form-control" required data-live-search="true" data-live-search-style="begins" title="Select Expense Category...">
                              <?php $__currentLoopData = $ezpos_expense_category_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($expense_category->id); ?>"><?php echo e($expense_category->name . ' (' . $expense_category->code. ')'); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <label><strong><?php echo e(trans('file.Store')); ?> *</strong></label>
                          <select name="store_id" class="selectpicker form-control" required data-live-search="true" data-live-search-style="begins" title="Select store...">
                              <?php $__currentLoopData = $ezpos_store_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($store->id); ?>"><?php echo e($store->name); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select>
                      </div>
                      <div class="form-group">
                          <label><strong><?php echo e(trans('file.Amount')); ?> *</strong></label>
                          <input type="number" name="amount" step="any" required class="form-control">
                      </div>
                      <div class="form-group">
                          <label><strong><?php echo e(trans('file.Note')); ?></strong></label>
                          <textarea name="note" rows="5" class="form-control"></textarea>
                      </div>
                      <div class="form-group">
                          <button type="submit" class="btn btn-primary"><?php echo e(trans('file.submit')); ?></button>
                      </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
      </div>

      <div id="customer-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.customer')); ?> <?php echo e(trans('file.Report')); ?></h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                  <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                    <?php echo Form::open(['route' => 'report.customer', 'method' => 'post']); ?>

                    <?php 
                      $ezpos_customer_list = DB::table('customers')->where('is_active', true)->get();
                    ?>
                      <div class="form-group">
                          <label><strong><?php echo e(trans('file.customer')); ?> *</strong></label>
                          <select name="customer_id" class="selectpicker form-control" required data-live-search="true" id="customer-id" data-live-search-style="begins" title="Select customer...">
                              <?php $__currentLoopData = $ezpos_customer_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($customer->id); ?>"><?php echo e($customer->name . ' (' . $customer->phone_number. ')'); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select>
                      </div>

                      <input type="hidden" name="start_date" value="1988-04-18" />
                      <input type="hidden" name="end_date" value="<?php echo e(date('Y-m-d')); ?>" />

                      <div class="form-group">
                          <button type="submit" class="btn btn-primary"><?php echo e(trans('file.submit')); ?></button>
                      </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
      </div>

      <div id="supplier-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title"><?php echo e(trans('file.Supplier')); ?> <?php echo e(trans('file.Report')); ?></h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                  <p class="italic"><small><?php echo e(trans('file.The field labels marked with * are required input fields')); ?>.</small></p>
                    <?php echo Form::open(['route' => 'report.supplier', 'method' => 'post']); ?>

                    <?php 
                      $ezpos_supplier_list = DB::table('suppliers')->where('is_active', true)->get();
                    ?>
                      <div class="form-group">
                          <label><strong><?php echo e(trans('file.Supplier')); ?> *</strong></label>
                          <select name="supplier_id" class="selectpicker form-control" required data-live-search="true" id="supplier-id" data-live-search-style="begins" title="Select Supplier...">
                              <?php $__currentLoopData = $ezpos_supplier_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supplier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($supplier->id); ?>"><?php echo e($supplier->name . ' (' . $supplier->phone_number. ')'); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </select>
                      </div>

                      <input type="hidden" name="start_date" value="1988-04-18" />
                      <input type="hidden" name="end_date" value="<?php echo e(date('Y-m-d')); ?>" />

                      <div class="form-group">
                          <button type="submit" class="btn btn-primary"><?php echo e(trans('file.submit')); ?></button>
                      </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
      </div>
      <!-- Counts Section -->
      
      <!-- Header Section-->
      
      <!-- Statistics Section-->
     
      <!-- Updates Section -->
      
      <?php echo $__env->yieldContent('content'); ?>
      <footer class="main-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <p>&copy; <?php echo e($general_setting->site_title); ?></p>
            </div>
            <div class="col-sm-6 text-right">
              <p><?php echo e(trans('file.Developed')); ?> <?php echo e(trans('file.By')); ?> <a href="http://iraq-soft.info" class="external">IraqSoft</a></p>
            </div>
          </div>
        </div>
      </footer>
    </div>
    <?php echo $__env->yieldContent('scripts'); ?>
    <script type="text/javascript">
       
	  $("#show-dashboard-in-small-size").click(function(){
		  $('.side-navbar').css('display','block');
	  });
	
	 $("#hide-dashboard-in-small-size").click(function(){
		  $('.side-navbar').css('display','none');
	  });
	
	
      var date = $('#date');
    date.datepicker({
     format: "dd-mm-yyyy",
     startDate: "<?php echo date('d-m-Y', strtotime('')); ?>",
     autoclose: true,
     todayHighlight: true
     });
      
	  
	   //auto hide alert
     $(".alert").delay(4000).slideUp(200, function() {
        $(this).alert('close');
     });
	 
	 
      $("a#add-expense").click(function(e){
        e.preventDefault();
        $('#expense-modal').modal();
      });

      $("a#profitLoss-link").click(function(e){
        e.preventDefault();
        $("#profitLoss-report-form").submit();
      });

      $("a#report-link").click(function(e){
        e.preventDefault();
        $("#product-report-form").submit();
      });

      $("a#purchase-report-link").click(function(e){
        e.preventDefault();
        $("#purchase-report-form").submit();
      });

      $("a#sale-report-link").click(function(e){
        e.preventDefault();
        $("#sale-report-form").submit();
      });

      $("a#payment-report-link").click(function(e){
        e.preventDefault();
        $("#payment-report-form").submit();
      });

      $("a#customer-report-link").click(function(e){
        e.preventDefault();
        $('#customer-modal').modal();
      });

      $("a#supplier-report-link").click(function(e){
        e.preventDefault();
        $('#supplier-modal').modal();
      });

      $("a#due-report-link").click(function(e){
        e.preventDefault();
        $("#due-report-form").submit();
      });

      $('.selectpicker').selectpicker({
          style: 'btn-link',
      });
	  
	  $(window).on('load', function() {
        $(document).responsiveTables();
     });
    </script>
  </body>
</html>