<?php

class ProfileController extends Controller
{


	public function actionEdit()
	{
        $model = User::model()->findByPk(Yii::app()->user->id);
        $model->setScenario('update');
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model->attributes = $_POST['User'];
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        elseif (Yii::app()->getRequest()->getIsPostRequest())
        {
            $model->attributes = $_POST['User'];
            if ($model->save(true,array('first_name','third_name','last_name','country_id')))
            {
                Yii::app()->user->setFlash('profileUpdated','Профиль успешно изменен');
            }
        }

		$this->render('edit',array('model'=>$model));
	}

	public function actionFriends()
	{
		$this->render('friends');
	}

	public function actionIndex()
	{
        $user = User::model()->findByPk(Yii::app()->user->id);
		$this->render('index',array('user'=>$user));
	}

    public function actionShow($id)
    {
        $id = (int)$id;
        $user = User::model()->findByPk($id);
        if ($user)
        {
            $this->render('index',array('user'=>$user));
        }
        else
        {
            throw new CHttpException(404,'Профиль не найден');
        }
    }

    public function actionUserList()
    {
        $current_user  = User::model()->findByPk(Yii::app()->user->id);
        $user_list = User::model()->findAll("ID!=".$current_user->id,array("order"=>"ID ASC"));

        $this->render("user_list",array("user_list"=>$user_list,'current_user'=>$current_user));
    }

    public function actionAddFriend()
    {
        $user = User::model()->findByPk(Yii::app()->user->id);

        if ($user->id == $_POST['from'] && $user->addFriend($_POST['from'],$_POST['to']))
        {
            return 'success';
        }
        return false;
    }

    public function actionRemoveFriend()
    {
        $user = User::model()->findByPk(Yii::app()->user->id);
        if ($user->id == $_POST['from'] && $user->removeFriend($_POST['from'],$_POST['to']))
        {
            return 'success';
        }
        return false;
    }

    public function actionExchange()
    {
        $trans = new CurrencyTransaction();
        if (Yii::app()->getRequest()->getIsPostRequest())
        {
            $trans->setAttributes($_POST['CurrencyTransaction']);
            $trans->user_id = Yii::app()->user->id;
            $trans->save();
        }

        $user = User::model()->findByPk(Yii::app()->user->id);

        $this->render('exchange',array('user'=>$user,'model'=>$trans,'currency_bills'));
    }

    public function actionCalc()
    {
        $from = (int)$_REQUEST['from'];
        $to   = (int)$_REQUEST['to'];
        $amount = (float)$_REQUEST['amount'];

        echo CurrencyTransaction::calc($from,$to,$amount);

    }

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        #TODO: вынести в константу защищенные экшены
        return array(
            array('allow',
                'actions'=>array('index', 'edit','friends','addFriend','userList','exchange','calc'),
                'users'=>array('@'),
            ),
            array('deny',
                'actions'=>array('index', 'edit','friends','addFriend','userList','exchange','calc'),
                'users'=>array('?'),
            ),
        );
    }
}