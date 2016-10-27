<?php
//print_r($list_box_contents);
$cell_scope = (!isset($cell_scope) || empty($cell_scope)) ? 'col' : $cell_scope;
$cell_title = (!isset($cell_title) || empty($cell_title)) ? 'list' : $cell_title;
?>
<div id="<?php echo 'cat' . $cPath . 'List'; ?>" class="tabTable">
<?php
  for($row=0; $row<sizeof($list_box_contents); $row++) {
    $r_params = "";
    $c_params = "";
    if (isset($list_box_contents[$row]['params'])) $r_params .= ' ' . $list_box_contents[$row]['params'];
?>
  <div <?php echo $r_params; ?>>
<?php
    for($col=0;$col<sizeof($list_box_contents[$row]);$col++) {
      $c_params = "";
      $cell_type = ($row==0) ? 'li' : 'div';
      if (isset($list_box_contents[$row][$col]['params'])) $c_params .= ' ' . $list_box_contents[$row][$col]['params'];
      if (isset($list_box_contents[$row][$col]['align']) && $list_box_contents[$row][$col]['align'] != '') $c_params .= ' align="' . $list_box_contents[$row][$col]['align'] . '"';
      if ($cell_type=='th') $c_params .= ' scope="' . $cell_scope . '" id="' . $cell_title . 'Cell' . $row . '-' . $col.'"';
      if (isset($list_box_contents[$row][$col]['text'])) {
?>

<?php echo $list_box_contents[$row][$col]['text'] ?>

<?php
      }
    }
?>
  </div>
<?php
  }
?>
</div>
