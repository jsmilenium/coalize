<?php

namespace app\modules\v1\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @var mixed|null
     */
    public mixed $id = null;

    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return ['username', 'password', 'auth_key', 'password_hash', 'id', 'access_token', 'status', 'created_at', 'updated_at'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
                [['username', 'password'], 'required'],
                ['username', 'string', 'max' => 20],
                [['username', 'password'], 'trim'],
                ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Valida a senha.
     * Isso é usado pelo método 'validatePassword()' acima.
     *
     * @param string $attribute o atributo que está sendo validado
     * @param array $params os parâmetros dados para a validação
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Nome de usuário ou senha inválidos.');
            }
        }
    }

    /**
     * Encontra o usuário pelo nome de usuário.
     *
     * @return User|null
     */
    protected function getUser()
    {
        return User::findOne(['username' => $this->username]);
    }

    /**
     * Efetua login no sistema.
     *
     * @return bool se o login for bem-sucedido
     */
    public function login(): bool
    {
        return Yii::$app->user->login($this->getUser());
    }

    /**
     * Registra um novo usuário.
     *
     * @return bool se o registro for bem-sucedido
     * @throws \Exception
     */
    public function register(): bool
    {
        if (!$this->getAttribute('username')) {
            throw new \Exception('Nome de usuário é obrigatório.', 400);
        }
        if (!$this->getAttribute('password')) {
            throw new \Exception('A senha é obrigatória.');
        }
        if($this->getUser()) {
            throw new \Exception('Nome de usuário já cadastrado.', 400);
        }
        $this->setAttribute('auth_key', Yii::$app->security->generateRandomString());
        $this->setAttribute('password_hash', Yii::$app->security->generatePasswordHash($this->password));
        return $this->save();
    }

    /**
     * Localiza uma identidade pelo ID informado
     *
     * @param string|int $id o ID a ser localizado
     * @return IdentityInterface|null o objeto da identidade que corresponde ao ID informado
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Localiza uma identidade pelo token informado
     *
     * @param string $token o token a ser localizado
     * @return IdentityInterface|null o objeto da identidade que corresponde ao token informado
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['id' => $token->claims()->get('uid')]);
    }

    /**
     * @return int|string o ID do usuário atual
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string a chave de autenticação do usuário atual
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool se a chave de autenticação do usuário atual for válida
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function findByUsername($username): ?User
    {
        return User::findOne(['username' => $username]);
    }
}
