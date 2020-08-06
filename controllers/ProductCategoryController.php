<?php

namespace app\controllers;

use Yii;
use app\models\ProductCategory;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\helpers\Json;
/**
 * ProductCategoryController implements the CRUD actions for ProductCategory model.
 */
class ProductCategoryController extends Controller
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
     * Lists all ProductCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(Yii::$app->user->identity->role!=4){
            throw new ForbiddenHttpException('Sizda ushbu amal uchun ruxsat mavjud emas!');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => ProductCategory::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductCategory model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(Yii::$app->user->identity->role!=4){
            throw new ForbiddenHttpException('Sizda ushbu amal uchun ruxsat mavjud emas!');
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->identity->role!=4){
            throw new ForbiddenHttpException('Sizda ushbu amal uchun ruxsat mavjud emas!');
        }
        $model = new ProductCategory();

        if ($model->load(Yii::$app->request->post())) {
            $encoding = Json::encode($model->name);
            $records= Json::decode($encoding);

            foreach ($records as $key =>$value) {
                $newRecord = new ProductCategory();
                $newRecord->name = $records[$key];
                $newRecord->save(false);
            }
            ProductCategory::deleteAll(['name' => 'array']);
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ProductCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->user->identity->role!=4){
            throw new ForbiddenHttpException('Sizda ushbu amal uchun ruxsat mavjud emas!');
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ProductCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->identity->role!=4){
            throw new ForbiddenHttpException('Sizda ushbu amal uchun ruxsat mavjud emas!');
        }
        $model = $this->findModel($id);
        $model->status=0;
        $model->save(false);

        return $this->redirect(['index']);
    }

    /**
     * Finds the ProductCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductCategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
