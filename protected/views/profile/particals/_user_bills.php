<p><strong>Текущее состояние счетов:</strong></p>
<? if ($user->bills): ?>
    <table class="table-bordered table-striped" style="width: 40%">
        <tr>
            <td>ID</td>
            <td><strong>Валюта</strong></td>
            <td><strong>Значение</strong></td>
        </tr>
        <?foreach($user->bills as $bill):?>
            <tr>
                <td><?=$bill->id?></td>
                <td><?=$bill->currency->currency?></td>
                <td><?=$bill->amount?></td>
            </tr>
        <?endforeach;?>
    </table>
<? endif;?>