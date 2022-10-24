<?php

namespace App\Controllers;

use \Core\View;
use \App\Config;
use \App\Session;
use \App\Models\BlogModel;
/**
 * Blog controller
 *
 * PHP version 7.0
 */
class Blog extends \Core\Controller
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
      $data['PageTitle'] = read_translate('menu_blog');
      $data['blogs'] = BlogModel::filter();

      // Header and Footer
      $data['header'] = true;
      $data['footer'] = true;

      View::render('blog/index', $data);
    }

    public function detail()
    {
      // detect_language
      detect_language($this->route_params);
      // is id
      if (isset($this->route_params['blogid']) == true) {
        // $blogid
        $blogid = $this->route_params['blogid'];
        // $BlogDetail
        $BlogDetail = BlogModel::get_by_id($blogid);
        if (!$BlogDetail) throw new \Exception("Sayfa Bulunamadı!..", 404);
        // user data
        $data['BlogDetail'] = $BlogDetail;

        View::add_meta('og:image', uploads_url(lang_text($BlogDetail['b_image_tr'], $BlogDetail['b_image_en'])));
        View::add_meta('og:image:width', '160');
        View::add_meta('og:image:height', '60');
        View::add_meta('og:type', 'website');
        View::add_meta('og:title', lang_text($BlogDetail['b_title_tr'], $BlogDetail['b_title_en']) . ' | ' . site_config('title'));
        View::add_meta('og:description', lang_text($BlogDetail['b_title_tr'], $BlogDetail['b_title_en']) . ' | ' . site_config('title'));
        View::add_meta('og:url', current_url());
        View::add_meta('fb:app_id', '');
        View::add_meta('twitter:card', 'summary_large_image');
        View::add_meta('twitter:site', '@' . site_setting('twitter'));
        View::add_meta('twitter:title', lang_text($BlogDetail['b_title_tr'], $BlogDetail['b_title_en']) . ' | ' . site_config('title'));
        View::add_meta('twitter:description', lang_text($BlogDetail['b_title_tr'], $BlogDetail['b_title_en']) . ' | ' . site_config('title'));

      } else {
        throw new \Exception("Sayfa Bulunamadı!..", 404);
      }
      // Page
      $data['PageTitle'] = lang_text($BlogDetail['b_title_tr'], $BlogDetail['b_title_en']);

      $data['active_menu'] = 'blog';

      // Header and Footer
      $data['header'] = true;
      $data['footer'] = true;

      View::render('blog/detail', $data);
    }

}
