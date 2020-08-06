<?php

namespace app\controllers;

use app\models\NewGoods;
use app\models\PaymentConfirmations;
use app\models\ProductPrices;
use app\models\ProductsQuantity;
use app\models\SaleNasiya;
use app\models\Sales;
use app\models\SalesOverallPayment;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        switch ($user->role) {
            case 1: /*admin role*/
                 $model = new Sales();
                $saleQuantity =$model->SaleAmount(null,null);
                $salePaymentTypes = PaymentConfirmations::find()->limit(30)->orderBy('id DESC')->all();
                if ($post = Yii::$app->request->post()) {

                    $statisticsDateBegin = strtotime($model->getStatisticsDateStart($post['date_range_2']));
                    $statisticsDateFinish = strtotime($model->getStatisticsDateEnd($post['date_range_2']));
                    $saleQuantity =$model->SaleAmount($statisticsDateBegin,$statisticsDateFinish);
                }
                return $this->render('admin',compact('model','saleQuantity','salePaymentTypes'));
                break;
            case 2:  /*sotuvchi role*/
                $sales = Sales::find()->where(['salesman'=>$user->id])->all();
                return $this->render('sotuvchi',compact('sales'));
                break;
            case 3: /*omborchi role*/
                $products = NewGoods::find()->where(['is_confirmed'=>null])->all();
                return $this->render('omborchi',compact('products'));
                break;
            case 4: /*bugalter role*/
                return $this->redirect(['new-goods/']);
                break;
            case 5: /*kassir role*/
                $sales = Sales::find()->select('sale_id')
                    ->where(['accountant_confirm'=>null])
                    ->andwhere(['is_finished'=>10])
                    ->groupBy(['sale_id'])
                    ->all();
                $finishedSales = Sales::find()->select('sale_id')
                    ->where(['accountant_confirm'=>10])
                    ->andWhere(['between','time',mktime('0','0','0'),mktime('23','59','59')])
                    ->groupBy(['sale_id'])->limit(50)
                    ->all();
                return $this->render('kassir',compact('sales','finishedSales'));
                break;
        }

        return $this->render('index');
    }

        // savdoni yakunlash
     public function actionFinishSale($sale_id) {

        $sales = Sales::findAll(['sale_id'=>$sale_id]);
        foreach ($sales as $sale){
            $model = Sales::findone(['sale_id'=>$sale->sale_id]);
            $model->is_finished = 10;
            $model->account_id = Yii::$app->user->id;
            $model->save(false);
        }
        return $this->redirect(['/']);
     }

    /* admindagi dashboard uchun statistik malumotlarni chiqarish*/
    public function actionAdminDashboard()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = new Sales();
        $sales = $model->SaleAmount(null, null);
        $graphDatas = [$sales['plastik'], $sales['naqd'], $sales['nasiya']];
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $statisticsDateBegin = strtotime($model->getStatisticsDateStart($data['date']));
            $statisticsDateFinish = strtotime($model->getStatisticsDateEnd($data['date']));
            $sales = $model->SaleAmount($statisticsDateBegin, $statisticsDateFinish);
            if ($data) {
                $graphDatas = [$sales['plastik'], $sales['naqd'], $sales['nasiya']];
                return ['graphDatas'=>$graphDatas,'sales'=>$sales['sale'],'naqd'=>$sales['naqd'],'nasiya'=> $sales['nasiya'],'plastik'=> $sales['plastik']];
            }
        }

        return ['graphDatas'=>$graphDatas,'sales'=>$sales['sale'],'naqd'=>$sales['naqd'],'nasiya'=> $sales['nasiya'],'plastik'=> $sales['plastik']];
    }

    public function actionTimelineGrowth()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $model = new Sales();
            $from_date = date('Y-m-d');
            $to_date = date('Y-m-d', strtotime("-10 days"));

            $start = strtotime($from_date);
            $end = strtotime($to_date);
            for ($i = $end; $i <= $start; $i += 86400)
                $dates[] = $model->Weekday(date('l', $i)) .' / '. date('d', $i);
        }
        $goods = $model->printDays($to_date,$from_date);
        return [
            'dates'=>$dates,
            'outsale'=>$goods['sold'],
            'incomeGoods'=>$goods['newPro']
        ];
    }

    /* admindagi dashboarch uchun nasiyaga olingan maxsulotlar*/
    public function actionNasiyaProducts()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new Sales();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if($data['date'] = '' or $data['date']==null) {
                $statisticsDateBegin = strtotime(date('Y-m-d H:i:s'));
                $statisticsDateFinish = strtotime(date('Y-m-d 23:59:59'));

            } else {
                $statisticsDateBegin = strtotime($model->getStatisticsDateStart($data['date']));
                $statisticsDateFinish = strtotime($model->getStatisticsDateEnd($data['date']));
            }

            $nasiyaPro = SaleNasiya::find()
                ->where(['nasiya_active' => 1])
                ->andWhere(['nasiya_returned' => null])
                ->orderBy('id DESC')
                ->all();
            return $nasiyaPro;

        }
    }


    /*yangi xarid uchun*/
    public function actionNewSale()
    {
        $model = new Sales();
        if (isset($_POST['SampleInformation'])) {
            $post = Yii::$app->request->post();

            foreach (($post['Sales']['product_category']) as $key => $value) {
                $sale = new Sales();
                $sale->product_category = $post['Sales']['product_category'][$key]['product_category'];
                $sale->quantity = $post['Sales']['product_category'][$key]['quantity'];
                $sale->time = time();
                $sale->salesman = Yii::$app->user->id;
                $sale->save(false);
            }

            return $this->redirect(['/']);
        }

        return $this->render('new_sale', compact('model'));
    }

    /* savdogar maxsultolarni bazaga kiritishi, xarud jarayoni*/
    public function actionSaleList($rand)
    {
        if(Yii::$app->user->identity->role!=2){
            throw new ForbiddenHttpException('Sizda ushbu amal uchun ruxsat mavjud emas!');
        }
        $model = new Sales();
        $sales = Sales::findAll(['sale_id'=>$rand,'accountant_confirm'=>null]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->time = time();
            $model->sale_id = $rand;
            $model->salesman = Yii::$app->user->id;
            $model->save(false);
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('sale_list', compact('model','sales'));
    }


    /*sale ichida dropdown malumotlarini olish uchun*/
    public function actionGetprice()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $id = end($_POST['depdrop_parents']);
            $list = ProductPrices::find()->select(['id','price'])->andWhere(['category_id' => $id])->all();
            $selected  = null;
            if ($id != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['id' => $account['id'], 'name' => $account['price']];
                    if ($i == 0) {
                        $selected = $account['id'];
                    }
                }
                // Shows how you can preselect a value
                return ['output' => $out, 'selected' => $selected];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    /*dependent dropdownda narxni ezgancha qancha omborda qolganini bilish uchun*/
    public function actionQuantity()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(Yii::$app->request->isAjax) {
            $unconfirmedSales = NewGoods::find()->andWhere(['product_category'=>$_POST['val']])->one();
            $sklad = ProductsQuantity::findOne(['product_category_id'=> $_POST['val']]);
            return [
                'in_stock'=>$sklad->quantity,
                'unconfirmed'=>Sales::find()->where(['accountant_confirm'=>null])->andWhere(['product_category'=>$_POST['val']])->sum('quantity'),
                'quantity'=>$unconfirmedSales->weightType->name];
        }
    }

    /*savatchadagi xaridlarni bekor qilish*/
    public function actionCancelSale($id)
    {
        $sale = Sales::findOne($id);
        if(!empty($sale))
        {
            $sale->delete();
        }
        
        return $this->redirect(Yii::$app->request->referrer);
    }

    /*yangi kelgan maxsulotlarni qabul qilish*/
    public function actionAccept()
    {
        $data = Yii::$app->request->post();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $product = NewGoods::find()->where(['id'=>$data['product_id']])->one();
        $product->is_confirmed='confirmed';
        $product->save(false);

        if(ProductsQuantity::find()->where(['product_category_id'=>$data['product_category']])->exists()) {
            $productModel = ProductsQuantity::find()->where(['product_category_id'=>$data['product_category']])->one();
            $productModel->quantity+=$data['product_quantity'];
            $productModel->save(false);
        } else {
            $productModel = new ProductsQuantity();
            $productModel->product_id = $data['product_id'];
            $productModel->product_category_id =$data['product_category'];
            $productModel->quantity =$data['product_quantity'];
            $productModel->save(false);
        }

        return  'Maxsulot qabul qilindi!';
    }


    /*omborda qolgam maxsulotlar*/

    public function actionLeftItems()
    {
        if(Yii::$app->user->identity->role == 3 ||
            Yii::$app->user->identity->role ==1 ||
            Yii::$app->user->identity->role ==4
        ){
            $products = ProductsQuantity::find()->orderBy('quantity ASC')->all();
            return $this->render('left_items',compact('products'));
        } else {
            throw new ForbiddenHttpException('Sizda ushbu amal uchun ruxsat mavjud emas!');
        }

    }

    /*kassir haridlarni korishi*/

   public function actionKassirSale($sale_id)
    {
        if(Yii::$app->user->identity->role!=5){
            throw new ForbiddenHttpException('Sizda ushbu amal uchun ruxsat mavjud emas!');
        }
        $sales = Sales::findAll(['accountant_confirm'=>null,'sale_id'=>$sale_id]);
        $model = new PaymentConfirmations();
        $nasiya = new SaleNasiya();

        if ($model->load(Yii::$app->request->post()) && $nasiya->load(Yii::$app->request->post())) {

            $encodingComingData = \yii\helpers\Json::encode($model->paymentData);
            $paymentConfimation = Json::decode($encodingComingData);
            $paymentReciept = new SalesOverallPayment();
            /* tolov turi va tolov summasini bazaga yozib qoyish*/
            for ($i = 0; $i < count($paymentConfimation); $i++) {
                $confirmation = new PaymentConfirmations();
                $confirmation->sale_id = $sale_id;
                $confirmation->payment_amount = $paymentConfimation[$i]['amount'];
                $confirmation->payment_type = $paymentConfimation[$i]['payment_type'];
                $confirmation->time = time();

                if($paymentConfimation[$i]['payment_type'] ==3 and $nasiya->nasiya_amount == null)
                {
                    echo "<h1 style='text-align: center'>Savdo nasiya orqali olingan, ammo nasiya malumotlari kiritilmagan! </h1>";
                    echo Html::a('Orqaga Qaytish', ['kassir-sale', 'sale_id' =>$_GET['sale_id']], ['class' => 'btn btn-primary','style'=>'font-size:26px;text-align:center']);
                    die;

                }
                $confirmation->save(false);
            }
            /*umumiy qaysi id_lik xarid qancha pullik savdo qilingani*/
            $paymentReciept->sale_id=$sale_id;
            $paymentReciept->payment_amount=$model->payment_amount_post;
            $paymentReciept->date = time();
            $paymentReciept->cashier = Yii::$app->user->id;
            $paymentReciept->save(false);

            /*bazadan sotib olingan maxsulotlarni ayirib yuborish uchun*/
            foreach ($sales as $sale) {
                $proQuantity = ProductsQuantity::findOne(['product_category_id' => $sale->product_category]);
                $proQuantity->quantity = $proQuantity->quantity - $sale->quantity;
                $proQuantity->save(false);
            }
            /*maxsulotlarni puli tolanganligi uchun confirmation*/
            Sales::updateAll(['accountant_confirm' => 10], "sale_id = $sale_id");

            $nasiya->sale_id =$sale_id;
            ($nasiya->nasiya_amount==null)?$nasiya->nasiya_active=0:$nasiya->nasiya_active=1;
            $nasiya->time = time();
            $nasiya->save(false);
            return $this->redirect(['site/view-sale','sale_id'=>$sale_id]);
        }
        return $this->render('kassir_check_sales', compact('sales', 'model','nasiya'));
    }
    /**
     * Login action.
     *
     * @return Response|string
     */

    /*Omborchi maxsulotlarni mijozga topshirishdan oldin tizimdan tekshirib oladi*/
    public function actionWarehouseCheckProduct()
    {
        if(Yii::$app->user->identity->role!=3){
            throw new ForbiddenHttpException('Sizda ushbu amal uchun ruxsat mavjud emas!');
        }
        $finishedSales = Sales::find()
            ->select('sale_id')
            ->where(['accountant_confirm' => 10])
            ->andWhere(['warehouse_giver_id'=>null])
            ->groupBy(['sale_id'])
            ->limit(50)
            ->all();
        $givenSales = Sales::find()->select('sale_id')
            ->where(['accountant_confirm' => 10])
            ->andWhere(['IS NOT', 'warehouse_giver_id', null])
            ->groupBy(['sale_id'])
            ->limit(50)
            ->all();
        return $this->render('warehouse_check_product', compact('sales', 'finishedSales','givenSales'));
    }

    /*omborchi maxsulotlarni xaridorga topshirish*/
    public function actionWarehouseGiveProcuts($sale_id)
    {
        Sales::updateAll(['warehouse_giver_id' => Yii::$app->user->id], "sale_id = $sale_id");
        return $this->redirect(Yii::$app->request->referrer);
    }

