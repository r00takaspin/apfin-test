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
    public  function testRegistration()
    {
        $user = $this->users['sample1'];
        $this->open(TEST_BASE_URL."r=auth/register");
        $this->type('name=User[country_id]',$user['country_id']);
        $this->type('name=User[login]',"webtest@selenium.se");
        $this->type('name=User[first_name]',$user['first_name']);
        $this->type('name=User[last_name]',$user['last_name']);
        $this->type('name=User[third_name]',$user['third_name']);
        $this->type('name=User[passwd]',$user['passwd']);
        $this->type('name=User[passwd_repeat]',$user['passwd_repeat']);
        $this->click('//*[@id="submit_registration"]');
        $this->waitForPageToLoad(1000);
        $this->assertTextPresent($user['first_name']);
        $this->assertTextPresent($user['last_name']);
        $this->assertTextPresent($user['third_name']);
    }
}
