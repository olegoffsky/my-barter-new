<?php
/*
 *      OSCLass – software for creating and publishing online classified
 *                           advertising platforms
 *
 *                        Copyright (C) 2010 OSCLASS
 *
 *       This program is free software: you can redistribute it and/or
 *     modify it under the terms of the GNU Affero General Public License
 *     as published by the Free Software Foundation, either version 3 of
 *            the License, or (at your option) any later version.
 *
 *     This program is distributed in the hope that it will be useful, but
 *         WITHOUT ANY WARRANTY; without even the implied warranty of
 *        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *             GNU Affero General Public License for more details.
 *
 *      You should have received a copy of the GNU Affero General Public
 * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
?>

<div id="settings_form" style="border: 1px solid #ccc; background: #eee; ">
    <div style="padding: 0 20px 20px;">
        <div>
           <fieldset>
                <legend>
                    <h1><?php _e('Referral Help', 'Referral'); ?></h1>
                </legend>
                <h2>
                    <?php _e('What is Referral Plugin?', 'Referral'); ?>
                </h2>
                <p>
                    <?php _e('Referral Plugin Encourage the user to share our website to others to increase the site traffic', 'Referral'); ?>
                </p>
                <h2>
                <?php _e('How to show Top Referrals', 'Referral'); ?>
                </h2>
                <p>
                    <?php _e('Locate these line in your main.php', 'Referral'); ?>.
                </p>
                <pre>
                    &ltdiv class="navigation"&gt'
                </pre>
                <p>
                    <?php _e('Replace the above line with this', 'Referral'); ?>
                </p>
                <pre>
                    &ltdiv class="navigation"&gt
                    &ltdiv class="box location"&gt
                    &lt?php top_referrals(); ?&gt
                    &lt/div&gt
                </pre>
            </fieldset>
        </div>
    </div>
</div>
