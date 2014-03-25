<?php
require_once 'PHPUnit/Autoload.php';

/**
 * Created by PhpStorm.
 * User: voldemar
 * Date: 25.03.14
 * Time: 5:33
 */

class UserTest extends CDbTestCase {
    public $fixtures=array(
        'users'=>'User',
        'countries'=>'Country',
    );

    public  function testCreateUser()
    {
        $new_user = new User;
        $new_user->setAttributes(array(
            'login'=>'test@example.com',
            'first_name'=>'Тестовый',
            'last_name'=>'Тест',
            'third_name'=>'Пупкин',
            'passwd'=>'123456',
            'passwd_repeat'=>'123456',
            'country_id'=>$this->countries['russia']['id']
        ));
        $this->assertTrue($new_user->validate());
    }


    public function testNotUniqueLogin()
    {
        $new_user = new User;
        $new_user->setAttributes(array(
            'login'=>'test@test.com',
        ));
        $this->assertFalse($new_user->validate(array('login')));
    }

    public function testWrongFormat()
    {
        $new_user = new User;
        $new_user->setAttributes(array(
            'login'=>'блаблабла',
        ));
        $this->assertFalse($new_user->validate(array('login')));
    }

    public function testPasswordNotMatch()
    {
        $new_user = new User;
        $new_user->setAttributes(array(
            'passwd'=>'блаблабла',
            'passwd_repeat'=>'траляля'
        ));
        $this->assertFalse($new_user->validate(array('passwd')));
    }

    public function testPasswordMatch()
    {
        $new_user = new User;
        $new_user->setAttributes(array(
            'passwd'=>'блаблабла',
            'passwd_repeat'=>'блаблабла'
        ));
        $this->assertTrue($new_user->validate(array('passwd')));
    }

    public function testCountry()
    {
        $new_user = new User;
        $new_user->setAttributes(array(
            'country_id'=>false
        ));

        $this->assertFalse($new_user->validate(array('country_id')));
    }
}