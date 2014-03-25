<?php

class AuthController extends Controller
{
    public function actionLogin()
    {
        $model=new LoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
                $this->redirect(array("auth/index"));
        }
        // display the login form
        $this->render('login',array('model'=>$model));
    }

	public function actionLogout()
	{
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
	}

	public function actionRegister()
	{
        if (Yii::app()->user->id)
        {
            $this->redirect(Yii::app()->createUrl("profile/index"));
        }
        if(Yii::app()->getRequest()->getIsAjaxRequest()) {
            $model = new User;
            $model->attributes = $_POST['User'];
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        elseif (Yii::app()->getRequest()->getIsPostRequest())
        {
            $model = new User;
            $model->attributes = $_POST['User'];
            if ($model->validate())
            {
                $password = $model->passwd;

                $model->save();

                $identity=new UserIdentity($model->login,$password);
                if($identity->authenticate())
                {
                    Yii::app()->user->login($identity,3600*24*7);
                    $this->redirect(array("profile/index"));
                }
                else
                    echo $identity->errorMessage;
            }
            else
            {
                var_dump($model->getErrors());
                die();
            }
        }

        $model = new User();
		$this->render('register',array('model'=>$model));
	}

    public function actionIndex()
    {
        if (Yii::app()->user->id)
        {
            $this->redirect(array("profile/index"));
        }

        $this->render('index');
    }

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}