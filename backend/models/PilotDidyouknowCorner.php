<?php

namespace backend\models;

use Yii;
use backend\models\Company;

/**
 * This is the model class for table "pilot_leadership_corner".
 *
 * @property integer $id
 * @property string $client_listing
 * @property string $title

 * @property string $description
 * @property integer $created
 * @property integer $updated
 * @property integer $user_id
 */
class PilotDidyouknowCorner extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pilot_didyouknow_corner';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['week', 'description'], 'required'],
            [['id', 'created', 'updated', 'user_id'], 'integer'],
                // ['title', 'checkWeek'],
                //[['client_listing', 'title',  'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'category_id' => 'category_id',
            'weeks' => 'Week',
            'description' => 'Description',
            'created' => 'Created',
            'updated' => 'Updated',
            'user_id' => 'User ID',
        ];
    }

    /**
     * retrive image name of leadership corner
     * if not exist the return default image name
     * @return mixed
     */

    /**
     * retrive updated by user name and updated date
     * @return mixed
     */
    public static function getUpdated($id, $uid) {
        $models = PilotDidyouknowCorner::find()->where(['id' => $id])->one();
        $user = PilotInhouseUser::find()->where(['id' => $uid])->one();
        $updated = $models->updated;
        return 'by ' . ucfirst($user->firstname) . ' ' . ucfirst($user->lastname) . '<br>' . date("M d, Y", $updated);
    }

    /**
     * retrive client name
     * @return mixed
     */
    public static function getClientname($id) {
        $models = Company::find()->where(['id' => $id])->one();
        return $models->company_name;
    }

    /**
     * retrive count number of client as per name
     * @return mixed
     */
    public static function getCountclient($id) {
        $models = Company::find()->where(['id' => $id])->one();
        $countmodel = PilotDidyouknowCorner::find()->where(['client_listing' => $models->id])->all();
        return count($countmodel);
    }

    /**
     * retrive client image
     * @return mixed
     */
    public static function getClientImage($id) {
        $models = Company::find()->where(['id' => $id])->one();
        $image = $models->image;
        if (empty($image)) {
            return "trans.gif.jpg";
        } else {
            return $image;
        }
    }

    public function checkWeek($attribute, $params) {
        $this->addError($attribute, 'Already exist!');
        return false;
    }

    public static function getRecords($id) {
        $model = PilotDidyouknowCorner::find()->where(['category_id' => $id])->all();
        return count($model);
    }

}
