<?php

namespace app\models;

use Yii;
use yii\db\Expression;

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
            [['name'], 'string', 'max' => 255],
            [['preview'], 'string', 'max' => 512]
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
            'date' => 'Дата выхода книги',
            'author_id' => 'Автор',
        ];
    }

    public function beforeSave($insert)
    {
        $r = parent::beforeSave($insert);
        echo '===';
        var_dump($r);
        echo '===';

        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->date_create = new Expression("NOW()");
                $d = $this->date;
                $this->date = new Expression("DATE_FORMAT($d, \"%D-%M-%Y %H:%i:%s\")");

                //echo "DATE_FORMAT($d, \"%D %M %Y %H:%i:%s\")";
                //die();
            }

            $this->date_update = new Expression("NOW()");
            return true;
        }

        return false;

        /*
        print('<pre>');
        print_r($this);
        print('</pre>');
        die();
        */
    }
}
