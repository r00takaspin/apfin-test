<?php

class ProfileController extends Controller
{
	public function actionEdit()
	{
		$this->render('edit');
	}

	public function actionFriends()
	{
		$this->render('friends');
	}

	public function actionIndex()
	{
		$this->render('index');
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