<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sale_nasiya".
 *
 * @property int $id
 * @property int|null $sale_id
 * @property int $nasiya_amount
 * @property string $fullname
 * @property string|null $phone
 * @property string|null $deadline
 * @property string|null $responsible_person
 */
class SaleNasiya extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_nasiya';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sale_id', 'nasiya_amount','time'], 'integer'],
            [['deadline','nasiya_active'], 'safe'],
            [['fullname', 'responsible_person'], 'string', 'max' => 200],
            [['phone'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sale_id' => 'Xarid ID',
            'nasiya_amount' => 'Qolayotgan summa',
            'fullname' => 'Nasiyaga olayotgan xaridorning ism sharifi',
            'phone' => 'Xaridorning telefon raqami',
            'deadline' => 'Nasiya qaytaradigon sana',
            'responsible_person' => 'Kafil shaxs',
        ];
    }

    public function ExportData($start,$end)
    {
        if(!empty($start) && !empty($end))
        {
            $query =  SaleNasiya::find()->where(['between','time',$start,$end])->andWhere(['nasiya_active'=>1])->andWhere(['nasiya_returned'=>null]);
        } else {
            $query =  SaleNasiya::find()->where(['nasiya_active'=>1])->andWhere(['nasiya_returned'=>null]);
        }
        $file = \Yii::createObject([
            'class' => 'codemix\excelexport\ExcelFile',
            'sheets' => [
                'Users' => [
                    'class' => 'codemix\excelexport\ActiveExcelSheet',
                    'query' => $query,
                    'attributes' => [
                        'sale_id',
                        'nasiya_amount',
                        'fullname',
                        'phone',
                        'deadline',
                        'responsible_person',
                    ],
                ]
            ]
        ]);
        return $file->send('nasiya_savdo.xlsx');
    }

}
