<?php

namespace app\modules\system\models\storage;


class FilesInfo extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['files_id', 'name', 'description', 'extension'], 'safe']
        ];
    }


    public static function tableName(){
        return 'system_files_info';
    }

}