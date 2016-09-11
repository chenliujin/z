<?php
/**
 * ot_total order-total module
 *
 * @package orderTotal
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Author: DrByte  Thu Apr 2 14:27:45 2015 -0400 Modified in v1.5.5 $
 */
class ot_subtotal {
	var $title, $output;

	function __construct() {
		$this->code = 'ot_subtotal';
		$this->title = MODULE_ORDER_TOTAL_SUBTOTAL_TITLE;
		$this->description = MODULE_ORDER_TOTAL_SUBTOTAL_DESCRIPTION;
		$this->sort_order = MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER;

		$this->output = array();
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-11
	 */
	public function process() 
	{
		global $order, $currencies;

		$this->output[] = [
			'title' => $this->title . ':',
			'text' 	=> $currencies->format($order->info['subtotal'], true, $order->info['currency'], $order->info['currency_value']),
			'value' => $order->info['subtotal']
			];
	}

	function check() {
		global $db;
		if (!isset($this->_check)) {
			$check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_SUBTOTAL_STATUS'");
			$this->_check = $check_query->RecordCount();
		}

		return $this->_check;
	}

	function keys() {
		return array('MODULE_ORDER_TOTAL_SUBTOTAL_STATUS', 'MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER');
	}

	function install() {
		global $db;
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('This module is installed', 'MODULE_ORDER_TOTAL_SUBTOTAL_STATUS', 'true', '', '6', '1','zen_cfg_select_option(array(\'true\'), ', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER', '100', 'Sort order of display.', '6', '2', now())");
	}

	function remove() {
		global $db;
		$db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}
}
?>
