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
            else
            {
                var_dump($model->getErrors());
                die();
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

    public function actionUserList()
    {
        $current_user  = User::model()->findByPk(Yii::app()->user->id);
        $user_list = User::model()->findAll(array("order"=>"ID ASC"));

        $this->render("user_list",array("user_list"=>$user_list,'current_user'=>$current_user));
    }

    public function actionAddFriend()
    {
        $user = User::model()->findByPk(Yii::app()->user->id);
        $user->addFriend((int)$_POST['to']);
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
                'actions'=>array('index', 'edit','friends','addFriend','userList'),
                'users'=>array('@'),
            ),
            array('deny',
                'actions'=>array('index', 'edit','friends','addFriend','userList'),
                'users'=>array('?'),
            ),
        );
    }
}