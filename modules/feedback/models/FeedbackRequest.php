<?php

namespace app\modules\feedback\models;

use Yii;

/**
 * This is the model class for table "feedback_request".
 *
 * @property int $id
 * @property int $name
 * @property string $phone
 * @property string $timestamp
 */
class FeedbackRequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback_request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'timestamp'], 'required'],
            [['name'], 'integer'],
            [['phone'], 'string'],
            [['timestamp'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'phone' => 'Phone',
            'timestamp' => 'Timestamp',
        ];
    }
}
