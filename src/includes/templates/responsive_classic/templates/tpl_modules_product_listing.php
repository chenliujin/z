<?php
include_once('z/model/products.php');

$page = \z\products::GetCategoriesProduct($listing_sql);
$data = $page->data();
?>

<div id="productListing" class="group">
	<ul>
	<?php
	$page = \z\products::GetCategoriesProduct($listing_sql);
	$data = $page->data();
	foreach ($data as $obj) {
		$products_link = zen_href_link( zen_get_info_page($obj->products_id), 'products_id=' . $obj->products_id);
		$price = \z\products::GetPriceList($obj->products_id);
		?>
		<li style="width: 24%; margin-bottom: 50px; list-style: none; display: inline-block; vertical-align: top">
		<div class="item-container">
			<div class="row bottom-base">
			<div style="position: relative; display: inline-block">
				<a href="<?php echo $products_link; ?>">
				<?php 
				$images = json_decode($obj->products_image, TRUE);
				echo \z\products::Image($images[0], $obj->products_name, 220, 220); 
				?>
				</a>
			</div>
			</div>
			<div class="bottom-mini">
				<a href="<?php echo $products_link; ?>">
				<?php echo $obj->products_name; ?>
				</a>
			</div>
			<div>
				<a href="<?php echo $products_link; ?>" class="price">
					<span class="text-bold"><?php echo $currencies->format($price->sale_price ? $price->sale_price : $price->normal_price); ?></span>
					<?php if ($price->sale_price) echo '&nbsp<span class="price-del">' . $currencies->format($price->normal_price) . '</span>'; ?>
				</a>
			</div>
		</div>
		</li>
		<?php
	}
	?>
	</ul>
	<div style="clear:both"></div>
	<div style="text-align: center">
	<div style="text-align: center">
		<?php echo $page->nav(); ?>
	</div>
	</div>


	<div id="<?php echo 'cat' . $cPath . 'List'; ?>" class="tabTable">
	<?php
	for($row=0; $row<sizeof($list_box_contents); $row++) {
		$r_params = "";

		if (isset($list_box_contents[$row]['params'])) {
			$r_params .= ' ' . $list_box_contents[$row]['params'];
		}
		?>
		<div <?php echo $r_params; ?>>
		<?php
		for($col=0; $col<sizeof($list_box_contents[$row]); $col++) {
			if (isset($list_box_contents[$row][$col]['text'])) {
				echo $list_box_contents[$row][$col]['text'];
			}
		}
		?>
		</div>
		<?php
	}
	?>
	</div>
</div>
