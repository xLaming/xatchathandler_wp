<?php
class XAS_ChatHandler {
    protected $name, $pass;
    protected $auth = false;
    private $html, $inputs, $headers;
    /* SETTINGS */
    const NOT_STAFF  = ['guest']; # You can use: member, mod, owner, main
    const BLACK_LIST = [10101, 1510151, 23232323, 356566558]; # Black list, you can ignore bots or someone else
    const CACHE_TIME = 86400; # 24 hours in seconds
    const PHRASES    = [
        'Invalid password.',
        'You need MANAGE power enabled.',
    ];
    const XAT_IDS = [
        7   => 'Darren',
        42  => 'xat',
        100 => 'Sam',
        101 => 'Chris',
        200 => 'Ajuda',
        201 => 'Ayuda',
        804 => 'Bot',
        911 => 'Guy',
    ];
    const URL = [
        'xs'   => 'https://xat.me/web_gear/chat/profile.php?id=%d',
        'edit' => 'https://xat.com/web_gear/chat.php?id=%d&pw=%d',
        'chat' => 'https://xat.com/web_gear/chat/editgroup.php?GroupName=%s',
    ];
    /*-*-*-*-*-*/

    public function __construct(string $name, string $pass) {
        try {
            $this->name = $name;
            $this->pass = $pass;
            $this->headers = [
                'Referer'    => sprintf(self::URL['chat'], $this->name),
                'User-Agent' => 'Mozilla/5.0 (X11; Linux i586; rv:31.0) Gecko/20100101 Firefox/31.0',
            ];
            $this->html = $this->getInitData();
            $this->loadInputs();
        } catch (Exception $e) {
            print $e;
            exit;
        }
    }

    public function getStaffList($listMembers = true) {       
        $this->inputs['BackupUsers'] = 1;
        $getParams = $this->submit();
        $staffList = [];
        $notList = self::NOT_STAFF;
        if (strpos($getParams, '**<span data-localize=edit.manage') !== false) {
            throw new Exception(self::PHRASES[1]);
        } else if (!$listMembers) {
            $noList[] = 'member';
        }
        foreach(explode(PHP_EOL, $getParams) as $line) {
            $user = explode(',', $line);
            if (!in_array($user[5], $noList) && !in_array(intval($user[0]), self::BLACK_LIST)) {
                $xatUser = $this->getUsername(intval($user[0]));
                $isTemp = substr($user[5], 0, 4) == 'temp' ? true : false;
                if ($xatUser) {
                    $staffList[$user[0]] = [
                        'user' => $xatUser,
                        'rank' => str_replace('temp', '', $user[5]),
                        'temp' => $isTemp,
                    ];
                } 
            } 
                
        }
        return $staffList;
    }

    public function submit() {
        $getSetup = wp_remote_post(
            self::URL['chat'],
            [
                "body"	  => $this->inputs,
                "headers" => $this->headers,
            ]
        )['body'];
        return $getSetup;
    }

    public function getUsername(int $uid) {
        $uid = intval($uid);
        if (array_key_exists($uid, self::XAT_IDS)) {
            return self::XAT_IDS[$uid];
        }
        $rUsers = file_get_contents(XAS_CACHE_DIR);
        $users = json_decode($rUsers, true); # not obj
        if (array_key_exists($uid, $users)) {
            if ($users[$uid]['time'] >= time()) {
                return $users[$uid]['name'];
            }
        } 
        $getProfile = wp_remote_get(
            sprintf(self::URL['xs'], $uid),
            [
                "headers" => $this->headers,
            ]
        )['body'];
        if ($getProfile && strlen($getProfile) < 20) {
            $users[$uid] = [
                'name' => $getProfile,
                'time' => intval(time() + self::CACHE_TIME),
            ];
        }
        file_put_contents(XAS_CACHE_DIR, json_encode($users));
        if (array_key_exists($uid, $users)) {
            return $users[$uid]['name'];
        }
        return false;
    }

    private function getInitData() {
        $params = [
            'GroupName'  => $this->name, 
            'password'   => $this->pass, 
            'SubmitPass' => 'Submit',
        ];
        $getParams = wp_remote_post(
            sprintf(self::URL['chat'], $this->name),
            [
                "body" => $params,
                "headers" => $this->headers,
            ]
        )['body'];
        if (strpos($getParams, '**<span data-localize=buy.wrongpassword>') !== false) {
            throw new Exception(self::PHRASES[0]);
        }
        $this->auth = true;
        return $getParams;
    }

    private function loadInputs() {
        if (!$this->auth) {
            return self::PHRASES[0];
        }
        $this->html = str_replace('\r\n', '', $this->html); # fixed
        preg_match_all('/<input(.*?)>/is', $this->html, $getInputs);
        preg_match('/<textarea id="media0"(.*?)>(.*?)<\/textarea>/is', $this->html, $getTextarea);
        $this->inputs['media0'] = $getTextarea[2];
        foreach ($getInputs[1] as $i) {
            preg_match_all('/name\="(.*?)"/', $i, $getInput);
            preg_match_all('/name\=(.*?) /', $i, $getInputLazy);
            if (!empty($getInput[1])) {
                preg_match_all('/value\="(.*?)"/is', $i, $getValue);
                preg_match_all('/ checked/', $i, $isChecked);
                if (!empty($getValue[1])) {
                    if (($getValue[1][0] == 'ON' && !empty($isChecked[1])) || $getValue[1][0] != 'ON') {
                        $this->inputs[$getInput[1][0]] = $getValue[1][0];
                    }
                }
            } else if (!empty($getInputLazy[1])) {
                preg_match_all('/value\="(.*?)"/is', $i, $getValue);
                if (!empty($getValue[1])) {
                    $this->inputs[$getInputLazy[1][0]] = $getValue[1][0];
                }
            }
        }
        return $this->inputs;
    }
}