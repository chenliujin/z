<?php
include_once('z/model/products.php');
?>
<div class="centerColumn" id="indexDefault">
	<ul>
	<?php
	$page = \z\products::GetAllProducts();
	$data = $page->data();
	foreach ($data as $obj) {
		$products_link = zen_href_link( zen_get_info_page($obj->products_id), 'cPath=' . zen_get_generated_category_path_rev($obj->master_categories_id) . '&products_id=' . $obj->products_id);
		$price = \z\products::GetPriceList($obj->products_id);
		?>
		<li style="width: 33%; margin-bottom: 50px; list-style: none; display: inline-block">
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

</div>
