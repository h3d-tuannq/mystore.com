<?php

namespace backend\controllers;

use common\models\base\CardService;
use common\models\CardType;
use common\models\search\ServiceSearch;
use common\models\Service;
use Yii;
use common\models\Card;
use common\models\search\CardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CardController implements the CRUD actions for Card model.
 */
class CardController extends Controller
{

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Card models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Card model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Card model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Card();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
            'card_types' => CardType::find()->active()->all(),
        ]);
    }

    /**
     * Updates an existing Card model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'card_types' => CardType::find()->active()->all(),
        ]);
    }

    /**
     * Deletes an existing Card model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Card model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Card the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Card::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionInfo()
    {
        if (Yii::$app->request->isAjax) {

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $card_id = Yii::$app->request->post('card_id');
            if ($card_id) {
                $card = Card::findOne($card_id);
                if ($card) {
                    //if ($card->cardType->slug == 'the-dich-vu') {
                        // Tìm các dịch vụ trong thẻ
                        $cardServices = CardService::findAll(['card_id' => $card_id]);
                        $detail = '';
                        foreach ($cardServices as $model) {
                            if($card->cardType->slug == 'the-tien'){
                                $amount = $model->amount;
                            }else{
                                $amount = 0;
                            }
                            $detail .= "<tr>";
                            $detail .= "<td>" . $model->service->slug . " </td>";
                            $detail .= "<td>" . $model->service->name . " </td>";
                            $detail .= "<td><input type='text' class='form-control' name='CustomerHistoryCard[services][" . $model->service->id . "]' value='".$amount."'/></td>";
                            $detail .= "<td>" . Yii::$app->formatter->asCurrency($model->service->retail_price, 'VND') . "  </td>";
                            $detail .= "<td>" . $model->service->duration . " </td>";
                            $detail .= "</tr>";
                        }
                    //} else {
//                        $detail = "<p>Mã thẻ: $card->slug </p>";
//                        $detail .= "<p>Tên thẻ: $card->name </p>";
//                        $detail .= "<p>$card->description </p>";
//                        $detail .= "<p>Giá : " . Yii::$app->formatter->asCurrency($card->retail_price, 'VND') . " </p>";

                    //}

                    return array(
                        'card_type' => $card->cardType->slug,
                        'total_price' => $card->raw_price,
                        'detail' => $detail,
                    );
                }

            }
            return [];
        }
        // TODO xử lý khi gọi trực tiếp
    }
    public function actionInfoAmount()
    {
        if (Yii::$app->request->isAjax) {

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $card_id = Yii::$app->request->post('card_id');
            if ($card_id) {
                $card = Card::findOne($card_id);
                if ($card) {
                    //if ($card->cardType->slug == 'the-dich-vu') {
                    // Tìm các dịch vụ trong thẻ
                    $cardServices = CardService::findAll(['card_id' => $card_id]);
                    $detail = '';
                    foreach ($cardServices as $model) {
                        $detail .= "<tr>";
                        $detail .= "<td>" . $model->service->slug . " </td>";
                        $detail .= "<td>" . $model->service->name . " </td>";
                        $detail .= "<td><input type='text' class='form-control' name='CustomerHistoryCard[services][" . $model->service->id . "]' value='".$model->amount."'/></td>";
                        $detail .= "<td>" . Yii::$app->formatter->asCurrency($model->service->retail_price, 'VND') . "  </td>";
                        $detail .= "<td>" . $model->service->duration . " </td>";
                        $detail .= "</tr>";
                    }
                    //} else {
//                        $detail = "<p>Mã thẻ: $card->slug </p>";
//                        $detail .= "<p>Tên thẻ: $card->name </p>";
//                        $detail .= "<p>$card->description </p>";
//                        $detail .= "<p>Giá : " . Yii::$app->formatter->asCurrency($card->retail_price, 'VND') . " </p>";

                    //}

                    return array(
                        'card_type' => $card->cardType->slug,
                        'total_price' => $card->raw_price,
                        'detail' => $detail,
                    );
                }

            }
            return [];
        }
        // TODO xử lý khi gọi trực tiếp
    }
    public function actionFindService($id)
    {
        if ($id) {
            if (Yii::$app->request->isAjax) {
                $searchModel = new ServiceSearch();
                $dataProvider = $searchModel->searchForCombo(Yii::$app->request->queryParams);
                $dataProvider->pagination->pageSize = 500;

                return $this->renderAjax('_form_add_service', [
                    'id' => $id,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
            } else {
                $this->redirect(['view', 'id' => $id]);
            }

        }
    }

    public function actionAddService()
    {
        $service_ids = (array)Yii::$app->request->post('id');
        $card_id = Yii::$app->request->post('card_id');

        foreach ($service_ids as $service_id) {
            $service = Service::findOne( $service_id );

            $model = CardService::findOne(['card_id' => $card_id, 'service_id' => $service_id]);
            if ($model) {
                $model->amount += 1;
            } else {
                $model = new CardService();
                $model->amount = 1;
            }
            $model->card_id = $card_id;
            $model->service_id = $service_id;
            $model->money = $service->retail_price * $model->amount;
            $model->save();
        }

        $this->redirect(['view', 'id' => $card_id]);
    }

    public function actionUpdateService()
    {
        if (Yii::$app->request->isAjax) {
            $service_id = Yii::$app->request->post('service_id');
            $card_id = Yii::$app->request->post('card_id');
            $amount = (int)Yii::$app->request->post('amount');
            $service = Service::findOne( $service_id );
            $model = CardService::findOne(['card_id' => $card_id, 'service_id' => $service_id]);
            if($model && $service){
                if($amount){
                    $model->amount = $amount;
                    $model->money = $amount * $service->retail_price;
                    $model->save();
                }else{
                    $model->delete();
                }
            }
        }
        $this->redirect(['view', 'id' => $card_id]);
    }

    public function actionRemoveService($id, $service_id)
    {
        if ($id) {
            $cardService = CardService::find()->where(['card_id' => $id, 'service_id' => $service_id])->one();
            if ($cardService && $cardService->delete()) {
                $this->redirect(['view', 'id' => $id]);
            }
        }
    }
}
