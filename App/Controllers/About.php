<?php

namespace App\Controllers;

use \Core\View;
use \App\Config;
use \App\Session;

/**
 * About controller
 *
 * PHP version 7.0
 */
class About extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function index()
    {
      // detect_language
      detect_language($this->route_params);
      // Page
      $data['PageTitle'] = read_translate('menu_hakkimizda');

      // Header and Footer
      $data['header'] = true;
      $data['footer'] = true;

      View::render('page/about', $data);
    }

    /**
     * en_index
     *
     * @return void
     */
    public function en_index()
    {
      $this->index();
    }

    /**
     * tr_index
     *
     * @return void
     */
    public function tr_index()
    {
      $this->index();
    }

    public function ru_index()
    {
      $this->index();
    }

}
