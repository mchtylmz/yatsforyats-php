
<?php foreach ($CustomModal as $key => $modal): private_view($modal, $data); endforeach; ?>
<!-- Footer -->
<?php if (isset($border_top)): ?>
<div class="container-fluid border-top">
<?php endif; ?>
<div class="container footer">
    <div class="row align-items-center border-bottom-0 border-lg-bottom py-5">
        <div class="col-lg-3 col-12 d-flex justify-content-center justify-content-lg-start mb-5 mb-lg-0">
            <img style="max-width: 150px;" src="<?=uploads_url(site_setting('site_logo_beyaz'))?>" alt="<?=site_config('title')?>">
        </div>
        <div class="col-lg-6 col-12 mb-5 mb-lg-0">
            <div class="text-center"><!-- d-flex justify-content-center -->
                <a href="<?=lang_site_url(lang_text('satilik/yatlar', 'sale/yachts', 'prodazha/yakhty'))?>" class="footer-link-item mx-3" style="display: inline !important; line-height: 300% !important">
                  <?=read_translate('menu_satilik_yatlar')?>
                </a>
                <a href="<?=lang_site_url(lang_text('yatlar', 'yachts', 'yakhty'))?>" class="footer-link-item mx-3" style="display: inline !important; line-height: 300% !important">
                  <?=read_translate('menu_yatlar')?>
                </a>
                <a href="<?=lang_site_url(lang_text('blog', 'blog', 'blog'))?>" class="footer-link-item mx-3" style="display: inline !important; line-height: 300% !important">
                  <?=read_translate('menu_blog')?>
                </a>
                <a href="<?=lang_site_url(lang_text('hakkimizda', 'about', 'около'))?>" class="footer-link-item mx-3" style="display: inline !important; line-height: 300% !important">
                  <?=read_translate('menu_hakkimizda')?>
                </a>
                <a href="<?=lang_site_url(lang_text('iletisim', 'contact', 'kkntakt'))?>" class="footer-link-item mx-3" style="display: inline !important; line-height: 300% !important">
                  <?=read_translate('menu_iletisim')?>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-12 d-flex justify-content-center justify-content-lg-end mb-0 mb-lg-0">
            <div class="d-flex justify-content-end">
                <div class="footer-social-item mx-3">
                    <a target="_blank" href="https://facebook.com/<?=site_setting('facebook')?>">
                      <img src="<?=site_url('assets/dist/img/Facebook.svg')?>" style="width: 26px">
                    </a>
                </div>
                <div class="footer-social-item mx-3">
                    <a target="_blank" href="https://twitter.com/<?=site_setting('twitter')?>">
                      <img src="<?=site_url('assets/dist/img/Twitter.svg')?>">
                    </a>
                </div>
                <div class="footer-social-item mx-3">
                    <a target="_blank" href="https://instagram.com/<?=site_setting('instagram')?>">
                      <img src="<?=site_url('assets/dist/img/Instagram.svg')?>">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row py-4 border-top align-items-center">
        <div class="col-8 text-center text-lg-left">
            <div class="copyright">© <?=date('Y')?> <?=site_config('title')?> | <?=read_translate('footer_telif_hakki')?></div>
        </div>
        <div class="col-4 text-center text-lg-right">
          <a href="<?=lang_site_url(lang_text('gizlilik', 'privacy', 'privacy'))?>" class="text-dark">
            <?=lang_text(site_setting('privacy_page_title_tr'), site_setting('privacy_page_title_en'))?>
          </a>
        </div>
    </div>
</div>
<?php if (isset($border_top)): ?>
</div>
<?php endif; ?>

<script src="<?=site_url('assets/dist/js/jquery-3.5.1.slim.min.js')?>"></script>
<script src="<?=site_url('assets/dist/js/popper.min.js')?>"></script>
<script src="<?=site_url('assets/dist/js/bootstrap.min.js')?>"></script>
<script src="<?=site_url('assets/dist/js/main.prod.js')?>"></script>
<script src="<?=site_url('assets/dist/libs/slick/slick.min.js')?>"></script>

