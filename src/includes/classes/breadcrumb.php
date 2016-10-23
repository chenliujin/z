<?php
if (!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}

/**
 * The following switch simply checks to see if the setting is already defined, and if not, sets it to true
 * If you desire to have the older behaviour of having all product and category items in the breadcrumb be shown as links
 * then you should add a define() for this item in the extra_datafiles folder and set it to 'false' instead of 'true':
 */
if (!defined('DISABLE_BREADCRUMB_LINKS_ON_LAST_ITEM')) define('DISABLE_BREADCRUMB_LINKS_ON_LAST_ITEM','true');

/**
 * breadcrumb Class.
 * Class to handle page breadcrumbs
 *
 * @package classes
 */
class breadcrumb extends base {
	var $_trail;

	function __construct() {
		$this->reset();
	}

	function reset() {
		$this->_trail = array();
	}

	function add($title, $link = '') {
		$this->_trail[] = array('title' => $title, 'link' => $link);
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-27
	 */
	public function trail($separator = '&nbsp;&gt;&nbsp;') 
	{
		$trail_string = '';

		for ($i=0, $n=sizeof($this->_trail); $i<$n; $i++) {
			$skip_link = false;

			if ($i==($n-1) && DISABLE_BREADCRUMB_LINKS_ON_LAST_ITEM =='true' && empty($_GET['products_id'])) {
				$skip_link = true;
			}

			if (isset($this->_trail[$i]['link']) && zen_not_null($this->_trail[$i]['link']) && !$skip_link ) {
				// this line simply sets the "Home" link to be the domain/url, not main_page=index?blahblah:
				if ($this->_trail[$i]['title'] == HEADER_TITLE_CATALOG) {
					$trail_string .= '  <a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">' . $this->_trail[$i]['title'] . '</a>';
				} else {
					$trail_string .= '  <a href="' . $this->_trail[$i]['link'] . '">' . $this->_trail[$i]['title'] . '</a>';
				}
			} else {
				$trail_string .= $this->_trail[$i]['title'];
			}

			if (($i+1) < $n) $trail_string .= $separator;
			$trail_string .= "\n";
		}

		return $trail_string;
	}

	function last() {
		$trail_size = sizeof($this->_trail);
		return $this->_trail[$trail_size-1]['title'];
	}
}
?>
