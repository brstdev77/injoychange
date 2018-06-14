<?php

namespace backend\models;

use Yii;
use backend\models\PilotInhouseUser;

/**
 * This is the model class for table "pilot_logs".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $error_type
 * @property integer $message
 * @property integer $ip
 * @property integer $location
 * @property integer $timestamp
 */
class PilotLogs extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pilot_logs';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'type', 'message', 'ip', 'location', 'timestamp'], 'required'],
            [['user_id', 'message', 'ip_address', 'location', 'timestamp'], 'integer'],
            [['log_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'message' => 'Message',
            'ip_address' => 'Ip Address',
            'location' => 'Location',
            'timestamp' => 'Timestamp',
            'log_type' => 'Log Type',
            'refer' => 'Referer',
        ];
    }

    /*
     * Save log messages in database
     * @params $uid integer
     * @params $type varchar
     * @params $errtype varchar
     * @params $refer varchar
     * @params $msg varchar
     * @return mixed
     */

    public static function setpilotlog($uid, $type, $errtype, $refer, $msg) {
        $log = new PilotLogs();
        $log->user_id = $uid;
        $log->type = $type;
        $log->log_type = $errtype;
        $log->refer = $refer;
        $log->message = $msg;
        $log->location = $_SERVER['REMOTE_ADDR'];
        $log->timestamp = time();
        $log->save(false);
        return true;
    }

    /*
     * Retrive user name
     * @params $id integer
     * @return mixed
     */

    public static function getusername($id) {
        $models = PilotInhouseUser::find()->where(['id' => $id])->one();
        $name = ucfirst($models->firstname) . ' ' . ucfirst($models->lastname);
        if (empty($models->firstname)) {
            return $models->username;
        } else {
            return $name;
        }
    }

    /*
     * Retrive log created date
     * @params $id integer
     * @return mixed
     */

    public static function logdate($id) {
        $model = PilotLogs::find()->where(['id' => $id])->one();
        if(!empty($model->timestamp)){
            return date('M d, Y H:i:s a', $model->timestamp);
        }else{
            return false;
        }
    }

}
