<div class="centerColumn" id="advSearchResultsDefault">

<h1 id="advSearchResultsDefaultHeading"><?php echo HEADING_TITLE; ?></h1>

<?php
if ($do_filter_list || PRODUCT_LIST_ALPHA_SORTER == 'true') {
	$form = zen_draw_form('filter', zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT), 'get');

	echo $form; 
	?>
<div id="filter-wrapper">
	<?php
	echo zen_post_all_get_params('currency');

	require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCT_LISTING_ALPHA_SORTER));
	?>
</div>
</form>
	<?php
}

require($template->get_template_dir('tpl_modules_product_listing.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_product_listing.php');
?>

<div class="buttonRow back"><?php echo '<a href="' . zen_href_link(FILENAME_ADVANCED_SEARCH, zen_get_all_get_params(array('sort', 'page', 'x', 'y')), 'NONSSL', true, false) . '">' . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?></div>

</div>
