<?php

use app\ext\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1 class="pull-right"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-sm-9">
            <p class="lead">Payments history</p>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#incoming" aria-controls="home" role="tab" data-toggle="tab">
                        Incoming <span style="color: #00CC00" class="glyphicon glyphicon-circle-arrow-left"></span>
                    </a>
                </li>
                <li role="presentation"><a href="#outgoing" aria-controls="profile" role="tab" data-toggle="tab">
                        Outgoing <span style="color: #FF0000" class="glyphicon glyphicon-circle-arrow-right"></span>
                    </a>
                </li>
            </ul>

            <!-- Вкладки панелей -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="incoming">
                    <p class="lead">From:</p>
                    <ul class="list-group">
                        <?php foreach ($model->incomingTransactions as $transaction):?>
                            <li class="list-group-item">
                                user <b><?=Html::ucfirstEncode($transaction->paymentSender->name)?></b>
                                send you <b><?=$transaction->amount?></b>
                                <span class="badge">+<?=$transaction->amount?></span>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane" id="outgoing">
                    <p class="lead">To:</p>
                    <ul class="list-group">
                        <?php foreach ($model->paymentsTransactions as $transaction):?>
                            <li class="list-group-item">
                                user <b><?=Html::ucfirstEncode($transaction->paymentReceivers->name)?></b>
                                get from you <b><?=$transaction->amount?></b>
                                <span class="badge">-<?=$transaction->amount?></span></li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>

        </div>
        <div class="col-sm-3">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name',
                    'balance',
                ],
            ]) ?>
        </div>

    </div>
</div>