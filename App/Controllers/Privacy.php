<?php

namespace App\Controllers;
use \Core\Model;
use \Core\View;
use \App\Config;
use \App\Session;

/**
 * Contact controller
 *
 * PHP version 7.0
 */
class Privacy extends \Core\Controller
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
      $data['PageTitle'] = lang_text(site_setting('privacy_page_title_tr'), site_setting('privacy_page_title_en'));

      // Header and Footer
      $data['header'] = true;
      $data['footer'] = true;

      View::render('page/privacy', $data);
    }
}
