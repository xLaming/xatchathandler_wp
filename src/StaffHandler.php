<?php
function initStaffList() {
    $perms = intval(substr(decoct(fileperms(DIRECTORY . '/src/usercache.json')), -3));
    if ($perms < 666) {
        return 'You need to set permissions(chmod) READ & WRITE on the file: ' . DIRECTORY . '/src/usercache.json';
    } else if (empty(get_option('chat_name')) || empty(get_option('chat_pass'))) {
        return 'You need to setup the chat name and password.';
    }
    define('RANKS', [
        'main'   => get_option('main_title', 'Main Owner'),
        'owner'  => get_option('owner_title', 'Owner'),
        'mod'    => get_option('mod_title', 'Moderator'),
        'member' => get_option('member_title', 'Member'),
    ]);
    $excpt = get_option('list_member') == '1' ? true : false;
    $chat  = new ChatHandler(get_option('chat_name'), get_option('chat_pass'));
    $list  = $chat->getStaffList($excpt);
    $staff = ['main' => [], 'owner' => [], 'mod' => [],'member' => []]; # Cache var
    $html  = '<table class="table table-responsive">';
    $html .= '<thead>
        <tr>
            <td>' . get_option('rank_title', 'Rank') . '</td>
            <td>' . get_option('name_title', 'Name') . '</td>
            <td>' . get_option('user_title', 'User') . '</td>
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
                <td>' . RANKS[$r] . '</td>
                <td>' . $u['name'] . '</td>
                <td><a href="//xat.me/' . $u['user'] . '">' . $u['user'] . ' (' . $u['id'] . ')</a></td>
            </tr>';
        }
    }
    $html .= '</tbody></table>';
    return $html;
}
