<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pilot_front_service_steps_modal".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $challenge_id
 * @property string $steps
 * @property string $modal_shown
 * @property string $modal_read
 * @property string $dayset
 * @property integer $created
 * @property integer $updated
 */
class PilotFrontServiceStepsModal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_front_service_steps_modal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'challenge_id', 'steps', 'modal_shown', 'modal_read', 'dayset', 'created', 'updated'], 'required'],
            [['user_id', 'challenge_id', 'created', 'updated'], 'integer'],
            [['steps', 'modal_shown', 'modal_read', 'dayset'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'challenge_id' => 'Challenge ID',
            'steps' => 'Steps',
            'modal_shown' => 'Modal Shown',
            'modal_read' => 'Modal Read',
            'dayset' => 'Dayset',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
