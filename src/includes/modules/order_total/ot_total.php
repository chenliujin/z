<?php
class ot_total 
{
	var $title, $output;

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-10
	 */
	public function __construct() 
	{
		$this->code 		= 'ot_total';
		$this->title 		= MODULE_ORDER_TOTAL_TOTAL_TITLE;
		$this->description 	= MODULE_ORDER_TOTAL_TOTAL_DESCRIPTION;
		$this->sort_order 	= MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER;

		$this->output = [];
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-10
	 */
	public function process() 
	{
		global $order, $currencies;

		$subtotal 		= $currencies->rateAdjusted($order->info['subtotal'], 		true, $order->info['currency'], $order->info['currency_value']);
		$shipping_cost 	= $currencies->rateAdjusted($order->info['shipping_cost'], 	true, $order->info['currency'], $order->info['currency_value']);
		$total			= $subtotal + $shipping_cost;

		$this->output[] = [ 
			'title' => $this->title . ':',
			'text' 	=> $currencies->format($total, FALSE, $order->info['currency'], $order->info['currency_value']),
			'value' => $order->info['total']
		];
	}

	function check() 
	{
		global $db;
		if (!isset($this->_check)) {
			$check_query = $db->Execute("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_TOTAL_STATUS'");
			$this->_check = $check_query->RecordCount();
		}

		return $this->_check;
	}

	function keys() 
	{
		return array('MODULE_ORDER_TOTAL_TOTAL_STATUS', 'MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER');
	}

	function install() 
	{
		global $db;
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('This module is installed', 'MODULE_ORDER_TOTAL_TOTAL_STATUS', 'true', '', '6', '1','zen_cfg_select_option(array(\'true\'), ', now())");
		$db->Execute("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER', '999', 'Sort order of display.', '6', '2', now())");
	}

	function remove() 
	{
		global $db, $messageStack;
		if (!isset($_GET['override']) && $_GET['override'] != '1') {
			$messageStack->add('header', ERROR_MODULE_REMOVAL_PROHIBITED . $this->code);
			return false;
		}
		$db->Execute("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
	}
}
