<?php
include_once('z/model/customers.php');
include_once('z/model/categories.php');

  if ($messageStack->size('header') > 0) {
    echo $messageStack->output('header');
  }
  if (isset($_GET['error_message']) && zen_not_null($_GET['error_message'])) {
    echo zen_output_string_protected(urldecode($_GET['error_message']));
  }
  if (isset($_GET['info_message']) && zen_not_null($_GET['info_message'])) {
   echo zen_output_string_protected($_GET['info_message']);
}

if (!isset($flag_disable_header) || !$flag_disable_header) {
?>

<div id="headerWrapper">

<div id="navMainWrapper" class="group onerow-fluid">
<?php 
 if ( $detect->isMobile() && !$detect->isTablet() || $_SESSION['layoutType'] == 'mobile' ) {
echo '<div class="header Fixed"><a href="#menu" title="Menu"><i class="fa fa-bars"></i></a></div>';
 } else if ( $detect->isTablet() || $_SESSION['layoutType'] == 'tablet' ){
echo '<div class="header Fixed"><a href="#menu" title="Menu"><i class="fa fa-bars"></i></a></div>';
} else { 
}
if ( $detect->isMobile() && !$detect->isTablet() || $_SESSION['layoutType'] == 'mobile' ) { ?>
  
<div id="navMain">
  <ul>
    <li><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'; ?><i class="fa fa-home" title="Home"></i></a></li>
    <li><a href="#top"><i class="fa fa-arrow-circle-up" title="Back to Top"></i></a></li>
<?php if ($_SESSION['customer_id']) { ?>
    <li><a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>"><i class="fa fa-sign-out" title="Log Off"></i></a></li>
<?php if ($_SESSION['cart']->count_contents() != 0) { ?>
    <li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><i class="fa fa-user" title="My Account"></i></a></li>
<?php } else { ?>
    <li class="last"><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><i class="fa fa-user" title="My Account"></i></a></li>
<?php } 
      } else {
        if (STORE_STATUS == '0') {
if ($_SESSION['cart']->count_contents() != 0) { ?>
    <li><a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>"><i class="fa fa-sign-in" title="Log In"></i></a></li>
<?php } else { ?>
    <li class="last"><a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>"><i class="fa fa-sign-in" title="Log In"></i></a></li>
<?php } 
  } 
} 
?>

<?php if ($_SESSION['cart']->count_contents() != 0) { ?>
    <li><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'); ?>"><i class="fa fa-shopping-cart" title="Shopping Cart"></i></a></li>
    <li class="last"><a class="blue" href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'); ?>"><i class="fa fa-check-square" title="Checkout"></i></a></li>
<?php }?>
  </ul>
<div id="navMainSearch" class="forward"><?php require(DIR_WS_MODULES . 'sideboxes/search_header.php'); ?></div>
</div>
</div>

<?php  } else if ( $detect->isTablet() || $_SESSION['layoutType'] == 'tablet' ){ ?> 

<div id="navMain">
    <ul>
<li class="hide"><a href="#top"><i class="fa fa-arrow-circle-up" title="Back to Top"></i></a></li>
    <li><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'; ?><?php echo HEADER_TITLE_CATALOG; ?></a></li>
<?php if ($_SESSION['customer_id']) { ?>
    <li><a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>"><?php echo HEADER_TITLE_LOGOFF; ?></a></li>
<?php if ($_SESSION['cart']->count_contents() != 0) { ?>
<li><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><?php echo HEADER_TITLE_MY_ACCOUNT; ?></a></li>
	    <?php } else { ?>
<li class="last"><a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>"><?php echo HEADER_TITLE_MY_ACCOUNT; ?></a></li>
      
      <?php } ?>
<?php
      } else {
        if (STORE_STATUS == '0') {
?>
<?php if ($_SESSION['cart']->count_contents() != 0) { ?>
    <li><a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>"><?php echo HEADER_TITLE_LOGIN; ?></a></li>
	    <?php } else { ?>
    <li class="last"><a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>"><?php echo HEADER_TITLE_LOGIN; ?></a></li>

	    <?php } ?>
<?php } } ?>

<?php if ($_SESSION['cart']->count_contents() != 0) { ?>
    <li><a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'); ?>"><?php echo HEADER_TITLE_CART_CONTENTS; ?></a></li>
    <li class="last"><a class="blue" href="<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'); ?>"><?php echo HEADER_TITLE_CHECKOUT; ?></a></li>
<?php }?>
</ul>
<div id="navMainSearch" class="forward"><?php require(DIR_WS_MODULES . 'sideboxes/search_header.php'); ?></div>
</div>
</div>
<?php  } else { ?>

<div id="navMain">
	<div id="logo">
		<a href="<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>">
			<span class="nav-text">Zdaylight</span>
		</a>
	</div>
	

	<div id="navMainSearch">
		<?php require(DIR_WS_MODULES . 'sideboxes/search_header.php'); ?>
	</div>
</div>
</div>
<?php  } ?>


<div id="nav" class="nav">
	<div id="nav-overlay"></div>

<div id="nav-flyout-list">
	<div id="nav-flyout-categories" class="nav-flyout-categories nav-flyout">
		<div class="nav-flyout-content" style="width: 180px; float:left">
			<?php $data = \z\categories::root(); ?>
			<?php foreach ($data as $category) {?>
			<a href="<?php echo zen_href_link( FILENAME_DEFAULT, $category->path ); ?>" class="nav-hasSubcate nav-item nav-link">
				<span class="nav-text"><?php echo $category->categories_name; ?></span>
			</a>
			<?php } ?>
			<a href="#" class="nav-link nav-item">All Categories</a>
		</div>
		<div class="nav-subcates">
			<?php foreach ($data as $category) { ?>
			<div class="nav-subcate">
				<?php 
				if (!empty($category->children)) {
					foreach ($category->children as $categories_id) {
						$subcate2 = \z\categories::get_category($categories_id);
						?>
						<div class="nav-column">
							<a href="<?php echo zen_href_link( FILENAME_DEFAULT, $subcate2->path ); ?>" class="nav-item">
								<span class="nav-title">
									<span class="nav-text">
									<?php echo $subcate2->categories_name; ?>
									</span>
								</span>
							</a>
						<?php
						if (!empty($subcate2->children)) {
							foreach ($subcate2->children as $categories_id) {
								$subcate3 = \z\categories::get_category($categories_id);
								?>
								<a href="<?php echo zen_href_link( FILENAME_DEFAULT, $subcate3->path ); ?>" class="nav-item">
									<span class="nav-text">
										<?php echo $subcate3->categories_name; ?>
									</span>
								</a>
								<?php
							}
						}
						?>
						</div>
						<?php
					}
				}
				?>
			</div>
			<?php } ?>
		</div>
	</div>
	<div id="nav-flyout-account" class="nav-flyout">
		<div class="nav-flyout-content">
		<?php if (!$_SESSION['customer_id']) {?>
		<a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>" class="nav-link nav-item">
			<span class="nav-text"><?php echo HEADER_TITLE_LOGIN; ?></span>
		</a>
		<?php } ?>
		<a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>" class="nav-link nav-item">
			<span class="nav-text"><?php echo HEADER_TITLE_MY_ACCOUNT; ?></span>
		</a>
		<a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>" class="nav-link nav-item">
			<span class="nav-text">My Orders</span>
		</a>
		<?php if ($_SESSION['customer_id']) { ?>
		<a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>" class="nav-link nav-item">
			<span class="nav-text"><?php echo HEADER_TITLE_LOGOFF; ?></span>
		</a>
		<?php } ?>
		</div>
	</div>
</div>

<div id="nav-categories">
	<a href="#" class="a1 nav-menu">
		<span class="nav-content">Departments</span>
	</a>
</div>
<div id="nav-cart">
	<a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'); ?>">
		<span class="nav-content">
			<u></u>
			<?php echo HEADER_TITLE_CART_CONTENTS; ?>&nbsp;(<span class="nav-cart-count"><?php echo $_SESSION['cart']->count_contents(); ?></span>)
		</span>
	</a>
</div>

<div id="nav-account">
	<a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>" class="a1 nav-menu">
		<span class="nav-content">
			<!--
			<span class="sign-in">
				<?php
				if (empty($_SESSION['customer_id'])) {
					echo 'Sign in';
				} else {
					echo 'Hello, ' . \z\customers::get_customer_nickname();
				}
				?>
			</span><br />
			-->
			<span>
				<?php echo HEADER_TITLE_MY_ACCOUNT; ?>
			</span>
		</span>
	</a>
</div>
<div id="nav-menus">
	<!--
	<a href="#">
		<span class="nav-content">
			Browsing History
		</span>
	</a>
	<?php
	if (SHOW_CATEGORIES_BOX_SPECIALS == 'true') {
		$show_this = $db->Execute("select s.products_id from " . TABLE_SPECIALS . " s where s.status= 1 limit 1");
		if ($show_this->RecordCount() > 0) {
			?>
			<a href="<?php echo zen_href_link(FILENAME_SPECIALS); ?>">
				<span class="nav-content">
					<?php echo CATEGORIES_BOX_HEADING_SPECIALS; ?>
				</span>
			</a>
			<?php
		}
	}

	if (SHOW_CATEGORIES_BOX_PRODUCTS_NEW == 'true') {
		$display_limit = zen_get_new_date_range();

		$show_this = $db->Execute("select p.products_id
			from " . TABLE_PRODUCTS . " p
			where p.products_status = 1 " . $display_limit . " limit 1");
		if ($show_this->RecordCount() > 0) {
			?>
			<a href="<?php echo zen_href_link(FILENAME_PRODUCTS_NEW); ?>">
				<span class="nav-content">
					<?php echo CATEGORIES_BOX_HEADING_WHATS_NEW; ?>
				</span>
			</a>
			<?php
		}
	}

	if (SHOW_CATEGORIES_BOX_FEATURED_PRODUCTS == 'true') {
		$show_this = $db->Execute("select products_id from " . TABLE_FEATURED . " where status= 1 limit 1");
		if ($show_this->RecordCount() > 0) {
			?>
			<a href="<?php echo zen_href_link(FILENAME_FEATURED_PRODUCTS); ?>">
				<span class="nav-content">
					<?php echo CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS; ?>
				</span>
			</a>
			<?php
		}
	}
	?>

	<a href="<?php echo zen_href_link(FILENAME_PRODUCTS_ALL); ?>">
		<span class="nav-content">
			<?php echo CATEGORIES_BOX_HEADING_PRODUCTS_ALL; ?>
		</span>
	</a>
	-->
</div>

</div>

<script>
	$(function(){
		var $menu 		= $('.nav-menu');
		var $overlay 	= $('#nav-overlay');

		$menu.bind(
			'mouseenter',
			function() {
				var $this = $(this);

				$overlay.width(document.body.scrollWidth);
				$overlay.height(document.body.scrollHeight);
				$overlay.stop(false, false).fadeTo(200, 0.6);

				var $id = $this.parent().attr('id').replace('nav', 'nav-flyout');

				$('#' + $id).css('display', 'block');
				$('#' + $id).css('top', $this.offset().top + $this.height());
				$('#' + $id).css('left', $this.offset().left);
			}
		).bind(
			'mouseleave',
			function(){
				var $this = $(this);
				$overlay.stop(true, true).fadeOut(200);

				$('.nav-flyout').hide();
				$('.nav-subcates').hide().css('width', 0);
				$('.nav-subcate').hide();
			}
		);

		$('.nav-flyout').bind(
			'mouseenter',
			function() {
				var $this = $(this);
				$this.show();
				$overlay.stop(false, false).fadeTo(200, 0.6);

			}
		).bind(
			'mouseleave',
			function() {
				var $this = $(this);
				$this.hide();

				$overlay.stop(true, true).fadeOut(200);
			}
		);


		$('.nav-hasSubcate').each(
			function(i) {
				$(this).mouseenter(
					function() {
						$('.nav-subcate').hide();
						$('.nav-subcate:eq(' + i + ')').show();
						$('.nav-subcates').show().animate({width: 500}, 250);
					}
				);

				$(this).mouseleave(
					function() {
						//$('.nav-subcate:eq(' + i + ')').hide();
						//$('.nav-subcates').hide();
					}
				);
			}
		);

		$('.nav-subcate').bind(
			'mouseenter',
			function() {
				$(this).show();
			}
		);
	});
</script>

<!--
<div id="logoWrapper" class="group onerow-fluid">
<div id="logo">
<?php 

if (SHOW_BANNERS_GROUP_SET2 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET2)) { ?>
	<div id="taglineWrapper"> <?php

	if (SHOW_BANNERS_GROUP_SET2 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET2)) {
		if ($banner->RecordCount() > 0) { ?>
			<div id="bannerTwo" class="banners"><?php echo zen_display_banner('static', $banner);?></div> <?php
		}
	} ?>

	</div> <?php 
} ?>
  </div>
</div>
-->

<?php if ( $detect->isMobile() && !$detect->isTablet() || $_SESSION['layoutType'] == 'mobile' ) { ?>
  <div id="navMainSearch1" class="forward"><?php require(DIR_WS_MODULES . 'sideboxes/search_header.php'); ?></div>
<?php  } else if ( $detect->isTablet() || $_SESSION['layoutType'] == 'tablet' ) { ?>
  <div id="navMainSearch1" class="forward"><?php require(DIR_WS_MODULES . 'sideboxes/search_header.php'); ?></div>
<?php  } else if ( $_SESSION['layoutType'] == 'full' ) {
  } else {
  }
?>

<?php if (EZPAGES_STATUS_HEADER == '1' or (EZPAGES_STATUS_HEADER == '2' and (strstr(EXCLUDE_ADMIN_IP_FOR_MAINTENANCE, $_SERVER['REMOTE_ADDR'])))) { ?>
<?php   require($template->get_template_dir('tpl_ezpages_bar_header.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_ezpages_bar_header.php'); ?>
<?php } ?>
</div>

<?php } ?>
