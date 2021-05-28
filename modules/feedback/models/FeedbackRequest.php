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

    public $polit;

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
            [['name', 'phone', 'timestamp', 'polit'], 'required'],
            [['name'], 'string'],
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
            'name' => 'Имя',
            'phone' => 'Телефон',
            'polit' => 'Согласие на обработку',
            'timestamp' => 'Timestamp',
        ];
    }
}
