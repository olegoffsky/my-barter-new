<?php
/*
 *      Thanks to _CONEJO and trains58554 for helping with this plugin
 * 
 */

if(Params::getParam('plugin_action')=='done') {
    $subject = Params::getParam('subject');
    $flag_users = Params::getParam('users');
    $flag_admins = Params::getParam('admins');

//        $messagesend = Params::getParam('message'); // original

    // HTML in messages OK (teseo)
    $messagesend = stripslashes($_REQUEST['message']) ;
    $messagesend = str_replace('src="../', 'src="' . osc_base_url() . '/' , $messagesend) ; //converts relative URL to absolute

    // v 1.2 No bcc, one mail per recipient to accomodate personalized addressing
    $recipients = array();
    $words = array();
    $words[0] = array('{USER_NAME}', '{WEB_TITLE}', '{WEB_URL}');
    $words[1] = array('dummy_name', osc_page_title(), '<a href="'.osc_base_url().'" >'.osc_base_url().'</a>') ;

    // Mails to users, admin/s or both (v. 1.2)
    if ($flag_users) { $recipients = array_merge ($recipients, User::newInstance()->listAll()); }

    if ($flag_admins) { $recipients = array_merge ($recipients, Admin::newInstance()->listAll()); }

            foreach($recipients as $user) {
                $words[1][0] = $user['s_name'] ;

                $csubject = str_ireplace($words[0], $words[1], $subject);
                $cmessagesend = str_ireplace($words[0], $words[1], $messagesend);

    $params = array(
        'subject' => $csubject
    ,'to' => $user['s_email']
    ,'to_name' => osc_page_title()
    ,'body' => $cmessagesend
    ,'alt_body' => strip_tags($cmessagesend)
    ,'add_bcc' => ''
    ,'from' => 'donotreply@' . osc_get_domain()
    ) ;

    osc_sendMail($params) ;

    }

    // Show a flash message informing admin that the email was sent
    osc_add_flash_ok_message(__('Ваше сообщение было отправлено', 'osclassmail'),'admin');
    echo '<script>location.href="'.osc_admin_render_plugin_url('osclassmail/osclassmail.php').'"</script>'; // Message OK (added by teseo)
}

?>

<script type="text/javascript" src="<?php echo osc_base_url().'oc-content/plugins/osclassmail/';?>tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">

    // Prevent blank mails. Click Submit button mandatory (teseo)
    $(document).ready(function() {
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });

    tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
        plugins : "emotions,spellchecker,advhr,insertdatetime,preview,fullpage,save,table,template",

        // Theme options - button# indicated the row# only
        theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,fontselect,fontsizeselect,formatselect",
        theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,|,code,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "insertdate,inserttime,|,spellchecker,advhr,,removeformat,|,sub,sup,|,charmap,emotions,|,table,fullpage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true
    });
</script>
<div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
    <div style="padding: 20px;">
        <div style="float: left; width: 100%;">
            <fieldset>
                <legend style="font-size: 1.4em; padding-bottom: 15px; clear: both;"><?php _e('OSClass Mail Sender', 'osclassmail'); ?></legend>
                <form name="osclassmail_form" id="moreedit_form" action="<?php echo osc_admin_base_url(true); ?>" method="POST" enctype="multipart/form-data" >
                    <input type="hidden" name="page" value="plugins" />
                    <input type="hidden" name="action" value="renderplugin" />
                    <input type="hidden" name="file" value="<?php echo osc_plugin_folder(__FILE__); ?>osclassmail.php" />
                    <input type="hidden" name="plugin_action" value="done" />
                    <div style="float: left;">
                        <label style="float: left; padding-right: 15px;"><?php _e('Тема', 'osclassmail'); ?></label><input type="text" name="subject" id="subject" value="" />
                        <br/>
                        <textarea name="message" id="message" rows="30" cols="" >
                        </textarea>
                        <br/>
                        <span style="float:right;"><button type="submit" style="float: right;"><?php _e('отправить', 'osclassmail');?></button></span>
                        <br/>
                    </div>
                    <div style="float: right; width: 40%;">
                        <label><?php _e('С помощью этого плагина Вы сможете отправить пользователям новость, акцию и любую другую информацию.','osclassmail'); ?></label>
                            <br/><br/><br/>
                            <b>Кому оправить письмо?</b><br /><br/>
                        <label><input type="checkbox" name="users" value="users" checked>Пользователям<br /></label>
                        <label><input type="checkbox" name="admins" value="admins" checked>Администраторам</label>
                        <br/><br/><br/>
                        <b>Доступные ключевые слова:</b><br /><br/>
                        {USER_NAME} Имя пользователя<br/>
                        {WEB_TITLE} Название вашего сайта<br/>
                        {WEB_URL} URL вашего сайта


                    </div>
                    <br/>
                    <div style="clear:both;"></div>
                </form>
            </fieldset>
        </div>
        <div style="clear: both;"></div>
    </div>
</div>