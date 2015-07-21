<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\web\UploadedFile;
use yii\imagine\Image;

/**
 * This is the model class for table "books".
 *
 * @property integer $id
 * @property string $name
 * @property string $date_create
 * @property string $date_update
 * @property string $preview
 * @property string $date
 * @property integer $author_id
 */
class Books extends \yii\db\ActiveRecord
{
    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'name', 'author_id'], 'required'],
            [['author_id'], 'integer'],
            [['date_create', 'date_update', 'date'], 'safe'],
            //[['date_create', 'date_update'], 'date'],
            //[['date'], 'date', 'format' => 'php:d.m.Y'],
            [['name'], 'string', 'max' => 255],
            [['preview'], 'string', 'max' => 512],
            [['imageFile'], 'image', 'extensions' => 'png,jpg,gif,bmp', 'skipOnEmpty' => true]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'date_create' => 'Дата добавления',
            'date_update' => 'Дата последнего изменения записи',
            'preview' => 'Превью',
            'imageFile' => 'Картинка',
            'date' => 'Дата выхода книги',
            'author_id' => 'Автор',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->date_create = new Expression("NOW()");
            }


            $d = split("\.", $this->date);
            $this->date = $d[2].'-'.$d[1].'-'.$d[0];

            $this->date_update = new Expression("NOW()");

            $file = UploadedFile::getInstance($this, 'imageFile');
            $dir = Yii::getAlias('@webroot/upload/images/');

            if ($this->validate()) {
                $path = $dir.md5($file->tempName).'.'.$file->getExtension();
                $isSaved = $file->saveAs($path);

                if (!$isSaved) {
                    return false;
                }

                $thumbPath = str_replace('images', 'preview', $path);
                $thumbWidth = Yii::$app->params['thumbWidth'];
                $thumbHeight = Yii::$app->params['thumbHeight'];
                $thumbQuality = Yii::$app->params['thumbQuality'];

                Image::thumbnail($path , $thumbWidth, $thumbHeight)
                    ->save($thumbPath, ['quality' => $thumbQuality]);
                $this->preview = str_replace(Yii::getAlias('@webroot'), '', $thumbPath);
            } else {
                return false;
            }

            return true;
        }

        return false;
    }
}
