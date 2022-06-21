<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()) ; ?>">
<head>
  <?php osc_current_web_theme_path('head.php') ; ?>
</head>

<body id="body-home" class="layout-<?php echo gam_param('home_layout'); ?>">
  <?php osc_current_web_theme_path('header.php') ; ?>

<!-- make less space
  <?php if(gam_banner('home_top') !== false) { ?>
    <div class="home-container banner-box">
      <div class="inside"><?php echo gam_banner('home_top'); ?></div>
    </div>
  <?php } ?>
-->

    <div class="home-container promote">
      <div class="inner">
        <div class="promote">
            <h2><?php _e('promo_about', 'gamma'); ?></h2>

            <div class="home-container">
              <h3><?php _e('promo_above', 'gamma'); ?></h3>
            </div>

            <div class="home-container">
              <center><iframe src="https://www.youtube.com/embed/Ldlz17Q6O4Q" title="Barter Promo Video" width="320" height="240" frameborder="0" allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe></center>
            </div>

            <div class="home-container">
              <h3><?php _e('promo_below', 'gamma'); ?></h3>
            </div>

        </div>
        <div class="promote">

         <div class="box">
          <div class="bl b1">
            <div class="img"><div><span><img src="<?php echo osc_current_web_theme_url('images/publish.svg'); ?>" alt="<?php echo osc_esc_html(__('Добавить объявление', 'gamma')); ?>"/></span></div></div>
            <strong><?php _e('Добавить объявление', 'gamma'); ?></strong>
            <span><?php _e('Это займет всего 1 минуту!', 'gamma'); ?></span>
          </div>

          <div class="bl b2">
            <div class="img"><div><span><img src="<?php echo osc_current_web_theme_url('images/promote.svg'); ?>" alt="<?php echo osc_esc_html(__('Продвигайте', 'gamma')); ?>"/></span></div></div>
            <strong><?php _e('Продвигайте', 'gamma'); ?></strong>
            <span><?php _e('Чтобы сделать его более привлекательным', 'gamma'); ?></span>
          </div>

          <div class="bl b3">
            <div class="img"><div><span><img src="<?php echo osc_current_web_theme_url('images/sold.svg'); ?>" alt="<?php echo osc_esc_html(__('Продано', 'gamma')); ?>"/></span></div></div>
            <strong><?php _e('Бартер', 'gamma'); ?></strong>
            <span><?php _e('Премиум-объявление находит отклик в 5 раз быстрее', 'gamma'); ?></span>
          </div>

          <i class="fa fa-caret-right ar ar1 mbCl"></i>
          <i class="fa fa-caret-right ar ar2 mbCl"></i>

          </div>
        </div>

      </div>
    </div>

  <?php osc_get_premiums(gam_param('premium_home_count')); ?>

  <?php if(gam_param('premium_home') == 1 && osc_count_premiums() > 0) { ?>
    <div class="home-container premium">
      <div class="inner">

        <!-- PREMIUMS BLOCK -->
        <div id="premium" class="products grid">
          <h2><?php _e('Featured listings', 'gamma'); ?></h2>

          <div class="block">
            <div class="prod-wrap">
              <?php $c = 1; ?>
              <?php while( osc_has_premiums() ) { ?>
                <?php gam_draw_item($c, true); ?>

                <?php $c++; ?>
              <?php } ?>

              <?php if(osc_count_premiums() <= 0) { ?>
                <div class="home-empty">
                  <img src="<?php echo osc_current_web_theme_url('images/home-empty.png'); ?>" />
                  <strong><?php _e('No premium listing yet', 'gamma'); ?></strong>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>

  <?php } ?>

  <?php if(function_exists('blg_param') && gam_param('blog_home') == 1) { ?>
    <?php
      $blogs = ModelBLG::newInstance()->getActiveBlogs();
    ?>

    <?php if(count($blogs) > 0) { ?>
      <?php $i = 1; ?>
      <?php $blog_limit = gam_param('blog_home_count'); ?>

      <div class="home-container" id="home-blog">
        <div class="inner">

          <!-- BLOG WIDGET -->
          <div id="blog" class="products grid">
            <a class="h2" href="<?php echo blg_home_link(); ?>"><?php _e('Latest articles on blog', 'gamma'); ?></a>

            <div class="box">
              <div class="nice-scroll-left"></div>
              <div class="nice-scroll-right"></div>

              <div class="wrap nice-scroll">
                <?php foreach($blogs as $b) { ?>
                  <?php if($i <= $blog_limit) { ?>
                    <a href="<?php echo osc_route_url('blg-post', array('blogSlug' => osc_sanitizeString(blg_get_slug($b)), 'blogId' => $b['pk_i_id'])); ?>">
                      <div class="img">
                        <div style="background-image:url('<?php echo blg_img_link($b['s_image']); ?>');"></div>
                      </div>

                      <div class="data">
                        <h3><?php echo strip_tags(blg_get_title($b)); ?></h3>
                        <div class="desc"><?php echo strip_tags(osc_highlight(blg_get_subtitle($b) <> '' ? blg_get_subtitle($b) : blg_get_description($b), 250)); ?></div>
                      </div>
                    </a>
                  <?php } ?>

                  <?php $i++; ?>

                <?php } ?>
              </div>
            </div>

          </div>
        </div>
      </div>
    <?php } ?>
  <?php } ?>


  <?php if(function_exists('osc_slider')) { ?>

    <!-- Slider Block -->
    <div class="home-container slider">
      <div class="inner">
        <div id="home-slider">
          <?php osc_slider(); ?>
        </div>
      </div>
    </div>
  <?php } ?>



  <div class="home-container latest">
    <div class="inner">

      <!-- LATEST LISTINGS BLOCK -->
      <div id="latest" class="products grid">
        <h2><?php _e('Lately added on our classifieds', 'gamma'); ?></h2>

        <?php View::newInstance()->_exportVariableToView('latestItems', gam_random_items()); ?>

        <?php if( osc_count_latest_items() > 0) { ?>
          <div class="block">
            <div class="prod-wrap">
              <?php $c = 1; ?>
              <?php while( osc_has_latest_items() ) { ?>
                <?php gam_draw_item($c); ?>

                <?php $c++; ?>
              <?php } ?>
            </div>
          </div>

        <?php } else { ?>
          <div class="home-empty">
            <img src="<?php echo osc_current_web_theme_url('images/home-empty.png'); ?>" />
            <strong><?php _e('No latest listing yet', 'gamma'); ?></strong>
          </div>
        <?php } ?>

        <?php View::newInstance()->_erase('items') ; ?>
      </div>
    </div>
  </div>


  <?php if(function_exists('bpr_companies_block') && gam_param('company_home') == 1 && count($sellers = ModelBPR::newInstance()->getSellers(1, -1, -1, 8, '', '', '', 'NEW')) > 0) { ?>
    <div class="home-container business">
      <div class="inner">
        <!-- BUSINESS PROFILE WIDGET -->
        <div id="company" class="products grid">
            <a class="h2" href="<?php echo bpr_companies_url(); ?>"><?php _e('Our partners', 'gamma'); ?></a>

            <div class="relative">
              <div class="nice-scroll-left"></div>
              <div class="nice-scroll-right"></div>

              <div class="bpr-outer-box nice-scroll">
                <?php echo bpr_companies_block(gam_param('company_home_count'), 'NEW'); ?>
              </div>
            </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <!-- STATS -->
    <div class="home-container stats">
      <div class="inner">
        <div class="stats">
          <h2><?php _e('promo_stats', 'gamma'); ?></h3>

          <div class="box">
            <div class="bl bl1">
              <div class="img"><img src="<?php echo osc_current_web_theme_url('images/listing.svg'); ?>" alt="<?php echo osc_esc_html(__('Active listings', 'gamma')); ?>"/></div>
              <strong><?php echo osc_total_active_items(); ?></strong>
              <span><?php _e('Активные объявления', 'gamma'); ?></span>
            </div>

            <div class="bl bl2">
              <div class="img"><img src="<?php echo osc_current_web_theme_url('images/category.svg'); ?>" alt="<?php echo osc_esc_html(__('Categories', 'gamma')); ?>"/></div>
              <strong><?php echo osc_count_categories(); ?></strong>
              <span><?php _e('Категории', 'gamma'); ?></span>
            </div>

            <div class="bl bl3">
              <div class="img"><img src="<?php echo osc_current_web_theme_url('images/region.svg'); ?>" alt="<?php echo osc_esc_html(__('Regions', 'gamma')); ?>"/></div>
              <strong><?php echo osc_count_regions(); ?></strong>
              <span><?php _e('Регионы', 'gamma'); ?></span>
            </div>

            <div class="bl bl4">
              <div class="img"><img src="<?php echo osc_current_web_theme_url('images/city.svg'); ?>" alt="<?php echo osc_esc_html(__('Cities', 'gamma')); ?>"/></div>
              <strong><?php echo osc_count_cities(); ?></strong>
              <span><?php _e('Города', 'gamma'); ?></span>
            </div>

            <div class="bl bl5">
              <div class="img"><img src="<?php echo osc_current_web_theme_url('images/user.svg'); ?>" alt="<?php echo osc_esc_html(__('Users registred', 'gamma')); ?>"/></div>
              <strong><?php echo osc_total_users(); ?></strong>
              <span><?php _e('Пользователи', 'gamma'); ?></span>
            </div>

          </div>
        </div>
      </div>
    </div>

  <?php if(gam_banner('home_bottom') !== false) { ?>
    <div class="home-container banner-box">
      <div class="inside"><?php echo gam_banner('home_bottom'); ?></div>
    </div>
  <?php } ?>

  <?php osc_current_web_theme_path('footer.php') ; ?>
</body>
</html>
