<?php
/**
 * Created by PhpStorm.
 * User: tuann
 * Date: 5/16/2019
 * Time: 20:58
 */

namespace frontend\controllers;


use cheatsheet\Time;
use frontend\models\search\ProductSearch;
use yii\filters\PageCache;
use yii\web\Controller;

class ProductController extends Controller
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => PageCache::class,
                'only' => ['sitemap'],
                'duration' => Time::SECONDS_IN_AN_HOUR,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
            ],
            'set-locale' => [
                'class' => 'common\actions\SetLocaleAction',
                'locales' => array_keys(\Yii::$app->params['availableLocales'])
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new ProductSearch();
        $dataProvider = $model->search();
        return $this->render('index',['model' => $model,'dataProvider' => $dataProvider]);
    }


}