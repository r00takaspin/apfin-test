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


    public function testUser()
    {
        $old_user = $this->users["sample1"];
        $new_user = new User;
        $new_user->setAttributes(array(
           'login'=>'test@test.com',
            'first_name'=>'выавыава',
            'last_name'=>'5jsdklfjskldf',
            'third_name'=>'петрович',
            'country_id'=>1
        ));

        $this->assertTrue($new_user->save(false));

    }


} 