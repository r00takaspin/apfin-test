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

    public function afterSave()
    {
        if ($this->getIsNewRecord())
        {
            $bill = new Bill();

            $bill->currency_id = CurrencyRate::randCurrency()->id;
            $bill->amount = 1000;
            $bill->user_id = $this->id;
            $bill->save();
        }
    }

	public function tableName()
	{
		return 'user';
	}

	public function rules()
	{
        #TODO: задать минимальную длину пароля
		return array(
			array('country_id', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name, third_name, login, passwd', 'length', 'max'=>255),
            array('first_name, last_name, login, passwd, country_id','required'),
            array('passwd_repeat','required','on'=>'create'),
            array('login','email'),
            array('login','validate_login','on'=>'create'),
            array('passwd_repeat,passwd','validate_passwd','on'=>'create'),
			array('id, first_name, last_name, third_name, login, passwd, country_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
            'country'=>array(self::BELONGS_TO,'Country','country_id'),
            'friends'=>array(self::MANY_MANY,'User','friendship(from_id, to_id)'),
            'bills'=>array(self::HAS_MANY,'Bill','user_id'),
            'trans'=>array(self::HAS_MANY,'CurrencyTransaction','user_id','order'=>'ID DESC')
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
                'directory' => Yii::getPathOfAlias('webroot').'/images/productTheme/preview',
                // url for images folder
                'url' => Yii::app()->request->baseUrl . '/images/productTheme/preview',
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

    private function isCurrentAuthorizedUser($user_id)
    {
        if ($user_id==Yii::app()->user->id)
            return true;
        else
            return false;
    }

    #TODO: вынести в отдельный класс
    public function validate_login($attribute,$params)
    {
        $found = User::model()->find('login=:login',array("login"=>$this->login));
        if ($found && !$this->isCurrentAuthorizedUser($found->id))
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


    public static function addFriend($from,$to)
    {
        $from = (int)$from;
        $to = (int)$to;
        if ($from==$to)
        {
            return false;
        }

        if (self::user_exists($from) && self::user_exists($to))
        {
            if (self::relation_exists($from,$to))
            {
                return false;
            }
            else
            {
                $f = new Friendship();
                $f->from_id = $from;
                $f->to_id = $to;
                if ($f->save(true))
                {
                    return true;
                }
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    public static function removeFriend($from,$to)
    {
        $from = (int)$from;
        $to = (int)$to;

        if ($from==$to)
        {
            return false;
        }

        if (self::user_exists($from) && self::user_exists($to))
        {
            if (self::relation_exists($from,$to))
            {
                $model = new Friendship();
                $rel = $model->model()->find('from_id=:from_id AND to_id=:to_id',array('from_id'=>$from,'to_id'=>$to));
                if ($rel->delete())
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
        }
        return false;
    }

    public static function isFriend($user1_id,$user2_id)
    {
        $user1_id = (int)$user1_id;
        $user2_id = (int)$user2_id;
        if (self::user_exists($user1_id) && self::user_exists($user1_id))
        {
            if (Friendship::model()->find('from_id=:user1_id AND to_id=:user2_id',array('user1_id'=>$user1_id,'user2_id'=>$user2_id)))
            {
                return true;
            }
            return false;
        }
        return false;
    }



    private function user_exists($user_id)
    {
        return User::model()->findByPk($user_id);
    }

    private function relation_exists($from,$to)
    {
        if (Friendship::model()->find('from_id=:from_id AND to_id=:to_id',array('from_id'=>$from,'to_id'=>$to)))
        {
            return true;
        }
        else
            return false;
    }
}
