<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * @inheritdoc
 */
class Order extends base\Order
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'id',
                'slugAttribute' => 'code',
                'immutable' => true,
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'raw_money', 'total_money', 'real_money', 'payment_type', 'status', 'created_by', 'updated_by'], 'integer'],
            [['rate_receptionist','rate_employee'], 'number'],
            [['code', 'voucher_code'], 'string', 'max' => 255],
            [['rate_employee_id', 'rate_receptionist_id','discount'], 'number', 'max' => 100],
	        //[['created_at'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['order_date'], 'filter', 'filter' => 'strtotime', 'skipOnEmpty' => true],
            [['order_id'], 'safe'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'code' => Yii::t('common', 'Mã hóa đơn'),
            'customer_id' => Yii::t('common', 'Khách hàng'),
            'discount' => Yii::t('common', 'Chiết khấu cho khách hàng'),
            'rate_receptionist' => Yii::t('common', 'Hoa hồng'),
            'rate_receptionist_id' => Yii::t('common', 'Lễ tân'),
            'rate_employee' => Yii::t('common', 'Hoa hồng'),
            'rate_employee_id' => Yii::t('common', 'Nhân viên'),
            'raw_money' => Yii::t('common', 'Raw Money'),
            'total_money' => Yii::t('common', 'Tổng tiền'),
            'real_money' => Yii::t('common', 'Real Money'),
            'order_date' => Yii::t('common', 'Ngày giờ'),
            'payment_type' => Yii::t('common', 'Hình thức thanh toán'),
            'voucher_code' => Yii::t('common', 'Mã Voucher'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Ngày tạo'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by' => Yii::t('common', 'Người lập'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'order_id' => Yii::t('common', 'Hóa đơn có nợ'),
        ];
    }
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getAuthor()
	{
		return $this->hasOne(User::class, ['id' => 'created_by']);
	}
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getReceptionist()
	{
		return $this->hasOne(Employee::class, ['id' => 'rate_receptionist_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getEmployee()
	{
		return $this->hasOne(Employee::class, ['id' => 'rate_employee_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUpdater()
	{
		return $this->hasOne(User::class, ['id' => 'updated_by']);
	}
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCustomer()
	{
		return $this->hasOne(Customer::class, ['id' => 'customer_id']);
	}
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderPayment()
    {
        return $this->hasMany(OrderPayment::class, ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetail::class, ['order_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\base\query\OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\OrderQuery(get_called_class());
    }

    public function calculate()
    {
        $orderDetails = OrderDetail::find()->where(['order_id'=>$this->id])->active()->all();
        $total = 0;
        foreach($orderDetails as $orderDetail){
            $total += $orderDetail->total_money;
        }

        //raw_money Tổng tiền các sản phẩm
        // total_money Tiền đã trừ discount

        $this->raw_money = $total;
        // real_money tiền đã trừ các chi phí hoa hồng
        if($this->discount){
            $this->total_money = $total - (int)($total * $this->discount / 100);
        }else{
            $this->total_money = $total;
        }
        $this->order_date = date('Y-m-d H:i:s',$this->order_date);
        $this->save();
    }


}
