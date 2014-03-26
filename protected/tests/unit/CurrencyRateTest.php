<?php
/**
 * Created by PhpStorm.
 * User: voldemar
 * Date: 27.03.14
 * Time: 0:51
 */

class CurrencyRateTest extends CDbTestCase {
    public $fixtures=array(
        'CurrencyRates'=>'CurrencyRate',
    );

    public function testRandCurrency()
    {
        $this->assertEquals(1,count(CurrencyRate::randCurrency()));
    }
}