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
        'friendship'=>'Friendship',
        'CurrencyRates'=>'CurrencyRate',
        'bills'=>'Bill'
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
        $new_user->scenario = "create";
        $new_user->setAttributes(array(
            'login'=>'test111@test.com',
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
        $new_user->scenario = "create";
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

    public function  testUpdateProfile()
    {
        $user = User::model()->findByPk($this->users["update_profile"]['id']);
        $user->setAttributes(array('first_name'=>'батя','last_name'=>'паук'));
        $user->scenario = 'update';
        $user->save(true);
        $updated_user = User::model()->findByPk($this->users["update_profile"]['id']);
        $this->assertEquals('батя',$updated_user->first_name);
        $this->assertEquals('паук',$updated_user->last_name);

        $identity=new UserIdentity($user->login,'123456');
        $this->assertTrue($identity->authenticate());
    }

    public function testAddFriend()
    {
        $this->assertTrue(User::addFriend($this->users['sample_friend1']['id'],$this->users['sample_friend2']['id']));
        $this->assertFalse(User::addFriend($this->users['sample_friend1']['id'],$this->users['sample_friend1']['id']));
    }

    public function testRemoveFriend()
    {
        $this->assertTrue(User::removeFriend($this->users['friend_one']['id'],$this->users['friend_two']['id']));

        $this->assertFalse(User::removeFriend($this->users['friend_one']['id'],$this->users['friend_one']['id']));
    }

    public function testFriendList()
    {
        $user = User::model()->findByPk($this->users['friend_one']['id']);
        $this->assertEquals(count($user->friends),1);

        $user = User::model()->findByPk($this->users['friends_owner']['id']);
        $this->assertEquals(count($user->friends),2);

        $user = User::model()->findByPk($this->users['new_user']['id']);
        $this->assertEquals(count($user->friends),0);
    }

    public function testIsFriend()
    {
        $this->assertTrue(User::isFriend($this->users['friends_owner']['id'],$this->users['friend_two']['id']));
    }

    public function testUserBillCreation()
    {
        $user = new User();
        $user->setScenario('create');

        $user->login = "create@bill.com";
        $user->first_name = "Тест";
        $user->last_name = "Создания";
        $user->third_name = "Счета";
        $user->country_id = $this->countries["russia"]['id'];
        $user->passwd = "123456";
        $user->passwd_repeat = "123456";

        $user->save();

        $this->assertEquals(1000,$user->bills[0]->amount);
    }

}