/*dependent dropdown jquery usulida*/
    public function actionGetoperations()
    {
        if ($id = Yii::$app->request->post('id')) {
            $operationPosts = ProductPrices::find()
                ->where(['category_id' => $id])
                ->count();

            if ($operationPosts > 0) {
                $operations = ProductPrices::find()
                    ->where(['category_id' => $id])
                    ->all();
                foreach ($operations as $operation)
                    echo "<option value='" . $operation->id . "'>" . $operation->price . "</option>";
            } else
                echo  "<option style='color:red'>Ushbu maxsulotni narxi bazada topilmadi!</option>";

        }
    }


    /*admin qismda xaridlar sahifasi*/
    public function actionAdminSales()
    {
        $salesRecords = Sales::find()
            ->where(['between','time',mktime('0','0','0'),mktime('23','59','59')])
            ->orderBy('id DESC')
            ->all();
        $minPriceModel = new Sales();
        if ($post = Yii::$app->request->post()) {
            $statisticsDateBegin = strtotime($minPriceModel->getStatisticsDateStart($_POST['date_range_2']));
            $statisticsDateFinish = strtotime($minPriceModel->getStatisticsDateEnd($_POST['date_range_2']));
            $salesRecords = Sales::find()->where(['between','time',$statisticsDateBegin,$statisticsDateFinish])
                ->orderBy('id DESC')
                ->all();
        }
        return $this->render('admin_sales',compact('salesRecords','minPriceModel'));
    }

    /*salelarni excelga exprot qilish*/
    public function actionExportSales()
    {
        $model = New Sales();
        $statisticsDateBegin = strtotime($model->getStatisticsDateStart($_POST['date_range_2']));
        $statisticsDateFinish = strtotime($model->getStatisticsDateEnd($_POST['date_range_2']));
        return $model->ExportSales($statisticsDateBegin,$statisticsDateFinish);
    }

    /*tolov turlarini excelga export qilish*/
    public function actionExportPayments()
    {
        $model = New PaymentConfirmations();
        $dateStrtoTime = New Sales();
        $statisticsDateBegin = strtotime($dateStrtoTime->getStatisticsDateStart($_POST['date_range_2']));
        $statisticsDateFinish = strtotime($dateStrtoTime->getStatisticsDateEnd($_POST['date_range_2']));
        return $model->ExportData($statisticsDateBegin,$statisticsDateFinish);
    }

    /*nasiya savdolarni excelga export qilish*/
    public function actionExportNasiya()
    {
        $model = New SaleNasiya();
        $dateStrtoTime = New Sales();
        $statisticsDateBegin = strtotime($dateStrtoTime->getStatisticsDateStart($_POST['date_range_2']));
        $statisticsDateFinish = strtotime($dateStrtoTime->getStatisticsDateEnd($_POST['date_range_2']));
        return $model->ExportData($statisticsDateBegin,$statisticsDateFinish);
    }

    /*barcha tolovlarni monitoring qismi*/
    public function actionAdminPayments()
    {
        $salePaymentTypes = PaymentConfirmations::find()->limit(30)->orderBy('id DESC')->all();
        return $this->render('admin_payments',compact('salePaymentTypes'));
    }
/*nasiyalar monitoring sahifasi*/
    public  function actionAdminNasiya()
    {
        $nasiya = SaleNasiya::find()->where(['nasiya_returned'=>null])->andWhere(['nasiya_active'=>1])->all();
        return $this->render('admin_nasiya',compact('nasiya'));
    }

    /*bugalterni nasiyalarni qaytaradigon sahifasi*/
    public function actionNasiyaReturn()
    {
        $nasiya = SaleNasiya::find()->where(['nasiya_returned'=>null])->andWhere(['nasiya_active'=>1])->all();
        return $this->render('nasiya_return',compact('nasiya'));
    }

    /*bulgalter nasiyani qaytarish knopkasi*/
    public function actionNasiyaEmpty($id)
    {
        $nasiya =  SaleNasiya::findOne($id);
        $nasiya->nasiya_returned=10;
        $nasiya->save(false);
        Yii::$app->session->setFlash('success', "Nasiya Qaytarildi!");
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionLogin()
    {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionViewSale($sale_id)
    {
        $sales = Sales::findAll(['accountant_confirm'=>10,'sale_id'=>$sale_id]);
        return $this->render('kassir_view_sale',compact('sales'));
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
