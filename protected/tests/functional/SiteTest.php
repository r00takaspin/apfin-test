<?php

class SiteTest extends WebTestCase
{
    public $fixtures=array(
        'users'=>'User',
    );

    public function testOpen()
    {
        var_dump(Yii::app()->createUrl("auth/register"));
        $this->open('');
        $this->assertTextPresent('Регистрация');
    }
/*
    public  function testRegistration()
    {
        $this->open(Yii::app()->createUrl(array("auth/register")));
        $this->assertTextPresent('Email');
    }
*/
}
