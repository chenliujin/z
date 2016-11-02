<?php
include_once('z/model/products.php');

$page = \z\products::GetCategoriesProduct($listing_sql);
$data = $page->data();
