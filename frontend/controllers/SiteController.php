<?php

namespace frontend\controllers;

use cheatsheet\Time;
use common\models\Appointment;
use common\models\Employee;
use common\sitemap\ArticleUrlGenerator;
use common\sitemap\PageUrlGenerator;
use common\sitemap\UrlsIterator;
use frontend\models\ContactForm;
use Sitemaped\Element\Urlset\Urlset;
use Sitemaped\Sitemap;
use Yii;
use yii\filters\PageCache;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
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
                'locales' => array_keys(Yii::$app->params['availableLocales'])
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionHome()
    {
        return $this->render('home');
    }

    /**
     * @return string|Response
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->contact(Yii::$app->params['adminEmail'])) {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => Yii::t('frontend', 'Thank you for contacting us. We will respond to you as soon as possible.'),
                    'options' => ['class' => 'alert-success']
                ]);
                return $this->refresh();
            } else {
                Yii::$app->getSession()->setFlash('alert', [
                    'body' => \Yii::t('frontend', 'There was an error sending email.'),
                    'options' => ['class' => 'alert-danger']
                ]);
            }
        }

        return $this->render('contact', [
            'model' => $model
        ]);
    }

    /**
     * @param string $format
     * @param bool $gzip
     * @return string
     */
    public function actionSitemap($format = Sitemap::FORMAT_XML, $gzip = false)
    {
        $links = new UrlsIterator();
        $sitemap = new Sitemap(new Urlset($links));

        Yii::$app->response->format = Response::FORMAT_RAW;

        if ($gzip === true) {
            Yii::$app->response->headers->add('Content-Encoding', 'gzip');
        }

        if ($format === Sitemap::FORMAT_XML) {
            Yii::$app->response->headers->add('Content-Type', 'application/xml');
            $content = $sitemap->toXmlString($gzip);
        } else if ($format === Sitemap::FORMAT_TXT) {
            Yii::$app->response->headers->add('Content-Type', 'text/plain');
            $content = $sitemap->toTxtString($gzip);
        } else {
            throw new BadRequestHttpException('Unknown format');
        }

        $linksCount = $sitemap->getCount();
        if ($linksCount > 50000) {
            Yii::warning(\sprintf('Sitemap links count is %d'), $linksCount);
        }

        return $content;
    }
    public function actionEmployees()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return Employee::find()->select('id,name as title')->active()->orderBy('slug')->asArray()->all();
    }

    public function actionAll()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // Ngày hiện tại
        //time();
        $appointments = Appointment::find()
            //->where(['appointment_time'=>time()])
            ->active()->all();

        $result = [];
        foreach ($appointments as $appointment){
            $title = '';
            $description = '<h3>';
            if($appointment->customer){
                $title .= $appointment->customer->slug ;
                $description .= 'KH: '. $appointment->customer->name ;
            }
            if($appointment->service){
                $title .= ' - ' . $appointment->service->name;
                $description .= "<br/>Dịch vụ: " . $appointment->service->name;
            }

//            if($appointment->number_customer){
//                $title .= ' - ' . $appointment->number_customer . 'người';
//            }

            if($appointment->phone){
                $title .= "\nĐiện thoại: " . $appointment->phone;
            }
            if($appointment->note){
                $title .= "\nGhi chú: " . $appointment->note;
            }

            if($appointment->appointment_time){
                $description .= "<br/>Lịch hẹn ngày " . date('d-m-Y',$appointment->appointment_time);
                $description .= "<br/>Từ " . date('H:i',$appointment->appointment_time);
                if($appointment->end_time) {
                    $description .= " đến " . date('H:i', $appointment->end_time);
                }
            }

            $description .= "</h3>";
            $result[] = array(
                'title' => $title,
                'resourceId' => $appointment->employee_id,
                'start' =>  date('Y-m-d H:i:s',$appointment->appointment_time),
                'end' =>  date('Y-m-d H:i:s',$appointment->end_time),
                'appointment_id' =>  $appointment->id,
                'description' =>  $description,
            );
        }
        return $result;
    }
}
