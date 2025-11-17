<?php
namespace app\controllers;


use Yii;
use yii\rest\Controller;
use app\models\Book;
use yii\filters\auth\HttpBearerAuth;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;


class BookController extends Controller
{
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'only' => ['create','update','delete'],
        ];
        return $behaviors;
    }


    public function verbs() {
        return [
            'index' => ['GET'],
            'view' => ['GET'],
            'create' => ['POST'],
            'update' => ['PUT','PATCH'],
            'delete' => ['DELETE'],
        ];
    }


    public function actionIndex() {
        $provider = new ActiveDataProvider([
            'query' => Book::find(),
            'pagination' => [
                'pageSize' => Yii::$app->request->get('per-page',10),
            ],
        ]);
        return $provider;
    }


    public function actionView($id) {
        $book = Book::findOne($id);
        if (!$book) throw new NotFoundHttpException('Книга не найдена');
        return $book;
    }


    public function actionCreate() {
        $book = new Book();
        $book->load(Yii::$app->request->bodyParams,'');
        if ($book->save()) {
            return $book;
        } else {
            return ['errors'=>$book->errors];
        }
    }


    public function actionUpdate($id) {
        $book = Book::findOne($id);
        if (!$book) throw new NotFoundHttpException('Книга не найдена');
        $book->load(Yii::$app->request->bodyParams,'');
        if ($book->save()) {
            return $book;
        } else {
            return ['errors'=>$book->errors];
        }
    }


    public function actionDelete($id) {
        $book = Book::findOne($id);
        if (!$book) throw new NotFoundHttpException('Книга не найдена');
        $book->delete();
        return ['success'=>true];
    }
}