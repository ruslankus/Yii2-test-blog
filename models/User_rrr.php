<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User_rrr extends ActiveRecord implements IdentityInterface
{


    public $id;
    public $username;
    public $surname;
    public $name;
    public $salt;
    public $password;
    public $acces_token;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blg_user';
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username','name'],
            ['username','email'],
            ['username','unique'],
        ];
    }


    public function attributeLabels(){
        return [

            'id' => _('ID'),
            'name' => _('Имя'),
            'surname' => _('Фамилия'),
            'online' => _('Онлайн'),
            'password' => _('Пароль'),
            'salt' => _('Соль'),
            'access_token' => _('Ключ авторизации'),
        ];
    }


    public function beforeSave($insert){

        if(parent::beforeSave($insert)){

            if($this->getIsNewRecord() && !empty($this->password) )
            {
                $this->salt = $this->saltGenerator();
            }
            if(!empty($this->password))
            {
                $this->password = $this->passWithSalt($this->password,$this->salt);
            }
            else
            {
                unset($this->password);
            }

        }
        else
        {
            return false;
        }

    }//beforeSave




    public function saltGenerator()
    {
        return hash("sha512",uniqid('salt_',true));

    }


    public function passWithSalt($password,$salt)
    {
        return hash("sha512",$password . $salt);
    }


    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }



    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|integer an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->getPrimaryKey()["id"];
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->acces_token;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }


    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return $this->password === $this->passWithSalt($password,$this->saltGenerator());
    }


    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $this->passWithSalt($password,$this->saltGenerator());
    }


    /**
     *
     * Generates "remember me" authentication key
     *
     */
    public function generateAuthKey()
    {
        $this->acces_token = Yii::$app->security->generateRandomString();
    }




}