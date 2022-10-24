<?php

namespace Core;

use \App\Config;
use \App\Models\SettingsModel;
/**
 * View
 *
 * PHP version 7.0
 */
class View
{
    // Include styles
    private static $custom_style  = [];

    // Include styles
    private static $custom_script = [];

    // Include custom header
    private static $header_code   = '';

    // Include custom footer
    private static $footer_code   = '';

    // include modal view
    private static $page_modal    = [];

    // include meta view
    private static $page_meta    = [];

    /**
     * Render a view file
     *
     * @param string $view  The view file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function render($view, $data = [], $extension = null)
    {
        // add header and footer script
        $data['CustomStyle']  = self::$custom_style;
        $data['CustomScript'] = self::$custom_script;
        // get header and footer manuel code
        $data['HeaderCode'] = self::$header_code;
        $data['FooterCode'] = self::$footer_code;
        /// get modal
        $data['CustomModal'] = self::$page_modal;
        /// get meta
        $data['CustomMeta'] = self::$page_meta;
        // language
        $data['Language'] = get_language();
        // data export variable
        extract($data, EXTR_SKIP);
        // view $extension
        if(!$extension) $extension = extension($view);
        // is file
        $file = Config::VIEW_PATH . $view . $extension;  // relative to Core directory
        // file readable
        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    // Add meta src
    public static function add_meta($name, $value = '')
    {
      self::$page_meta[] = [
        'name'  => $name,
        'value' => $value
      ];
    }

    // Add Style src
    public static function add_style($style, $external = false, $version = false)
    {
      if ($version) {
        $style = $style . '?v=' . (Config::SHOW_ERRORS ? '0.'.date('hi'):Config::VERSION);
      }

      $prepend_url = site_path('Public');
      if ($external) $prepend_url = '';

      self::$custom_style[] = $prepend_url . $style;
    }

    // Add Script src
    public static function add_script($script, $external = false, $version = false)
    {
      if ($version) {
        $script = $script . '?v=' . (Config::SHOW_ERRORS ? '0.'.date('hi'):Config::VERSION);
      }

      $prepend_url = site_path('Public');
      if ($external) $prepend_url = '';

      self::$custom_script[] = $prepend_url . $script;
    }

    // Add Footer Code script and style
    public static function add_header_code($code)
    {
      self::$header_code = self::$header_code . $code;
    }

    // Add Header Code script and style
    public static function add_footer_code($code)
    {
      self::$footer_code = self::$footer_code . $code;
    }

    // Add footer modal
    public static function add_modal($modal)
    {
      self::$page_modal[] = $modal;
    }

    // add plugin
    public static function plugin($plugin_name)
    {
      switch ($plugin_name) {
        case 'dataTable': {
          // style
          // self::add_style('https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css', true);
          self::add_style('assets/vendors/datatables-buttons-dt/buttons.dataTables.min.css');
          // script
          self::add_script('assets/vendors/datatables/jquery.dataTables.min.js');
          self::add_script('assets/vendors/datatables-buttons/dataTables.buttons.min.js');
          self::add_script('assets/vendors/datatables-buttons/buttons.print.min.js');
          self::add_script('assets/vendors/datatables-buttons/buttons.colVis.min.js');
          self::add_script('assets/vendors/jszip/jszip.min.js');
          self::add_script('assets/vendors/datatables-buttons/buttons.html5.min.js');
          // self::add_script('https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js', true);
        } break;

        case 'select2': {
          // style
          self::add_style('assets/vendors/select2/css/select2.min.css');
          // script
          self::add_script('assets/vendors/select2/js/select2.full.min.js');
          self::add_script('assets/vendors/select2/js/i18n/tr.js');
        } break;

        case 'selectpicker': {
          // style
          self::add_style('assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css');
          // script
          self::add_script('assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js');
          self::add_script('assets/vendors/bootstrap-select/dist/js/i18n/defaults-tr_TR.min.js');
        } break;

        case 'dateTimePicker': {
          // script
          self::add_script('assets/vendors/bootstrap-datetimepicker.js');
        } break;

        case 'datePicker': {
          self::add_script('assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');
          self::add_script('assets/vendors/bootstrap-datepicker/dist/locales/bootstrap-datepicker.tr.min.js');
        } break;

        case 'flatpicker': {
          self::add_style('assets/vendors/flatpickr/flatpickr.min.css');
          self::add_script('assets/vendors/flatpickr/flatpickr.min.js');
        } break;

        case 'ckeditor5': {
          // style
          self::add_style('assets/css/ckeditor5.css');
          // script
          self::add_script('assets/vendor/ckeditor5/ckeditor.js');
          self::add_script('assets/vendor/ckeditor5/translations/tr.js');
        } break;

        case 'summernote': {
          // style
          self::add_style('assets/vendor/summernote/summernote-lite.min.css');
          // script
          self::add_script('assets/vendor/summernote/summernote-lite.min.js');
          self::add_script('assets/vendor/summernote/lang/summernote-tr-TR.min.js');

        } break;

        case 'tinymce': {
          // style
          // script
          self::add_script('https://cdn.tinymce.com/4/tinymce.min.js', true);
          self::add_script('assets/vendor/tinymce/langs/tr_TR.js');

        } break;

        case 'wsgyeditor': {
          // style
          self::add_style('assets/vendors/trumbowyg/ui/trumbowyg.min.css');
          // script
          self::add_script('assets/vendors/trumbowyg/trumbowyg.min.js');

        } break;

        case 'side_modal': {
          // style
          self::add_style('assets/css/bootstrap-side-modals.css');

        } break;

        case 'fullcalendar': {
          // style
          self::add_style('assets/vendor/fullcalendar/dist/fullcalendar.min.css');
          // script
          self::add_script('assets/vendor/moment/min/moment.min.js');
          self::add_script('assets/vendor/fullcalendar/dist/fullcalendar.min.js');
          self::add_script('assets/vendor/fullcalendar/dist/locale/tr.js');
        } break;

        case 'chart': {
          // script
          self::add_script('assets/vendors/flot/jquery.flot.js');
          self::add_script('assets/vendors/flot/jquery.flot.resize.js');
          self::add_script('assets/vendors/flot.curvedlines/curvedLines.js');
          self::add_script('assets/vendors/easy-pie-chart/jquery.easypiechart.min.js');
          self::add_script('assets/vendors/sparkline/jquery.sparkline.min.js');

          self::add_script('assets/vendors/flot/jquery.flot.js');
          self::add_script('assets/vendors/flot/jquery.flot.resize.js');
          self::add_script('assets/vendors/flot.curvedlines/curvedLines.js');
          self::add_script('assets/vendors/easy-pie-chart/jquery.easypiechart.min.js');
          self::add_script('assets/vendors/salvattore/salvattore.min.js');
          self::add_script('assets/vendors/sparkline/jquery.sparkline.min.js');
          self::add_script('assets/vendors/moment/moment.min.js');

          self::add_script('assets/demo/js/flot-charts/curved-line.js');
          self::add_script('assets/demo/js/flot-charts/line.js');
          self::add_script('assets/demo/js/flot-charts/chart-tooltips.js');
          self::add_script('assets/demo/js/other-charts.js');

        } break;

        case 'reCAPTCHA': {
          // script
          self::add_script('https://www.google.com/recaptcha/api.js?hl=tr', true);
        } break;

        case 'dropzone': {
          // style
          self::add_style('assets/vendors/dropzone/dropzone.css');
          // script
          self::add_script('assets/vendors/dropzone/dropzone.min.js');
        } break;

      } // switch
    }
}
