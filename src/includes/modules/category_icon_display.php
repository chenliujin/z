<?php
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}
if ($cPath == '' || $cPath == 0) {
  $cPath= zen_get_product_path((int)$_GET['products_id']);
}
if (!isset($_GET['cPath']) || $_GET['cPath'] == '') $_GET['cPath'] = $cPath;

$cPath_new = zen_get_path(zen_get_products_category_id((int)$_GET['products_id']));
switch(true) {
  case ($module_show_categories=='1'):
  $align='left';
  break;
  case ($module_show_categories=='2'):
  $align='center';
  break;
  case ($module_show_categories=='3'):
  $align='right';
  break;
}

$category_icon_display_name = zen_get_categories_name((int)$current_category_id);
$category_icon_display_image = zen_get_categories_image((int)$current_category_id);

switch(true) {
  // name only
  case (PRODUCT_INFO_CATEGORIES_IMAGE_STATUS == 1):
    $category_icon_display_image = '';
    break;
  // name and image but name only when blank
  case (PRODUCT_INFO_CATEGORIES_IMAGE_STATUS == 2 && $category_icon_display_image == ''):
    $category_icon_display_image = '';
    break;
  default:
    // name and image always display image regardless
    $category_icon_display_image = zen_image(DIR_WS_IMAGES . $category_icon_display_image, $category_icon_display_name, CATEGORY_ICON_IMAGE_WIDTH, CATEGORY_ICON_IMAGE_HEIGHT) . '<br />';
    break;
}
