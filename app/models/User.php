<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['username', 'password', 'name'], 'required'],
            [['username'], 'unique'],
            [['username', 'password', 'name'], 'string', 'max' => 255],
        ];
    }

    // Encontra uma identidade pelo ID dado.
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    // Encontra uma identidade pelo token de acesso dado.
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // Implemente a lógica para verificar o token aqui
        // Exemplo: return static::findOne(['access_token' => $token]);
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        // Aqui você deveria retornar uma chave usada para verificação de sessão
        // Exemplo: return $this->auth_key;
        throw new NotSupportedException('"getAuthKey" is not implemented.');
    }

    public function validateAuthKey($authKey)
    {
        // Aqui você compara a authKey fornecida com a armazenada
        // Exemplo: return $this->getAuthKey() === $authKey;
        throw new NotSupportedException('"validateAuthKey" is not implemented.');
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
}
