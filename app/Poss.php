<?php
/**
 * Point Of Sale Scanner
 * 
 * @package     Poss
 * @copyright   biswal@jyotiranjan.in
 * @author      Jyotiranjan Biswal <biswal@jyotiranjan.in>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('BP', dirname(dirname(__FILE__)));

Poss::register('original_include_path', get_include_path());

/**
 * Set include path
 */
$paths = array();
$paths[] = BP . DS . 'app' . DS . 'poss';

$appPath = implode(PS, $paths);
set_include_path($appPath . PS . Poss::registry('original_include_path'));
include_once "lib/Autoload.php";

Poss_Autoload::register();

/**
 * Main Poss hub class
 *
 * @author      Jyotiranjan Biswal <biswal@jyotiranjan.in>
 */
final class Poss
{
    /**
     * Registry collection
     *
     * @var array
     */
    static private $_registry = array();

    /**
     * Application root absolute path
     *
     * @var string
     */
    static private $_appRoot;

    /**
     * Set all my static data to defaults
     */
    public static function reset()
    {
        self::$_registry        = array();
        self::$_appRoot         = null;
    }

    /**
     * Register a new variable
     *
     * @param string $key
     * @param mixed $value
     * @param bool $graceful
     * @throws Exception
     */
    public static function register($key, $value, $graceful = false)
    {
        if (isset(self::$_registry[$key])) {
            if ($graceful) {
                return;
            }
            throw new Exception('Poss registry key "'.$key.'" already exists');
        }
        self::$_registry[$key] = $value;
    }

    /**
     * Unregister a variable from register by key
     *
     * @param string $key
     */
    public static function unregister($key)
    {
        if (isset(self::$_registry[$key])) {
            if (is_object(self::$_registry[$key]) && (method_exists(self::$_registry[$key], '__destruct'))) {
                self::$_registry[$key]->__destruct();
            }
            unset(self::$_registry[$key]);
        }
    }

    /**
     * Retrieve a value from registry by a key
     *
     * @param string $key
     * @return mixed
     */
    public static function registry($key)
    {
        if (isset(self::$_registry[$key])) {
            return self::$_registry[$key];
        }
        return null;
    }

    /**
     * Set application root absolute path
     *
     * @param string $appRoot
     * @throws Exception
     */
    public static function setRoot($appRoot = '')
    {
        if (self::$_appRoot) {
            return ;
        }

        if ('' === $appRoot) {
            // automagically find application root by dirname of Poss.php
            $appRoot = dirname(__FILE__);
        }

        $appRoot = realpath($appRoot);

        if (is_dir($appRoot) and is_readable($appRoot)) {
            self::$_appRoot = $appRoot;
        } else {
            throw new Exception($appRoot . ' is not a directory or not readable by this user');
        }
    }

    /**
     * Retrieve application root absolute path
     *
     * @return string
     */
    public static function getRoot()
    {
        return self::$_appRoot;
    }
	
    /**
     * Display exception
     *
     * @param Exception $e
     */
    public static function printException(Exception $e, $extra = '')
    {
        print '<pre>';

		if (!empty($extra)) {
			print $extra . "\n\n";
		}

		print $e->getMessage() . "\n\n";
		print $e->getTraceAsString();
		print '</pre>';

        die();
    }
}
