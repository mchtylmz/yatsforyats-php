<!DOCTYPE html>
<html lang="<?=site_config('Language')?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="keywords" content="<?=site_config('keywords')?>">
  <meta name="author" content="Enuox Bilişim">
  <meta name="copyright" content="Copyright <?=date('Y')?>">
  <meta name="version" content="v<?=site_config('Version')?>"/>
  <!-- Favicon -->
  <link rel="icon" href="<?=uploads_url(site_setting('site_favicon'))?>">
  <meta property="og:locale" content="<?=get_language()?>-<?=mb_strtoupper(get_language())?>"/>
  <?php if ($CustomMeta): ?>
  <?php foreach ($CustomMeta as $key => $meta): ?>
  <meta property="<?=$meta['name']?>" content="<?=$meta['value']?>"/>
  <?php endforeach; ?>
  <?php else: ?>
  <meta property="og:image" content="<?=uploads_url(site_setting('site_logo_normal'))?>"/>
  <meta property="og:image:width" content="160"/>
  <meta property="og:image:height" content="60"/>
  <meta property="og:type" content="website"/>
  <meta property="og:title" content="<?php echo isset($PageTitle) ? $PageTitle . ' - ':''; ?><?=site_config('title')?>"/>
  <meta property="og:description" content="<?php echo isset($PageTitle) ? $PageTitle . ' - ':''; ?><?=site_config('title')?>"/>
  <meta property="og:url" content="<?=current_url()?>"/>
  <meta property="fb:app_id" content=""/>
  <meta name="twitter:card" content="summary_large_image"/>
  <meta name="twitter:site" content="@twitter"/>
  <meta name="twitter:title" content="<?php echo isset($PageTitle) ? $PageTitle . ' - ':''; ?><?=site_config('title')?>"/>
  <meta name="twitter:description" content="<?php echo isset($PageTitle) ? $PageTitle . ' - ':''; ?><?=site_config('title')?>"/>
  <?php endif; ?>
  <link rel="canonical" href="<?=current_url()?>"/>

  <!-- Title -->
  <title><?php echo isset($PageTitle) ? $PageTitle . ' - ':''; ?><?=site_config('title')?></title>

  <!-- Style -->
  <link rel="stylesheet" href="<?=site_url('assets/dist/css/bootstrap.min.css')?>">
  <link rel="stylesheet" href="<?=site_url('assets/dist/css/main.min.css?v=1.1')?>">

  <!-- Slick -->
  <link rel="stylesheet" type="text/css" href="<?=site_url('assets/dist/libs/slick/slick.css')?>" />
  <link rel="stylesheet" type="text/css" href="<?=site_url('assets/dist/libs/slick/slick-theme.css')?>" />

  <!-- Bootstrap Select -->
  <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css" />

  <?php foreach ($CustomStyle as $key => $style): ?>
  <!-- Plugin Style -->
  <link rel="stylesheet" href="<?=$style?>" type="text/css">
  <?php endforeach; ?>

  <!-- Script -->
  <script type="text/javascript">
     var $site_url   = "<?=site_url()?>";
     var $site_lang  = "<?=site_config('Language')?>";
     var $csrf_token = "<?=csrf_token()?>";
  </script>
  <!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '265246668274876');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=265246668274876&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
  <?php if (site_setting('google_analytics')): ?>
  <!-- Google Analytics -->
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', '<?=site_setting('google_analytics')?>', 'auto');
  ga('send', 'pageview');
  </script>
  <!-- End Google Analytics -->
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?=site_setting('google_analytics')?>"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '<?=site_setting('google_analytics')?>');
  </script>
  <?php endif; ?>
  <?php if ($zendesk_code = site_setting('zendesk_code')): ?>
  <?=str_replace("&#039;", "'", html_entity_decode($zendesk_code))?>
  <?php endif; ?>
  <!-- style -->
  <style media="screen">
    .btn-site {
      border-color: #07A4BA !important;
      outline: none !important;
      color: #07A4BA;
      background-color: #07A4BA;
      color: #FFF;
    }
    .btn-site:hover,
    .btn-site:not(:disabled):not(.disabled).active,
    .btn-site:not(:disabled):not(.disabled):active, .show>.btn-site.dropdown-toggle,
    .btn-site.focus, .btn-site:focus {
      background-color: #FFF !important;
      outline: none !important;
      color: #07A4BA !important;
      box-shadow: 0 0 0 0;
    }
    .not-active {border: solid 2px transparent}
    .form-control:focus {border: 1px solid #07A4BA !important}
    .yatlar .yat-adi {font-size: 20px !important;}
    #map_desktop, #map_mobile {	height: 100%; width: 100%; background-color: #eee;outline: none !important}
    #map_desktop {min-height: 750px;}
    .text-truncate {
      display: -webkit-box;
      -webkit-line-clamp: 1;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    @media screen and (max-width: 768px) {
      .search-area {
        margin-top: -315px !important;
      }
    }
    .rimage, .yimage, .gtimage, .gimage, .feimg, .byimage {
      object-fit: cover;
      object-position: center;
    }
    .feimg {
      width: 100%;
      height: 180px;
    }
    .blimage {
      width: 100%;
      height: 250px;
    }
    .rimage, .yimage {
      width: 100%;
      height: 300px;
    }
    .gtimage {
      height: 132px;
    }
    .gimage {
      height: 640px;
    }
    .byimage {
      height: 200px;
    }
    /*
      ##Device = Laptops, Desktops
    */
    @media (min-width: 1025px) and (max-width: 1280px) {
      .rimage {
        height: 250px !important;
      }
      .yimage {
        height: 225px !important;
      }
      .byimage {
        height: 175px !important;
      }
      .gimage {
        height: 480px !important;
      }
      .blimage {
        height: 225px !important;
      }
      .feimg {
        height: 150px;
      }
    }

    /*
      ##Device = Tablets, Ipads (portrait)
    */
    @media (min-width: 768px) and (max-width: 1024px) {
      .rimage {
        height: 250px !important;
      }
      .yimage {
        height: 225px !important;
      }
      .byimage {
        height: 175px !important;
      }
      .gtimage {
        height: 99px !important;
      }
      .yat-detay-slider .item .yat-item-detaylar .yat-adi {
        font-size: 24px !important;
      }
      .gimage {
        height: 360px !important;
      }
      .blimage {
        height: 200px !important;
      }
      .feimg {
        height: 300px;
      }
    }

    /*
      ##Device = Low Resolution Tablets, Mobiles (Landscape)
    */
    @media (min-width: 481px) and (max-width: 767px) {
      .rimage {
        height: 180px !important;
      }
      .yimage {
        height: 225px !important;
      }
      .byimage {
        height: 175px !important;
      }
      .yat-detay-slider .item .yat-item-detaylar .yat-adi {
        font-size: 24px !important;
      }
      .gimage {
        height: 360px !important;
      }
      .blimage {
        height: 175px !important;
      }
      .feimg {
        height: 300px;
      }
    }

    /*
      ##Device = Most of the Smartphones Mobiles (Portrait)
    */
    @media (min-width: 320px) and (max-width: 480px) {
      .rimage {
        height: 150px !important;
      }
      .yimage {
        height: 175px !important;
      }
      .byimage {
        height: 140px !important;
      }
      .gtimage {
        height: 72px !important;
      }
      .yat-detay-slider .item .yat-item-detaylar .yat-adi {
        font-size: 24px !important;
      }
      .gimage {
        height: 360px !important;
      }
      .blimage {
        height: 150px !important;
      }
      .feimg {
        height: 300px;
      }
    }

    .yat-detay-content p {
      margin-bottom: 0px !important;
    }
    :root{--ck-color-mention-background:hsla(341, 100%, 30%, 0.1);--ck-color-mention-text:hsl(341, 100%, 30%);--ck-highlight-marker-blue:hsl(201, 97%, 72%);--ck-highlight-marker-green:hsl(120, 93%, 68%);--ck-highlight-marker-pink:hsl(345, 96%, 73%);--ck-highlight-marker-yellow:hsl(60, 97%, 73%);--ck-highlight-pen-green:hsl(112, 100%, 27%);--ck-highlight-pen-red:hsl(0, 85%, 49%);--ck-image-style-spacing:1.5em;--ck-todo-list-checkmark-size:16px}.ck-content .text-tiny{font-size:.7em}.ck-content .text-small{font-size:.85em}.ck-content .text-big{font-size:1.4em}.ck-content .text-huge{font-size:1.8em}.ck-content pre{padding:1em;color:hsl(0,0%,20.8%);background:hsla(0,0%,78%,.3);border:1px solid #c4c4c4;border-radius:2px;text-align:left;direction:ltr;tab-size:4;white-space:pre-wrap;font-style:normal;min-width:200px}.ck-content pre code{background:unset;padding:0;border-radius:0}.ck-content hr{margin:15px 0;height:4px;background:#ddd;border:0}.ck-content .marker-yellow{background-color:var(--ck-highlight-marker-yellow)}.ck-content .marker-green{background-color:var(--ck-highlight-marker-green)}.ck-content .marker-pink{background-color:var(--ck-highlight-marker-pink)}.ck-content .marker-blue{background-color:var(--ck-highlight-marker-blue)}.ck-content .pen-red{color:var(--ck-highlight-pen-red);background-color:transparent}.ck-content .pen-green{color:var(--ck-highlight-pen-green);background-color:transparent}.ck-content .image-style-side{float:right;margin-left:var(--ck-image-style-spacing);max-width:50%}.ck-content .image-style-align-left{float:left;margin-right:var(--ck-image-style-spacing)}.ck-content .image-style-align-center{margin-left:auto;margin-right:auto}.ck-content .image-style-align-right{float:right;margin-left:var(--ck-image-style-spacing)}.ck-content .image>figcaption{display:table-caption;caption-side:bottom;word-break:break-word;color:#333;background-color:#f7f7f7;padding:.6em;font-size:.75em;outline-offset:-1px}.ck-content .image{display:table;clear:both;text-align:center;margin:1em auto}.ck-content .image img{display:block;margin:0 auto;max-width:100%;min-width:50px}.ck-content .image.image_resized{max-width:100%;display:block;box-sizing:border-box}.ck-content .image.image_resized img{width:100%}.ck-content .image.image_resized>figcaption{display:block}.ck-content span[lang]{font-style:italic}.ck-content blockquote{overflow:hidden;padding-right:1.5em;padding-left:1.5em;margin-left:0;margin-right:0;font-style:italic;border-left:solid 5px #ccc}.ck-content[dir=rtl] blockquote{border-left:0;border-right:solid 5px #ccc}.ck-content code{background-color:hsla(0,0%,78%,.3);padding:.15em;border-radius:2px}.ck-content .table{margin:1em auto;display:table}.ck-content .table table{border-collapse:collapse;border-spacing:0;width:100%;height:100%;border:1px double #b2b2b2}.ck-content .table table td,.ck-content .table table th{min-width:2em;padding:.4em;border:1px solid #bfbfbf}.ck-content .table table th{font-weight:700;background:hsla(0,0%,0%,5%)}.ck-content[dir=rtl] .table th{text-align:right}.ck-content[dir=ltr] .table th{text-align:left}.ck-content .page-break{position:relative;clear:both;padding:5px 0;display:flex;align-items:center;justify-content:center}.ck-content .page-break::after{content:'';position:absolute;border-bottom:2px dashed #c4c4c4;width:100%}.ck-content .page-break__label{position:relative;z-index:1;padding:.3em .6em;display:block;text-transform:uppercase;border:1px solid #c4c4c4;border-radius:2px;font-family:Helvetica,Arial,Tahoma,Verdana,Sans-Serif;font-size:.75em;font-weight:700;color:#333;background:#fff;box-shadow:2px 2px 1px hsla(0,0%,0%,.15);-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.ck-content .media{clear:both;margin:1em 0;display:block;min-width:15em}.ck-content .todo-list{list-style:none}.ck-content .todo-list li{margin-bottom:5px}.ck-content .todo-list li .todo-list{margin-top:5px}.ck-content .todo-list .todo-list__label>input{-webkit-appearance:none;display:inline-block;position:relative;width:var(--ck-todo-list-checkmark-size);height:var(--ck-todo-list-checkmark-size);vertical-align:middle;border:0;left:-25px;margin-right:-15px;right:0;margin-left:0}.ck-content .todo-list .todo-list__label>input::before{display:block;position:absolute;box-sizing:border-box;content:'';width:100%;height:100%;border:1px solid #333;border-radius:2px;transition:250ms ease-in-out box-shadow,250ms ease-in-out background,250ms ease-in-out border}.ck-content .todo-list .todo-list__label>input::after{display:block;position:absolute;box-sizing:content-box;pointer-events:none;content:'';left:calc(var(--ck-todo-list-checkmark-size)/ 3);top:calc(var(--ck-todo-list-checkmark-size)/ 5.3);width:calc(var(--ck-todo-list-checkmark-size)/ 5.3);height:calc(var(--ck-todo-list-checkmark-size)/ 2.6);border-style:solid;border-color:transparent;border-width:0 calc(var(--ck-todo-list-checkmark-size)/ 8) calc(var(--ck-todo-list-checkmark-size)/ 8) 0;transform:rotate(45deg)}.ck-content .todo-list .todo-list__label>input[checked]::before{background:#25ab33;border-color:#25ab33}.ck-content .todo-list .todo-list__label>input[checked]::after{border-color:#fff}.ck-content .todo-list .todo-list__label .todo-list__label__description{vertical-align:middle}.ck-content .raw-html-embed{margin:1em auto;min-width:15em;font-style:normal}.ck-content .mention{background:var(--ck-color-mention-background);color:var(--ck-color-mention-text)}@media print{.ck-content .page-break{padding:0}.ck-content .page-break::after{display:none}}
  </style>
</head>
<body <?=isset($body_id) && $body_id ? 'id="'.$body_id.'"':''?>>
