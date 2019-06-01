<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

?>
<div class="order-info">
    <table class="table no-margin">
        <tr>
            <td>Mã hóa đơn</td>
            <th><?= $model->code ?></th>
        </tr>
        <tr>
            <td>Khách hàng</td>
            <th><?= $model->customer ? $model->customer->name : 'Khách hàng' ?></th>
        </tr>
        <tr>
            <td>Điện thoại</td>
            <th><?= $model->customer ? $model->customer->phone : '' ?></th>
        </tr>
        <tr>
            <td>Ngày tạo</td>
            <th><?= Yii::$app->formatter->asDatetime($model->created_at) ?></th>
        </tr>
        <tr>
            <td>Tạo bởi</td>
            <th><?= $model->author ? $model->author->userProfile->fullName : '' ?></th>
        </tr>
        <tr>
            <td>Ngày cập nhật</td>
            <th><?= Yii::$app->formatter->asDatetime($model->updated_at) ?></th>
        </tr>
        <tr>
            <td>Cập nhật bởi</td>
            <th><?= $model->updater ? $model->updater->userProfile->fullName : '' ?></th>
        </tr>
        <?php if ($model->employee) { ?>
            <tr>
                <td>Chiết khấu nhân viên <b><?= $model->employee->name ?></b></td>
                <th><?= \Yii::$app->formatter->asPercent($model->rate_employee / 100, 0) ?></th>
            </tr>
        <?php } ?>

        <?php if ($model->employee) { ?>
            <tr>
                <td>Chiết khấu lễ tân <b><?= $model->receptionist ? $model->receptionist->name : '' ?></b></td>
                <th><?= \Yii::$app->formatter->asPercent($model->rate_receptionist / 100, 0) ?></th>
            </tr>
        <?php } ?>


    </table>

</div>
