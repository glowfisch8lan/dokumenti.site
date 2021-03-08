<?php

namespace app\modules\system\models\files;

use Yii;
use DateTime;
use yii\db\Exception;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;

/**
 * This is the model class for table "system_files".
 * При инициализации класса нужно передать $config['model] -> модель с Тэгом и Файлами;
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

    /**
     * Files constructor. Наполняем приватное свойство $_model => $config['model] -> модель с Тэгом и Файлами;
     * @param array $config
     */
    public function __construct($config = [])
    {
        if(isset($config['model']))
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
            [['filename', 'uuid', 'tag', 'timestamp'], 'required'],
            [['filename', 'uuid', 'tag'], 'string'],
            [['user_id', 'timestamp'], 'integer'],
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

    /**
     * Загрузка файлов;
     *
     * @return bool
     * @throws \yii\base\Exception
     */
    public function upload()
    {

        $files = UploadedFile::getInstances($this->_model, '_files');;

        /**
         * Проходим по каждому файлу циклом;
         */
        foreach ($files as $file) {
            /**
             * Создаем экземпляр модели, чтобы наполнять ее и записать в БД
             */
            $object = new self();
            $date = new DateTime();
            $baseName = uniqid('file') . md5($file->name.rand(0,1000));

            /**
             * Наполняем собственную модель для записи в БД в таблицу tableName();
             */
            $object->filename = $baseName . '.' . $file->extension;
            /**
             * Записываем uuid файла, пока мало где используется.
             */
            $object->uuid = $baseName;
            /**
             * Получаем весь массив тегов, записанный в таблице заказов БД в формате JSON и выбираем самый последний Тэг, записанный раннее. Он является текущим для данной операции тегом.
             */
            $arrayTag = json_decode($this->_model->tag); //Иначе PHP выдает Notice;
            $object->tag = array_pop($arrayTag);
            /**
             * Устанавливаем дату загрузки файла - timestamp;
             */
            $object->timestamp = $date->getTimestamp();

            /**
             * Присваиваем файлам владельца;
             */
            $object->user_id = Yii::$app->user->identity->id;

            /**
             * создаем тегированную Папку в Хранилище;
             */
            $path = Yii::getAlias('@uploads') . '/files/' . $object->tag;
            BaseFileHelper::createDirectory($path);

            /**
             * Сохраняем файл;
             */
            if(!$file->saveAs($path.'/'.$object->filename))
                throw new \yii\base\Exception('Ошибка при сохранении файла');

            /**
             * В случае успешной загрузки файла -> добавляем запись в БД, иначе выбрасываем исключение
             */
            if(!$object->save())
                throw new \yii\base\Exception('Ошибка при записи в таблицу ' . $this->tableName() . ' информациюю о файле!');
        }

        return true;
    }

    /**
     * Получаем все файлы из таблицы tableName() по уникальному тегу;
     *
     * @param $tag
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getFilesByTag($tag)
    {
       return self::find()->where(['tag' => $tag])->all();
    }

    public static function fileExist($uuid, $file)
    {
        return file_exists(Yii::getAlias('@uploads/files').'/'.$uuid.'/'.$file);
    }
}
