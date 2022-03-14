<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
<head>
  <?php osc_current_web_theme_path('head.php') ; ?>
  <meta name="robots" content="noindex, nofollow" />
  <meta name="googlebot" content="noindex, nofollow" />
</head>
<body id="body-user-items" class="body-ua">
  <?php osc_current_web_theme_path('header.php') ; ?>

  <?php echo gam_user_menu_top(); ?>

  <?php
    $current_url =  $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

    $c_active = Item::newInstance()->countItemTypesByUserID(osc_logged_user_id(), 'active');
    $c_pending = Item::newInstance()->countItemTypesByUserID(osc_logged_user_id(), 'pending_validate');
    $c_expired = Item::newInstance()->countItemTypesByUserID(osc_logged_user_id(), 'expired');

    $c_all = $c_active + $c_pending + $c_expired;

    if (osc_rewrite_enabled()) {
      $s_active = '?itemType=active';
      $s_pending = '?itemType=pending_validate';
      $s_expired = '?itemType=expired';
    } else {
      $s_active = '&itemType=active';
      $s_pending = '&itemType=pending_validate';
      $s_expired = '&itemType=expired';
    }

    if (strpos($current_url, 'itemType=active') !== false) {
      $yes_active = 1;
    } else if (strpos($current_url, 'itemType=pending_validate') !== false) {
      $yes_pending = 1;
    } else if (strpos($current_url, 'itemType=expired') !== false) {
      $yes_expired = 1;
    } else {
      $yes_all = 1;
    }
  ?>

  <div class="inside user_account">
    <div class="usr-menu">
      <a href="<?php echo osc_user_list_items_url(); ?>" <?php if($yes_all == 1) { ?>class="active"<?php } ?>>
        <strong><?php _e('All items', 'gamma'); ?></strong>
        <span><?php echo sprintf(__('%s listings', 'gamma'), $c_all); ?></span>
      </a>

      <a href="<?php echo osc_user_list_items_url() . $s_active; ?>" <?php if($yes_active == 1) { ?>class="active"<?php } ?>>
        <strong><?php _e('Active items', 'gamma'); ?></strong>
        <span><?php echo sprintf(__('%s listings', 'gamma'), $c_active); ?></span>
      </a>

      <a href="<?php echo osc_user_list_items_url() . $s_pending; ?>" <?php if($yes_pending == 1) { ?>class="active"<?php } ?>>
        <strong><?php _e('Pending items', 'gamma'); ?></strong>
        <span><?php echo sprintf(__('%s listings', 'gamma'), $c_pending); ?></span>
      </a>

      <a href="<?php echo osc_user_list_items_url() . $s_expired; ?>" <?php if($yes_expired == 1) { ?>class="active"<?php } ?>>
        <strong><?php _e('Expired items', 'gamma'); ?></strong>
        <span><?php echo sprintf(__('%s listings', 'gamma'), $c_expired); ?></span>
      </a>
    </div>

    <div id="main" class="items">
      <div class="inner-box">
        <div class="inside">
          <?php if(osc_count_items() > 0) { ?>
            <?php while(osc_has_items()) { ?>
              <div class="uitem lazy<?php if(osc_item_is_inactive()) { ?> inactive<?php } ?><?php if(osc_item_is_expired()) { ?> expired<?php } ?>">
                <?php if(osc_images_enabled_at_items()) { ?>
                  <div class="image">
                    <a href="<?php echo osc_item_url(); ?>">
                      <?php if(osc_count_item_resources() > 0) { ?>
                        <img src="<?php echo osc_resource_thumbnail_url(); ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" />
                      <?php } else { ?>
                        <img src="<?php echo gam_get_noimage(); ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" />
                      <?php } ?>
                    </a>
                  </div>
                <?php } ?>

                <div class="body">
                  <?php
                    $loc = @array_filter(array(osc_item_city(), osc_item_region(), osc_item_country()))[0];
                  ?>

                  <div class="category">
                    <?php echo osc_item_category(); ?>
                    <?php if($loc <> '') { ?>
                      / <?php echo $loc; ?>
                    <?php } ?>
                  </div>

                  <div class="pub"><?php echo osc_format_date(osc_item_pub_date()); ?></div>

                  <div class="title">
                    <a href="<?php echo osc_item_url(); ?>"><?php echo osc_item_title(); ?></a>

                    <?php if(osc_item_is_inactive()) {?>
                      <div class="ua-premium inactive"><span><?php _e('Inactive', 'gamma'); ?></span></div>
                    <?php } else if(osc_item_is_expired()) { ?>
                       <div class="ua-premium expired"><span><?php _e('Expired', 'gamma'); ?></span></div>
                    <?php } else if(osc_item_is_premium()) { ?>
                      <div class="ua-premium mbBg3" title="<?php _e('This listing is premium', 'gamma'); ?>"><?php _e('Premium', 'gamma'); ?></div>
                    <?php } ?>
                  </div>

                  <?php if( osc_price_enabled_at_items() ) { ?>
                    <span class="price mbCl"><?php echo osc_item_formated_price(); ?></span>
                  <?php } ?>


            

                  <div class="buttons">
                    <?php if(osc_item_is_inactive()) { ?>
                      <?php if((function_exists('iv_add_item') && osc_get_preference('enable','plugin-item_validation') <> 1) || !function_exists('iv_add_item')) { ?>
                        <a class="activate" target="_blank" href="<?php echo osc_item_activate_url(); ?>"><?php _e('Validate', 'gamma'); ?></a>
                      <?php } ?>
                    <?php } else { ?>
                      <?php $item_extra = gam_item_extra(osc_item_id()); ?>
                      <?php 
                        if (osc_rewrite_enabled()) { 
                          if( $item_extra['i_sold'] == 0 ) {
                            $sold_url = '?itemId=' . osc_item_id() . '&markSold=1&secret=' . osc_item_field('s_secret');
                            $reserved_url = '?itemId=' . osc_item_id() . '&markSold=2&secret=' . osc_item_field('s_secret');
                          } else {
                            $sold_url = '?itemId=' . osc_item_id() . '&markSold=0&secret=' . osc_item_field('s_secret');
                            $reserved_url = '?itemId=' . osc_item_id() . '&markSold=0&secret=' . osc_item_field('s_secret');
                          }
                        } else {
                          if( $item_extra['i_sold'] == 0 ) {
                            $sold_url = '&itemId=' . osc_item_id() . '&markSold=1&secret=' . osc_item_field('s_secret');
                            $reserved_url = '&itemId=' . osc_item_id() . '&markSold=2&secret=' . osc_item_field('s_secret');
                          } else {
                            $sold_url = '&itemId=' . osc_item_id() . '&markSold=0&secret=' . osc_item_field('s_secret');
                            $reserved_url = '&itemId=' . osc_item_id() . '&markSold=0&secret=' . osc_item_field('s_secret');
                          }
                        }
                      ?>

                      <?php if(!in_array(osc_item_category_id(), gam_extra_fields_hide())) { ?>
                        <a class="sold round2 tr1" href="<?php echo osc_user_list_items_url() . $sold_url; ?>"><?php echo ($item_extra['i_sold'] == 1 ? __('Not sold', 'gamma') : __('Sold', 'gamma')); ?></a>
                        <span class="delim">/</span>

                        <a class="reserved" href="<?php echo osc_user_list_items_url() . $reserved_url; ?>"><?php echo ($item_extra['i_sold'] == 2 ? __('Not reserved', 'gamma') : __('Reserve', 'gamma')); ?></a>
                        <span class="delim">/</span>

                      <?php } ?>                  

                    <?php } ?>
                    
                    <a class="edit" target="_blank" href="<?php echo osc_item_edit_url(); ?>" rel="nofollow"><?php _e('Edit', 'gamma'); ?></a>
                    <span class="delim">/</span>

                    <?php if(function_exists('republish_link_raw') && republish_link_raw(osc_item_id())) { ?>
                      <a class="republish" href="<?php echo republish_link_raw(osc_item_id()); ?>" rel="nofollow"><?php _e('Republish', 'gamma'); ?></a>
                      <span class="delim">/</span>
                    <?php } ?>
                    

                    <a class="delete" onclick="return confirm('<?php echo osc_esc_js(__('Are you sure you want to delete this listing? This action cannot be undone.', 'gamma')); ?>')" href="<?php echo osc_item_delete_url(); ?>" rel="nofollow"><?php _e('Delete', 'gamma'); ?></a>

                  </div>
                </div>
              </div>
            <?php } ?>
          <?php } else { ?>
            <div class="ua-items-empty">
              <img src="<?php echo osc_current_web_theme_url('images/ua-empty.jpg'); ?>"/>
              <span><?php _e('No listings found', 'gamma'); ?></span>
            </div>
          <?php } ?>


          <div class="paginate">
            <?php echo osc_pagination_items(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php osc_current_web_theme_path('footer.php') ; ?>
</body>
</html>