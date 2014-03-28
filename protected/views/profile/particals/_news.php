<? if ($friends_news):?>

<p><strong>Новости:</strong></p>

<table class="table table-condensed table-hover table-striped">
    <thead>
    <tr>
        <th class="span1">#ID</th>
        <th class="span2">Кто</th>
        <th class="span2"> </th>
        <th class="span9">Что делал</th>
        <th class="span2">Когда</th>
    </tr>
    </thead>
    <tbody>
    <?foreach($friends_news as $news):?>
    <tr>
        <td><?=$news->id?></td>
        <td><strong><?=CHtml::encode($news->user->first_name)?> <?=CHtml::encode($news->user->last_name)?></strong></td>
        <td><span class="label pull-right"></span></td>
        <td><?=$news->amount?> <?=$news->from_currency->currency?> => <?=$news->converted_amount?> <?=$news->to_currency->currency?></td>
        <td><strong><?=$news->date?></strong></td>
    </tr>
    <?endforeach;?>
</table>
<?endif;?>