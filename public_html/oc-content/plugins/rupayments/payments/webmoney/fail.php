<?php
/*
 * Copyright 2016 osclass-pro.com and osclass-pro.ru
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */

    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo osc_page_title(); ?></title>
    </head>
    <body>
        <?php 
                osc_add_flash_error_message(__('You cancel the payment process or there was an error. If the error continue, please contact the administrator', 'rupayments'));
                rupayments_js_redirect_to(osc_base_url());

        ?>
    </body>
</html>