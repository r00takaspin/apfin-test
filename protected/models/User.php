<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $third_name
 * @property string $login
 * @property string $passwd
 * @property integer $country_id
 */
class User extends CActiveRecord
{
    public $passwd_repeat;


    #TODO: добавить соли
    public function beforeSave()
    {
        if(parent::beforeSave() && $this->isNewRecord) {
            $this->passwd = md5($this->passwd);
        }
        return true;
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_id', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name, third_name, login, passwd', 'length', 'max'=>255),
            array('first_name, last_name, login, passwd, country_id, passwd_repeat','required'),
            #array('login','email'),
            array('login','validate_login'),
            array('passwd_repeat','validate_passwd'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, first_name, last_name, third_name, login, passwd, country_id', 'safe', 'on'=>'search'),
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
            'country'=>array(self::HAS_ONE,'Country','country_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'first_name' => 'Имя',
			'last_name' => 'Фамилия',
			'third_name' => 'Отчество',
			'login' => 'Email',
			'passwd' => 'Пароль',
            'passwd_repeat'=>'Пароль еще раз',
			'country_id' => 'Страна',
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
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('third_name',$this->third_name,true);
		$criteria->compare('login',$this->login,true);
		$criteria->compare('passwd',$this->passwd,true);
		$criteria->compare('country_id',$this->country_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


    #TODO: вынести в отдельный класс
    public function validate_login($attribute,$params)
    {

        $found = User::model()->find('login=:login',array("login"=>$this->login));
        if ($found)
        {
            $this->addError($attribute,"Такой почтовый ящик уже существует в базе");
        }
    }

    public function validate_passwd($attribute,$params)
    {
        if ($this->passwd!=$this->passwd_repeat)
        {
            $this->addError($attribute,"Пароли не совпадают!");
        }
    }

    public function behaviors()
    {
        return array(
            'preview' => array(
                'class' => 'ext.imageAttachment.ImageAttachmentBehavior',
                // size for image preview in widget
                'previewHeight' => 200,
                'previewWidth' => 300,
                // extension for image saving, can be also tiff, png or gif
                'extension' => 'jpg',
                // folder to store images
                'directory' => Yii::getPathOfAlias('webroot').'/images/avatars/preview',
                // url for images folder
                'url' => Yii::app()->request->baseUrl . '/images/avatars/preview',
                // image versions
                'versions' => array(
                    'small' => array(
                        'resize' => array(200, null),
                    ),
                    'medium' => array(
                        'resize' => array(800, null),
                    )
                )
            )
        );
    }
}
