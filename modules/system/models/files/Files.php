<?php

namespace app\modules\system\models\files;

use Yii;
use yii\db\Exception;
use yii\helpers\BaseFileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "system_files".
 *
 * @property int $id
 * @property string $filename Имя файла
 * @property string $uuid UUID файла
 * @property string $tag
 * @property int|null $user_id
 */
class Files extends \yii\db\ActiveRecord
{
    private $_model;

    public function __construct($config = [])
    {
        $this->_model = $config['model'];


    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'system_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['filename', 'uuid', 'tag'], 'required'],
            [['filename', 'uuid', 'tag'], 'string'],
            [['user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Filename',
            'uuid' => 'Uuid',
            'tag' => 'Tag',
            'user_id' => 'User ID',
        ];
    }
    public function upload()
    {

        $files = UploadedFile::getInstances($this->_model, '_files');;
        foreach ($files as $file) {
            $baseName = uniqid('file') . md5($file->name.rand(0,1000));

            $this->filename = $baseName . '.' . $file->extension;
            $this->uuid = $baseName;
            $this->tag = array_pop(json_decode($this->_model->tag));
            $this->user_id = Yii::$app->user->identity->id;

            $path = Yii::getAlias('@uploads') . '/files/' . $this->tag;
            BaseFileHelper::createDirectory($path);
            if(!$file->saveAs($path.'/'.$this->filename))
                throw new \yii\base\Exception('Ошибка при сохранении файла');
            $this->save();
        }
        return true;
    }

    public static function getFilesByTag($tag)
    {
       return self::find()->all();
    }
}
