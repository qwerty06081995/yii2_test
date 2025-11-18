<?php
namespace app\models;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Yii;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName(): string
    {
        return 'user';
    }

    public function rules(): array
    {
        return [
            [['username','email','password'],'required','on'=>'create'],
            ['email','email'],
            [['username','email'], 'string', 'max'=>255],
            ['password','string','min'=>6],
        ];
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => false,
                'updatedAtAttribute' => false,
            ],
        ];
    }


    /**
     * @throws Exception
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            if ($this->password) {
                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
                $this->auth_key = Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    public static function findIdentity($id) {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        try {
            $key = 'YOUR_SECRET_KEY'; // тот же ключ, который использовался при генерации токена
            $data = JWT::decode($token, new Key($key, 'HS256')); // HS256 — алгоритм подписи
            return static::findOne($data->sub); // sub — ID пользователя в payload
        } catch (\Exception $e) {
            Yii::error("JWT decode error: ".$e->getMessage());
            return null;
        }
    }

    public function getId() { return $this->id; }
    public function getAuthKey(): ?string
    { return $this->auth_key; }
    public function validateAuthKey($authKey): bool
    { return $this->auth_key === $authKey; }

    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

}
