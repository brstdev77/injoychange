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
class PilotTodayslessonCorner extends \yii\db\ActiveRecord {

    public $type;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pilot_todayslesson_corner';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title', 'week', 'question', 'file_link','popup_image','dashboard_image','answer_type','question_placeholder'], 'required'],
            //['file_link', 'validatefile'],
//            ['file_link', 'required', 'when' => function ($model) {
//                    if ($model->answer_type == '') {
//                        return false;
//                    }
//                },
//                'whenClient' => "function (attribute, value) { if($(!'#pilotleadershipcorner-answer_type input').is(':checked')){ return false; } ; }"],
            
            [['id', 'created', 'updated', 'user_id'], 'integer'],
            // ['title', 'checkWeek'],
            [['title', 'question', 'answer_type', 'designation','popup_image','dashboard_image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'category_id' => 'category_id',
            'popup_image' => 'Popup Image',
            'title' => 'Title',
            'weeks' => 'Week',
            'description1' => 'Description 1',
            'description2' => 'Description 2',
            'created' => 'Created',
            'updated' => 'Updated',
            'user_id' => 'User ID',
            'dashboard_image' => 'Dashboard Image',
            'type' => 'Type',
            'file_link' => 'File Link',
            'answer_type' => 'Answer Type',
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
        $models = PilotTodayslessonCorner::find()->where(['id' => $id])->one();
        $user = PilotInhouseUser::find()->where(['id' => $uid])->one();
        $updated = $models->updated;
        return 'by ' . ucfirst($user->firstname) . ' ' . ucfirst($user->lastname) . '<br>' . date("M d, Y", $updated);
    }

    public function validatefile($attributes, $params) {
        echo 'dsdsd';
        die;
        if ($this->answer_type) {
            if ($this->file_link == '')
                $this->addError('file_link', 'Error Message');
        }
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
        $countmodel = PilotTodayslessonCorner::find()->where(['client_listing' => $models->id])->all();
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
        $model = PilotTodayslessonCorner::find()->where(['category_id' => $id])->all();
        return count($model);
    }

}
