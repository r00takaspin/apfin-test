<?php

/**
 * This is the model class for table "currency_trans".
 *
 * The followings are the available columns in table 'currency_trans':
 * @property integer $id
 * @property integer $user_id
 * @property integer $from_currency_id
 * @property integer $to_currency_id
 * @property double $amount
 * @property double $converted_amount
 */
class CurrencyTransaction extends CActiveRecord
{

    public function afterSave()
    {
        if ($this->getIsNewRecord())
        {
            $this->date=date('now');
        }
    }

    public function beforeSave()
    {
        $this->date = date('Y-m-d H:i:s');
        if ($this->getIsNewRecord())
        {

            $criteria = new CDbCriteria();
            $criteria->compare('currency_id',$this->to_currency_id);
            $criteria->compare('user_id',$this->user_id);

            $to_bill = Bill::model()->find($criteria);

            $criteria = new CDbCriteria();
            $criteria->compare('currency_id',$this->from_currency_id);
            $criteria->compare('user_id',$this->user_id);

            $from_bill  = Bill::model()->find($criteria);

            if ($from_bill->id==$to_bill->id)
            {
                $this->addError('from_currency_id','Нельзя конвертировать валюту в себя');
                return false;
            }

            if ($from_bill->amount - (float)(CurrencyTransaction::calc($this->to_currency_id,$this->from_currency_id,CurrencyTransaction::calc($this->from_currency_id,$this->to_currency_id,$this->amount)))<0.0)
            {
                $this->addError('amount','Недостаточно средств на счете');
                return false;
            }
            if (!$to_bill)
            {
                $to_bill = new Bill();
                $to_bill->scenario = 'create';
                $to_bill->user_id = $this->user_id;
                $to_bill->currency_id = $this->to_currency_id;
                $to_bill->amount = CurrencyTransaction::calc($this->from_currency_id,$this->to_currency_id,$this->amount);
                if (!$to_bill->save())
                {
                    return false;
                }
            }
            else
            {
                $to_bill->user_id = $this->user_id;
                $to_bill->currency_id = $this->to_currency_id;
                $to_bill->amount += CurrencyTransaction::calc($this->from_currency_id,$this->to_currency_id,$this->amount);
                $to_bill->save();
            }
            $from_bill->amount -= CurrencyTransaction::calc($this->to_currency_id,$this->from_currency_id,CurrencyTransaction::calc($this->from_currency_id,$this->to_currency_id,$this->amount));
            $this->converted_amount = CurrencyTransaction::calc($this->from_currency_id,$this->to_currency_id,$this->amount);
            if (!$from_bill->save())
            {
                return false;
            }
            return true;
        }
        return false;
    }
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'currency_trans';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, from_currency_id, to_currency_id, amount', 'required'),
			array('user_id, from_currency_id, to_currency_id', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, from_currency_id, to_currency_id, amount', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'from_currency'=>array(self::BELONGS_TO,'CurrencyRate','from_currency_id'),
            'to_currency'=>array(self::BELONGS_TO,'CurrencyRate','to_currency_id'),
            'user'=>array(self::BELONGS_TO,'User','user_id')
		);
	}


	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'from_currency_id' => 'Из чего',
			'to_currency_id' => 'Во что',
			'amount' => 'Сумма',
		);
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('from_currency_id',$this->from_currency_id);
		$criteria->compare('to_currency_id',$this->to_currency_id);
		$criteria->compare('amount',$this->amount);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function calc($from,$to,$amount)
    {
        if ($amount>0)
        {
            $from_curr = CurrencyRate::model()->findByPk($from);
            $to_curr = CurrencyRate::model()->findByPk($to);
            if ($from_curr && $to_curr)
            {
                $result = ($amount/$from_curr->rate)*$to_curr->rate;
                return $result;
            }
            return false;

        }
        return false;

    }
}
