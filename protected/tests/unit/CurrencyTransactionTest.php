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
        $this->assertEquals(11696.887783173,CurrencyTransaction::calc($this->CurrencyRates['pln']['id'],$this->CurrencyRates['rub']['id'],1000));
        $this->assertFalse(CurrencyTransaction::calc($this->CurrencyRates['rub']['id'],$this->CurrencyRates['pln']['id'],0));
        $this->assertFalse(CurrencyTransaction::calc(999,333,0));
    }

}