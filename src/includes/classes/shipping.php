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
/**
 * shipping class
 * Class used for interfacing with shipping modules
 *
 * @package classes
 */
class shipping extends base {
	var $modules;

	// class constructor
	function __construct($module = '') {
		global $PHP_SELF, $messageStack;

		if (defined('MODULE_SHIPPING_INSTALLED') && zen_not_null(MODULE_SHIPPING_INSTALLED)) {
			$this->modules = explode(';', MODULE_SHIPPING_INSTALLED);

			$include_modules = array();

			if ( (zen_not_null($module)) && (in_array(substr($module['id'], 0, strpos($module['id'], '_')) . '.' . substr($PHP_SELF, (strrpos($PHP_SELF, '.')+1)), $this->modules)) ) {
				$include_modules[] = array(
					'class' => substr($module['id'], 0, strpos($module['id'], '_')), 
					'file' => substr($module['id'], 0, strpos($module['id'], '_')) . '.' . substr($PHP_SELF, (strrpos($PHP_SELF, '.')+1)));
			} else {
				reset($this->modules);
				while (list(, $value) = each($this->modules)) {
					$class = substr($value, 0, strrpos($value, '.'));
					$include_modules[] = array(
						'class' => $class, 
						'file' => $value
					);
				}
			}

			for ($i=0, $n=sizeof($include_modules); $i<$n; $i++) {
				$lang_file = null;
				$module_file = DIR_WS_MODULES . 'shipping/' . $include_modules[$i]['file'];
				if (IS_ADMIN_FLAG === true) {
					$lang_file = zen_get_file_directory(DIR_FS_CATALOG . DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/shipping/', $include_modules[$i]['file'], 'false');
					$module_file = DIR_FS_CATALOG . $module_file;
				} else {
					$lang_file = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/shipping/', $include_modules[$i]['file'], 'false');
				}
				if (@file_exists($lang_file)) {
					include_once($lang_file);
				} else {
					if (IS_ADMIN_FLAG === false && is_object($messageStack)) {
						$messageStack->add('checkout_shipping', WARNING_COULD_NOT_LOCATE_LANG_FILE . $lang_file, 'caution');
					} else {
						$messageStack->add_session(WARNING_COULD_NOT_LOCATE_LANG_FILE . $lang_file, 'caution');
					}
				}

				$this->enabled = TRUE;

				include_once($module_file);
				$GLOBALS[$include_modules[$i]['class']] = new $include_modules[$i]['class'];
			}
		}
	}

	function quote($method = '', $module = '') {
		global $total_weight, $shipping_weight, $shipping_num_boxes;

		$quotes_array = array();

		/*
		if (is_array($this->modules)) {
			$shipping_num_boxes = 1;
			$shipping_weight = $total_weight;

			$include_quotes = array();

			reset($this->modules);
			while (list(, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, '.'));
				if (zen_not_null($module)) {
					if ( ($module == $class) && (isset($GLOBALS[$class]) && $GLOBALS[$class]->enabled) ) {
						$include_quotes[] = $class;
					}
				} elseif (isset($GLOBALS[$class]) && $GLOBALS[$class]->enabled) {
					$include_quotes[] = $class;
				}
			}

			$size = sizeof($include_quotes);
			for ($i=0; $i<$size; $i++) {
				$save_shipping_weight = $shipping_weight;
				$quotes = $GLOBALS[$include_quotes[$i]]->quote($method);
				$shipping_weight = $save_shipping_weight;

				if (is_array($quotes)) $quotes_array[] = $quotes;
			}
		}

		return $quotes_array;
		 */



		$params = ['status' => 1];

		if ($module) $params['code'] = $module;

		var_dump($module);

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

	function cheapest() {
		if (is_array($this->modules)) {
			$rates = array();

			reset($this->modules);
			while (list(, $value) = each($this->modules)) {
				$class = substr($value, 0, strrpos($value, '.'));
				if ($GLOBALS[$class]->enabled) {
					$quotes = $GLOBALS[$class]->quotes;
					$size = sizeof($quotes['methods']);
					for ($i=0; $i<$size; $i++) {
						//              if ($quotes['methods'][$i]['cost']) {
						if (isset($quotes['methods'][$i]['cost'])){
							$rates[] = array('id' => $quotes['id'] . '_' . $quotes['methods'][$i]['id'],
								'title' => $quotes['module'] . ' (' . $quotes['methods'][$i]['title'] . ')',
								'cost' => $quotes['methods'][$i]['cost'],
								'module' => $quotes['id']
							);
						}
					}
				}
			}

			$cheapest = false;
			$size = sizeof($rates);
			for ($i=0; $i<$size; $i++) {
				if (is_array($cheapest)) {
					// never quote storepickup as lowest - needs to be configured in shipping module
					if ($rates[$i]['cost'] < $cheapest['cost'] and $rates[$i]['module'] != 'storepickup') {
						$cheapest = $rates[$i];
					}
				} else {
					if ($rates[$i]['module'] != 'storepickup') {
						$cheapest = $rates[$i];
					}
				}
			}
			$this->notify('NOTIFY_SHIPPING_MODULE_CALCULATE_CHEAPEST', $cheapest, $cheapest, $rates);
			return $cheapest;
		}
	}
}
