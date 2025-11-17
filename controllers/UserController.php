<?php
namespace app\controllers;


use Yii;
use yii\db\Exception;
use yii\rest\Controller;
use app\models\User;
use yii\filters\auth\HttpBearerAuth;
use yii\web\NotFoundHttpException;


class UserController extends Controller
{
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'only' => ['view'],
        ];
        return $behaviors;
    }


    public function verbs() {
        return [
            'create' => ['POST'],
            'view' => ['GET'],
        ];
    }


    /**
     * @throws Exception
     */
    public function actionCreate() {
        $user = new User(['scenario'=>'create']);
        //$req = Yii::$app->request;
        $params = Yii::$app->request->bodyParams;
        //return ['params'=>$params];

        $user->username = $params['username'] ?? null;
        $user->email = $params['email'] ?? null;
        $user->password = $params['password'] ?? null;

        if ($user->save()) {
            return $user;
        } else {
            return ['errors'=>$user->errors];
        }
    }




    public function actionView($id) {
        $user = User::findOne($id);
        if (!$user) throw new NotFoundHttpException('User not found');
        return $user;
    }
}