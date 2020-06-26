<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $fullname
 * @property int $role
 * @property int|null $status
 */
class UserModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'fullname', 'role'], 'required'],
            [['role', 'status'], 'integer'],
            [['username', 'password', 'fullname'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Login',
            'password' => 'Parol',
            'fullname' => 'Ism Sharif',
            'role' => 'Xuquqi',
            'status' => 'Status',
        ];
    }

    public function getRoleName()
    {
        return $this->hasOne(Roles::className(), ['id' => 'role']);   //city_state_id is field of city
    }

}
