<?php

//print_r($list_box_contents);
  $cell_scope = (!isset($cell_scope) || empty($cell_scope)) ? 'col' : $cell_scope;
  $cell_title = (!isset($cell_title) || empty($cell_title)) ? 'list' : $cell_title;

?>
<table class="listBoxContentTable">
<?php
  for($row=0; $row<sizeof($list_box_contents); $row++) {
    $params = "";
    if (isset($list_box_contents[$row]['params'])) $params .= ' ' . $list_box_contents[$row]['params'];
?>
  <tr <?php echo $params; ?>>
<?php
    for($col=0;$col<sizeof($list_box_contents[$row]);$col++) {
      $r_params = "";
      $cell_type = ($row==0) ? 'th' : 'td';
      if (isset($list_box_contents[$row][$col]['params'])) $r_params .= ' ' . $list_box_contents[$row][$col]['params'];
      if ($cell_type=='th') $r_params .= ' scope="' . $cell_scope . '" id="' . $cell_title . '-Cell-' . $row . ' - ' . $col.'"';
      if (isset($list_box_contents[$row][$col]['text'])) {
?>
   <?php echo '<' . $cell_type . $r_params . '>'; ?><?php echo $list_box_contents[$row][$col]['text'] ?><?php echo '</' . $cell_type . '>'; ?>
<?php
      }
    }
?>
  </tr>
<?php
  }
?>
</table>
