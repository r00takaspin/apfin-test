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
            if ($model->save(true,array('first_name','last_name','country_id')))
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
                'actions'=>array('index', 'edit','friends'),
                'users'=>array('@'),
            ),
            array('deny',
                'actions'=>array('index', 'edit','friends'),
                'users'=>array('?'),
            ),
        );
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