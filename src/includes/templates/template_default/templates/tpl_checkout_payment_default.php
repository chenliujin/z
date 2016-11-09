<?php echo $payment_modules->javascript_validation(); ?>
<div class="centerColumn" id="checkoutPayment">
<?php echo zen_draw_form('checkout_payment', zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'), 'post'); ?>
<?php echo zen_draw_hidden_field('action', 'submit'); ?>

<h1 id="checkoutPaymentHeading"><?php echo HEADING_TITLE; ?></h1>

<?php if ($messageStack->size('redemptions') > 0) echo $messageStack->output('redemptions'); ?>
<?php if ($messageStack->size('checkout') > 0) echo $messageStack->output('checkout'); ?>
<?php if ($messageStack->size('checkout_payment') > 0) echo $messageStack->output('checkout_payment'); ?>


<fieldset id="checkoutOrderTotals">
	<legend><?php echo TEXT_YOUR_TOTAL; ?></legend>
	<?php
	if (MODULE_ORDER_TOTAL_INSTALLED) {
		$order_totals = $order_total_modules->process();
		$order_total_modules->output(); 
	}
	?>
</fieldset>


<?php
  $selection =  $order_total_modules->credit_selection();
  if (sizeof($selection)>0) {
    for ($i=0, $n=sizeof($selection); $i<$n; $i++) {
      if ($_GET['credit_class_error_code'] == $selection[$i]['id']) {
?>
<div class="messageStackError"><?php echo zen_output_string_protected($_GET['credit_class_error']); ?></div>

<?php
      }
      for ($j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++) {
?>
<fieldset>
<legend><?php echo $selection[$i]['module']; ?></legend>
<?php echo $selection[$i]['redeem_instructions']; ?>
<div class="gvBal larger"><?php echo $selection[$i]['checkbox']; ?></div>
<label class="inputLabel"<?php echo ($selection[$i]['fields'][$j]['tag']) ? ' for="'.$selection[$i]['fields'][$j]['tag'].'"': ''; ?>><?php echo $selection[$i]['fields'][$j]['title']; ?></label>
<?php echo $selection[$i]['fields'][$j]['field']; ?>
</fieldset>
<?php
      }
    }
?>

<?php
    }
?>

<?php if (!$payment_modules->in_special_checkout()) { ?>
<fieldset class="payment">
	<legend><?php echo TABLE_HEADING_PAYMENT_METHOD; ?></legend> 
	<?php 
  	if (SHOW_ACCEPTED_CREDIT_CARDS != '0') {
    	if (SHOW_ACCEPTED_CREDIT_CARDS == '1') {
      		echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled();
    	}

    	if (SHOW_ACCEPTED_CREDIT_CARDS == '2') {
      		echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled('IMAGE_');
    	}
		?>
		<br class="clearBoth" />
	<?php } ?>

	<?php
	$selection = $payment_modules->selection(); 

	if (sizeof($selection) > 1) { ?> 
		<p class="important"><?php echo TEXT_SELECT_PAYMENT_METHOD; ?></p> <?php 
	} elseif (sizeof($selection) == 0) { ?> 
		<p class="important"><?php echo TEXT_NO_PAYMENT_OPTIONS_AVAILABLE; ?></p> <?php 
	} 
	
	$radio_buttons = 0; 
	
	for ($i=0, $n=sizeof($selection); $i<$n; $i++) { 
		if (sizeof($selection) > 1) { 
			if (empty($selection[$i]['noradio'])) {
				echo zen_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == $_SESSION['payment'] ? true : false), 'id="pmt-'.$selection[$i]['id'].'"'); 
			} 
		} else {
			echo zen_draw_hidden_field('payment', $selection[$i]['id'], 'id="pmt-'.$selection[$i]['id'].'"');
		} ?> 

		<label for="pmt-<?php echo $selection[$i]['id']; ?>" class="radioButtonLabel"><?php echo $selection[$i]['module']; ?></label> 

		<?php
		if (defined('MODULE_ORDER_TOTAL_COD_STATUS') && MODULE_ORDER_TOTAL_COD_STATUS == 'true' and $selection[$i]['id'] == 'cod') { ?> 
			<div class="alert"><?php echo TEXT_INFO_COD_FEES; ?></div> <?php 
		} 
		?>
		<br class="clearBoth" />

		<?php
    	if (isset($selection[$i]['error'])) { ?>
    		<div><?php echo $selection[$i]['error']; ?></div> <?php
		} elseif (isset($selection[$i]['fields']) && is_array($selection[$i]['fields'])) { ?> 
			<div class="ccinfo"> <?php 

			for ($j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++) { ?> 
				<label <?php echo (isset($selection[$i]['fields'][$j]['tag']) ? 'for="'.$selection[$i]['fields'][$j]['tag'] . '" ' : ''); ?>class="inputLabelPayment"><?php echo $selection[$i]['fields'][$j]['title']; ?></label><?php echo $selection[$i]['fields'][$j]['field']; ?> 
				<br class="clearBoth" /> <?php
      		} ?>

			</div>
			<br class="clearBoth" /> <?php
    	}

    	$radio_buttons++; ?>
		<br class="clearBoth" /> <?php
  	}
	?>
</fieldset> <?php 

} else { ?>
	<input type="hidden" name="payment" value="<?php echo $_SESSION['payment']; ?>" /><?php
}
?>
	  

<fieldset>
	<legend><?php echo TABLE_HEADING_COMMENTS; ?></legend>
	<div>
		<?php echo zen_draw_textarea_field('comments', '45', '5'); ?>
  	</div>
</fieldset>


<?php if (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') { ?>
<fieldset>
	<legend><?php echo TABLE_HEADING_CONDITIONS; ?></legend>
	<div><?php echo TEXT_CONDITIONS_DESCRIPTION;?></div>
	<?php echo  zen_draw_checkbox_field('conditions', '1', false, 'id="conditions"');?>
	<label class="checkboxLabel" for="conditions"><?php echo TEXT_CONDITIONS_CONFIRM; ?></label>
</fieldset>
<?php } ?>


<div class="buttonRow forward" id="paymentSubmit"><?php echo zen_image_submit(BUTTON_IMAGE_CONTINUE_CHECKOUT, BUTTON_CONTINUE_ALT, 'onclick="submitFunction('.zen_user_has_gv_account($_SESSION['customer_id']).','.$order->info['total'].')"'); ?></div>

<div class="buttonRow back"><?php echo TITLE_CONTINUE_CHECKOUT_PROCEDURE . '<br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></div>

</form>
</div>
