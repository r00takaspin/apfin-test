<?php
/**
 * Created by PhpStorm.
 * User: voldemar
 * Date: 26.03.14
 * Time: 21:42
 */

class EcbParserCommand extends CConsoleCommand {

    public function run($args)
    {
        $xml= simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");

        for($i=0;$i<count($xml[0]->Cube->Cube->Cube);$i++)
        {
            $currency = CurrencyRate::model()->find('currency=:c',array('c'=>(string)$xml[0]->Cube->Cube->Cube[$i]['currency']));
            if ($currency)
            {
                $currency->rate = (float)$xml[0]->Cube->Cube->Cube[$i]['rate'];
                $currency->save();
            }
            else
            {
                $cr = new CurrencyRate();
                $cr->currency = (string)$xml[0]->Cube->Cube->Cube[$i]['currency'];
                $cr->rate = (float)$xml[0]->Cube->Cube->Cube[$i]['rate'];
                $cr->save();
            }
        }

        $cr = new CurrencyRate();
        $cr->currency = "EUR";
        $cr->rate     = 1;

    }
} 