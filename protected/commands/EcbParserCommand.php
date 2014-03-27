<?php
/**
 * Created by PhpStorm.
 * User: voldemar
 * Date: 26.03.14
 * Time: 21:42
 */

class EcbParserCommand extends CConsoleCommand {

    #TODO: сделать апдейт вместо удаления всего из БД
    public function run($args)
    {
        $xml= simplexml_load_file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");

        #по идее надо записывать сначала в темповую таблицу и лишь
        #потом удалять записи, но этот момент я опущу в
        #тестовом задании
        CurrencyRate::model()->deleteAll();
        for($i=0;$i<count($xml[0]->Cube->Cube->Cube);$i++)
        {
            $cr = new CurrencyRate();
            $cr->currency = (string)$xml[0]->Cube->Cube->Cube[$i]['currency'];
            $cr->rate = (float)$xml[0]->Cube->Cube->Cube[$i]['rate'];
            $cr->save();
        }

        $cr = new CurrencyRate();
        $cr->currency = "EUR";
        $cr->rate     = 1;

    }
} 