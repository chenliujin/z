<?php
$content = "";
$content .= zen_draw_form('quick_find_header', zen_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', $request_type, false), 'get');
$content .= zen_draw_hidden_field('main_page',FILENAME_ADVANCED_SEARCH_RESULT);
$content .= zen_draw_hidden_field('search_in_description', '1') . zen_hide_session_id();
$content .= zen_draw_input_field('keyword', '', 'size="6" maxlength="30" style="width: 100px"');
$content .= '<input type="submit" value="" class="search-submit" />';
$content .= '</form>';

echo $content;
