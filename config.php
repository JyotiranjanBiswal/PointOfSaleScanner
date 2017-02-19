<?php
/**
 * Point Of Sale Scanner
 * 
 * @package     Poss
 * @copyright   biswal@jyotiranjan.in 
 * @author      Jyotiranjan Biswal <biswal@jyotiranjan.in>
 *
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

if (version_compare(phpversion(), '5.3.0', '<')===true) {
    echo  '<div style="font:12px/1.35em arial, helvetica, sans-serif;">
	<div style="margin:0 0 25px 0; border-bottom:1px solid #ccc;">
	<h3 style="margin:0; font-size:1.7em; font-weight:normal; text-transform:none; text-align:left; color:#2f2f2f;">
	Whoops, it looks like you have an invalid PHP version.</h3></div><p>This Application supports PHP 5.3.0 or newer.</div>';
	exit;
}

define('POSS_ROOT', getcwd());

/**
 * includes main application file
 */
 
$possFilename = POSS_ROOT . '/app/Poss.php';

if (!file_exists($possFilename)) {
    echo $possFilename." was not found";
    exit;
}

require_once $possFilename;
ini_set('display_errors', 1);

umask(0);