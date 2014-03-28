<?php

/**
 * This is the model class for table "currency_rates".
 *
 * The followings are the available columns in table 'currency_rates':
 * @property integer $id
 * @property string $currency
 * @property double $rate
 */
class CurrencyRate extends CActiveRecord
{
    public function __toString()
    {
        return $this->currency;
    }


    const BASE_CURRENCY = 'RUB';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'currency_rates';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('currency, rate', 'required'),
			array('rate', 'numerical'),
			array('currency', 'length', 'max'=>20),
			// The following rule is used by search().
			array('id, currency, rate', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'currency' => 'Currency',
			'rate' => 'Rate',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('rate',$this->rate);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CurrencyRate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function randCurrency()
    {
        $criteria = new CDbCriteria();
        $criteria->limit = 1;
        $criteria->order = 'RAND()';

        $cr = CurrencyRate::model()->find($criteria);
        return $cr;
    }
}
