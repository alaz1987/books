<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Authors;

/* @var $this yii\web\View */
/* @var $model app\models\Books */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить книгу?',
                'method' => 'post',
            ],
        ]) ?>
    </p>



    <?
    $attributes = [
        'name',
        'date_create',
        'date_update'
    ];

    if (!empty($model->preview)) {
        $path = Yii::getAlias('@webroot'.$model->preview);
        if (file_exists($path)) {
            $size = getimagesize($path);

            $attributes[] = [
                'attribute' => 'preview',
                'format' => 'raw',
                'value' => Html::a(Html::img($model->preview, [
                        'width' => $size[0],
                        'height' => $size[1]
                    ]),
                    str_replace('preview', 'images', $model->preview),
                    ['rel' => 'fancybox']
                )
            ];
        }
    }

    $author = Authors::findOne($model->author_id);
    $attributes = array_merge($attributes, [
        'date',
        [
            'attribute' => 'author_id',
            'format' => 'raw',
            'value' => ($author->firstname.' '.$author->lastname)
        ]
    ]);

    echo DetailView::widget([
        'model' => $model,
        'attributes' => $attributes
    ]); ?>

</div>
