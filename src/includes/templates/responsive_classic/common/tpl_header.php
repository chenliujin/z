<?php
include_once('z/model/customers.php');

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
  <ul class="back">
    <li><?php echo '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'; ?><?php echo HEADER_TITLE_CATALOG; ?></a></li> 
  </ul>
	
	<div style="clear:both"></div>

	<div id="navMainSearch">
		<?php require(DIR_WS_MODULES . 'sideboxes/search_header.php'); ?>
	</div>
</div>
</div>
<?php  } ?>


<div>
<div id="nav-overlay"></div>

<div id="nav-flyout-list">
	<div id="nav-flyout-categories" class="nav-flyout">
		xxx
	</div>
	<div id="nav-flyout-account" class="nav-flyout">
		<?php if (!$_SESSION['customer_id']) {?>
		<a href="<?php echo zen_href_link(FILENAME_LOGIN, '', 'SSL'); ?>" class="nav-link nav-item">
			<span class="nav-text"><?php echo HEADER_TITLE_LOGIN; ?></span>
		</a>
		<?php } ?>
		<a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>" class="nav-link nav-item">
			<span class="nav-text"><?php echo HEADER_TITLE_MY_ACCOUNT; ?></span>
		</a>
		<a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>" class="nav-link <?php if ($_SESSION['customer_id']) echo 'nav-item';?> ">
			<span class="nav-text">My Orders</span>
		</a>
		<?php if ($_SESSION['customer_id']) { ?>
		<a href="<?php echo zen_href_link(FILENAME_LOGOFF, '', 'SSL'); ?>" class="nav-link">
			<span class="nav-text"><?php echo HEADER_TITLE_LOGOFF; ?></span>
		</a>
		<?php } ?>
	</div>
</div>

<div class="nav-left">
	<a href="#" class="nav-a">
		Categories
	</a>
</div>
<div class="nav-tool">
	<a href="<?php echo zen_href_link(FILENAME_ACCOUNT, '', 'SSL'); ?>" class="nav-a nav-menu">
		<div class="nav-account">
			<span class="sign-in">
			<?php
				if (empty($_SESSION['customer_id'])) {
					echo 'Sign in';
				} else {
					echo 'Hello, ' . \z\customers::get_customer_nickname();
				}
			?>
			</span><br />
			<span><?php echo HEADER_TITLE_MY_ACCOUNT; ?></span>
		</div>
	</a>

	<a href="<?php echo zen_href_link(FILENAME_SHOPPING_CART, '', 'NONSSL'); ?>" class="nav-a">
		<div class="nav-cart">
			<u></u>
			<span>
			<?php echo HEADER_TITLE_CART_CONTENTS; ?>&nbsp;(<span class="nav-cart-count"><?php echo $_SESSION['cart']->count_contents(); ?></span>)
			</span>
		</div>
	</a>
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

				$('#nav-flyout-account').css('display', 'block');
				$('#nav-flyout-account').css('top', $this.offset().top + 42);
				$('#nav-flyout-account').css('left', $this.offset().left + 10);
			}
		).bind(
			'mouseleave',
			function(){
				var $this = $(this);
				$overlay.stop(true, true).fadeOut(200);

				$('.nav-flyout').hide();
			}
		);

		$('.nav-flyout').bind(
			'mouseover',
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

	});
</script>

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
