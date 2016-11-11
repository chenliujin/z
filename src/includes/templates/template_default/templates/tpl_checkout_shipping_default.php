<div class="centerColumn" id="checkoutShipping">

<?php echo zen_draw_form('checkout_address', zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL')) . zen_draw_hidden_field('action', 'process'); ?>

<h1 id="checkoutShippingHeading"><?php echo HEADING_TITLE; ?></h1>

<?php if ($messageStack->size('checkout_shipping') > 0) echo $messageStack->output('checkout_shipping'); ?>


<fieldset>
	<legend><?php echo TITLE_SHIPPING_ADDRESS; ?></legend>
 
	<div id="checkoutShipto" class="floatingBox back">
		<?php if ($displayAddressEdit) { ?>
		<div class="buttonRow forward">
			<?php echo '<a href="' . $editShippingButtonLink . '">' . zen_image_button(BUTTON_IMAGE_CHANGE_ADDRESS, BUTTON_CHANGE_ADDRESS_ALT) . '</a>'; ?>
		</div>
		<?php } ?>

		<address>
			<?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], true, ' ', '<br />'); ?>
		</address>
	</div>
</fieldset>

<fieldset>
	<legend><?php echo TABLE_HEADING_SHIPPING_METHOD; ?></legend>

<?php
if ( !empty($quotes) ) { ?>
		<div style="padding: 20px;">

<style>
table {
	padding: 0 20px;
}
tr td {
	padding: 10px 0;
	border-bottom: 1px solid #e8e8e8;
}
</style>
	<table>
		<tr class="list-item-border">
			<th></th>
			<th></th>
			<th></th>
			<th></th>
		</tr>
	<?php
	foreach ($quotes as $quote) { 
		$checked = FALSE;
		if (isset($_SESSION['shipping']) && isset($_SESSION['shipping']['id'])) {
			$checked = ($quote['id'] . '_' . $quote['methods'][0]['id'] == $_SESSION['shipping']['id']);
		}


		?>
		<tr class="list-item-border">
			<td> <?php
				echo zen_draw_radio_field(
					'shipping', 
					$quote['id'] . '_' . $quote['methods'][0]['id'], 
					$checked, 
					'id="ship-'.$quote['id'] . '-' . str_replace(' ', '-', $quote['methods'][0]['id']) .'"'
				); ?>
			</td>
			<td>
				<label for="ship-<?php echo $quote['id'] . '-' . str_replace(' ', '-', $quote['methods'][0]['id']); ?>" class="checkboxLabel" >
					<img src="<?php echo $quote['icon']; ?>" width="75" />
				</label>
			</td>
			<td>
				<label for="ship-<?php echo $quote['id'] . '-' . str_replace(' ', '-', $quote['methods'][0]['id']); ?>" class="checkboxLabel" >
					<?php echo $quote['module']; ?>
				</label>
			</td>
			<td>
				<div class="important forward price size-medium">
					<?php echo $currencies->format($quote['methods'][0]['cost']); ?>
				</div>
			</td>
		</tr>
		<?php
	}
	?>
		</table> 
		</div>
	<?php
} else { ?>
	<h2 id="checkoutShippingHeadingMethod"><?php echo TITLE_NO_SHIPPING_AVAILABLE; ?></h2>
	<div id="checkoutShippingContentChoose" class="important"><?php echo TEXT_NO_SHIPPING_AVAILABLE; ?></div><?php
}
?>
</fieldset>


<div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_CONTINUE_CHECKOUT, BUTTON_CONTINUE_ALT); ?></div>
 
</form>
</div>
