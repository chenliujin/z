<?php
$zco_notifier->notify('NOTIFY_TPL_COLUMNAR_DISPLAY_START', $current_page_base, $list_box_contents, $title);
?>
<?php
if ($title) {
?>
<?php echo $title; ?>
<?php
}
?>
<?php
if (is_array($list_box_contents) > 0 ) {
	for($row=0;$row<sizeof($list_box_contents);$row++) {
		$params = "";
?>

<?php
		for($col=0;$col<sizeof($list_box_contents[$row]);$col++) {
			$r_params = "";
			if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . (string)$list_box_contents[$row][$col]['params'];
			if (isset($list_box_contents[$row][$col]['text'])) {
?>
	<?php echo '<div' . $r_params . '>' . $list_box_contents[$row][$col]['text'] .  '</div>' . "\n"; ?>
<?php
			}
		}
?>

<?php
	}
}

$zco_notifier->notify('NOTIFY_TPL_COLUMNAR_DISPLAY_END', $current_page_base, $list_box_contents, $title);
