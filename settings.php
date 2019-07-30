<?php
function autoStaffSettingsMenu() {
	add_menu_page(
        'xat Auto Staff', 
        'xat Auto Staff', 
        'administrator', 
        __FILE__, 
        'autoStaffSettingsPage' , 
    );
	add_action('admin_init', 'autoStaffSettingsRegister');
}

function autoStaffSettingsRegister() {
	register_setting('autoStaffSettingsGroup', 'chat_name');
    register_setting('autoStaffSettingsGroup', 'chat_pass');

    register_setting('autoStaffSettingsGroup', 'list_member');

    register_setting('autoStaffSettingsGroup', 'mainowner_title');
    register_setting('autoStaffSettingsGroup', 'owner_title');
    register_setting('autoStaffSettingsGroup', 'mod_title');
    register_setting('autoStaffSettingsGroup', 'member_title');

    register_setting('autoStaffSettingsGroup', 'rank_title');
    register_setting('autoStaffSettingsGroup', 'name_title');
    register_setting('autoStaffSettingsGroup', 'user_title');
}

function autoStaffSettingsPage() {
?>
<div class="wrap">
<h1>xat: Auto Staff Settings</h1>
<p>In order to work correctly the plugin you may setup the details correctly, otherside it will not work.</p>
<form method="post" action="options.php">
    <?php settings_fields('autoStaffSettingsGroup'); ?>
    <?php do_settings_sections('autoStaffSettingsGroup'); ?>
    <h2>Settings</h2>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Chat name:</th>
            <td><input type="text" name="chat_name" value="<?php echo esc_attr(get_option('chat_name')); ?>"></td>
        </tr>
        <tr valign="top">
            <th scope="row">Chat password:</th>
            <td><input type="password" name="chat_pass" value="<?php echo esc_attr(get_option('chat_pass')); ?>"></td>
        </tr>
        <tr valign="top">
            <th scope="row">List members:</th>
            <td>
                <select name="list_member">
                    <?php if (get_option('list_member') == '1'): ?>
                    <option value="1" selected>Yes</option>
                    <option value="0">No</option>
                    <?php else: ?>
                    <option value="0" selected>No</option>
                    <option value="1">Yes</option>
                    <?php endif; ?>
                </select>
            </td>
        </tr>
    </table>

    <h2>Titles:</h2>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Rank:</th>
            <td><input type="text" name="rank_title" value="<?php echo esc_attr(get_option('rank_title')); ?>"></td>
        </tr>
        <tr valign="top">
            <th scope="row">Name:</th>
            <td><input type="text" name="name_title" value="<?php echo esc_attr(get_option('name_title')); ?>"></td>
        </tr>
        <tr valign="top">
            <th scope="row">User:</th>
            <td><input type="text" name="user_title" value="<?php echo esc_attr(get_option('user_title')); ?>"></td>
        </tr>
    </table>

    <h2>Rank titles:</h2>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Main owner:</th>
            <td><input type="text" name="mainowner_title" value="<?php echo esc_attr(get_option('mainowner_title')); ?>"></td>
        </tr>
        <tr valign="top">
            <th scope="row">Owner:</th>
            <td><input type="text" name="owner_title" value="<?php echo esc_attr(get_option('owner_title')); ?>"></td>
        </tr>
        <tr valign="top">
            <th scope="row">Moderator:</th>
            <td><input type="text" name="mod_title" value="<?php echo esc_attr(get_option('mod_title')); ?>"></td>
        </tr>
        <tr valign="top">
            <th scope="row">Member:</th>
            <td><input type="text" name="member_title" value="<?php echo esc_attr(get_option('member_title')); ?>"></td>
        </tr>
    </table>

    <?php submit_button(); ?>
</form>
</div>
<?php } ?>
