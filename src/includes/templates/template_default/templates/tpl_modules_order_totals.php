<?php
for ($i=0; $i<$size; $i++) { ?>
	<div id="<?php echo str_replace('_', '', $GLOBALS[$class]->code); ?>">
		<div class="totalBox larger forward price text-bold size-medium"><?php echo $GLOBALS[$class]->output[$i]['text']; ?></div>
		<div class="lineTitle larger forward text-bold size-medium"><?php echo $GLOBALS[$class]->output[$i]['title']; ?></div>
	</div>
	<br class="clearBoth" /> <?php 
} 
