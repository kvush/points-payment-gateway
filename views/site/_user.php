<?php
/* @var $this yii\web\View */
/* @var $model app\models\User */

if ($model->balance < 0) {
    $color = "#FF0000";
}
else {
    $color = "#00CC00";
}
?>

<h3><?=\app\ext\Html::ucfirstEncode($model->name)?></h3>
<p>
    Current balance:<br>
    <b style="color: <?=$color?>"><?=number_format($model->balance, 2)?></b>
</p>
