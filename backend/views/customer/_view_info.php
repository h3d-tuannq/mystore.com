<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

?>

<div class="box box-primary">

    <div class="box-body">
        <h3>Thông tin cơ bản</h3>
	    <?php echo DetailView::widget( [
		    'model'      => $model,
		    'attributes' => [
			    //'id',
			    'name',
			    'birth_of_date:date',
			    //'source',
			    //'is_notification_birthday',
			    //'is_notification_service',
                [
                    'attribute'=>'status',
                    'value'=> function($model){
                        switch($model->status){
                            case \common\models\Common::STATUS_DELETED: $status = 'Đã xóa';break;
                            case \common\models\Common::STATUS_ACTIVE: $status = 'Hoạt động';break;
                            case \common\models\Common::STATUS_ACTIVE:
                            default: $status = 'Không hoạt động';
                        }
                        return $status;
                    }
                ],
			    //'thumbnail_base_url:url',
			    //'thumbnail_path',
			    //'created_at:datetime',
			    //'updated_at:datetime',
			    //'created_by',
			    //'updated_by',
			    'account_money:currency',
		    ],
	    ] ) ?>
    </div>
</div>

