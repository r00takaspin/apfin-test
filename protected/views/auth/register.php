<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>
<?
CHtml::$errorCss='alert alert-error'
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-register-form',
    'htmlOptions'=>array('class'=>'form-horizontal'),
    'enableAjaxValidation'=>true,
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
    ),
)); ?>

	<p class="note">Поля со звездочкой <span class="required">*</span> являются обязательными.</p>
		<?php echo $form->labelEx($model,'country_id'); ?>
		<?php echo $form->dropDownList(
                            $model,
                            'country_id',
                            CHtml::listData(Country::model()->findAll(array('order' => 'id ASC')),'id','name'),
                            array('onchange'=>'showThirdName(this)')
                    ); ?>
		<?php echo $form->error($model,'country_id'); ?>

        <?php echo $form->labelEx($model,'login'); ?>
        <?php echo $form->textField($model,'login',array('onkeypress'=>'this.form.submit')); ?>
        <?php echo $form->error($model,'login'); ?>

		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name'); ?>
		<?php echo $form->error($model,'first_name'); ?>

		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name'); ?>
		<?php echo $form->error($model,'last_name'); ?>
        <div>
		<?php echo $form->labelEx($model,'third_name'); ?>
		<?php echo $form->textField($model,'third_name'); ?>
		<?php echo $form->error($model,'third_name'); ?>
        </div>
		<?php echo $form->labelEx($model,'passwd'); ?>
		<?php echo $form->textField($model,'passwd'); ?>
		<?php echo $form->error($model,'passwd'); ?>


        <?php echo $form->labelEx($model,'passwd_repeat'); ?>
        <?php echo $form->textField($model,'passwd_repeat'); ?>
        <?php echo $form->error($model,'passwd_repeat'); ?>

        <BR /> <BR />

		<?php echo CHtml::submitButton('Submit'); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    /*
    проверяем, нужно ли нам показывать отчество
     */

    var enable_third_name = <?=Country::model()->find('required_third_name=1')->id?>

    function showThirdName(dropdown)
    {
        if ($(dropdown,"option :selected").val()==enable_third_name)
        {
            $("#<?=CHTML::activeId($model,'third_name');?>").parent().show();
        }
        else
        {
            $("#<?=CHTML::activeId($model,'third_name');?>").parent().hide();
        }
    }
</script>