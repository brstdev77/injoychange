<?php

namespace common\models;

use Yii;

use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "pilot_inhouse_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $emailaddress
 * @property string $passsword
 * @property integer $role
 * @property string $last_login_id
 * @property string $last_access_time
 * @property string $firstname
 * @property string $lastname
 */
class PilotInhouseUser extends ActiveRecord implements IdentityInterface
{
	
	
	public $recaptcha;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_inhouse_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'emailaddress', 'passsword', 'role', 'last_login_id', 'last_access_time', 'firstname', 'lastname','recaptcha'], 'required'],
            [['role'], 'integer'],
            [['username', 'emailaddress', 'passsword', 'last_login_id', 'last_access_time', 'firstname', 'lastname'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'emailaddress' => 'Emailaddress',
            'passsword' => 'Passsword',
            'role' => 'Role',
            'last_login_id' => 'Last Login ID',
            'last_access_time' => 'Last Access Time',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
        ];
    }
	/**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
  //  public static function findByUsername($username)
   // {
   //     return static::findOne(['username' => $username]);
    //}
      public static function findByEmailaddress($emailaddress)
    {
        return static::findOne(['emailaddress' => $emailaddress]);
    }
	/**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
		if(($this->password)== md5($password))
		{
			return md5($password);
		}else{
			return false;
		}
       // return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
	/**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }
	/**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
	 /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
	/**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        //return $this->auth_key;
    }
	/**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
