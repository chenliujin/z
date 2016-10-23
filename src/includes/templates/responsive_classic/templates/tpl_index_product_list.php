<div class="centerColumn" id="indexProductList">

<div id="cat-top" class="group">
<div id="cat-left" class="back">
<h1 id="productListHeading"><?php echo $current_categories_name; ?></h1>

<?php
if (PRODUCT_LIST_CATEGORIES_IMAGE_STATUS == 'true') {
	if ($categories_image = zen_get_categories_image($current_category_id)) {
		?>
<div id="categoryImgListing" class="categoryImg"><?php echo zen_image(DIR_WS_IMAGES . $categories_image, '', CATEGORY_ICON_IMAGE_WIDTH, CATEGORY_ICON_IMAGE_HEIGHT); ?></div>
		<?php
	}
} 
?>
</div>

<?php
if ($current_categories_description != '') {
	?>
<div id="indexProductListCatDescription" class="content"><?php echo $current_categories_description;  ?></div>
	<?php } 
?>
</div>

<?php if ($listing->RecordCount()) { ?>
<div id="filter-wrapper" class="group">
<?php } ?>

<?php
$check_for_alpha = $listing_sql;
$check_for_alpha = $db->Execute($check_for_alpha);

if ($do_filter_list || isset($_GET['alpha_filter_id']) || ($check_for_alpha->RecordCount() > 0 && PRODUCT_LIST_ALPHA_SORTER == 'true')) {
	$form = zen_draw_form('filter', zen_href_link(FILENAME_DEFAULT), 'get') . '<label class="inputLabel">' .TEXT_SHOW . '</label>';
	echo $form;
	echo zen_draw_hidden_field('main_page', FILENAME_DEFAULT);

	// draw cPath if known
	if (!$getoption_set) {
		echo zen_draw_hidden_field('cPath', $cPath);
	} else {
		// draw manufacturers_id
		echo zen_draw_hidden_field($get_option_variable, $_GET[$get_option_variable]);
	}

	if (isset($_GET['music_genre_id']) && $_GET['music_genre_id'] != '') echo zen_draw_hidden_field('music_genre_id', $_GET['music_genre_id']);

	if (isset($_GET['record_company_id']) && $_GET['record_company_id'] != '') echo zen_draw_hidden_field('record_company_id', $_GET['record_company_id']);

	if (isset($_GET['typefilter']) && $_GET['typefilter'] != '') echo zen_draw_hidden_field('typefilter', $_GET['typefilter']);

	if ($get_option_variable != 'manufacturers_id' && isset($_GET['manufacturers_id']) && $_GET['manufacturers_id'] > 0) {
		echo zen_draw_hidden_field('manufacturers_id', $_GET['manufacturers_id']);
	}

	echo zen_draw_hidden_field('sort', $_GET['sort']);

	// draw filter_id (ie: category/mfg depending on $options)
	if ($do_filter_list) {
		echo zen_draw_pull_down_menu('filter_id', $options, (isset($_GET['filter_id']) ? $_GET['filter_id'] : ''), 'onchange="this.form.submit()"');
	}

	// draw alpha sorter
	require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCT_LISTING_ALPHA_SORTER));
	?>
</form>
	<?php
}
?>

<?php if ($listing->RecordCount()) { ?>
</div>
<?php } 

require($template->get_template_dir('tpl_modules_product_listing.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_product_listing.php');
?>


<?php
if ($error_categories==true) {
	$check_category = $db->Execute("select categories_id from " . TABLE_CATEGORIES . " where categories_id='" . $cPath . "'");
	if ($check_category->RecordCount() == 0) {
		$new_products_category_id = '0';
		$cPath= '';
	}

	$show_display_category = $db->Execute(SQL_SHOW_PRODUCT_INFO_MISSING);

	while (!$show_display_category->EOF) {
		if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_MISSING_FEATURED_PRODUCTS') {
			require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php');
		} 

		if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_MISSING_SPECIALS_PRODUCTS') {
			require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php');
		}

		if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_MISSING_NEW_PRODUCTS') {
			require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php');
		} 

		if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_MISSING_UPCOMING') {
			include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS));
		}

		$show_display_category->MoveNext();
	} 
}

$show_display_category = $db->Execute(SQL_SHOW_PRODUCT_INFO_LISTING_BELOW);

if ($error_categories == false and $show_display_category->RecordCount() > 0) {
	$show_display_category = $db->Execute(SQL_SHOW_PRODUCT_INFO_LISTING_BELOW);
	while (!$show_display_category->EOF) {
		if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_LISTING_BELOW_FEATURED_PRODUCTS') {
			require($template->get_template_dir('tpl_modules_featured_products.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_featured_products.php');
		}

		if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_LISTING_BELOW_SPECIALS_PRODUCTS') {
			require($template->get_template_dir('tpl_modules_specials_default.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_specials_default.php');
		} 

		if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_LISTING_BELOW_NEW_PRODUCTS') {
			require($template->get_template_dir('tpl_modules_whats_new.php',DIR_WS_TEMPLATE, $current_page_base,'templates'). '/tpl_modules_whats_new.php');
		} 

		if ($show_display_category->fields['configuration_key'] == 'SHOW_PRODUCT_INFO_LISTING_BELOW_UPCOMING') {
			include(DIR_WS_MODULES . zen_get_module_directory(FILENAME_UPCOMING_PRODUCTS));
		}

		$show_display_category->MoveNext();
	}
}
?>

</div>
