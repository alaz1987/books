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

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'preview')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->widget(DatePicker::className(), [
        'name' => 'date', 
        'value' => date('d.m.Y', strtotime($model->date)),
        'options' => ['placeholder' => 'Укажите дату выхода книги'],
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
