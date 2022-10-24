<?php
@ob_start();
// Her müşteri, tam olarak 12 saat boyunca oturum kimliğini hatırlamalıdır.
@session_set_cookie_params(43200, '/', @$_SERVER['HTTP_HOST']);
// Set the maxlifetime of session
ini_set( "session.gc_maxlifetime", 43200);
// Also set the session cookie timeout
ini_set( "session.cookie_lifetime", 43200);
@session_start();
date_default_timezone_set('Europe/Istanbul');
setlocale(LC_TIME,'turkish');


/**
 * Front controller
 *
 * PHP version 7.1
 */
if(version_compare(PHP_VERSION, '7.2', '<') == true) {
	exit('PHP sürümü en az 7.2 olmalıdır!.');
}

/**
 * Aspath define
 */
define('ASPATH', true);

/**
 * Composer
 */
$autoload = __DIR__ . '/vendor/autoload.php';
if (!file_exists($autoload) == true) {
	exit('autoload.php dosyası bulunamıyor, işleme devam edilemez!.');
}
require $autoload;

/**
 * Error and Exception handling
 */

error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
// home
$router->add('', [
	'controller' => 'Home', 'action' => 'index'
]);
$router->add('{lang:[slug]}', [
	'controller' => 'Home', 'action' => 'index'
]);
$router->add('{lang:[slug]}/home', [
	'controller' => 'Home', 'action' => 'en_index'
]);
$router->add('{lang:[slug]}/anasayfa', [
	'controller' => 'Home', 'action' => 'tr_index'
]);
$router->add('{lang:[slug]}/dom', [
	'controller' => 'Home', 'action' => 'ru_index'
]);
// --------------------------------------------
// about
$router->add('{lang:[slug]}/about', [
	'controller' => 'About', 'action' => 'en_index'
]);
$router->add('{lang:[slug]}/hakkimizda', [
	'controller' => 'About', 'action' => 'tr_index'
]);
$router->add('{lang:[slug]}/около', [
	'controller' => 'About', 'action' => 'ru_index'
]);
// --------------------------------------------
// contact
$router->add('{lang:[slug]}/contact', [
	'controller' => 'Contact', 'action' => 'en_index'
]);
$router->add('{lang:[slug]}/iletisim', [
	'controller' => 'Contact', 'action' => 'tr_index'
]);
$router->add('{lang:[slug]}/kkntakt', [
	'controller' => 'Contact', 'action' => 'ru_index'
]);
// --------------------------------------------
// privacy
$router->add('{lang:[slug]}/privacy', [
	'controller' => 'Privacy', 'action' => 'index'
]);
$router->add('{lang:[slug]}/gizlilik', [
	'controller' => 'Privacy', 'action' => 'index'
]);
$router->add('{lang:[slug]}/уединение', [
	'controller' => 'Privacy', 'action' => 'index'
]);
// --------------------------------------------
// yachts
$router->add('{lang:[slug]}/yachts', [
	'controller' => 'Yachts', 'action' => 'en_index'
]);
$router->add('{lang:[slug]}/yatlar', [
	'controller' => 'Yachts', 'action' => 'tr_index'
]);
$router->add('{lang:[slug]}/yakhty', [
	'controller' => 'Yachts', 'action' => 'ru_index'
]);
// buy yachts
$router->add('{lang:[slug]}/sale/yachts', [
	'controller' => 'BuyYachts', 'action' => 'en_index'
]);
$router->add('{lang:[slug]}/satilik/yatlar', [
	'controller' => 'BuyYachts', 'action' => 'tr_index'
]);
$router->add('{lang:[slug]}/prodazha/yakhty', [
	'controller' => 'BuyYachts', 'action' => 'ru_index'
]);
// --------------------------------------------
// yachts_detail
$router->add('{lang:[slug]}/{slugid:[any]}/{yachtid:[number]}', [
	'controller' => 'Yachts', 'action' => 'detail'
]);
// buy_yachts_detail
$router->add('{lang:[slug]}/{slugid:[any]}/{yachtid:[number]}/sale', [
	'controller' => 'BuyYachts', 'action' => 'detail'
]);
$router->add('{lang:[slug]}/{slugid:[any]}/{yachtid:[number]}/satilik', [
	'controller' => 'BuyYachts', 'action' => 'detail'
]);
$router->add('{lang:[slug]}/{slugid:[any]}/{yachtid:[number]}/prodazha', [
	'controller' => 'BuyYachts', 'action' => 'detail'
]);
// --------------------------------------------
// blogs
$router->add('{lang:[slug]}/blog', [
	'controller' => 'Blog', 'action' => 'index'
]);
// --------------------------------------------
// blog_detail
$router->add('{lang:[slug]}/{slug:[any]}/blog-{blogid:[number]}', [
	'controller' => 'Blog', 'action' => 'detail'
]);
// --------------------------------------------
// reserve
$router->add('{lang:[slug]}/reservation/re{yachtid:[number]}', [
	'controller' => 'Reserve', 'action' => 'en_index'
]);
$router->add('{lang:[slug]}/rezervasyon/re{yachtid:[number]}', [
	'controller' => 'Reserve', 'action' => 'tr_index'
]);
$router->add('{lang:[slug]}/rezervirovaniye/re{yachtid:[number]}', [
	'controller' => 'Reserve', 'action' => 'ru_index'
]);
// --------------------------------------------
// buy
$router->add('{lang:[slug]}/buy/yi{yachtid:[number]}', [
	'controller' => 'Buy', 'action' => 'en_index'
]);
$router->add('{lang:[slug]}/satinal/yi{yachtid:[number]}', [
	'controller' => 'Buy', 'action' => 'tr_index'
]);
$router->add('{lang:[slug]}/kupit/yi{yachtid:[number]}', [
	'controller' => 'Buy', 'action' => 'ru_index'
]);
// --------------------------------------------
// payment
$router->add('{lang:[slug]}/payment/{slugid:[number]}/PY{reserveid:[number]}', [
	'controller' => 'Payment', 'action' => 'en_index'
]);
$router->add('{lang:[slug]}/odeme/{slugid:[number]}/OE{reserveid:[number]}', [
	'controller' => 'Payment', 'action' => 'tr_index'
]);
$router->add('{lang:[slug]}/oplata/{slugid:[number]}/OE{reserveid:[number]}', [
	'controller' => 'Payment', 'action' => 'ru_index'
]);
// Payment
$router->add('payment/control/{pay_id:[number]}/RI{pay_row_id:[number]}', [
	'controller' => 'Payment', 'action' => 'ziraatbank_response'
]);
// --------------------------------------------
// success
$router->add('{lang:[slug]}/success', [
	'controller' => 'Home', 'action' => 'en_success'
]);
$router->add('{lang:[slug]}/basarili', [
	'controller' => 'Home', 'action' => 'tr_success'
]);
$router->add('{lang:[slug]}/uspekh', [
	'controller' => 'Home', 'action' => 'ru_success'
]);
// --------------------------------------------
// error
$router->add('{lang:[slug]}/error', [
	'controller' => 'Home', 'action' => 'en_error'
]);
$router->add('{lang:[slug]}/basarisiz', [
	'controller' => 'Home', 'action' => 'tr_error'
]);
$router->add('{lang:[slug]}/oshibka', [
	'controller' => 'Home', 'action' => 'ru_error'
]);
// --------------------------------------------
// payment result
$router->add('payment-result/{pay_id:[number]}', [
	'controller' => 'Payment', 'action' => 'payment_result'
]);
$router->add('odeme-sonucu/{pay_id:[number]}', [
	'controller' => 'Payment', 'action' => 'payment_result'
]);
$router->add('pay-response/{pay_id:[number]}', [
	'controller' => 'Payment', 'action' => 'payment_result'
]);
// --------------------------------------------
$router->add('sitemap.xml', [
	'controller' => 'Home', 'action' => 'sitemap'
]);

/*
** ANY ROUTE
*/
// dynamic route
$router->add('{controller}/{action}');

// run route
$router->dispatch($_SERVER['QUERY_STRING']);
// session aciton
ob_end_flush();
?>
