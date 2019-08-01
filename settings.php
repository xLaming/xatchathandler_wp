<?php
function XAS_SettingsMenu() {
	add_menu_page(
        'xat Auto Staff', 
        'xat Auto Staff', 
        'administrator', 
        __FILE__, 
        'XAS_SettingsPage'
    );
	add_action('admin_init', 'XAS_SettingsRegister');
}

function XAS_SettingsRegister() {
	register_setting('XAS_SettingsGroup', 'xas_chat_name');
    register_setting('XAS_SettingsGroup', 'xas_chat_pass');

    register_setting('XAS_SettingsGroup', 'xas_list_member');

    register_setting('XAS_SettingsGroup', 'xas_mainowner_title');
    register_setting('XAS_SettingsGroup', 'xas_owner_title');
    register_setting('XAS_SettingsGroup', 'xas_mod_title');
    register_setting('XAS_SettingsGroup', 'xas_member_title');

    register_setting('XAS_SettingsGroup', 'xas_rank_title');
    register_setting('XAS_SettingsGroup', 'xas_name_title');
    register_setting('XAS_SettingsGroup', 'xas_user_title');
}

function XAS_SettingsPage() {
?>
<div class="wrap">
<h1>xat: Auto Staff Settings</h1>
<p>In order to work correctly the plugin you may setup the details correctly, otherside it will not work.</p>
<form method="post" action="options.php">
    <?php settings_fields('XAS_SettingsGroup'); ?>
    <?php do_settings_sections('XAS_SettingsGroup'); ?>
    <h2>Settings</h2>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Chat name:</th>
            <td><input type="text" name="xas_chat_name" value="<?php echo esc_attr(get_option('xas_chat_name')); ?>"></td>
        </tr>
        <tr valign="top">
            <th scope="row">Chat password:</th>
            <td><input type="password" name="xas_chat_pass" value="<?php echo esc_attr(get_option('xas_chat_pass')); ?>"></td>
        </tr>
        <tr valign="top">
            <th scope="row">List members:</th>
            <td>
                <select name="xas_list_member">
                    <?php if (get_option('xas_list_member') == '1'): ?>
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
            <td><input type="text" name="xas_rank_title" value="<?php echo esc_attr(get_option('xas_rank_title', 'Rank')); ?>"></td>
        </tr>
        <tr valign="top">
            <th scope="row">Name:</th>
            <td><input type="text" name="xas_name_title" value="<?php echo esc_attr(get_option('xas_name_title', 'Name')); ?>"></td>
        </tr>
        <tr valign="top">
            <th scope="row">User:</th>
            <td><input type="text" name="xas_user_title" value="<?php echo esc_attr(get_option('xas_user_title', 'User')); ?>"></td>
        </tr>
    </table>

    <h2>Rank titles:</h2>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Main owner:</th>
            <td><input type="text" name="xas_mainowner_title" value="<?php echo esc_attr(get_option('xas_mainowner_title', 'Main Owner')); ?>"></td>
        </tr>
        <tr valign="top">
            <th scope="row">Owner:</th>
            <td><input type="text" name="xas_owner_title" value="<?php echo esc_attr(get_option('xas_owner_title', 'Owner')); ?>"></td>
        </tr>
        <tr valign="top">
            <th scope="row">Moderator:</th>
            <td><input type="text" name="xas_mod_title" value="<?php echo esc_attr(get_option('xas_mod_title', 'Moderator')); ?>"></td>
        </tr>
        <tr valign="top">
            <th scope="row">Member:</th>
            <td><input type="text" name="xas_member_title" value="<?php echo esc_attr(get_option('xas_member_title', 'Member')); ?>"></td>
        </tr>
    </table>

    <?php submit_button(); ?>
</form>
</div>
<?php } ?>
