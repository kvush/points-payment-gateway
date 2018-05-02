<?php

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\bootstrap\Html;
use yii\widgets\ListView;


$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome to <small><?=Html::encode($this->title)?></small></h1>

        <p class="lead">Send "points" between users</p>
    </div>

    <div class="body-content">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{summary}<div class="row">{items}</div>{pager}',
            'itemOptions' => ['class' => 'col-lg-3'],
            'itemView' => '_user'
        ]) ?>
    </div>
</div>
