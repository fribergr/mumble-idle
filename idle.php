<?php
set_include_path(get_include_path() . ":/usr/share/php5/ice/");
require "Ice.php";
require "Murmur.php";

// Number of seconds before moving idle user
$idle = 1200;

// To which channel should we move the user?
// The channel ID can be found by dumping $server->getChannels()
$afk = 1;

// If you only have one server (?) this seems to have ID 1
$serverid = 1;

try {
        $ICE = Ice_initialize();
        $meta = Murmur_MetaPrxHelper::checkedCast($ICE->stringToProxy('Meta:tcp -h 127.0.0.1 -p 6502'));
        $server = $meta->getServer($serverid);
        $users = $server->getUsers();

        foreach ($users as $u) {
                if ($u->idlesecs >= $idle && $u->channel != $afk) {
                        $state = $server->getState($u->session);
                        if ($state) {
                                $state->channel = $afk;
                                $server->setState($state);
                        }
                }
        }
} catch (Exception $ex) {
        // Something went wrong
        echo $ex->getMessage();
}
