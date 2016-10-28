<?php
//print_r($list_box_contents);
?>
<div id="<?php echo 'cat' . $cPath . 'List'; ?>" class="tabTable">
<?php
for($row=0; $row<sizeof($list_box_contents); $row++) {
	$r_params = "";

	if (isset($list_box_contents[$row]['params'])) {
		$r_params .= ' ' . $list_box_contents[$row]['params'];
	}
	?>
  	<div <?php echo $r_params; ?>>
	<?php
	for($col=0; $col<sizeof($list_box_contents[$row]); $col++) {
		if (isset($list_box_contents[$row][$col]['text'])) {
			echo $list_box_contents[$row][$col]['text'];
		}
	}
	?>
  	</div>
	<?php
}
?>
</div>
