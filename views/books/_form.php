<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Books */
/* @var $authors app\models\Authors */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="books-form">

    <? $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <?=$form->errorSummary($model)?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?
        // preview image
        echo $form->field($model, 'imageFile')->fileInput();

        if (!empty($model->preview)) {
            $path = Yii::getAlias('@webroot'.$model->preview);
            if (file_exists($path)) {
                $size = getimagesize($path);

                echo Html::a(Html::img($model->preview, [
                        'width' => $size[0],
                        'height' => $size[1]
                    ]),
                    str_replace('preview', 'images', $model->preview),
                    ['rel' => 'fancybox']
                );
                echo "<br><br>";
            }
        }
    ?>

    <?= $form->field($model, 'date')->widget(DatePicker::className(), [
        'options' => [
            'placeholder' => 'Укажите дату выхода книги',
            'value' => empty($model->date) ? '' : Yii::$app->formatter->asDate($model->date)
        ],
        'pluginOptions' => [
            'format' => 'dd.mm.yyyy',
            'todayHighlight' => true,
            'autoclose' => true,
            'endDate' => date('d.m.Y')
        ]
    ]) ?>

    <?= $form->field($model, 'author_id')->DropDownList($authors, ['prompt' => 'Выберите автора']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
