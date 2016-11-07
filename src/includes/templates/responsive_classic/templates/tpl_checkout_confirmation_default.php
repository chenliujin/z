<div class="centerColumn" id="checkoutConfirmDefault">

<h1 id="checkoutConfirmDefaultHeading"><?php echo HEADING_TITLE; ?></h1>

<?php if ($messageStack->size('redemptions') > 0)           echo $messageStack->output('redemptions'); ?>
<?php if ($messageStack->size('checkout_confirmation') > 0) echo $messageStack->output('checkout_confirmation'); ?>
<?php if ($messageStack->size('checkout') > 0)              echo $messageStack->output('checkout'); ?>

<div id="checkoutBillto" class="back">
	<fieldset>
		<legend><?php echo HEADING_BILLING_ADDRESS; ?></legend>
		<?php if (!$flagDisablePaymentAddressChange) { ?>
		  <div class="buttonRow forward"><?php echo '<a href="' . zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_EDIT_SMALL, BUTTON_EDIT_SMALL_ALT) . '</a>'; ?></div>
		<?php } ?> 
		<address><?php echo zen_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br />'); ?></address>
	</fieldset>

<fieldset>
	<?php $class = &$_SESSION['payment']; ?>
	<legend><?php echo HEADING_PAYMENT_METHOD; ?></legend>
	<div><?php echo $GLOBALS[$class]->title; ?></div>
</fieldset>

<?php
  if (is_array($payment_modules->modules)) {
    if ($confirmation = $payment_modules->confirmation()) { ?>
  	<div class="important"><?php echo $confirmation['title']; ?></div>
	<?php } ?>

  <div class="important">
	<?php for ($i=0, $n=sizeof($confirmation['fields']); $i<$n; $i++) { ?>
    <div class="back"><?php echo $confirmation['fields'][$i]['title']; ?></div>
    <div ><?php echo $confirmation['fields'][$i]['field']; ?></div>
	<?php } ?>
  </div>
<?php } ?>

</div>

<?php if ($_SESSION['sendto'] != false) { ?>
<div id="checkoutShipto" class="forward">
	<fieldset>
		<legend><?php echo HEADING_DELIVERY_ADDRESS; ?></legend>
  		<div class="buttonRow forward"><?php echo '<a href="' . $editShippingButtonLink . '">' . zen_image_button(BUTTON_IMAGE_EDIT_SMALL, BUTTON_EDIT_SMALL_ALT) . '</a>'; ?></div>
  		<address><?php echo zen_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />'); ?></address>
	</fieldset>

  <?php if ($order->info['shipping_method']) { ?>
  <fieldset>
	<legend><?php echo HEADING_SHIPPING_METHOD; ?></legend>
	<div><?php echo $order->info['shipping_method']; ?></div>
  </fieldset>
  <?php } ?>

  </div>
<?php } ?>

<br class="clearBoth" />

<fieldset>
	<legend><?php echo HEADING_ORDER_COMMENTS; ?></legend>
  	<div><?php echo (empty($order->info['comments']) ? NO_COMMENTS_TEXT : nl2br(zen_output_string_protected($order->info['comments'])) . zen_draw_hidden_field('comments', $order->info['comments'])); ?></div>
</fieldset>


<?php  if ($flagAnyOutOfStock) { ?>
<?php    if (STOCK_ALLOW_CHECKOUT == 'true') {  ?>
<div class="messageStackError"><?php echo OUT_OF_STOCK_CAN_CHECKOUT; ?></div>
<?php    } else { ?>
<div class="messageStackError"><?php echo OUT_OF_STOCK_CANT_CHECKOUT; ?></div>
<?php    } //endif STOCK_ALLOW_CHECKOUT ?>
<?php  } //endif flagAnyOutOfStock ?>


<table id="cartContentsDisplay">
	<tr class="cartTableHeading">
		<th scope="col" class="text-left"><?php echo TABLE_HEADING_PRODUCTS; ?></th>
		<th scope="col" id="ccQuantityHeading"><?php echo TABLE_HEADING_QUANTITY; ?></th>

		<?php if (sizeof($order->info['tax_groups']) > 1) { ?>
		<th scope="col" id="ccTaxHeading"><?php echo HEADING_TAX; ?></th>
		<?php } ?> 

		<th scope="col" id="ccTotalHeading"><?php echo TABLE_HEADING_TOTAL; ?></th>
	</tr>

	<?php for ($i=0, $n=sizeof($order->products); $i<$n; $i++) { ?>
	<tr class="<?php echo $order->products[$i]['rowClass']; ?>">
		<td class="cartProductDisplay">
			<?php echo $order->products[$i]['name']; ?>
			<?php  echo $stock_check[$i]; ?> 
			<?php 
  			if (isset($order->products[$i]['attributes']) && sizeof($order->products[$i]['attributes']) > 0 ) { 
	  			echo '<ul class="cartAttribsList">'; 

				for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) { ?> 
					<li><?php echo $order->products[$i]['attributes'][$j]['option'] . ': ' . nl2br(zen_output_string_protected($order->products[$i]['attributes'][$j]['value'])); ?></li> <?php 
				} 

				echo '</ul>'; 
			} ?>
		</td>
		<td class="text-center"><?php echo $order->products[$i]['qty']; ?></td>

		<?php if (sizeof($order->info['tax_groups']) > 1)  { ?>
		<td class="cartTotalDisplay">
		<?php echo zen_display_tax_value($order->products[$i]['tax']); ?>%
		</td>
		<?php    } ?>

		<td class="cartTotalDisplay price">
		<?php echo $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']);
		if ($order->products[$i]['onetime_charges'] != 0 ) echo '<br /> ' . $currencies->display_price($order->products[$i]['onetime_charges'], $order->products[$i]['tax'], 1); ?>
		</td>

	</tr>
	<?php  } ?>
</table>


<?php 
		if (MODULE_ORDER_TOTAL_INSTALLED) { 
			$order_totals = $order_total_modules->process(); ?> 
			<div id="orderTotals"><?php $order_total_modules->output(); ?></div> <?php 
		}
?>

<?php
  echo zen_draw_form('checkout_confirmation', $form_action_url, 'post', 'id="checkout_confirmation" onsubmit="submitonce();"');

  if (is_array($payment_modules->modules)) {
    echo $payment_modules->process_button();
  }
?>
<div class="buttonRow forward confirm-order"><?php echo zen_image_submit(BUTTON_IMAGE_CONFIRM_ORDER, BUTTON_CONFIRM_ORDER_ALT, 'name="btn_submit" id="btn_submit"') ;?></div>
</form>
<div class="buttonRow back"><?php echo TITLE_CONTINUE_CHECKOUT_PROCEDURE . '<br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></div>

</div>
