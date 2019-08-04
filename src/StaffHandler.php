<?php
function XAS_StaffList() {
    if (!file_exists(XAS_CACHE_DIR)) {
        file_put_contents(XAS_CACHE_DIR, '{}');
    } else if (empty(get_option('xas_chat_name')) || empty(get_option('xas_chat_pass'))) {
        return 'You need to setup the chat name and password in order to show your staff list.';
    }
    define('XAS_RANKS', [
        'main'   => get_option('xas_main_title', 'Main Owner'),
        'owner'  => get_option('xas_owner_title', 'Owner'),
        'mod'    => get_option('xas_mod_title', 'Moderator'),
        'member' => get_option('xas_member_title', 'Member'),
        'guest'  => 'NOT USED',
    ]);
    $excpt = get_option('xas_list_member') == '1' ? true : false;
    $chat  = new XAS_ChatHandler(get_option('xas_chat_name'), get_option('xas_chat_pass'));
    $list  = $chat->getStaffList($excpt);
    $staff = ['main' => [], 'owner' => [], 'mod' => [],'member' => [], 'guest' => []]; # Cache var
    $html  = '<table class="table table-responsive">';
    $html .= '<thead>
        <tr>
            <td>' . get_option('xas_rank_title', 'Rank') . '</td>
            <td>' . get_option('xas_name_title', 'Name') . '</td>
            <td>' . get_option('xas_user_title', 'User') . '</td>
        </tr>
    </thead>
    <tbody>';
    foreach ($list as $i => $u) {
        $staff[$u['rank']][] = [
            'id'   => $i,
            'user' => $u['user'],
            'name' => ucfirst(strtolower($u['user'])),
            'temp' => $u['temp'],
        ];
    }
    foreach ($staff as $r => $i) {
        foreach ($i as $u) {
            $html .= '<tr>
                <td>' . XAS_RANKS[$r] . '</td>
                <td>' . $u['name'] . '</td>
                <td><a href="//xat.me/' . $u['user'] . '">' . $u['user'] . ' (' . $u['id'] . ')</a></td>
            </tr>';
        }
    }
    $html .= '</tbody></table>';
    return $html;
}
