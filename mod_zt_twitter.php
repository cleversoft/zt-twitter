<?php
/**
 * @package ZT Twitter module for Joomla! 2.5 vs Joomla 3.0
 * @author Hiepvu
 * @copyright (C) 2013 - ZooTemplate.Com
 * @license PHP files are GNU/GPL
**/
//no direct accees
defined ('_JEXEC') or die ('resticted aceess');

defined('DS') or define('DS', DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__).DS.'helper.php');

$helper = new modZTTwitterHelper($params);
$rows = $helper->getList();
require JModuleHelper::getLayoutPath('mod_zt_twitter',$params->get('module_layout','default'));
