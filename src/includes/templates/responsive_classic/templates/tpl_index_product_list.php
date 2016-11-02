<div class="centerColumn" id="indexProductList">

<div id="cat-top" class="group">
<div id="cat-left" class="back">

<?php
if (PRODUCT_LIST_CATEGORIES_IMAGE_STATUS == 'true') {
	if ($categories_image = zen_get_categories_image($current_category_id)) {
		?>
<div id="categoryImgListing" class="categoryImg">
	<?php echo zen_image(DIR_WS_IMAGES . $categories_image, '', CATEGORY_ICON_IMAGE_WIDTH, CATEGORY_ICON_IMAGE_HEIGHT); ?>
</div>
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

<?php 
if ($do_filter_list) { 
	?>
<div id="filter-wrapper" class="group">
	<?php 
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

	echo zen_draw_pull_down_menu('filter_id', $options, (isset($_GET['filter_id']) ? $_GET['filter_id'] : ''), 'onchange="this.form.submit()"');
	?>
	</form>
</div>
	<?php 
} 

require($template->get_template_dir('tpl_modules_product_listing.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_product_listing.php');

?>

</div>
