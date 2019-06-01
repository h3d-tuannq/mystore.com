<?php

use yii\helpers\Html;


?>

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#service" data-toggle="tab" aria-expanded="true">Lịch sử Dịch vụ</a></li>
        <li class=""><a href="#card" data-toggle="tab" aria-expanded="false">Lịch sử Thẻ</a></li>
        <li class=""><a href="#payment" data-toggle="tab" aria-expanded="false">Lịch sử Thẻ tiền</a></li>
        <li class=""><a href="#order" data-toggle="tab" aria-expanded="false">Lịch sử Hóa đơn</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="service">
            <!-- Post -->
            <?php //echo $this->render('history/_service', ['model' => $model, 'serviceDataProvider' => $serviceDataProvider]) ?>
            <?php echo $this->render('history/_service_combo', ['model' => $model, 'dataProvider' => $dataProvider]) ?>
            <!-- /.post -->
        </div>

        <div class="tab-pane" id="card">

            <?php //echo $this->render('history/_card', ['model' => $model, 'cardDataProvider' => $cardDataProvider]) ?>
            <?php echo $this->render('history/_card_combo', ['model' => $model, 'cDataProvider' => $cDataProvider,]) ?>
        </div>
        <div class="tab-pane" id="payment">
            <?php echo $this->render('history/_payment', ['model' => $model]) ?>
        </div>
        <div class="tab-pane" id="order">

            <?php //echo $this->render('history/_card', ['model' => $model, 'cardDataProvider' => $cardDataProvider]) ?>
            <?php echo $this->render('history/_order', ['model' => $model, 'oDataProvider' => $oDataProvider,]) ?>
        </div>
        <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
</div>

