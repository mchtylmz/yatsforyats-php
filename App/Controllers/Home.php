<?php

namespace App\Controllers;

use \Core\View;
use \App\Config;
use \App\Session;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends \Core\Controller
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
      $data['PageTitle'] = read_translate('menu_anasayfa');

      // Header and Footer
      $data['header'] = true;
      $data['footer'] = true;

      View::render('index', $data);
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

    /**
     * ru_index
     *
     * @return void
     */
    public function ru_index()
    {
      $this->index();
    }


    /**
     * Show the index page
     *
     * @return void
     */
    public function result($status = 'error')
    {
      // detect_language
      detect_language($this->route_params);
      // Page
      $data['PageTitle'] = read_translate('menu_sonuc');
      $data['status'] = $status;
      if (Session::get('result_message')) {
        $data['message'] = Session::get('result_message');
        Session::delete('result_message');
      }
      if (Session::get('result_description')) {
        $data['description'] = Session::get('result_description');
        Session::delete('result_description');
      }
      // Header and Footer
      $data['header'] = true;
      $data['footer'] = true;
      // destroy
      Session::delete('form_data');

      View::render('page/result', $data);
    }

    public function en_success()
    {
      $this->result('success');
    }

    public function tr_success()
    {
      $this->result('success');
    }

    public function ru_success()
    {
      $this->result('success');
    }

    public function en_error()
    {
      $this->result('error');
    }

    public function tr_error()
    {
      $this->result('error');
    }

    public function ru_error()
    {
      $this->result('error');
    }

    public function sitemap()
    {
      header('Content-type: Application/xml; charset="utf8"', true);
      $menus = [
        site_url(),
        site_url('tr'),
        site_url('en'),
        site_url('ru'),
        site_url('en/yachts'),
        site_url('tr/yatlar'),
        site_url('ru/yakhty'),
        site_url('tr/hakkimizda'),
        site_url('en/about'),
        site_url('ru/onas'),
        site_url('tr/iletisim'),
        site_url('en/contact'),
        site_url('ru/kontakt')
      ];
      $yachts = \App\Models\YachtModel::all();
      ?>
      <urlset
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xmlns:xhtml="http://www.w3.org/1999/xhtml"
        xsi:schemaLocation="
            http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
          <?php foreach ($menus as $key => $link): ?>
          <url>
            <loc><?=$link?></loc>
            <lastmod><?=date('Y-m-d')?>T<?=date('H:i:s')?>+00:00</lastmod>
            <changefreq>daily</changefreq>
            <priority>1.00</priority>
          </url>
          <?php endforeach; ?>
          <?php if ($yachts): ?>
          <?php foreach ($yachts as $key => $yacht): ?>
          <url>
             <loc><?=site_url('tr/' . generate_permalink($yacht['yc_title_tr']) .'/'. $yacht['yc_id'])?></loc>
            <lastmod><?=date('Y-m-d')?>T<?=date('H:i:s', strtotime('-'.$key.' minutes'))?>+00:00</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.500</priority>
          </url>
          <url>
            <loc><?=site_url('en/' . generate_permalink($yacht['yc_title_en']) .'/'. $yacht['yc_id'])?></loc>
            <lastmod><?=date('Y-m-d')?>T<?=date('H:i:s', strtotime('-'.($key + 1).' minutes'))?>+00:00</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.500</priority>
          </url>
          <url>
            <loc><?=site_url('ru/' . generate_permalink($yacht['yc_title_ru']) .'/'. $yacht['yc_id'])?></loc>
            <lastmod><?=date('Y-m-d')?>T<?=date('H:i:s', strtotime('-'.($key + 1).' minutes'))?>+00:00</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.500</priority>
          </url>
          <?php endforeach; ?>
          <?php endif; ?>
      </urlset>
      <?php
    }

    public function test()
    {
      try {
        echo 1/0;
      } catch (\Exception $e) {
echo 'A';
      }

    }
}
