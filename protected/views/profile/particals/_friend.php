<div class="span4 well pull-left">
    <div class="row">
        <div class="span1">
            <a href="<?=Yii::app()->createUrl('profile/show',array('id'=>$friend->id))?>">
            <?
            if($friend->preview && $friend->preview->hasImage())
                echo CHtml::image($friend->preview->getUrl('preview'),'',array('class'=>'img-rounded'));
            else
                echo CHtml::image(Yii::app()->baseUrl.'/images/default_avatar.png','',array('class'=>'img-rounded'));
            ?>
            </a>
        </div>
        <div class="span3">
            <p><strong><a href="<?=Yii::app()->createUrl('profile/show',array('id'=>$friend->id))?>"><?=$friend->login?></a></strong> </p>
            <p><?=$friend->first_name?> <?=$friend->last_name?>, <?=$friend->country->name?></p>
            <span class=" badge badge-info"><?=count($friend->friends)?> друзей</span>
        </div>
    </div>
</div>