<?php

// the following IF statement can be duplicated/modified as needed to set additional flags
if (in_array($current_page_base,explode(",",'list_pages_to_skip_all_right_sideboxes_on_here,separated_by_commas,and_no_spaces')) ) {
	$flag_disable_right = true;
}

// ZCAdditions.com, Responsive Template Default (BOF-addition 1 of 1)
if ($flag_disable_right or COLUMN_RIGHT_STATUS == '0') {
	$box_width_right = preg_replace('/[^0-9]/', '', '0');
	$box_width_right_new = '';
} else {
	$box_width_right = COLUMN_WIDTH_RIGHT;
	$box_width_right = preg_replace('/[^0-9]/', '', $box_width_right);
	$box_width_right_new = 'col' . $box_width_right;
}

if ($flag_disable_left or COLUMN_LEFT_STATUS == '0') {
	$box_width_left = preg_replace('/[^0-9]/', '', '0');
	$box_width_left_new = '';
} else {
	$box_width_left = COLUMN_WIDTH_LEFT;
	$box_width_left = preg_replace('/[^0-9]/', '', $box_width_left);
	$box_width_left_new = 'col' . $box_width_left;
}

$side_columns_total = $box_width_left + $box_width_right;
$center_column = '970'; // This value should not be altered
$center_column_width = $center_column - $side_columns_total;
// ZCAdditions.com, Responsive Template Default (EOF-addition 1 of 1)


$header_template = 'tpl_header.php';
$footer_template = 'tpl_footer.php';
$left_column_file = 'column_left.php';
$right_column_file = 'column_right.php';
$body_id = ($this_is_home_page) ? 'indexHome' : str_replace('_', '', $_GET['main_page']);
?>
<body id="<?php echo $body_id . 'Body'; ?>"<?php if($zv_onload !='') echo ' onload="'.$zv_onload.'"'; ?>>

<?php
if ( $detect->isMobile() && !$detect->isTablet() || $_SESSION['layoutType'] == 'mobile' ) {
	echo '<div id="page">';
} else if ( $detect->isTablet() || $_SESSION['layoutType'] == 'tablet' ){
	echo '<div id="page">';
} else {
	//
}
?>

<?php
if (SHOW_BANNERS_GROUP_SET1 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET1)) {
	if ($banner->RecordCount() > 0) {
?>
<div id="bannerOne" class="banners"><?php echo zen_display_banner('static', $banner); ?></div>
<?php
	}
}
?>

<div id="mainWrapper">
<?php
/**
 * prepares and displays header output
 *
 */
if (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_HEADER_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == '')) {
	$flag_disable_header = true;
}
require($template->get_template_dir('tpl_header.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_header.php');?>

<div id="contentMainWrapper">
<?php
if (
	COLUMN_LEFT_STATUS == 0 
	|| (CUSTOMERS_APPROVAL == '1' and $_SESSION['customer_id'] == '') 
	|| (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_COLUMN_LEFT_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == ''))
) {
	// global disable of column_left
	$flag_disable_left = true;
}
if (!isset($flag_disable_left) || !$flag_disable_left) {
?>
  <div class="<?php echo $box_width_left_new; ?>">
	<?php 
	require(DIR_WS_MODULES . zen_get_module_directory('column_left.php')); 
	?>
  </div>
<?php
}
?>

  <div class="<?php echo 'col' . $center_column_width; ?>">
<?php if (DEFINE_BREADCRUMB_STATUS == '1' || (DEFINE_BREADCRUMB_STATUS == '2' && !$this_is_home_page) ) { ?>
	<div id="navBreadCrumb">
		<?php echo $breadcrumb->trail(BREAD_CRUMBS_SEPARATOR); ?>
	</div>
<?php } ?>

<?php
if (SHOW_BANNERS_GROUP_SET3 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET3)) {
	if ($banner->RecordCount() > 0) {
?>
	<div id="bannerThree" class="banners"><?php echo zen_display_banner('static', $banner); ?></div>
<?php
	}
}
?>

<!-- bof upload alerts -->
<?php if ($messageStack->size('upload') > 0) echo $messageStack->output('upload'); ?>
<!-- eof upload alerts -->

<?php
/**
 * prepares and displays center column
 *
 */
require($body_code);
?>

<?php
if (SHOW_BANNERS_GROUP_SET4 != '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET4)) {
	if ($banner->RecordCount() > 0) {
?>
	<div id="bannerFour" class="banners"><?php echo zen_display_banner('static', $banner); ?></div>
<?php
	}
}
?>
  </div>
</div>

<?php
/**
 * prepares and displays footer output
 *
 */
if (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_FOOTER_OFF == 'true' and ($_SESSION['customers_authorization'] != 0 or $_SESSION['customer_id'] == '')) {
	$flag_disable_footer = true;
}
require($template->get_template_dir('tpl_footer.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_footer.php');
?>

</div>
<!--bof- parse time display -->
<?php
if (DISPLAY_PAGE_PARSE_TIME == 'true') {
?>
<div class="smallText center">Parse Time: <?php echo $parse_time; ?> - Number of Queries: <?php echo $db->queryCount(); ?> - Query Time: <?php echo $db->queryTime(); ?></div>
<?php
}
?>
<!--eof- parse time display -->

<?php
if  ($detect->isMobile() && !$detect->isTablet() || $_SESSION['layoutType'] == 'mobile' ) {
	echo '</div>';
} else if ( $detect->isTablet() || $_SESSION['layoutType'] == 'tablet' ){
	echo '</div>';
} else {
	//
}
?>

<?php /* add any end-of-page code via an observer class */
$zco_notifier->notify('NOTIFY_FOOTER_END', $current_page);
?>
</body>
