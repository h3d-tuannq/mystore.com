<?php
/**
 * @var $this yii\web\View
 * @var $model common\models\Article
 */
use yii\helpers\Html;

?>
<div class="product-item">
    <div class="col-xs-12">
        <h5 class="product-title">
            <?php echo Html::a($model->name, ['view', 'slug'=>$model->slug]) ?>
        </h5>
        <div class="btn-buy">
                <?php
                echo Html::a("Buy",['view','class' => "btn-danger"]);
                ?>
        </div>

        <div class="product-content">
            <div class="product-img">
                <?php // test design image
                $model->thumbnail_path  = "https://cdn.24h.com.vn/upload/2-2019/images/2019-05-23/120x90/td-1558595312-238-width640height480.jpg";
                echo Html::img($model->thumbnail_path,['class' => 'product-image article-thumb img-rounded pull-left' ]);
                ?>
            </div>
            <?php /*if ($model->thumbnail_path): */?><!--
                <?php /*echo Html::img(
                    Yii::$app->glide->createSignedUrl([
                        'glide/index',
                        'path' => $model->thumbnail_path,
                        'w' => 100
                    ], true),
                    ['class' => 'article-thumb img-rounded pull-left']
                ) */?>
            --><?php /*endif; */?>
            <div class="product-price">
                <p><h4><?=$model->retail_price ?></h4></p>
            </div>

         <!--   <div class="article-text">
                <?php /*echo \yii\helpers\StringHelper::truncate($model->name, 150, '...', null, true) */?>
            </div>-->


        </div>



    </div>
</div>
