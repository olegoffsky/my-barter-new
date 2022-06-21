<?php
  /*
 * Copyright 2017 osclass-pro.com
 *
 * You shall not distribute this plugin and any its files (except third-party libraries) to third parties.
 * Rental, leasing, sale and any other form of distribution are not allowed and are strictly forbidden.
 */
        $title = osc_mailBeauty($content['s_title'], $words) ;
        $body  = osc_mailBeauty($content['s_text'], $words) ;

        if ( isset ( $item['s_contact_email'] ) ) {
            $emailParams =  array ( 'subject'   => $title
                                    ,'to'       => $item['s_contact_email']
                                    ,'to_name'  => $item['s_contact_name']
                                    ,'body'     => $body
                                    ,'alt_body' => $body );
        }
        else {
            $emailParams =  array ( 'subject'   => $title
                                    ,'to'       => $user['s_email']
                                    ,'to_name'  => $user['s_name']
                                    ,'body'     => $body
                                    ,'alt_body' => $body );
        }

        osc_sendMail($emailParams);
           
?>