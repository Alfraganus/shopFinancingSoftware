<?php

namespace app\controllers;

use app\models\ProductPrices;
use app\models\ProductsQuantity;
use Yii;
use app\models\NewGoods;
use app\models\searchModel\NewGoodsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NewGoodsController implements the CRUD actions for NewGoods model.
 */
class NewGoodsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all NewGoods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewGoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single NewGoods model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $productPrices = ProductPrices::find()->where(['product_id'=>$id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'productPrices'=>$productPrices
        ]);
    }

    /**
     * Creates a new NewGoods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NewGoods();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

           $prices = Yii::$app->request->post('price');
           if(ProductsQuantity::find()->where(['product_category_id'=>$model->product_category])->exists()) {
               $productModel = ProductsQuantity::find()->where(['product_category_id'=>$model->product_category])->one();
               $productModel->quantity+=$model->amount;
               $productModel->save(false);
           } else {
               $productModel = new ProductsQuantity();
               $productModel->product_id = $model->id;
               $productModel->product_category_id = $model->product_category;
               $productModel->quantity = $model->amount;
               $productModel->save(false);
           }
            foreach ($prices as $price)
           {
               $product_price = new ProductPrices();
               $product_price->product_id =$model->id;
               $product_price->price = $price;
               $product_price->price_id=time();
               $product_price->save(false);
           }
           $model->created_at = time();
           $model->created_by = Yii::$app->user->id;
           $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing NewGoods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $productPrices = ProductPrices::find()->where(['product_id'=>$id])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $prices = Yii::$app->request->post('oldprice');
            foreach ($productPrices as $key =>$value)
            {
                $product_price = ProductPrices::find()->where(['id'=>$value->id])->one();
                $product_price->product_id =$model->id;
                $product_price->price = $prices[$key];
                $product_price->save();
            }
            $model->updated_at = time();
            $model->updated_by = Yii::$app->user->id;
            $model->save(false);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'productPrices' => $productPrices,
        ]);
    }

    /**
     * Deletes an existing NewGoods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the NewGoods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NewGoods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NewGoods::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
