<div id="productQuantityDiscounts">
  <table id="quantityDiscountsDetails">
	<tr>
		<th>Quantity</th>
		<th>
			<?php echo $show_qty; ?>
		</th> 
		<?php
		foreach ($quantityDiscounts as $quantityDiscount) {
			echo '<th>' . $quantityDiscount['show_qty'] . '</th>';
		}
		?>
	</tr>
	<tr>
		<th>Rate</th>
		<td>
			<?php echo $currencies->display_price($show_price, zen_get_tax_rate($products_tax_class_id)); ?>
		</td>
		<?php
		foreach ($quantityDiscounts as $quantityDiscount) {
			echo '<td>' . $currencies->display_price($quantityDiscount['discounted_price'], zen_get_tax_rate($products_tax_class_id)) . '</td>';
		}
		?>

	</tr>
</table> 

</div>
