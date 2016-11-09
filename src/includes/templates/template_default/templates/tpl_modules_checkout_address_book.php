<?php
$radio_buttons = 0;

$addresses_query = "
	select 
		address_book_id, 
		entry_firstname as firstname, 
		entry_lastname as lastname,
		entry_company as company, 
		entry_street_address as street_address,
		entry_suburb as suburb, 
		entry_city as city, 
		entry_postcode as postcode,
		entry_state as state, 
		entry_zone_id as zone_id,
		entry_country_id as country_id
	from " . TABLE_ADDRESS_BOOK . "
	where customers_id = '" . (int)$_SESSION['customer_id'] . "'";

$addresses = $db->Execute($addresses_query);
if (!$addresses->EOF) $radio_buttons = $addresses->recordCount();

while (!$addresses->EOF) {
	if ($addresses->fields['address_book_id'] == $_SESSION['sendto']) {
		echo '<div id="defaultSelected" class="moduleRowSelected">' . "\n";
	} else {
		echo '<div class="moduleRow">' . "\n";
	} 
	?>
	
		<div class="back">
			<?php echo zen_draw_radio_field('address', $addresses->fields['address_book_id'], ($addresses->fields['address_book_id'] == $_SESSION['sendto']), 'id="name-' . $addresses->fields['address_book_id'] . '"'); ?>
		</div>

		<div class="back">
			<label for="name-<?php echo $addresses->fields['address_book_id']; ?>">
				<?php echo zen_output_string_protected($addresses->fields['firstname'] . ' ' . $addresses->fields['lastname']); ?>
			</label>
		</div>

	</div>

	<br class="clearBoth" />

	<address>
		<?php echo zen_address_format(zen_get_address_format_id($addresses->fields['country_id']), $addresses->fields, true, ' ', '<br />'); ?>
	</address>

	<?php
	$addresses->MoveNext();
}
