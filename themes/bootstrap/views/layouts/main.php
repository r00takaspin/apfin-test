<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<?php Yii::app()->bootstrap->register(); ?>
</head>

<body>

<?
#TODO: переместить в site_controller


$menu_items = array(
    'main'=>array('label'=>'Главная', 'url'=>array('/profile/index')),
    'edit_profile'=>array('label'=>'Редактировать профиль', 'url'=>array('/profile/edit'), 'visible'=>!Yii::app()->user->isGuest),
    'exchange'=>array('label'=>'Обмен валют', 'url'=>array('/profile/exchange'), 'visible'=>!Yii::app()->user->isGuest),
    'user_list'=>array('label'=>'Все пользователи', 'url'=>array('/profile/userList'), 'visible'=>!Yii::app()->user->isGuest),
    'logout'=>array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/auth/logout'), 'visible'=>!Yii::app()->user->isGuest)
);

?>

<?php $this->widget('bootstrap.widgets.TbNavbar',array(

    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>$menu_items
        ),
    ),
)); ?>

<div class="container" id="page">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
