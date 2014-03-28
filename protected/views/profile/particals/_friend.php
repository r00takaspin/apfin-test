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
            <p><?=CHtml::encode($friend->first_name)?> <?=CHtml::encode($friend->last_name)?>, <?=CHtml::encode($friend->country->name)?></p>
            <span class=" badge badge-info"><?=count($friend->friends)?> друзей</span>
            <?if ($friend->bills):?>
            <p>
                <BR />
                <?foreach($friend->bills as $b):?>
                    <? if (round($b->amount)>0): ?>
                        <span class="badge"><?=round($b->amount)?> <?=$b->currency?></span>
                    <? endif; ?>
                <?endforeach;?>
            </p>
            <?endif;?>
        </div>
    </div>
</div>