<?php
/**
 * shipping class
 *
 * @package classes
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Author: DrByte  Sun Oct 18 01:50:12 2015 -0400 Modified in v1.5.5 $
 */
if (!defined('IS_ADMIN_FLAG')) {
	die('Illegal Access');
}

include_once('z/model/transportation.php');
include_once('z/model/transportation_zone.php');
include_once('z/model/transportation_description.php');

/**
 * shipping class
 * Class used for interfacing with shipping modules
 *
 * @package classes
 */
class shipping extends base 
{
	var $modules;

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-08
	 */
	public function __construct($module = '') 
	{
		if ($module) $this->module = $module; 
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-08
	 */
	public function quote($method = '', $module = '') 
	{
		$quotes_array = array();

		$params = ['status' => 1];

		if ($module) $params['code'] = $module;
		if ($this->module) $params['code'] = $this->module; 

		$transportation 		= new \z\transportation;
		$transportation_list 	= $transportation->findAll($params);

		foreach ($transportation_list as $transportation) {
			try {
				$quotes_array[] = $transportation->quote();
			} catch (\Exception $e) {
				error_log(var_export($e, TRUE));
			}
		}

		return $quotes_array;
	}

	/**
	 * @author chenliujin <liujin.chen@qq.com>
	 * @since 2016-09-08
	 */
	public function cheapest() 
	{
		$rates = array();

		$list = $this->quote();

		foreach ($list as $quotes) {
			$size = sizeof($quotes['methods']);
			for ($i=0; $i<$size; $i++) {
				if (isset($quotes['methods'][$i]['cost'])){
					$rates[] = array(
						'id' 		=> $quotes['id'] . '_' . $quotes['methods'][$i]['id'],
						'title' 	=> $quotes['module'],
						'cost' 		=> $quotes['methods'][$i]['cost'],
						'module' 	=> $quotes['id']
					);
				}
			}
		}

		$cheapest = false;
		$size = sizeof($rates);
		for ($i=0; $i<$size; $i++) {
			if (is_array($cheapest)) {
				if ( $rates[$i]['cost'] < $cheapest['cost'] ) {
					$cheapest = $rates[$i];
				}
			} else {
				$cheapest = $rates[$i];
			}
		}
		$this->notify('NOTIFY_SHIPPING_MODULE_CALCULATE_CHEAPEST', $cheapest, $cheapest, $rates);
		return $cheapest;
	}
}
