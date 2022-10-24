<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{
    /**
     * system version
     * @var string
     */
    const VERSION = '';

    /**
     * Database type
     * @var string
     */
    const DB_TYPE = '';

    /**
     * Database host
     * @var string
     */
    const DB_HOST = '';

    /**
     * Database name
     * @var string
     */
     const DB_NAME = '';

     /**
      * Database user
      * @var string
      */
     const DB_USER = '';

     /**
      * Database password
      * @var string
      */
     const DB_PASS = '';

    /**
     * Database charset
     * @var string
     */
    const DB_CHAR = 'utf8';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;

    /**
     * site url
     * end of word should not end => '/'
     * @var string
     */
    const SCHEME = 'https://';

    /**
     * site url
     * end of word should not end => '/'
     * @var string
     */
    const HTTP_HOST = '';

    /**
     * site url
     * end of word should not end => '/'
     * @var string
     */
    const SITE_URL = self::SCHEME . self::HTTP_HOST;
    const ADMIN_SITE_URL = self::SCHEME .'site.'. self::HTTP_HOST;

    /**
     * path/assets url
     * end of word and start of word => '/'
     * @var string
     */
    const PATH_URL = '/';

    /**
     * dir path
     * @var string
     */
    const DIR_PATH = __DIR__ . '/';

    /**
     * auth url
     * @var string
     */
    const HOME_URL = self::ADMIN_SITE_URL . self::PATH_URL . 'home';

    /**
     * auth url
     * @var string
     */
    const AUTH_URL = self::ADMIN_SITE_URL . self::PATH_URL . 'auth';

    /**
     * string hash prepend code
     * just word characters
     * @var string
     */
    const HASH = '';

    /**
     * string csrf name
     * just word characters
     * @var string
     */
    const CSRF = '_csrf';

    /**
     * string cookie prefix
     * just word characters
     * @var string
     */
    const COOKIE_PREFIX = '';

    /**
     * string app onesignal meta name
     * @var string
     */
    const ONESIGNAL_META_NAME = '';

    /**
     * google maps geocode apikey
     * @var string
     */
    const GEOCODE_MAPS_APIKEY = "";

    /**
     * view dir path
     * @var string
     */
    const VIEW_PATH = self::DIR_PATH . 'Views/';

    /**
     * upload path
     * @var string
     */
    const UPLOAD_PATH = self::DIR_PATH . '../uploads/';
    const FRONTED_UPLOAD_PATH = self::DIR_PATH . '../uploads/';

    /**
     * cache path
     * @var string
     */
    const CACHE_PATH = self::DIR_PATH . 'Cache/';


    /**
     * language | default language[0]
     * @var string
     */
    const LANGUAGES = ['tr', 'en'];
}
