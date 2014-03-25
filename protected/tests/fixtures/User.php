<?php
/**
 * Created by PhpStorm.
 * User: voldemar
 * Date: 25.03.14
 * Time: 5:35
 */

return array(
    'sample1'=>array(
        'id'=>1,
        'login'=>'test111@test.com',
        'first_name'=>'Вася',
        'last_name'=>'Пупкин',
        'third_name'=>'Пантелеевич',
        'passwd'=>md5('123456'),
        'country_id'=>1,
    ),
    'new_user'=>array(
        'id'=>2,
        'login'=>'test222@test.com',
        'first_name'=>'Вася',
        'last_name'=>'Пупкин',
        'third_name'=>'Пантелеевич',
        'passwd'=>md5('123456'),
        'country_id'=>1,
    ),
    'update_profile'=>array(
        'id'=>3,
        'login'=>'test333@test.com',
        'first_name'=>'Семен',
        'last_name'=>'Сосницкий',
        'third_name'=>'Котиков',
        'passwd'=>md5('123456'),
        'country_id'=>1,
    ),
);