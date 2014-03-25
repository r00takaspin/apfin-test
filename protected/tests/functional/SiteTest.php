<?php

class SiteTest extends WebTestCase
{
    public $fixtures=array(
        'users'=>'User',
    );

    public function testOpen()
    {
        $this->open('');
        $this->assertTextPresent('Регистрация');
    }
    public function testRegistration()
    {
        $user = $this->users['sample1'];
        $this->open(TEST_BASE_URL."r=auth/register");
        $this->type('name=User[country_id]',$user['country_id']);
        $this->type('name=User[login]',"webtest@selenium.se");
        $this->type('name=User[first_name]',$user['first_name']);
        $this->type('name=User[last_name]',$user['last_name']);
        $this->type('name=User[third_name]',$user['third_name']);
        $this->type('name=User[passwd]','123456');
        $this->type('name=User[passwd_repeat]','123456');
        $this->click('//*[@id="submit_registration"]');
        $this->waitForPageToLoad(1000);

        $this->assertTextPresent($user['first_name']);
        $this->assertTextPresent($user['last_name']);
        $this->assertTextPresent($user['third_name']);
    }

    public function testLogin()
    {
        $user = $this->users['sample1'];
        $this->open(TEST_BASE_URL."r=auth/login");
        $this->type('name=LoginForm[username]',$user['login']);
        $this->type('name=LoginForm[password]','123456');
        $this->click('//*[@id="login"]');
        $this->waitForPageToLoad(1000);
        $this->assertTextPresent($user['first_name']);
        $this->assertTextPresent($user['last_name']);
        $this->assertTextPresent($user['third_name']);
    }
}
