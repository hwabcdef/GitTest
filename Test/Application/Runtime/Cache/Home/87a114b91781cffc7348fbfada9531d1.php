<?php if (!defined('THINK_PATH')) exit();?><h2>系统推荐</h2>
<div class="leftbox">
<?php if(is_array($tuijian["1"])): $i = 0; $__LIST__ = $tuijian["1"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php $urlname='Index/tmdetail?id='.$vo['tm_id'];echo U($urlname); ?>" target="_blank" title="<?php echo ($vo["tm_name"]); ?>"><img src="<?php echo C('PIC15');?>/<?php echo ($vo["tm_id"]); ?>" alt="<?php echo ($vo["tm_name"]); ?>" /></a><?php endforeach; endif; else: echo "" ;endif; ?>
<?php echo (htmlspecialchars_decode($ad)); ?>
</div>
<div class="minbox">
<ul>
<?php if(is_array($tuijian["2"])): $i = 0; $__LIST__ = $tuijian["2"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php $urlname='Index/tmdetail?id='.$vo['tm_id'];echo U($urlname); ?>" target="_blank" title="<?php echo ($vo["tm_name"]); ?>"><img src="<?php if(($vo["is_fine"]) == "1"): echo C('PIC9');?>/<?php echo ($vo["tm_id"]); else: echo C('PIC4');?>/<?php echo ($vo["tm_id"]); endif; ?>" alt="<?php echo ($vo["tm_name"]); ?>" /></a><p><a href="<?php $urlname='Index/tmdetail?id='.$vo['tm_id'];echo U($urlname); ?>" target="_blank" title="<?php echo ($vo["tm_name"]); ?>" class="title"><?php echo (subtext($vo["tm_name"],8)); ?></a><a href="<?php $urlname='Index/tmclass?id='.$vo['tm_categories'];echo U($urlname); ?>" target="_blank" class="type" title="<?php echo $sblist[$vo['tm_categories']] ?>">第<?php echo ($vo["tm_categories"]); ?>类</a></p></li><?php endforeach; endif; else: echo "" ;endif; ?>

</ul>
</div>
<div class="rightbox">
<ul>
<?php if(is_array($tuijian["3"])): $i = 0; $__LIST__ = $tuijian["3"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php $urlname='Index/tmdetail?id='.$vo['tm_id'];echo U($urlname); ?>" target="_blank" title="<?php echo ($vo["tm_name"]); ?>"><img src="<?php if(($vo["is_fine"]) == "1"): echo C('PIC13');?>/<?php echo ($vo["tm_id"]); else: echo C('PIC4');?>/<?php echo ($vo["tm_id"]); endif; ?>" alt="<?php echo ($vo["tm_name"]); ?>" /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
<?php if(is_array($tuijian["4"])): $i = 0; $__LIST__ = $tuijian["4"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><p class="adimg"><a href="<?php $urlname='Index/tmdetail?id='.$vo['tm_id'];echo U($urlname); ?>" target="_blank" title="<?php echo ($vo["tm_name"]); ?>"><img src="<?php echo C('PIC16');?>/<?php echo ($vo["tm_id"]); ?>" alt="<?php echo ($vo["tm_name"]); ?>" /></a></p><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>