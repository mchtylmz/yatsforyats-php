<?php

namespace App\Controllers;

use \Core\View;
use \App\Config;
use \App\Session;
use \App\Models\YachtModel;
use App\Models\RegionModel;
/**
 * Yachts controller
 *
 * PHP version 7.0
 */
class Yachts extends \Core\Controller
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
      $data['PageTitle'] = read_translate('menu_yatlar');

      $filter = $this->filter();
      $data['filter_yachts'] = $filter['filter_yachts'] ?? null;
      $data['map_filter_yachts'] = $filter['map_filter_yachts'] ?? null;
      $data['filter_region'] = $filter['filter_region'] ?? null;
      $data['filter_person'] = $filter['filter_person'] ?? null;
      $data['filter_period'] = $filter['filter_period'] ?? null;
      $data['filter_type']   = $filter['filter_type'] ?? null;
      $data['notype_yachts'] = $filter['notype_yachts'] ?? null;
      $data['map_notype_yachts'] = $filter['map_notype_yachts'] ?? null;

      $data['active_menu'] = 'rent';
      // Header and Footer
      $data['header'] = true;
      $data['footer'] = true;

      View::render('yacht/index', $data);
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

    public function filter()
    {
      $region = get('region') ?? null;
      if ($region) {
       $region_row = \App\Models\RegionModel::get_by_id($region);
       if ($region_row) {
         $filter_region = lang_text($region_row['tr_title'], $region_row['en_title']);
       }
      }

      $person = get('person') ?? null;
      $filter_person = $person ? $person:null;
      if ($filter_person == '6') {
        $filter_person = '5-10';
      }
      if ($filter_person == '11') {
        $filter_person = '10+';
      }


      $type   = get('type') ?? null;
      if ($type) {
        $type_row = \App\Models\YachtModel::get_type_by_id($type);
        if ($type_row) {
          $filter_type = lang_text($type_row['type_title_tr'], $type_row['type_title_en']);
        }
      }

      $results = YachtModel::filter($region, $person, $type);
      $filter_resılts = [
        'filter_yachts'   => $results,
        'map_filter_yachts' => YachtModel::filter($region, $person, $type, 150),
      	'filter_region'   => $filter_region ?? null,
      	'filter_person'   => $filter_person ?? null,
      	'filter_period'   => get('period') == '0' ? read_translate('kis'):read_translate('yaz'),
      	'filter_type'     => $filter_type ?? null,
      ];
      if (!isset($results['yachts']) || !count($results['yachts'] ?? [])) {
        $filter_resılts['notype_yachts'] = YachtModel::filter($region, $person);
        $filter_resılts['map_notype_yachts'] = YachtModel::filter($region, $person, null, 150);
      }
      return $filter_resılts;
    }


    public function detail()
    {
      // detect_language
      detect_language($this->route_params);
      // is id
      if (isset($this->route_params['yachtid']) == true && isset($this->route_params['slugid']) == true) {
        // $yacht_id
        $yacht_id = $this->route_params['yachtid'];
        // $Yacht
        $Yacht = YachtModel::get_by_id($yacht_id);
        if (!$Yacht) throw new \Exception("Sayfa Bulunamadı!..", 404);
        // user data
        $data['Yacht'] = $Yacht;
        if ($Yacht) {
          $data['Galleries'] = YachtModel::get_gallery_by_yacht_id($Yacht['yc_id']);
          $data['Features'] = YachtModel::get_feature_by_yacht_id($Yacht['yc_id']);
          $data['Extras'] = YachtModel::get_extras_by_yacht_id($Yacht['yc_id']);
          $data['ReserveDates'] = \App\Models\ReserveModel::get_reserve_date_by_yacht_id($Yacht['yc_id']);
          // metas
          View::add_meta('og:image', uploads_url($Yacht['yc_image']));
          View::add_meta('og:image:width', '160');
          View::add_meta('og:image:height', '60');
          View::add_meta('og:type', 'website');
          View::add_meta('og:title', lang_text($Yacht['yc_title_tr'], $Yacht['yc_title_en']) . ' | ' . site_config('title'));
          View::add_meta('og:description', lang_text($Yacht['yc_title_tr'], $Yacht['yc_title_en']) . ' | ' . site_config('title'));
          View::add_meta('og:url', current_url());
          View::add_meta('fb:app_id', '');
          View::add_meta('twitter:card', 'summary_large_image');
          View::add_meta('twitter:site', '@' . site_setting('twitter'));
          View::add_meta('twitter:title', lang_text($Yacht['yc_title_tr'], $Yacht['yc_title_en']) . ' | ' . site_config('title'));
          View::add_meta('twitter:description', lang_text($Yacht['yc_title_tr'], $Yacht['yc_title_en']) . ' | ' . site_config('title'));
        } else
          throw new \Exception("Sayfa Bulunamadı!..", 404);
      } else {
        throw new \Exception("Sayfa Bulunamadı!..", 404);
      }
      // Page
      $data['PageTitle'] = lang_text($Yacht['yc_title_tr'], $Yacht['yc_title_en']);

      if ($Yacht['yc_status'] == 'sale') {
        $data['active_menu'] = 'sale';
      } else {
        $data['active_menu'] = 'rent';
      }

      // Header and Footer
      $data['header'] = true;
      $data['footer'] = true;

      View::render('yacht/detail', $data);
    }

}
