<?php
namespace app\controllers;


use Yii;
use yii\rest\Controller;
use app\models\User;
use app\components\JwtHelper;
use yii\web\BadRequestHttpException;


class AuthController extends Controller
{
    public function verbs() {
        return [
            'login' => ['POST'],
        ];
    }


    public function actionLogin() {
        $body = Yii::$app->request->bodyParams;
        if (empty($body['username']) || empty($body['password'])) {
            throw new BadRequestHttpException('Username and password required');
        }


        $user = User::findOne(['username'=>$body['username']]);
        if (!$user || !$user->validatePassword($body['password'])) {
            throw new BadRequestHttpException('Invalid credentials');
        }


        $token = JwtHelper::encode(['sub'=>$user->id]);
        return [
            'access_token' => $token,
            'expires_in' => 86400,
        ];
    }
}