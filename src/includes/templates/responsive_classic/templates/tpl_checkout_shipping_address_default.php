<div class="centerColumn" id="checkoutShipAddressDefault">

<?php 

if ($messageStack->size('checkout_address') > 0) echo $messageStack->output('checkout_address');

if ($process == false || $error == true) {

	if ($addresses_count > 1) { 
		echo zen_draw_form('checkout_address_book', zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL'), 'post', 'class="group"'); 
		?>
	
		<fieldset>
			<legend><?php echo TABLE_HEADING_ADDRESS_BOOK_ENTRIES; ?></legend>
			<?php
		    require($template->get_template_dir('tpl_modules_checkout_address_book.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_checkout_address_book.php');
			?>

			<div class="buttonRow">
				<?php echo zen_draw_hidden_field('action', 'submit') . zen_image_submit(BUTTON_IMAGE_CONTINUE, BUTTON_CONTINUE_ALT); ?>
			</div>
		</fieldset>
		</form>
		<?php
	}

	if ($addresses_count < MAX_ADDRESS_BOOK_ENTRIES) {
		require($template->get_template_dir('tpl_modules_checkout_new_address.php', DIR_WS_TEMPLATE, $current_page_base,'templates'). '/' . 'tpl_modules_checkout_new_address.php');
	}
}

if ($process == true) { ?>
	<div class="buttonRow back">
		<?php echo '<a href="' . zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL') . '">' . zen_image_button(BUTTON_IMAGE_BACK, BUTTON_BACK_ALT) . '</a>'; ?>
	</div> <?php 
} 
?>

</div>
