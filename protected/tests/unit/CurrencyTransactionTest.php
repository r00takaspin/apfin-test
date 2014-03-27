<?php
require_once 'PHPUnit/Autoload.php';

class CurrencyTransactionTest extends CDbTestCase  {
    public $fixtures=array(
        'users'=>'User',
        'countries'=>'Country',
        'friendship'=>'Friendship',
        'CurrencyRates'=>'CurrencyRate',
        'bills'=>'Bill'
    );

    public function testConvert()
    {
        $this->assertEquals(85.492826684937,CurrencyTransaction::calc($this->CurrencyRates['rub']['id'],$this->CurrencyRates['pln']['id'],1000));
        $this->assertSame((string)11696.887783173,(string)CurrencyTransaction::calc($this->CurrencyRates['pln']['id'],$this->CurrencyRates['rub']['id'],1000));
        $this->assertFalse(CurrencyTransaction::calc($this->CurrencyRates['rub']['id'],$this->CurrencyRates['pln']['id'],0));
        $this->assertFalse(CurrencyTransaction::calc(999,333,0));
    }

    public function testTransactions()
    {
        $user = User::model()->findByPk($this->users['bill_test1']['id']);
        $this->assertEquals(1,count($user->bills));
        $ct = new CurrencyTransaction();
        $ct->user_id = $user->id;
        $ct->from_currency_id = $this->bills['bill_test1']['currency_id'];
        $ct->to_currency_id = $this->CurrencyRates['pln']['id'];
        $ct->amount = 500;
        $ct->save();
        $user->refresh();
        $this->assertEquals(2,count($user->bills));
        $this->assertEquals(500,$user->bills[0]->amount);
        $this->assertEquals((string)42.7464,(string)$user->bills[1]->amount);
    }

    public function testTransactionFailsSameCurr()
    {
        $user = User::model()->findByPk($this->users['bill_test1']['id']);
        $this->assertEquals(1,count($user->bills));

        $ct = new CurrencyTransaction();
        $ct->user_id = $user->id;
        $ct->from_currency_id = $this->bills['bill_test1']['currency_id'];
        $ct->to_currency_id = $this->bills['bill_test1']['currency_id'];
        $ct->amount = 500;
        $this->assertFalse($ct->save());
    }

    public function testTransactionFailsWrongAmount()
    {
        $user = User::model()->findByPk($this->users['bill_test1']['id']);
        $this->assertEquals(1,count($user->bills));

        $ct = new CurrencyTransaction();
        $ct->user_id = $user->id;
        $ct->from_currency_id = $this->bills['bill_test1']['currency_id'];
        $ct->to_currency_id = $this->bills['bill_test1']['currency_id'];
        $ct->amount = 1500;
        $this->assertFalse($ct->save());
        $ct->amount = 0;
        $this->assertFalse($ct->save());
        $ct->amount = -1;
        $this->assertFalse($ct->save());
    }



}