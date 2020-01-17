<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 09/01/2019
 * Time: 01:17
 */

namespace App\Service;


class steamAuthService
{
    /* Examples
        toSteamID(25490879)                 // STEAM_0:1:12745439
        toSteamID(76561197985756607)        // STEAM_0:1:12745439
        toSteamID("STEAM_0:1:12745439")     // STEAM_0:1:12745439
        toUserID(25490879)                  // 25490879
        toUserID(76561197985756607)         // 25490879
        toUserID("STEAM_0:1:12745439")      // 25490879
        toCommunityID(25490879)             // 76561197985756607
        toCommunityID(76561197985756607)    // 76561197985756607
        toCommunityID("STEAM_0:1:12745439") // 76561197985756607
     */


    public function toCommunityID($id) {
        if (preg_match('/^STEAM_/', $id)) {
            $parts = explode(':', $id);
            return bcadd(bcadd(bcmul($parts[2], '2'), '76561197960265728'), $parts[1]);
        } elseif (is_numeric($id) && strlen($id) < 16) {
            return bcadd($id, '76561197960265728');
        } else {
            return $id;
        }
    }

    public function toSteamID($id) {
        if (is_numeric($id) && strlen($id) >= 16) {
            $z = bcdiv(bcsub($id, '76561197960265728'), '2');
        } elseif (is_numeric($id)) {
            $z = bcdiv($id, '2');
        } else {
            return $id;
        }
        $y = bcmod($id, '2');
        return 'STEAM_0:' . $y . ':' . floor($z);
    }

    public function toUserID($id) {
        if (preg_match('/^STEAM_/', $id)) {
            $split = explode(':', $id);
            return $split[2] * 2 + $split[1];
        } elseif (preg_match('/^765/', $id) && strlen($id) > 15) {
            return bcsub($id, '76561197960265728');
        } else {
            return $id;
        }
    }

    /**
     * @string $id
     * @return mixed
     */
    function getUserName($id) {
        $request = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=52A66B13219F645834149F1A1180770A&steamids=' . $id);
        $result = json_decode($request);
        $name = "";

        foreach ($result->response->players as $player)
             $name = $player->personaname;
        return $name == "" ? "Brak" : $name;
    }

    /**
     * @string $id
     * @return mixed
     */
    function getAvatar($id) {
        $avatar = "";
        $url = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=52A66B13219F645834149F1A1180770A&steamids='.$id";
        $json_object= file_get_contents($url);
        $json_decoded = json_decode($json_object);

        foreach ($json_decoded->response->players as $player)
            $avatar = $player->avatarmedium;

        return $avatar;
    }
}