<?php

namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\validators\Validator;

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
class PilotInhouseUser extends ActiveRecord implements IdentityInterface {

    public $confirm_password;
    public $passupdate;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pilot_inhouse_user';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['emailaddress', 'firstname', 'password', 'confirm_password', 'status'], 'required'],
            //[['role'], 'integer'],
            [['emailaddress'], 'email'],
            [['designation', 'emailaddress', 'password','firstname', 'lastname','role','phone_number_1','phone_number_2','address'], 'string', 'max' => 255],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
            [['emailaddress'], 'unique'],
            ['passupdate', 'validateUsername', 'on' => 'update'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'emailaddress' => 'Email Address',
            'password' => 'Password',
            'role' => 'Role',
            'last_login_id' => 'Last Login ID',
            'last_access_time' => 'Last Access Time',
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'phone_number_1' => 'Phone Number 1',
            'phone_number_2' => 'Phone Number 2',
            'profile_pic' => 'Profile Picture',            
            'created' => 'Created At',
            'updated' => 'updated',
            'ip_address' => 'ip_address',
            'confirm_password' => 'Confirm Password',
            'address' => 'Address',
            'status' => 'Status',
            'passupdate' => 'Password',
            'designation' => 'Designation'
        ];
    }

    /* rules define for update page
     * if it change the email only then password validation will true
     */

    /*
     * scenerio is used to define diffrent validation on update page
     */

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['update'] = ['passupdate', 'firstname'];
        return $scenarios;
    }

    /*
     * this function is used for validation called by scenario
     */

    public function validateUsername() {
        $pass = $this->password;
        if (!empty($pass)) {
            if (!empty($this->confirm_password)) {
                if (($this->password) == ($this->confirm_password)) {
                    
                } else {
                    $this->addError('confirm_password', ' Confirm Password do not match');
                }
            } else {
                $this->addError('confirm_password', 'Confirm Password cannot be blank');
            }
        } else {
            
        }
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        if (($this->password) == $password) {
            return $password;
        } else {
            return false;
        }
        // return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        //return $this->auth_key;
    }

    /**
     * @params $authKey as integer
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @params $id as integer
     * @inheritdoc
     */
    public static function getUsername($id) {
        $models = PilotInhouseUser::find()->where(['id' => $id])->one();
        $name = ucfirst($models->firstname) . ' ' . ucfirst($models->lastname);
        if (empty($models->firstname)) {
            return $models->username;
        } else {
            return $name;
        }
    }

    /**
     * @params $id as integer
     * @inheritdoc
     */
    public static function getImage($id) {
        $models = PilotInhouseUser::find()->where(['id' => $id])->one();
        if (!empty($models->profile_pic)) {
            return $models->profile_pic;
        } else {
            return 'images.jpg';
        }
    }

    /**
     * @params $id as integer
     * @inheritdoc
     */
    public static function getStatus($id) {
        $models = PilotInhouseUser::find()->where(['id' => $id])->one();
        if (($models->status) == 0) {
            return 'Inactive';
        } else {
            return 'Active';
        }
    }

    /**
     * @params $id as integer
     * @inheritdoc
     */
    public static function getRole($id) {
        $models = PilotInhouseUser::find()->where(['id' => $id])->one();
        if (($models->role) == 1) {
            return 'Admin';
        } elseif (($models->role) == 2) {
            return 'Manager';
        } else {
            return 'Manager';
        }
    }

    /**
     * @params $id as integer
     * @inheritdoc
     */
    public static function getAccesstime($id) {
        $models = PilotInhouseUser::find()->where(['id' => $id])->one();
        $created = $models->last_access_time;
        if (empty($created) || $created == 0) {
            return false;
        }
        return date("M d, Y", $created);
    }

    /**
     * @params $id as integer
     * @inheritdoc
     */
    public static function getEmail($id) {
        $models = PilotInhouseUser::find()->where(['id' => $id])->one();
        return $models->emailaddress;
    }

    /**
     * @params $id as integer
     * @inheritdoc
     */
    public static function getphonenumber1($id) {
        $models = PilotInhouseUser::find()->where(['id' => $id])->one();
        return $models->phone_number_1;
    }

   

    /**
     * @params $id as integer
     * @inheritdoc
     */
    public static function getIP($id) {
        $models = PilotInhouseUser::find()->where(['id' => $id])->one();
        return $models->ip_address;
    }

    /**
     * @params $id as integer
     * @inheritdoc
     */
    public static function isUserAdmin($id) {
        $models = PilotInhouseUser::find()->where(['id' => $id])->one();
        if (($models->role) == 1) {
            return true;
        } else {
            return false;
        }
    }

}
