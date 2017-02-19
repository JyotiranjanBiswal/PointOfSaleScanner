<?php
/**
 * Point Of Sale Scanner
 * 
 * @package     Poss
 * @copyright   biswal@jyotiranjan.in 
 * @author      Jyotiranjan Biswal <biswal@jyotiranjan.in>
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * INFORMATION
 *
 * Classes source autoload
 */
class Poss_Autoload
{
    static protected $_instance;
    static protected $_scope = 'default';
	
    /**
     * Class constructor
     */
    public function __construct()
    {
        self::registerScope(self::$_scope);
    }

    /**
     * Singleton pattern implementation
     *
     * @return Poss_Autoload
     */
    static public function instance()
    {
        if (!self::$_instance) {
            self::$_instance = new Poss_Autoload();
        }
        return self::$_instance;
    }

    /**
     * Register SPL autoload function
     */
    static public function register()
    {
        spl_autoload_register(array(self::instance(), 'autoload'));
    }

    /**
     * Load class source code
     *
     * @param string $class
     */
    public function autoload($class)
    {
        $classFile = str_replace(' ', DIRECTORY_SEPARATOR, ucwords(str_replace('_', ' ', $class)));
        $classFile.= '.php';
        //echo $classFile;die();
        return include $classFile;
    }

    /**
     * Register autoload scope
     * This process allow include scope file which can contain classes
     * definition which are used for this scope
     *
     * @param string $code scope code
     */
    static public function registerScope($code)
    {
        self::$_scope = $code;
    }

    /**
     * Get current autoload scope
     *
     * @return string
     */
    static public function getScope()
    {
        return self::$_scope;
    }
}
