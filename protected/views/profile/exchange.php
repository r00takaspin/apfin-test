<?
$this->breadcrumbs=array(
    'Обмен валют',
);
?>

<?=$this->renderPartial("particals/_user_bills",array('user'=>$user)); ?>

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'exchange-currency',
    'htmlOptions'=>array('class'=>'form-horizontal','name'=>'CurrencyExchange'),
)); ?>
<br/>
<p><strong>Обменять валюту:</strong></p>
<?if ($model->getErrors()):?>
    <p>Ошибки:</p>
    <?foreach($model->getErrors() as $err):?>
        <div class="alert-error" style="width:30%">
            <p><?=$err[0]?></p>
        </div>
    <?endforeach;?>
<? endif;?>
<div class="span9">
    <div class="row">

        <div class="pull-left">
            <?php echo $form->labelEx($model,'amount'); ?>
            <?php echo $form->textField(
                $model,
                'amount',
                array('style'=>'width:100px','placeholder'=>1000)
                //array('onchange'=>'updateInfo()')
            ); ?>
            &nbsp;&nbsp;&nbsp;
        </div>

        <div class="pull-left">
            <?php echo $form->labelEx($model,'from_currency_id'); ?>
            <?php echo $form->dropDownList(
                $model,
                'from_currency_id',
                CHtml::listData($user->bills,'currency_id','currency')
                //array('onchange'=>'updateInfo()')
            ); ?>
            <?php echo $form->error($model,'from_currency_id'); ?>
        </div>

        <div class="pull-left">
            <BR>
            &nbsp;  &nbsp; &nbsp;
        </div>

        <div class="pull-left">
            <?php echo $form->labelEx($model,'to_currency_id'); ?>
            <?php echo $form->dropDownList(
                $model,
                'to_currency_id',
                CHtml::listData(CurrencyRate::model()->findAll(),'id','currency')
                //array('onchange'=>'updateInfo()')
            ); ?>
            <?php echo $form->error($model,'to_currency_id'); ?>
        </div>
        <div class="pull-left" style="padding-top: 24px;padding-left: 10px">
            <input type="submit" value="Курс" class="btn btn-warning" onclick="updateInfo();return false;">
        </div>
        <div class="pull-left " style="padding-top: 24px;padding-left: 10px">
            <?php echo CHtml::submitButton('Обменять!',array('name'=>'submit','id'=>'submit_registration','class'=>'btn btn-success')); ?>
        </div>
    </div>
</div>
<BR /> <BR />

<?php $this->endWidget(); ?>
<div class="alert-info" id="exchange_info" style="display: none;width:60%">

</div>

<div class="clearfix"></div>
<BR />

<? if ($user->trans):?>
<div><p><strong>История операций:</strong></p></div>

<table class="table table-striped span8" style="margin-left: -5px">
    <tr>
        <td>
            ID
        </td>
        <td>
            <strong>Откуда</strong>
        </td>
        <td>
        </td>
        <td>
            <strong>Куда</strong>
        </td>
        <td>
            <strong>Сумма</strong>
        </td>
    </tr>

    <? foreach($user->trans as $t): ?>
        <tr>
            <td><?=$t->id?></td>
            <td><?=$t->from_currency->currency?></td>
            <td>=></td>
            <td><?=$t->to_currency->currency?></td>
            <td><?=$t->amount?></td>
        </tr>
    <? endforeach; ?>
</table>
<div class="clearfix"></div>

<? endif; ?>

<script>
    function updateInfo()
    {
        $("#exchange_info").hide();

        var amount = $("#<?=CHTML::activeId($model,'amount');?>").val();
        var from   = $("#<?=CHTML::activeId($model,'from_currency_id');?>").val();
        var to     = $("#<?=CHTML::activeId($model,'to_currency_id');?>").val();

        if (amount > 0)
        {
            $.ajax({
                url: "<?=Yii::app()->createUrl('profile/calc')?>",
                data: 'amount='+amount+"&from="+from+"&to="+to,
                context: document.body,
                error: function(data)
                {
                    alert('error');
                }
            }).done(function(data) {
                    $("#exchange_info").show();
                    $("#exchange_info").html(
                        "<strong>"+
                            +amount+" "+
                            $("#<?=CHTML::activeId($model,'from_currency_id');?> :selected").html()+
                            " = "+
                            data+" "+$("#<?=CHTML::activeId($model,'to_currency_id');?> :selected").html()+"</strong>"
                    )
            });
        }
        else
        {
            alert('Введите сумму');
        }
    }
</script>