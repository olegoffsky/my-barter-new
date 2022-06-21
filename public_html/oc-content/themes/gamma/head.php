<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title><?php echo meta_title(); ?></title>
<meta name="title" content="<?php echo osc_esc_html(meta_title()); ?>" />
<?php if( meta_description() != '' ) { ?><meta name="description" content="<?php echo osc_esc_html(meta_description()); ?>" /><?php } ?>
<?php if( osc_get_canonical() != '' ) { ?><link rel="canonical" href="<?php echo osc_get_canonical(); ?>"/><?php } ?>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="Mon, 01 Jul 1970 00:00:00 GMT" />
<?php if( !osc_is_search_page() )  { ?>
<meta name="robots" content="index, follow" />
<meta name="googlebot" content="index, follow" />
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />


<?php osc_current_web_theme_path('head-favicon.php') ; ?>
<?php osc_current_web_theme_path('head-color.php') ; ?>

<?php
  $current_locale = osc_get_current_user_locale();
  $dimNormal = explode('x', osc_get_preference('dimNormal', 'osclass'));
?>

<script type="text/javascript">
  var gamCurrentLocale = '<?php echo osc_esc_js($current_locale['s_name']); ?>';
  var fileDefaultText = '<?php echo osc_esc_js(__('No file selected', 'gamma')); ?>';
  var fileBtnText     = '<?php echo osc_esc_js(__('Choose File', 'gamma')); ?>';
  var baseDir = "<?php echo osc_base_url(); ?>";
  var baseSearchUrl = '<?php echo osc_search_url(array('page' => 'search')); ?>';
  var baseAjaxUrl = '<?php echo gam_ajax_url(); ?>';
  var baseAdminDir = '<?php echo osc_admin_base_url(true); ?>';
  var currentLocation = '<?php echo osc_get_osclass_location(); ?>';
  var currentSection = '<?php echo osc_get_osclass_section(); ?>';
  var adminLogged = '<?php echo osc_is_admin_user_logged_in() ? 1 : 0; ?>';
  var gamLazy = '<?php echo gam_is_lazy(); ?>';
  var gamMasonry = '<?php echo osc_get_preference('force_aspect_image', 'osclass') == 1 ? 1 : 0; ?>';
  var imgPreviewRatio= <?php echo round($dimNormal[0]/$dimNormal[1], 3); ?>;
  var searchRewrite = '/<?php echo osc_get_preference('rewrite_search_url', 'osclass'); ?>';
  var ajaxSearch = '<?php echo (gam_param('search_ajax') == 1 ? '1' : '0'); ?>';
  var ajaxForms = '<?php echo (gam_param('forms_ajax') == 1 ? '1' : '0'); ?>';
  var locationPick = '<?php echo (gam_param('location_pick') == 1 ? '0' : '0'); ?>';
  var gamTitleNc = '<?php echo osc_esc_js(__('Parent category cannot be selected', 'gamma')); ?>';
</script>


<?php
osc_enqueue_style('style', osc_current_web_theme_url('css/style.css?v=' . date('YmdHis')));
osc_enqueue_style('responsive', osc_current_web_theme_url('css/responsive.css?v=' . date('YmdHis')));
//osc_enqueue_style('montserrat', 'https://fonts.googleapis.com/css?family=Montserrat:200,400,600');
//osc_enqueue_style('quicksand', 'https://fonts.googleapis.com/css?family=Quicksand:400,500,700&display=swap&subset=latin-ext,vietnamese');
//osc_enqueue_style('nunito', 'https://fonts.googleapis.com/css?family=Nunito:400,500,600,700,800&display=swap&subset=latin-ext,vietnamese');
//osc_enqueue_style('encode-sans', 'https://fonts.googleapis.com/css?family=Encode+Sans+Condensed:600,700,800&display=swap');

osc_enqueue_style('fonts', 'https://fonts.googleapis.com/css?family=Nunito:400,600,700|Encode+Sans+Condensed:600,700&display=swap');

osc_remove_style('font-awesome');
//osc_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
osc_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css');

osc_enqueue_style('jquery-ui', osc_current_web_theme_url('css/jquery-ui.min.css'));
osc_enqueue_style('fancy', osc_current_web_theme_js_url('fancybox/jquery.fancybox.css'));


if(gam_is_rtl()) {
  osc_enqueue_style('rtl', osc_current_web_theme_url('css/rtl.css') . '?v=' . date('YmdHis'));
}


if(osc_is_ad_page() || (osc_get_osclass_location() == 'item' && osc_get_osclass_section() == 'send_friend')) {
  osc_enqueue_style('bxslider', 'https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.1.2/jquery.bxslider.css');
  osc_enqueue_style('lightgallery', 'https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.11/css/lightgallery.min.css');
}


if(gam_ajax_image_upload() && (osc_is_publish_page() || osc_is_edit_page())) {
  osc_enqueue_style('fine-uploader-css', osc_assets_url('js/fineuploader/fineuploader.css'));
}


osc_remove_style('font-open-sans');
osc_remove_style('open-sans');
osc_remove_style('fi_font-awesome');
osc_remove_style('font-awesome44');
osc_remove_style('font-awesome45');
osc_remove_style('font-awesome47');
osc_remove_style('responsiveslides');
osc_remove_style('cookiecuttr-style');


//osc_register_script('jquery-drag', osc_current_web_theme_js_url('jquery.drag.min.js'), array('jquery'));
osc_register_script('global', osc_current_web_theme_js_url('global.js?v=' . date('YmdHis')), array('jquery'));
osc_register_script('fancybox', osc_current_web_theme_url('js/fancybox/jquery.fancybox.pack.js'), array('jquery'));
osc_register_script('validate', osc_current_web_theme_js_url('jquery.validate.min.js'), array('jquery'));
osc_register_script('date', osc_base_url() . 'oc-includes/osclass/assets/js/date.js');
osc_register_script('bxslider', 'https://cdnjs.cloudflare.com/ajax/libs/bxslider/4.1.2/jquery.bxslider.min.js');
osc_register_script('lazyload', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js');
osc_register_script('google-maps', 'https://maps.google.com/maps/api/js?key='.osc_get_preference('maps_key', 'google_maps'));
osc_register_script('images-loaded', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.4/imagesloaded.pkgd.min.js');
osc_register_script('masonry', 'https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js');
osc_register_script('lightbox', 'https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.11/js/lightgallery-all.min.js');
osc_register_script('mousewheel', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js');
osc_register_script('pace', 'https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js');


osc_enqueue_script('jquery');
osc_enqueue_script('fancybox');
osc_enqueue_script('pace');


if(gam_param('lazy_load') == 1) {
  osc_enqueue_script('lazyload');
}

if(!osc_is_search_page() && !osc_is_home_page()) {
  osc_enqueue_script('validate');
}

if(osc_is_publish_page() || osc_is_edit_page() || osc_is_search_page()) {
  osc_enqueue_script('date');
}


if(osc_is_ad_page() || (osc_get_osclass_location() == 'item' && osc_get_osclass_section() == 'send_friend')) {
  osc_enqueue_script('bxslider');
  //osc_enqueue_script('mousewheel');
  osc_enqueue_script('lightbox');
}

if( osc_is_ad_page() && function_exists('google_maps_location') && osc_get_preference('include_maps_js', 'google_maps') != '0' ) {
  //osc_enqueue_script('google-maps');
}

if( osc_get_preference('force_aspect_image', 'osclass') == 1 ) {
  osc_enqueue_script('masonry');
  osc_enqueue_script('images-loaded');
}

if(!osc_is_search_page() && !osc_is_home_page() && !osc_is_ad_page()) {
  osc_enqueue_script('tabber');
}

if(gam_ajax_image_upload() && (osc_is_publish_page() || osc_is_edit_page())) {
  osc_enqueue_script('jquery-fineuploader');
}


osc_enqueue_script('jquery-ui');
osc_enqueue_script('global');

?>


<?php osc_run_hook('header'); ?>

<!-- Блоки Олего -->

<!-- Yandex.RTB -->
<script>window.yaContextCb=window.yaContextCb||[]</script>
<script src="https://yandex.ru/ads/system/context.js" async></script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KXGSMR');</script>
<!-- End Google Tag Manager -->
