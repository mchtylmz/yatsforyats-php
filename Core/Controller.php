<?php

namespace Core;

use \App\Config;
use \App\Session;
/**
 * Base controller
 *
 * PHP version 7.0
 */
abstract class Controller
{

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = [];

    /**
     * Class constructor
     *
     * @param array $route_params  Parameters from the route
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;

        /*
        * Class session
        */
        Session::start();

        /*
        * Class not session user
        */
        if (Session::check_login() != true && get_cookie('ucookie')) {
          $user_id = \App\Models\UserModel::column_by_appkey(get_cookie('ucookie'), 'id');
          if($user_id)
            \App\Models\UserModel::session_update($user_id);
        } // cookie

        // site language
        if (get('lang')) {
          site_language(get('lang'));
        }

        // Default language
        default_language();
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name  Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     */
    public function __call($name, $args)
    {
        $method = $name;

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }

    }

    /**
     * Load helper file
     *
     * @param string $file
     *
     * @return @require file
     */
    protected function helper($file)
    {
      // file Directory
      $filename = Config::DIR_PATH . "Helpers/$file.php";
      // require file
      if ( is_readable($filename) && file_exists($filename) ) {
          require_once $filename;
      }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {

    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after()
    {

    }
}
