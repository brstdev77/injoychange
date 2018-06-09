<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pilot_tags".
 *
 * @property integer $id
 * @property string $tags
 * @property integer $created
 * @property integer $updated
 */
class PilotTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created', 'updated'], 'integer'],
            [['tags'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tags' => 'Tags',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
     public static function getRecords($id){
        $model = PilotTags::find()->where(['id'=>$id])->one();
        return $model->tags;
    }
}
