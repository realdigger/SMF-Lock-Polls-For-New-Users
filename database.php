<?php
/**
 * @package SMF Lock Polls For New Users
 * @author digger http://mysmf.ru
 * @copyright 2012-2016
 * @license The MIT License (MIT)
 * @version 1.0
 */

if (file_exists(dirname(__FILE__) . '/SSI.php') && !defined('SMF')) {
    require_once(dirname(__FILE__) . '/SSI.php');
} elseif (!defined('SMF')) {
    die('<b>Error:</b> Cannot install - please verify that you put this file in the same place as SMF\'s index.php and SSI.php files.');
}

if ((SMF == 'SSI') && !$user_info['is_admin']) {
    die('Admin privileges required.');
}

global $smcFunc;
db_extend('packages');

$column_info = array('name' => 'date_started', 'type' => 'timestamp null default current_timestamp', 'null' => true);
$parameters = array();

$smcFunc['db_add_column'] ('{db_prefix}polls', $column_info, $parameters, 'ignore');

if (SMF == 'SSI') {
    echo 'Database changes are complete! <a href="/">Return to the main page</a>.';
}