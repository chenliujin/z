<?php
/**
 * Page Template
 *
 * Loaded automatically by index.php?main_page=checkout_shipping.<br />
 * Displays allowed shipping modules for selection by customer.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2013 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: Ian Wilson  Mon Oct 28 17:54:33 2013 +0000 Modified in v1.5.2 $
 */
?>
<div class="centerColumn" id="checkoutShipping">

<?php echo zen_draw_form('checkout_address', zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL')) . zen_draw_hidden_field('action', 'process'); ?>

<h1 id="checkoutShippingHeading"><?php echo HEADING_TITLE; ?></h1>

<?php if ($messageStack->size('checkout_shipping') > 0) echo $messageStack->output('checkout_shipping'); ?>
 
<h2 id="checkoutShippingHeadingAddress"><?php echo TITLE_SHIPPING_ADDRESS; ?></h2>
 
<div id="checkoutShipto" class="floatingBox back">
<?php if ($displayAddressEdit) { ?>
<div class="buttonRow forward"><?php echo '<a href="' . $editShippingButtonLink . '">' . zen_image_button(BUTTON_IMAGE_CHANGE_ADDRESS, BUTTON_CHANGE_ADDRESS_ALT) . '</a>'; ?></div>
<?php } ?>
<address class=""><?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], true, ' ', '<br />'); ?></address>
</div>
<div class="floatingBox important forward"><?php echo TEXT_CHOOSE_SHIPPING_DESTINATION; ?></div>
<br class="clearBoth" />
 
<?php
if ( !empty($quotes) ) { ?>
	<h2 id="checkoutShippingHeadingMethod"><?php echo TABLE_HEADING_SHIPPING_METHOD; ?></h2>
<style>
table {
	padding: 0 20px;
}
tr td {
	padding: 20px 0;
	border-bottom: 1px solid #e8e8e8;
}
</style>
	<table>
		<tr>
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
		<tr>
		<td><?php
		echo zen_draw_radio_field(
			'shipping', 
			$quote['id'] . '_' . $quote['methods'][0]['id'], 
			$checked, 
			'id="ship-'.$quote['id'] . '-' . str_replace(' ', '-', $quote['methods'][0]['id']) .'"'
		); 
?>
			</td>
			<td><label for="ship-<?php echo $quote['id'] . '-' . str_replace(' ', '-', $quote['methods'][0]['id']); ?>" class="checkboxLabel" ><img src="<?php echo $quote['icon']; ?>" width="50" /></label></td>
			<td><label for="ship-<?php echo $quote['id'] . '-' . str_replace(' ', '-', $quote['methods'][0]['id']); ?>" class="checkboxLabel" ><?php echo $quote['module']; ?></label></td>
			<td><div class="important forward price"><?php echo $currencies->format(zen_add_tax($quote['methods'][0]['cost'], 0)); ?></div></td>
		</tr>
		<?php
	}
	?>
	</table>
<?php
} else { ?>
	<h2 id="checkoutShippingHeadingMethod"><?php echo TITLE_NO_SHIPPING_AVAILABLE; ?></h2>
	<div id="checkoutShippingContentChoose" class="important"><?php echo TEXT_NO_SHIPPING_AVAILABLE; ?></div><?php
}
?>


<fieldset class="shipping" id="comments">
	<legend><?php echo TABLE_HEADING_COMMENTS; ?></legend>
	<?php echo zen_draw_textarea_field('comments', '45', '3'); ?>
</fieldset>
 
<div class="buttonRow forward"><?php echo zen_image_submit(BUTTON_IMAGE_CONTINUE_CHECKOUT, BUTTON_CONTINUE_ALT); ?></div>
<div class="buttonRow back"><?php echo '<strong>' . TITLE_CONTINUE_CHECKOUT_PROCEDURE . '</strong><br />' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?></div>
 
</form>
</div>