<script>
    $(document).ready(function () {
      window.change_filter = function(text_element, text_value, input_element, input_value) {
        $(text_element).text(text_value);
        $(input_element).val(input_value);
      };
        $('.main-slider').slick({
            dots: true,
            autoplay: true,
            autoplaySpeed: 3000,
        });
        $('.gidilecek-yerler').slick({
            slidesToShow: 4,
            rows: 1,
            slidesToScroll: 4,
            arrows: true,
            dots: true,
            infinite: false,
            prevArrow: '<div class="slick-prev"><i class="fa fa-chevron-left"></i></div>',
            nextArrow: '<div class="slick-next"><i class="fa fa-chevron-right"></i></div>',
            responsive: [{
                breakpoint: 760,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: false,
                    arrows: false,
                    dots: true,
                }
            }]
        });
        $('.en-luks-yatlar').slick({
            slidesToShow: 3,
            rows: 2,
            slidesToScroll: 3,
            arrows: true,
            dots: true,
            infinite: false,
            prevArrow: '<div class="slick-prev"><i class="fa fa-chevron-left"></i></div>',
            nextArrow: '<div class="slick-next"><i class="fa fa-chevron-right"></i></div>',
            responsive: [{
                breakpoint: 760,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: false,
                    arrows: false,
                    dots: true,
                }
            }]
        });
        $('.organizasyon-slider').slick({
            slidesToShow: 2,
            slidesToScroll: 2,
            arrows: true,
            dots: true,
            infinite: false,
            prevArrow: '<div class="slick-prev"><i class="fa fa-chevron-left"></i></div>',
            nextArrow: '<div class="slick-next"><i class="fa fa-chevron-right"></i></div>',
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 1.1,
                    slidesToScroll: 1,
                    infinite: false,
                    arrows: false,
                    dots: true,
                }
            }]
        });
        $('.info-slider').slick({
            slidesToShow: 4,
            slidesToScroll: 4,
            arrows: false,
            dots: false,
            infinite: false,
            prevArrow: '<div class="slick-prev"><i class="fa fa-chevron-left"></i></div>',
            nextArrow: '<div class="slick-next"><i class="fa fa-chevron-right"></i></div>',
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: false,
                    arrows: false,
                    dots: true,
                }
            }]
        });
        $('.contact-slider').slick({
            slidesToShow: 3,
            autoplay: false,
            speed: 1000,
            arrows: false,
            dots: false,
            responsive: [{
                breakpoint: 992,
                settings: {
                    slidesToShow: 1,
                    dots: true,
                }
            }]
        });
    });
</script>
</body>
</html>


<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<?php if (get_language() == 'tr'): ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/tr.min.js" charset="utf-8"></script>
<script type="text/javascript">
window.turkish_daterangepicker = {
"direction": "ltr",
"format": "YYYY-MM-DD",
"separator": " - ",
"applyLabel": "Seç",
"cancelLabel": "Vazgeç",
"fromLabel": "Nereden",
"toLabel": "Nereye",
"customRangeLabel": "Özel Aralık",
"daysOfWeek": [
    "Pzt",
    "Sal",
    "Çar",
    "Per",
    "Cum",
    "Cmt",
    "Paz"
    // Pzt, Sal, Çar, Per, Cum, Cmt, Paz
],
"monthNames": [
    // Oca, Şub, Mar, Nis, May, Haz, Tem, Ağu, Eyl, Eki, Kas, Ara
    "Ocak",
    "Şubat",
    "Mart",
    "Nisan",
    "Mayıs",
    "Haziran",
    "Temmuz",
    "Ağustos",
    "Eylül",
    "Ekim",
    "Kasım",
    "Aralık"
],
"firstDay": 1
};
</script>
<?php else: ?>
<script type="text/javascript">
  window.turkish_daterangepicker = {};
</script>
<?php endif; ?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<?php if (get('period_start') && get('period_end')): ?>
<script type="text/javascript">
 window.start = moment('<?=date('Y-m-d', strtotime(get('period_start')))?>');
 window.end = moment('<?=date('Y-m-d', strtotime(get('period_end')))?>');
</script>
<?php else: ?>
<script type="text/javascript">
 window.start = moment();
 window.end = moment();
</script>
<?php endif; ?>
<script type="text/javascript">
$(function() {
    function cb(start, end) {
        var start_txt = start.format('DD MMM');
        var end_txt = end.format('DD MMM');
        if (start_txt == end_txt) {
          $('#dropdownPeriod span').html(start.format('DD MMMM'));
          $('#mobil_zaman span').html(start.format('DD MMMM'));
        } else {
          $('#dropdownPeriod span').html(start.format('DD MMM') + '/' + end.format('DD MMM'));
          $('#mobil_zaman span').html(start.format('DD MMM') + '/' + end.format('DD MMM'));
        }
        $('#period_start').val(start.format('YYYY-MM-DD'));
        $('#period_end').val(end.format('YYYY-MM-DD'));
    }
    $('#dropdownPeriod').daterangepicker({
        locale : turkish_daterangepicker,
        startDate: start,
        endDate: end,
        opens: "center"
    }, cb);
    $('#mobil_zaman').daterangepicker({
        locale : turkish_daterangepicker,
        startDate: start,
        endDate: end,
        opens: "center",
    }, cb);
    cb(start, end);
});
</script>
