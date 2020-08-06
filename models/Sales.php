<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sales".
 *
 * @property int $id
 * @property int $product_category
 * @property int $quantity
 * @property int $product_id
 * @property int $is_sold
 * @property int $time
 * @property int $salesman
 */
class Sales extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales';
    }

    public $in_stock;
    public $datePicker;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
             [['product_category', 'quantity', 'price_id'], 'required'],
            [['product_category', 'quantity', 'time', 'accountant_confirm','price_id','in_stock','sale_id','warehouse_giver_id','datePicker'], 'safe'],
          [['salesman','account_id','is_finished'],'integer'],
            ['product_category','checkStock'],
            ['quantity','checkQuantity']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_category' => 'Maxsulot nomi',
            'quantity' => 'Soni',
            'product_id' => 'Maxsulot ID',
            'is_sold' => 'Tasdiqlandi',
            'time' => 'Vaqt',
            'price_id'=>'Narx',
            'salesman' => 'Savdogar',
            'accountant_confirm'=>'Kassir tasdig\'i',
            'warehouse_giver_id'=>'Omborchi tasdig\'i'
        ];
    }

    /* dropdown talangandan sotuvchi, tekshiradi bu maxsulot nechta qolganini*/
    public function checkStock($attribute)
    {
        $stock = ProductsQuantity::find()->where(['product_category_id'=>$this->product_category])->sum('quantity');
        $num = $stock->quantity;
        if($stock<1) {
            return $this->addError($attribute,'Ushbu maxsulot mavjud emas');
        }
    }

    public function checkQuantity($attribute)
    {
        $stock = ProductsQuantity::find()->where(['product_category_id'=>$this->product_category])->sum('quantity');
        if($this->quantity > $stock) {
            return $this->addError($attribute,'Ushbu maxsulot yetarli emas yoki bazada mavjud emas');
        }
    }

    /*korsatilgan muddatdagi savdo puli*/
    public function SaleAmount($from,$to)
    {
        $fromDated = date('d',$from);
        $fromDatm = date('m',$from);
        $fromDatey = date('Y',$from);

        $toDated = date('d',$to);
        $toDatem = date('m',$to);
        $toDatey = date('Y',$to);

        $start =mktime('0','0','0',$fromDatm,$fromDated,$fromDatey);
        $end =mktime('23','59','59',$toDatem,$toDated,$toDatey);
        if($from==null && $to==null)
        {
            $sale = SalesOverallPayment::find()->where(['between','date',mktime('0','0','0'),mktime('23','59','59')])->sum('payment_amount');
            $plastik = PaymentConfirmations::find()
                ->where(['between','time',mktime('0','0','0'),mktime('23','59','59')])
                ->andWhere(['payment_type'=>2])
                ->sum('payment_amount');

            $naqd = PaymentConfirmations::find()
                ->where(['between','time',mktime('0','0','0'),mktime('23','59','59')])
                ->andWhere(['payment_type'=>1])
                ->sum('payment_amount');
            $nasiya = PaymentConfirmations::find()
                ->where(['between','time',mktime('0','0','0'),mktime('23','59','59')])
                ->andWhere(['payment_type'=>3])
                ->sum('payment_amount');
        } else {
            $sale = SalesOverallPayment::find()->where(['between','date',$start,$end])->sum('payment_amount');
            $plastik = PaymentConfirmations::find()->where(['between','time',$start,$end])
                ->andWhere(['payment_type'=>2])
                ->sum('payment_amount');

            $naqd = PaymentConfirmations::find()->where(['between','time',$start,$end])
                ->andWhere(['payment_type'=>1])
                ->sum('payment_amount');
            $nasiya = PaymentConfirmations::find()->where(['between','time',$start,$end])
                ->andWhere(['payment_type'=>3])
                ->sum('payment_amount');

        }
        return ['sale'=>$sale,'plastik'=>$plastik,'naqd'=>$naqd,'nasiya'=>$nasiya];
    }

    /*admin chart uchun, 2 sana ortasidagi kunlarni aniqlash*/
    public function printDays($from, $to) {
        $from_date=strtotime($from);
        $to_date = strtotime($to);
        $current = $from_date;
        while ($current <= $to_date) {
            $days[] = date('d', $current);
            $current = $current + 86400;
            $dayCounts[] = $current;

        }
        foreach ($dayCounts as $day) {
            $starting = strtotime(date('Y-m-d H:i:s', $day - 86400));
            $finishing = strtotime(date('Y-m-d 23:59:59', $day - 86400));
            $soldProducts = SalesOverallPayment::find()->where(['between', 'date', $starting, $finishing])->sum('payment_amount');
            $newProducts = NewGoods::find()->where(['between', 'created_at', $starting, $finishing])->sum('initial_price');

            if ($soldProducts == 0) {
                $soldResult[] = 0;
            } else {
                $soldResult[] = $soldProducts;
            }
            if ($newProducts == 0) {
                $newProductResult[] = 0;
            } else {
                $newProductResult[] = $newProducts;
            }
        }
        return ['sold'=>$soldResult,'newPro'=>$newProductResult];
    }

    /*ozbekcha hafta kunlarini chiqarish*/
    public function Weekday($day)
    {

        switch ($day) {
            case 'Monday':
                $result = "Dushanba";
                break;
            case 'Tuesday':
                $result = "Seshanba";
                break;
            case 'Wednesday':
                $result = "Chorshana";
                break;
            case 'Thursday':
                $result = "Payshanba";
                break;
            case 'Friday':
                $result = "Juma";
                break;
            case 'Saturday':
                $result = "Shanba";
                break;
            case 'Sunday':
                $result = "Yakshanba";
                break;

        }
        return $result;
    }

    public function FindMinPrice($product_category)
    {
        $productPrice = ProductPrices::find()->where(['category_id'=>$product_category])->min('price');
        return $productPrice;
    }

    public function ExportSales($start,$end)
    {
        if(!empty($start) && !empty($end))
        {
            $query =  Sales::find()->where(['between','time',$start,$end]);
        } else {
            $query =  Sales::find();
        }
        $file = \Yii::createObject([
            'class' => 'codemix\excelexport\ExcelFile',
            'sheets' => [
                'Users' => [
                    'class' => 'codemix\excelexport\ActiveExcelSheet',
                    'query' => $query,
                    'attributes' => [
                        'productCategory.name',
                        'quantity',
                        'price.price',
                        'sale_id',
                        'salesman',
                        'accountant_confirm',    // Related attribute
                        'warehouse_giver_id',
                    ],
                ]
            ]
        ]);
        return $file->send('savdo_xisobotlari.xlsx');
    }


/*kartik datepickerni boshlanish sanasi chiqarish*/
    public function GetStatisticsDateStart($date)
    {
        $date = explode(' - ',$date);
        return $date[0];
    }
    /*kartik datepickerni tugallanish sanasi chiqarish*/
    public function GetStatisticsDateEnd($date)
    {
        $date = explode(' - ',$date);
        return $date[1];
    }

    /*----------relationlar---------------*/
   public function getNewgoods()
    {
        return $this->hasOne(NewGoods::className(), ['product_category' => 'product_category']);
    }

    public function getProductCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'product_category']);
    }
    public function getSaleperson()
    {
        return $this->hasOne(UserModel::className(), ['id' => 'salesman']);
    }

    public function getPrice()
    {
        return $this->hasOne(ProductPrices::className(), ['id' => 'price_id']);
    }
    public function getOverallPrice()
    {
        return $this->hasOne(SalesOverallPayment::className(), ['sale_id' => 'sale_id']);
    }

}
