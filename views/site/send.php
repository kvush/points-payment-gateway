<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */


use app\ext\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Send points';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-send">
    <h1><?= Html::encode($this->title) ?> <small>from <?=Html::ucfirstEncode(Yii::$app->user->identity->name)?></small></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'send-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'receiverName')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'amount')->textInput() ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Send', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
