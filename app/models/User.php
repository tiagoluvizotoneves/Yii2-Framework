<?php
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    /**
     * Especifica o nome da tabela associada ao modelo.
     * 
     * @return string O nome da tabela no banco de dados.
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * Especifica o nome da tabela associada ao modelo.
     * 
     * @return string O nome da tabela no banco de dados.
     */
    public function rules()
    {
        return [
            [['username', 'password', 'name'], 'required'],
            [['username'], 'unique'],
            [['username', 'password', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * Encontra uma identidade (usuário) pelo ID dado.
     * 
     * @param int|string $id O ID do usuário.
     * @return static|null A instância do usuário, ou null se não encontrado.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Encontra uma identidade (usuário) pelo token de acesso dado.
     * 
     * @param string $token O token de acesso.
     * @param mixed $type O tipo do token.
     * @return static|null A instância do usuário, ou null se não encontrado.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Obtém o ID do usuário.
     * 
     * @return string|int O ID do usuário.
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Obtém a chave de autenticação para o usuário.
     * 
     * @return string A chave de autenticação.
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Valida a chave de autenticação fornecida.
     * 
     * @param string $authKey A chave de autenticação a ser validada.
     * @return bool Se a chave de autenticação é válida.
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Gera uma nova chave de autenticação.
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Valida se a senha fornecida é correta.
     * 
     * @param string $password A senha para validar.
     * @return bool Se a senha é válida para o usuário atual.
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Define a senha para o usuário, criptografando-a antes de armazenar.
     * 
     * @param string $password A senha a ser definida.
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
}
