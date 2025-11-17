<?php
// components/JwtHelper.php
namespace app\components;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Yii;

class JwtHelper
{
    private static $key = 'YOUR_SECRET_KEY'; // лучше хранить в params.php или .env Не стал заморочиваться ))))))


    public static function encode($data, $exp = 86400) {
        $payload = [
            'sub' => $data['sub'],
            'iat' => time(),
            'exp' => time() + $exp
        ];
        return JWT::encode($payload, self::$key, 'HS256');
    }


    public static function decode($token) {
        return (array)JWT::decode($token, new Key(self::$key,'HS256'));
    }
}