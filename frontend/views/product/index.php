<?php
/**
 * Created by PhpStorm.
 * User: tuann
 * Date: 5/16/2019
 * Time: 22:18
 */

use yii\bootstrap\ActiveForm;
$this->title = Yii::t('frontend','Danh sách sản phẩm của cửa hàng');
$this->registerCssFile('@web/css/product.css', ['depends' => [common\assets\AdminLte::className()]]);
?>
<div>
    <?php $form = ActiveForm::begin(); ?>
        <div class="filter-search-container">
            <div class="filter-container">
                <?php
                    echo $this->render('_filter',
                        [
                            'form' => $form
                        ]
                    );


                ?>
            </div>
            <div class="search-container">
                <?php
                echo $this->render('_search',
                    [
                        'form' => $form
                    ]
                );


                ?>
            </div>
        </div>

        <div class="product-list">
            <div class="col-md-12">
                <?php echo \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_product',
                    'viewParams' => [
                        'view' => 1,
                    ],
                    'layout' => "{summary}\n{items}\n{pager}"
                ])

                ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>