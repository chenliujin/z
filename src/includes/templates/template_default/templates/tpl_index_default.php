<?php
include_once('z/model/products.php');
?>
<div class="centerColumn" id="indexDefault">
	<ul>
	<?php
	$page = \z\products::GetAllProducts();
	$data = $page->data();
	foreach ($data as $obj) {
		?>
		<li style="width: 33%; margin-bottom: 50px; list-style: none; display: inline-block">
		<div class="item-container">
			<div class="row bottom-base">
			<div style="position: relative; display: inline-block">
			<a href="<?php echo zen_href_link( zen_get_info_page($obj->products_id), 'cPath=' . zen_get_generated_category_path_rev($obj->master_categories_id) . '&products_id=' . $obj->products_id); ?>" style="line-height: 1em">
				<?php 
				$images = json_decode($obj->products_image, TRUE);
				echo \z\products::Image($images[0], $obj->products_name, 150, 150); 
				?>
				</a>
			</div>
			</div>
			<div class="bottom-mini">
				<a href="<?php echo zen_href_link( zen_get_info_page($obj->products_id), 'cPath=' . zen_get_generated_category_path_rev($obj->master_categories_id) . '&products_id=' . $obj->products_id); ?>">
				<?php echo $obj->products_name; ?>
				</a>
			</div>
			<div class="price">
				$1.00
			</div>
		</div>
		</li>
<?php
	}
	?>
	</ul>
	<div style="clear:both"></div>

</div>
