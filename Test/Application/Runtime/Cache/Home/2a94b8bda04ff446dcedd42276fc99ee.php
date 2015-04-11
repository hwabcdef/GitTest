<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($tmpl_info["title"]); ?></title>
<meta name="Keywords" content="<?php echo ($tmpl_info["keywords"]); ?>" />
<meta name="Description" content="<?php echo ($tmpl_info["description"]); ?>" />
<link rel="stylesheet" href="<?php echo C('HTMLPATH');?>css/main.css">
<link rel="stylesheet" href="<?php echo C('HTMLPATH');?>css/indexStyle.css">
<link rel="stylesheet" href="<?php echo C('HTMLPATH');?>css/ion.rangeSlider.css"/><!--滑块样式-->
<script type="text/javascript" src="<?php echo C('HTMLPATH');?>js/pptBox.js"></script>
<script type="text/javascript" src="<?php echo C('HTMLPATH');?>js/jquery-1.7.1.js"></script>
<script type="text/javascript" src="<?php echo C('HTMLPATH');?>js/common.js"></script>
<script type="text/javascript" src="<?php echo C('HTMLPATH');?>js/ion.rangeSlider.js"></script>
<script type='text/javascript' src="<?php echo C('HTMLPATH');?>js/dropdown.js"></script>
<script type="text/javascript">
var trace_page_on = "<?php echo ($trace_page_arr["on"]); ?>";
if(trace_page_on){
function trace_close_time(){
	$.ajax({
		type:"POST",
		url:"<?php echo U('Index/traceUrl');?>",
		async: false,
		data:"id=<?php echo ($trace_page_arr["trace_id"]); ?>",
		success: function(result){
			}
	});
}
function trace_update_time(){
	$.ajax({
		type:"POST",
		url:"<?php echo U('Index/traceUrl');?>",
		async: false,
		data:"type=1&id=<?php echo ($trace_page_arr["trace_id"]); ?>",
		success: function(result){
			}
	});
}
window.onbeforeunload = function(){
	trace_close_time();
}
var time_limit_tmp = "<?php echo ((isset($trace_page_arr["limit_time"]) && ($trace_page_arr["limit_time"] !== ""))?($trace_page_arr["limit_time"]):10000); ?>";
time_limit_tmp = parseInt(time_limit_tmp);
time_limit_tmp = time_limit_tmp * 1000;
setInterval(trace_update_time, time_limit_tmp);
}
</script>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
</head>
<body>
<div class="header">
<div id="site-nav">
<ul class="leftsite">
<li class="left">欢迎来到全国最大商标网站 - 华唯商标网<?php if(isset($_SESSION['id'])): ?><em>欢迎您，<?php echo (session('nick')); ?></em></em><em><a href="<?php echo U('User/info');?>">个人中心</a></em><em><a href="<?php echo U('User/logout');?>">退出</a></em><?php else: ?><em><a href="<?php echo U('User/index');?>">登录</a></em><em><a href="<?php echo U('User/reg');?>">注册</a></em><?php endif; ?></li>
</ul>
<ul class="quick-menu">
<li><a href="<?php echo U('Article/help',array('id'=>28,'tid'=>27));?>" target="_blank">新手帮助中心</a></li>
<li><a href="<?php echo U('Article/help',array('id'=>29,'tid'=>27));?>" target="_blank">买家须知</a></li>
<li><a href="<?php echo U('Article/help',array('id'=>30,'tid'=>27));?>" target="_blank">卖家须知</a></li>
<li><a href="<?php echo U('Article/help',array('id'=>31,'tid'=>27));?>" target="_blank">商标交易注意事项</a></li>
<li class="mytm menu-item">
<div class="menu">
<a class="menu-title" href="<?php echo U('Article/index',array('id'=>26));?>" rel="nofollow">网站导航<b></b></a> 
<div class="menu-bd">
<a href="http://bbs.hw-tm.cn" target="_blank" rel="nofollow">商标论坛</a>
<a href="http://ask.hw-tm.cn" target="_blank" rel="nofollow">商标问答</a>
<a href="<?php echo U('Article/help',array('id'=>28,'tid'=>27));?>" target="_blank" rel="nofollow">帮助中心</a>
</div>
</div>
</li>
<li class="mobile menu-item">
<div class="menu">
<a class="menu-title" href="/m" rel="nofollow">手机版<b></b></a> 
<div class="menu-bd">
<p>手机浏览器扫描二维码访问</p>
<img src="<?php echo C('HTMLPATH');?>images/mcode.png" />
</div>
</div>
</li>
<li class="phone">400-888-1139</li>
</ul>
</div>

<div class="clear"></div>

<div class="midbox">
<div class="logobox"><h1><a href="<?php echo C('INDEXPATH');?>" target="_blank" title="华唯商标转让网">华唯商标转让网</a></h1></div>
<div class="searchbox">
<ul>
<form name="f" action="<?php echo U('Index/search');?>" method='post' target="_blank">
<div><input name='category' type='hidden' id='category' value=""><div id="sugOut"><input type="text" value="<?php echo ((isset($con["content1"]) && ($con["content1"] !== ""))?($con["content1"]):'商标名称、注册号、编号、介绍'); ?>" name='content1' id="kww" onfocus="if(this.value==this.attributes.attr_val.value)this.value='';" onblur="if(!this.value)this.value=this.attributes.attr_val.value;" attr_val="商标名称、注册号、编号、介绍" autocomplete="off"><div id="sugbox"><div id="sug"></div></div></div>
</div>
<div class="scate">
<input class="input_01 cr_input_02 ipt1" type="text" value="选择商标类型" onfocus="if(this.value==this.attributes.attr_val.value)this.value='';" onblur="if(!this.value)this.value=this.attributes.attr_val.value;" attr_val="选择商标类型" />
<div id="reg_div" class='reg_div_02' style="display:none;">
<div class="ps_div"><span style="float:right;" class="cr_close">关闭</span>查找提示：</div>
<?php if(is_array($sblist)): $i = 0; $__LIST__ = $sblist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="cate" value="<?php echo ($key); ?>">第<?php echo ($key); ?>类</li><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
</div>
<input type="hidden" value="1" name="discu"/>
<input type="submit" name="Submit" value="搜索" class="btn1" />
</form>
<input type="submit" name="Submit" value="高级搜索" class="btn2" onclick="location.href='<?php echo U('Index/search');?>'" />
<li>热门搜索：
<?php $remensize=sizeof($remen); ?>
<?php if(is_array($remen)): $i = 0; $__LIST__ = $remen;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(($i) == $remensize): ?>&nbsp;<a href="<?php echo U('Index/indeustry',array('id'=>$key));?>" target="_blank"><?php echo ($vo); ?></a><?php else: ?><a href="<?php echo U('Index/indeustry',array('id'=>$key));?>" target="_blank" ><?php echo ($vo); ?></a>&nbsp;|<?php endif; endforeach; endif; else: echo "" ;endif; ?></li>
</ul>
</div>
<div class="subbox">
<ul>
<li><a href="<?php echo U('Index/transfer');?>" class="ibtn3" target="_blank">更新商标及联系方式</a></li><li><a href="<?php echo U('Index/transfer');?>" class="ibtn2" target="_blank">我要卖商标</a></li><li><a href="<?php echo U('Index/buy');?>" class="ibtn1" target="_blank">我要买商标</a></li>
</ul>
</div>
</div>

<div class="clear"></div>
<!--导航 Start-->
<div class="menubox">
<div class="all-sort"><h2>适用行业分类</h2></div>
<div class="nav">
<ul class="clearfix">
<?php $self_tmp = strtolower($_SERVER['PHP_SELF']); $nav_arr_c = array('quality','search','sblist','tmclass','tradeIndex','permisTm','fzmold','tmlike','indeustry'); $currentnav_tmp = ''; foreach($nav_arr_c as $val){ if(strpos($self_tmp,strtolower($val))){ $currentnav_tmp = $val; break; } } $currentnav_tmp = $currentnav_tmp ? : 'index'; ?>
<li><a href="<?php echo C('INDEXPATH');?>" <?php if($currentnav_tmp == 'index'): ?>class="current"<?php endif; ?>>首页</a></li>
<li><a href="<?php echo U('Index/quality');?>" <?php if($currentnav_tmp == 'quality'): ?>class="current"<?php endif; ?>>精品商标</a></li>
<li><a href="<?php echo U('Index/search');?>" <?php if(($currentnav_tmp == 'search') or ($currentnav_tmp == 'tmlike')): ?>class="current"<?php elseif($currentnav_tmp == 'fzmold'): ?>class="current"<?php endif; ?>>商标搜索</a></li>
<li><a href="<?php echo U('Index/sblist');?>" <?php if(($currentnav_tmp == 'sblist') or (($currentnav_tmp == 'tmclass') and ($class != 25)) or ($currentnav_tmp == 'indeustry')): ?>class="current"<?php endif; ?>>商标分类</a></li>
<li><a href="<?php $urlname='Index/tmclass?id=25';echo U($urlname); ?>" <?php if(($currentnav_tmp == 'tmclass') and ($class == 25)): ?>class="current"<?php endif; ?>>服装商标</a></li>
<li><a href="http://www.ipsoon.cn/" target="_blank">国内商标注册</a></li>
<li><a href="http://www.ipsoon.org.cn/" target="_blank">国外商标注册</a></li>
<li><a href="<?php echo U('Index/tradeIndex');?>" <?php if($currentnav_tmp == 'tradeIndex'): ?>class="current"<?php endif; ?>>商品/服务分类表</a></li>
<li><a href="http://www.ipsoon.org.cn/" target="_blank">国际商标转让</a></li>
<li><a href="<?php echo U('Index/permisTm');?>" <?php if($currentnav_tmp == 'permisTm'): ?>class="current"<?php endif; ?>>许可商标</a></li>

</ul>
</div>
</div>
<!--导航 End-->
</div>

<div class="mainbox">
<div class="inporbox">
<div class="leftbox">
<!--所有分类 Start-->
<div class="all-sort-list">
<?php if(is_array($fenlei)): $k = 0; $__LIST__ = array_slice($fenlei,0,2,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><h4 class="t<?php echo ($k); ?>"><?php echo ($vo["self"]["name"]); ?></h4>
<?php if(is_array($vo["down"])): $i = 0; $__LIST__ = $vo["down"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vod): $mod = ($i % 2 );++$i;?><div class="item bo">
<h3><span>·</span><a><?php echo ($vod["self"]["name"]); ?></a></h3>
<div class="item-list clearfix">
<div class="subitem">
<?php if(is_array($vod["down"])): $i = 0; $__LIST__ = $vod["down"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vodd): $mod = ($i % 2 );++$i;?><dl>
	<dt></dt>
	<dd>
	<?php if(is_array($vodd["down"])): foreach($vodd["down"] as $key=>$voddd): ?><em><a href="<?php echo U('Index/indeustry',array('id'=>$voddd['id']));?>"><?php echo ($voddd["name"]); ?></a><dfn>
			<?php $conditions=json_decode($voddd['conditions'],true); if($conditions['category'] || $conditions['25group']){ echo '('; if($conditions['category']){ echo $conditions['category'].'类'; }; if($conditions['25group']){ echo $conditions['25group']; }; echo ')'; } ?>

		</dfn></em><?php endforeach; endif; ?>
	</dd>
	</dl><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
</div>
</div><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>

</div>
<!--所有分类 End-->
</div>

<div class="minbox">
<!--焦点图-->
<div id="focimg">
<script>
var box =new PPTBox();
box.width = 670; //宽度
box.height = 320;//高度
box.autoplayer = 5;//自动播放间隔时间
var a="http://192.168.1.192<?php echo ($slide["1"]["ad_pic"]); ?>";
var b="http://192.168.1.192<?php echo ($slide["2"]["ad_pic"]); ?>";
//box.add({"url":"图片地址","title":"悬浮标题","href":"链接地址"})
box.add({"url":a,"href":"{$slide.1.ad_url}"})
box.add({"url":b,"href":"{$slide.2.ad_url}"})
box.show();
</script>
</div>
<!--焦点图 end-->
<div class="sadbox">
<ul>
<li><a href="<?php echo ($slide["3"]["ad_url"]); ?>" target="_blank"><img src="http://192.168.1.192<?php echo ($slide["3"]["ad_pic"]); ?>" /></a></li>
<li><a href="<?php echo ($slide["4"]["ad_url"]); ?>" target="_blank"><img src="http://192.168.1.192<?php echo ($slide["4"]["ad_pic"]); ?>" /></a></li>
<li><a href="<?php echo ($slide["5"]["ad_url"]); ?>" target="_blank"><img src="http://192.168.1.192<?php echo ($slide["5"]["ad_pic"]); ?>" /></a></li>
<li class="last"><a href="<?php echo ($slide["6"]["ad_url"]); ?>" target="_blank"><img src="http://192.168.1.192<?php echo ($slide["6"]["ad_pic"]); ?>" /></a></li>
</ul>
</div>
</div>

<div class="rightbox">
<!--登录-->
<div class="loginbox">
<dl>
<dt>本地登录</dt>
<dd class="qq"><a href="<?php echo U('Oauth/oauthlogin', 'type=qq');?>" rel="nofollow">QQ登录</a></dd>
<dd class="weibo"><a href="<?php echo U('Oauth/oauthlogin', 'type=sina');?>" rel="nofollow">微博登录</a></dd>
</dl>
<?php if(isset($_SESSION['id'])): ?><!--登录后-->
<ul class="loged">
<p>全国最大商标网站 - 华唯商标网</p>
<p>欢迎您，<em><?php echo (session('nick')); ?></em> [<a href="<?php echo U('User/logout');?>">退出</a>]</p>
<p><a href="<?php echo U('User/info');?>" class="blue">个人中心</a> <a href="<?php echo U('User/transfer');?>" class="blue">发布转让</a> <a href="<?php echo U('User/buy');?>" class="blue">发布求购</a> 
</br>
<a href="<?php echo U('User/collection');?>" class="blue">我的商标夹</a>
<a href="<?php echo U('Index/myhistory');?>" class="blue">浏览记录</a>
</p>
</ul>
<!--登录后 end-->
<?php else: ?>
<ul>
<form action='<?php echo U("User/index");?>' method='post' />

<!-- 登陆验证 -->
<script type='text/javascript' src="<?php echo C('HTMLPATH');?>js/jquery.bgiframe.min.js"></script>
<link  href="<?php echo C('HTMLPATH');?>css/validate.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(function(){
    var xOffset = -20;
    var yOffset = 20;

    $("[reg],[tip]").hover(
        function(e) {
            if($(this).attr('tip') != undefined){
                var top = (e.pageY + yOffset);
                var left = (e.pageX + xOffset);
                $('body').append( '<p id="vtip"><img id="vtipArrow" src="<?php echo C('HTMLPATH');?>images/vtip_arrow.png"/>' + $(this).attr('tip') + '</p>' );
                $('body').append( '<p id="vtip">' + $(this).attr('tip') + '</p>' );
                $('p#vtip').css("top", top+"px").css("left", left+"px");
                $('p#vtip').bgiframe();
            }
        },
        function() {
            if($(this).attr('tip') != undefined){
                $("p#vtip").remove();
            }
        }
    ).blur(function(){
        if($(this).attr("reg") != undefined){
            validate($(this));
        }
    });

    // 提交前验证
    $("form").submit(function(){
        var isSubmit = true;
        $(this).find("[reg]").each(function(){
            if(!validate($(this))){
                isSubmit = false;
                // return false;   // 跳出循环
            }
        });
        return isSubmit;
    });
});
// 验证函数
function validate(obj){
    var reg = new RegExp(obj.attr("reg"));
    var objValue = obj.attr("value");
    if(!reg.test(objValue)){
        obj.addClass("input_validation-failed");
        return false;
    }else{
        obj.removeClass("input_validation-failed");
        return true;
    }
}
</script>

<li>用户名：<input type="text" name="name" class="ipt" reg="^\s*([\u4e00-\u9fa5]|\w)+\s*$" tip="用户名为中文或英文字母"/></li>
<li>密　码：<input type="password" name="password" class="ipt" reg="^\s*\w{6,}\s*$" tip="密码为6位以上字母或数字"/></li>
<li class="right"><input type="submit" name="Submit" value="登录" class="btn" /></li>

<p><input type="checkbox" name="jizhu" value="1" id="psw" /> <label for="psw">记住密码</label><span><a href="<?php echo U('User/reg');?>" target="_blank">新用户注册</a></span></p></form>
<p><em>QQ号或新浪微博的帐户可直接登陆本站</em></p>
</ul><?php endif; ?>

</div>
<!--登录 end-->

<!--快捷搜索-->
<div class="screenbox">
<script type="text/javascript">
function sbtype(){
	var b='';
	$('[key]').each(function(){
    			if($(this).attr('checked')=='checked'){
    						if(b==''){
    							b=$(this).parent().text();
    						}else{
    							var text1=$(this).parent().text();
    							text1=text1.replace('包含','');
    							b=b+','+text1;
    						}	
    			}
		});
		if(b==''){
			$('#sbtype').html('中文/英文/图形/数字');	
		}else{
			$('#sbtype').html("已选择"+b);	
		}
}
function ch_num(){
	var b='';
		$('[name=ch_num]').each(function(){
    			if($(this).attr('checked')=='checked'){
    						if(b==''){
    							b=$(this).parent().text();
    						}else{
    							b=b+','+$(this).parent().text();
    						}	
    			}
		});
		if(b==''){
			$('#ch_num').html('汉字字数');	
		}else{
			if($('[name=hzall]').attr('checked')=='checked'){
				b=b+"-以上";
			}

			$('#ch_num').html(b);	
		}
}
function en_num(){
	var b='';
		$('[name=en_num]').each(function(){
    			if($(this).attr('checked')=='checked'){
    						if(b==''){
    							b=$(this).parent().text();
    						}else{
    							b=b+','+$(this).parent().text();
    						}	
    			}
		});
		if(b==''){
			$('#en_num').html('字母字数');	
		}else{
			if($('[name=zmall]').attr('checked')=='checked'){
				b=b+"-以上";
			}
			$('#en_num').html(b);	
		}
}
function regdate(){
	var b='';
		$('[name=regdate]').each(function(){
    			if($(this).attr('checked')=='checked'){
    						if(b==''){
    							b=$(this).parent().text();
    						}else{
    							b=b+','+$(this).parent().text();
    						}	
    			}
		});
		if(b==''){
			$('#regdate').html('注册年限');	
		}else{
			$('#regdate').html(b);	
		}
}

$(document).ready(function(){
	$('[name=ch_num]').click(function(){
		ch_num();
	})
	$('[name=hzall]').click(function(){
		ch_num();
	})
	$('[name=en_num]').click(function(){
		en_num();
	})
	$('[name=zmall]').click(function(){
		en_num();
	})
	$('[name=regdate]').click(function(){
		regdate();
	})

    $('[key]').click(function(){
            if($(this).attr('key')==1){
                var name=$(this).attr('name');
                $('[key]').each(function(){
                    if($(this).attr('name') != name){
                        $(this).removeAttr('checked');
                    }
                });
            }
            if($(this).attr('key')==2){
                $('[key=1]').each(function(){
                        $(this).removeAttr('checked');
                });
            }
            sbtype();
        });
});

</script>
<form action='<?php echo U("Index/search");?>' method="post" />
<input type="hidden" value="1" name="discu"/>
<h2>快捷搜索</h2>
<ul class="ulcon">
<dl>
<dt>商标类别：</dt>
<dd class="genbox">
<input class="input_01 cr_input_01 ipt1" type="text" name='category' >
<div id="reg_div" class='reg_div_01' style="display:none;">
<div class="ps_div"><span style="float:right;" class="cr_close">关闭</span>查找提示：</div>
<?php if(is_array($sblist)): $i = 0; $__LIST__ = $sblist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="cate">第<?php echo ($key); ?>类</li><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
</dd>
</dl>

<dl>
<dt>关键字：</dt>
<dd><input type="text" value="<?php echo ((isset($con["content"]) && ($con["content"] !== ""))?($con["content"]):'中文/英文/注册号/ID号'); ?>" name='content' class="ipt1" onfocus="if(this.value==this.attributes.attr_val.value)this.value='';" onblur="if(!this.value)this.value=this.attributes.attr_val.value;" attr_val="中文/英文/注册号/ID号" />
<em><label><input type="checkbox"  name='before' value="1" <?php if(($con["before"]) == "1"): ?>checked<?php endif; ?>/> 前包含</label></em>
<em><label><input type="checkbox" name='middle' value="1" checked/> 任意包含</label></em>
<em><label><input type="checkbox"  name='end' value='1' <?php if(($con["end"]) == "1"): ?>checked<?php endif; ?>  /> 结尾包含</label></em>
<em><label><input type="checkbox" name='like' value="1" checked /> 包含近似商标</label></em>
</dd>
</dl>
<dl>
<dt>商标类型：</dt>
<dd>
<ul id="jDropDown">
<li><a id='sbtype'>中文/英文/图形/数字</a>
<div class="column_6">
<div class="column">
<ul>
<li><label><input type="checkbox" name='chun_ch' key='1' value="1" <?php if(($con["chun_ch"]) == "1"): ?>checked<?php endif; ?>/>纯中文</label></li>
<li><label><input type="checkbox" name='chun_en' <?php if(($con["chun_en"]) == "1"): ?>checked<?php endif; ?> key='1' value="1" />纯英文</label></li>
<li><label><input type="checkbox" <?php if(($con["chun_tx"]) == "1"): ?>checked<?php endif; ?> name='chun_tx' key='1' value="1" />纯图形</label></li>
<li><label><input type="checkbox" <?php if(($con["chun_num"]) == "1"): ?>checked<?php endif; ?> key='1' name='chun_num' value="1"/>纯数字</label></li>
<li><label><input type="checkbox" key='2' name='chinese' <?php if(($con["chinese"]) == "1"): ?>checked<?php endif; ?> value='1' />包含中文</label></li>
<li><label><input type="checkbox" key='2'  name='english' <?php if(($con["english"]) == "1"): ?>checked<?php endif; ?> value='1' />包含英文</label></li>
<li><label><input type="checkbox" key='2' <?php if(($con["tuxing"]) == "1"): ?>checked<?php endif; ?>  name='tuxing' value='1'/>包含图形</label></li>
<li><label><input type="checkbox" key='2' <?php if(($con["numbers"]) == "1"): ?>checked<?php endif; ?>  name='numbers' value='1' />包含数字</label></li>
</ul>
</div>
</div>
</li>
<li><a id='ch_num'>汉字字数</a>
<div class="column_6">
<div class="column">
<ul>
<?php $hz_arr=array('1个汉字'=>'1,1','2个汉字'=>'2,2','3个汉字'=>'3,3','4个汉字'=>'4,999'); $con['ch_num']=explode(',', $con['ch_num']); $con['ch_num'][1]=$con['ch_num'][0]; if($con['ch_num'][0]==4){ $con['ch_num'][1]=999; } $con['ch_num']=join(',',$con['ch_num']); ?>

<?php if(is_array($hz_arr)): $i = 0; $__LIST__ = $hz_arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $checked=($con['ch_num']==$vo)?'checked':''; ?>
<li><label><input type="radio" name="ch_num" value="<?php echo ($vo); ?>" <?php echo ($checked); ?>/><?php echo ($key); ?></label></li><?php endforeach; endif; else: echo "" ;endif; ?>
<li><label><input type="checkbox"  name="hzall" value='1' checked/>包含所选及以上</label></li>
</ul>
</div>
</div>
</li>
<li><a id='en_num'>英文字数</a>
<div class="column_6">
<div class="column">
<ul>
<?php $zm_arr=array('1个字母'=>'1,1','2个字母'=>'2,2','3个字母'=>'3,3','4个字母'=>'4,4','5个字母'=>'5,5','6个字母'=>'6,6','7个字母'=>'7,7','8个字母'=>'8,999'); $con['en_num']=explode(',', $con['en_num']); $con['en_num'][1]=$con['en_num'][0]; if($con['en_num'][0]==4){ $con['en_num'][1]=999; } $con['en_num']=join(',',$con['en_num']); ?>
<?php if(is_array($zm_arr)): $i = 0; $__LIST__ = $zm_arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $checked=($con['en_num']==$vo)?'checked':''; ?>
<li><label><input type="radio" name="en_num" value="<?php echo ($vo); ?>" <?php echo ($checked); ?>/><?php echo ($key); ?></label></li><?php endforeach; endif; else: echo "" ;endif; ?> 
<li><label><input type="checkbox"  name="zmall" value='1' checked/>包含所选及以上</label></li>
</ul>
</div>
</div>
</li>
<li><a id='regdate'>注册年限</a>
<div class="column_6">
<div class="column">
<ul>
<?php $zc_arr=array('已注册1年以下'=>'0,1','已注册1年以上'=>'1,999','已注册2年以上'=>'2,999','已注册3年以上'=>'3,999','已注册4年以上'=>'4,999','已注册5年以上'=>'5,999'); ?>
<?php if(is_array($zc_arr)): $i = 0; $__LIST__ = $zc_arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $checked=($con['regdate']==$vo)?'checked':''; ?>
<li><label><input  type="radio" name="regdate" value="<?php echo ($vo); ?>" <?php echo ($checked); ?>/><?php echo ($key); ?></label></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>
</div>
</li>
</ul>
</dd>
</dl>
<dl><dt></dt><dd><input type="submit" name="Submit" value="搜索" class="btn" /></dd></dl>
</ul>
</div>
</form>
<!--快捷搜索 end-->

</div>
</div>

<div id="classbox">
<div class="leftbox">
<!--商标分类-->
<div class="tmclass">
<h2>商标分类<a href="<?php echo U('Index/tradeIndex');?>" target="_blank">第十版《类似商标和服务分类表》</a></h2>
<ul>
<?php if(is_array($fenlei_all)): $i = 0; $__LIST__ = $fenlei_all;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php $urlname='Index/tmclass?id='.$key;echo U($urlname); ?>" title="<?php echo ($vo["info"]); ?>"><?php if(($vo["hot"]) == "1"): ?><em><?php endif; ?>第<?php if(($vo["cate_id"]) == "46"): ?>25<?php else: echo ($vo["cate_id"]); endif; ?>类-<?php echo ($vo["cate_name"]); ?>(<?php echo ($vo["count"]); ?>)<?php if(($vo["hot"]) == "1"): ?></em><?php endif; ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>
<!--商标分类 end-->
<!--特价商标-->
<div class="c_setbox">
<div class="title">
<dl>
<h2>本周特价商标</h2>
<?php if(is_array($gettejia)): $i = 0; $__LIST__ = $gettejia;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><dt id="norTabBox<?php echo ($i); ?>" onclick="setTab('norTabBox',<?php echo ($i); ?>,3)" title="<?php echo $sblist[$vo['name']]; ?>" <?php if($i == 1): ?>class="hover"<?php endif; ?>>第<?php echo ($vo["name"]); ?>类</dt><?php endforeach; endif; else: echo "" ;endif; ?>
</dl>
</div>
<?php $dd=1; ?>
<?php if(is_array($gettejia)): $i = 0; $__LIST__ = $gettejia;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div id="con_norTabBox_<?php echo ($dd); ?>" class="contable" <?php if($dd == 1): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
<ul>
<?php unset($vo['name']);$dd++; ?>
<?php if(is_array($vo)): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?><li><a href="<?php $urlname='Index/tmdetail?id='.$voo['tm_id'];echo U($urlname); ?>" target="_blank" title="<?php echo ($voo["tm_name"]); ?>"><img src="<?php if(($voo["is_fine"]) == "1"): echo C('PIC12');?>/<?php echo ($voo["tm_id"]); else: echo C('PIC4');?>/<?php echo ($voo["tm_id"]); endif; ?>" alt="<?php echo ($voo["tm_name"]); ?>" /><p><?php echo (subtext($voo["tm_name"],5)); ?>&nbsp;&nbsp;ID:<?php echo ($voo["tm_id"]); ?></p></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
<!--特价商标 end-->
</div>

<div class="rightbox">
<!--联系电话-->
<div class="contactbox">
<h2>联系电话<a href="<?php echo U('Article/index',array('id'=>3));?>" target="_blank" rel="nofollow">查看详细值班电话...</a></h2>
<ul>
<li><b>24小时询价热线（全国）：</b><strong>400-888-1139</strong></li>
<li><b>广州电话（询价及办理手续）：</b><em>020-38819075</em><em>020-38866371</em><em>020-38866172</em><em>020-38810791</em></li>
<li class="mobi"><b>24小时服务热线：</b>
<?php if(is_array($tel)): $i = 0; $__LIST__ = $tel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><em><?php echo ($vo["tel"]); ?></em><?php endforeach; endif; else: echo "" ;endif; ?>
</li>
<li><b>北京电话：仅办理手续</b><em>010-62218730</em><em>010-62215195</em></li>
<li><b>杭州电话：仅办理手续</b><em>0571-56278880</em><em>0571-87850793</em></li>
<li><b>香港电话：</b><em>00852-30788896</em></li>
</ul>
<i><a href="<?php echo U('Index/kefu');?>" target="_blank"><img src="<?php echo C('HTMLPATH');?>images/kf.jpg" alt="在线客服" /></a></i>
</div>
<!--联系电话 end-->
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
  $.get("<?php echo U('Index/tuijiansb');?>",function(data,status){
    $('.tuijiansb').html(data);
  });
});
</script>
<!--推荐商标-->
<div id="all_conbox" class='tuijiansb'>
</div>
<div id="all_conbox">
<h2>推荐商标<?php echo (htmlspecialchars_decode($tuijianurl["22"])); ?></h2>
<div class="leftbox">
<?php if(is_array($gettuijian["0"])): $i = 0; $__LIST__ = array_slice($gettuijian["0"],0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php $urlname='Index/tmdetail?id='.$vo['tm_id'];echo U($urlname); ?>" target="_blank" title="<?php echo ($vo["tm_name"]); ?>"><img src="<?php echo C('PIC15');?>/<?php echo ($vo["tm_id"]); ?>" alt="<?php echo ($vo["tm_name"]); ?>" /></a><?php endforeach; endif; else: echo "" ;endif; ?>
<?php echo (htmlspecialchars_decode($tuijianurl["34"])); ?></div>
<div class="minbox">
<ul>
<?php if(is_array($gettuijian["0"])): $i = 0; $__LIST__ = array_slice($gettuijian["0"],1,12,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php $urlname='Index/tmdetail?id='.$vo['tm_id'];echo U($urlname); ?>" target="_blank" title="<?php echo ($vo["tm_name"]); ?>"><img src="<?php if(($vo["is_fine"]) == "1"): echo C('PIC9');?>/<?php echo ($vo["tm_id"]); else: echo C('PIC4');?>/<?php echo ($vo["tm_id"]); endif; ?>" alt="<?php echo ($vo["tm_name"]); ?>" /></a><p><a href="<?php $urlname='Index/tmdetail?id='.$vo['tm_id'];echo U($urlname); ?>" target="_blank" title="<?php echo ($vo["tm_name"]); ?>" class="title"><?php echo (subtext($vo["tm_name"],8)); ?></a><a href="<?php $urlname='Index/tmclass?id='.$vo['tm_categories'];echo U($urlname); ?>" target="_blank" class="type" title="<?php echo $sblist[$vo['tm_categories']] ?>">第<?php echo ($vo["tm_categories"]); ?>类</a></p></li><?php endforeach; endif; else: echo "" ;endif; ?>

</ul>
</div>
<div class="rightbox">
<ul>
<?php if(is_array($gettuijian["0"])): $i = 0; $__LIST__ = array_slice($gettuijian["0"],13,12,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php $urlname='Index/tmdetail?id='.$vo['tm_id'];echo U($urlname); ?>" target="_blank" title="<?php echo ($vo["tm_name"]); ?>"><img src="<?php if(($vo["is_fine"]) == "1"): echo C('PIC13');?>/<?php echo ($vo["tm_id"]); else: echo C('PIC4');?>/<?php echo ($vo["tm_id"]); endif; ?>" alt="<?php echo ($vo["tm_name"]); ?>" /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
<?php if(is_array($gettuijian["0"])): $i = 0; $__LIST__ = array_slice($gettuijian["0"],25,2,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><p class="adimg"><a href="<?php $urlname='Index/tmdetail?id='.$vo['tm_id'];echo U($urlname); ?>" target="_blank" title="<?php echo ($vo["tm_name"]); ?>"><img src="<?php echo C('PIC16');?>/<?php echo ($vo["tm_id"]); ?>" alt="<?php echo ($vo["tm_name"]); ?>" /></a></p><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>
</div>
<div id="all_conbox">
<h2>推荐商标<?php echo (htmlspecialchars_decode($tuijianurl["23"])); ?></h2>
<div class="leftbox">
<?php if(is_array($gettuijian["1"])): $i = 0; $__LIST__ = array_slice($gettuijian["1"],0,1,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php $urlname='Index/tmdetail?id='.$vo['tm_id'];echo U($urlname); ?>" target="_blank" title="<?php echo ($vo["tm_name"]); ?>"><img src="<?php echo C('PIC15');?>/<?php echo ($vo["tm_id"]); ?>" alt="<?php echo ($vo["tm_name"]); ?>" /></a><?php endforeach; endif; else: echo "" ;endif; ?>
<?php echo (htmlspecialchars_decode($tuijianurl["35"])); ?>
</div>
<div class="minbox">
<ul>
<?php if(is_array($gettuijian["1"])): $i = 0; $__LIST__ = array_slice($gettuijian["1"],1,12,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php $urlname='Index/tmdetail?id='.$vo['tm_id'];echo U($urlname); ?>" target="_blank" title="<?php echo ($vo["tm_name"]); ?>"><img src="<?php if(($vo["is_fine"]) == "1"): echo C('PIC9');?>/<?php echo ($vo["tm_id"]); else: echo C('PIC4');?>/<?php echo ($vo["tm_id"]); endif; ?>" alt="<?php echo ($vo["tm_name"]); ?>" /></a><p><a href="<?php $urlname='Index/tmdetail?id='.$vo['tm_id'];echo U($urlname); ?>" target="_blank" title="<?php echo ($vo["tm_name"]); ?>" class="title"><?php echo (subtext($vo["tm_name"],8)); ?></a><a href="<?php $urlname='Index/tmclass?id='.$vo['tm_categories'];echo U($urlname); ?>" target="_blank" class="type" title="<?php echo $sblist[$vo['tm_categories']] ?>">第<?php echo ($vo["tm_categories"]); ?>类</a></p></li><?php endforeach; endif; else: echo "" ;endif; ?>

</ul>
</div>
<div class="rightbox">
<ul>
<?php if(is_array($gettuijian["1"])): $i = 0; $__LIST__ = array_slice($gettuijian["1"],13,12,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php $urlname='Index/tmdetail?id='.$vo['tm_id'];echo U($urlname); ?>" target="_blank" title="<?php echo ($vo["tm_name"]); ?>"><img src="<?php if(($vo["is_fine"]) == "1"): echo C('PIC13');?>/<?php echo ($vo["tm_id"]); else: echo C('PIC4');?>/<?php echo ($vo["tm_id"]); endif; ?>" alt="<?php echo ($vo["tm_name"]); ?>" /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
<?php if(is_array($gettuijian["1"])): $i = 0; $__LIST__ = array_slice($gettuijian["1"],25,2,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><p class="adimg"><a href="<?php $urlname='Index/tmdetail?id='.$vo['tm_id'];echo U($urlname); ?>" target="_blank" title="<?php echo ($vo["tm_name"]); ?>"><img src="<?php echo C('PIC16');?>/<?php echo ($vo["tm_id"]); ?>" alt="<?php echo ($vo["tm_name"]); ?>" /></a></p><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>
</div>
<!--推荐商标 end-->

<div id="classbox">
<div class="leftbox">
<!--最新更新商标-->
<div class="n_setbox">
<div class="title">
<dl>
<h2>最新更新商标</h2>
<?php if(is_array($zuijin)): $key = 0; $__LIST__ = $zuijin;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><dt id="newTabBox<?php echo ($key); ?>" <?php if(($key) == "1"): ?>class="hover"<?php endif; ?> onclick="setTab('newTabBox',<?php echo ($key); ?>,7)"><?php echo ($vo["name"]); ?></dt><?php endforeach; endif; else: echo "" ;endif; ?>

</dl>
</div>
<?php if(is_array($zuijin)): $key = 0; $__LIST__ = $zuijin;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($key % 2 );++$key;?><div id="con_newTabBox_<?php echo ($key); ?>" class="contable" <?php if(($key) == "1"): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
<ul>
<li>
<?php if(is_array($vo["down"])): $i = 0; $__LIST__ = $vo["down"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vvo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Index/indeustry',array('id'=>$vvo['id']));?>" target="_blank"><?php echo ($vvo["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?></li>
<div class="more">
<h3>最新商标</h3>
<?php if(is_array($vo["zuixin"])): $i = 0; $__LIST__ = $vo["zuixin"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vvo1): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Index/tmdetail',array('id'=>$vvo1['tm_id']));?>" target="_blank"><?php echo ($vvo1["tm_name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
</ul>
</div><?php endforeach; endif; else: echo "" ;endif; ?>

</div>
<!--最新更新商标 end-->

<!--求购信息-->
<div class="pur_w570">
<div class="plainbox">
<h2>求购信息<a href="<?php echo U('Article/demand',array('id'=>16));?>" target="_blank" rel="nofollow">更多...</a></h2>
<ul>
<?php if(is_array($qiugou)): $i = 0; $__LIST__ = $qiugou;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><em>[商标买卖]</em><a href="<?php echo U('Article/demandinfo',array('aid'=>$vo['id']));?>" target="_blank" class="w570"><?php echo ($vo["title"]); ?><i><?php echo (date("Y/m/d",$vo["time"])); ?></i></a></li><?php endforeach; endif; else: echo "" ;endif; ?>

</ul>
</div>
</div>
<!--求购信息 end-->

<!--动态商标发布量-->
<div class="pur_w310">
<div class="plainbox">
<h2>动态商标发布量<em>共<b>45</b>类<b><?php echo ($fenlei_order_a); ?></b>枚待转让商标</em></h2>
<ul>

<?php if(is_array($fenlei_order)): $i = 0; $__LIST__ = array_slice($fenlei_order,0,5,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="none"><u class="n<?php echo ($i); ?>"></u><a href="<?php $urlname='Index/tmclass?id='.$vo['cate_id'];echo U($urlname); ?>" target="_blank" class="w310">第<?php if(($vo["cate_id"]) == "46"): ?>25<?php else: echo ($vo["cate_id"]); endif; ?>类商标-<?php echo ($vo["cate_name"]); ?><i><?php echo ($vo["count"]); ?></i></a></li><?php endforeach; endif; else: echo "" ;endif; ?>

</ul>
</div>
</div>
<!--动态商标发布量 end-->
</div>

<div class="rightbox">
<div class="artbox">
<h2>帮助中心<a href="<?php echo U('Article/news',array('id'=>14,'tid'=>27));?>" target="_blank" rel="nofollow">更多...</a></h2>
<ul>
<?php $helplist=getNews(28,8); ?>
<?php if(is_array($helplist)): foreach($helplist as $key=>$tmnew): ?><li><em>[品牌转让帮助]</em><a href='<?php echo U('Article/info',array('id'=>7,'aid'=>$tmnew['id'],'tid'=>6));?>'><?php echo ($tmnew["post_title"]); ?></a></li><?php endforeach; endif; ?>
</ul>
</div>
<div class="casebox">
<h2>成功案例<a href="<?php echo U('Article/news',array('id'=>35,'tid'=>6));?>" target="_blank">更多...</a></h2>
<div class="rollbox">
<ul>
		<?php if(is_array($lists)): $k = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><li><b>NO.<?php echo ($k+1); ?></b><a href="<?php echo U('Article/info',array('id'=>$vo['term_id'],'aid'=>$vo['id'],'tid'=>6));?>" target="_blank">第<?php echo ($vo["term_id"]); ?>类商标<?php if(strlen($vo['post_title']) > 10): echo (mb_substr($vo["post_title"],0,10,'utf-8')); ?>...<?php else: echo ($vo["post_title"]); endif; ?>成功转让</a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>
</div>
</div>
</div>

<div id="all_span">

<div id="all_span">
<!--新闻资讯-->
<div class="infor">
<div class="i_setbox">
<div class="title">
<dl>
<dt id="inTabBox1" onclick="setTab('inTabBox',1,8)" class="hover">关于华唯</dt>
<dt id="inTabBox2" onclick="setTab('inTabBox',2,8)">商标新闻</dt>
<dt id="inTabBox3" onclick="setTab('inTabBox',3,8)">知识产权新闻</dt>
<dt id="inTabBox4" onclick="setTab('inTabBox',4,8)">品牌转让</dt>
<dt id="inTabBox5" onclick="setTab('inTabBox',5,8)">企业管理</dt>
<dt id="inTabBox6" onclick="setTab('inTabBox',6,8)">商标知识</dt>
<dt id="inTabBox7" onclick="setTab('inTabBox',7,8)">商标法律</dt>
<dt id="inTabBox8" onclick="setTab('inTabBox',8,8)">商标问答</dt>
</dl>
<!--推荐图-->
<div class="foimg">
<script>
var box =new PPTBox();
box.width = 300; //宽度
box.height = 174;//高度
box.autoplayer = 3;//自动播放间隔时间
var a="http://192.168.1.192<?php echo ($slide["16"]["ad_pic"]); ?>";
var b="http://192.168.1.192<?php echo ($slide["17"]["ad_pic"]); ?>";
//box.add({"url":"图片地址","title":"悬浮标题","href":"链接地址"})
box.add({"url":a,"href":"{$slide.16.ad_url}"})
box.add({"url":b,"href":"{$slide.17.ad_url}"})
box.show();
</script>
</div>
<!--推荐图 end-->

</div>
<div id="con_inTabBox_1" class="contable" style="display:block;">
<div class="more"><a href="<?php echo U('Article/news',array('id'=>14,'tid'=>1));?>" target="_blank">更多...</a></div>
<ul>
<p>华唯商标转让网是由华唯环球（武汉）科技有限公司、华唯环球国际设立的行业门户，旗下华唯知识产权、中唯企业是商标行业知名的企业，全国较早成立的商标代理机构，特别是在商标转让领域，盘活闲置商标几千例，日前，华唯商标所拥有的待转让商标资源全国第一，商标交易量全国第一，华唯商标转让是全国最大最全的商标转让网。华唯商标目前在杭州，北京及广州设有直属企业，在全国超过十个地方设有办事处。能为您提供全国性的知识产权服务，我们在全国各地的商标转让成交案例比比皆是。</p>
<?php $abouts=getNews(14,4); ?>
<?php if(is_array($abouts)): foreach($abouts as $key=>$about): $time=strtotime($about['post_date']); ?>
<li><em><?php echo (date("Y/m/d",$time)); ?></em><a href='<?php echo U('Article/info',array('id'=>14,'aid'=>$about['id'],'tid'=>1));?>' ><?php echo ($about["post_title"]); ?></a></li><?php endforeach; endif; ?>
</ul>
</div>
<div id="con_inTabBox_2" class="contable" style="display:none;">
<div class="more"><a href="<?php echo U('Article/news',array('id'=>7,'tid'=>6));?>" target="_blank">更多...</a></div>
<ul>
<?php $tmnews=getNews(7,7); ?>
<?php if(is_array($tmnews)): foreach($tmnews as $key=>$tmnew): $time=strtotime($tmnew['post_date']); ?>
<li><em><?php echo (date("Y/m/d",$time)); ?></em><a href='<?php echo U('Article/info',array('id'=>7,'aid'=>$tmnew['id'],'tid'=>6));?>' ><?php echo ($tmnew["post_title"]); ?></a></li><?php endforeach; endif; ?>
</ul>
</div>
<div id="con_inTabBox_3" class="contable" style="display:none;">
<div class="more"><a href="<?php echo U('Article/news',array('id'=>11,'tid'=>6));?>" target="_blank">更多...</a></div>
<ul>
<?php $rights=getNews(11,7); ?>
<?php if(is_array($rights)): foreach($rights as $key=>$right): $time=strtotime($right['post_date']); ?>
<li><em><?php echo (date("Y/m/d",$time)); ?></em><a href='<?php echo U('Article/info',array('id'=>11,'aid'=>$right['id'],'tid'=>6));?>' ><?php echo ($right["post_title"]); ?></a></li><?php endforeach; endif; ?>
</ul>
</div>
<div id="con_inTabBox_4" class="contable" style="display:none;">
<div class="more"><a href="<?php echo U('Article/transfer',array('id'=>12,'tid'=>6));?>" target="_blank">更多...</a></div>
<ul>
<?php $transfers=getTransfer(2,7); ?>
<?php if(is_array($transfers)): foreach($transfers as $key=>$transfer): ?><li><em><?php echo (date("Y/m/d",$transfer["time"])); ?></em><a href='<?php echo U('Article/transferinfo',array('id'=>12,'aid'=>$transfer['id'],'tid'=>6));?>' >第<?php echo ($transfer["cate_id"]); ?>类<?php echo ($transfer["tm_name"]); ?> 注册号:<?php echo ($transfer["regnum"]); ?> 申请人:<?php echo ($transfer["applicant"]); ?> 价格:<?php echo ($transfer["price"]); ?></li><?php endforeach; endif; ?>
</ul>
</div>
<div id="con_inTabBox_5" class="contable" style="display:none;">
<div class="more"><a href="<?php echo U('Article/news',array('id'=>13,'tid'=>6));?>" target="_blank">更多...</a></div>
<ul><?php $enterprises=getNews(13,7); ?>
<?php if(is_array($enterprises)): foreach($enterprises as $key=>$enterprise): $time=strtotime($enterprise['post_date']); ?>
<li><em><?php echo (date("Y/m/d",$time)); ?></em><a href='<?php echo U('Article/info',array('id'=>13,'aid'=>$enterprise['id'],'tid'=>6));?>' ><?php echo ($enterprise["post_title"]); ?></a></li><?php endforeach; endif; ?>
</ul>
</div>
<div id="con_inTabBox_6" class="contable" style="display:none;">
<div class="more"><a href="<?php echo U('Article/news',array('id'=>10,'tid'=>6));?>" target="_blank">更多...</a></div>
<ul>
<?php $tmknowledges=getNews(10,7); ?>
<?php if(is_array($tmknowledges)): foreach($tmknowledges as $key=>$tmknowledge): $time=strtotime($tmknowledge['post_date']); ?>
<li><em><?php echo (date("Y/m/d",$time)); ?></em><a href='<?php echo U('Article/info',array('id'=>10,'aid'=>$tmknowledge['id'],'tid'=>6));?>' ><?php echo ($tmknowledge["post_title"]); ?></a></li><?php endforeach; endif; ?>
</ul>
</div>
<div id="con_inTabBox_7" class="contable" style="display:none;">
<div class="more"><a href="<?php echo U('Article/news',array('id'=>9,'tid'=>6));?>" target="_blank">更多...</a></div>
<ul>
<?php $tmlaws=getNews(9,7); ?>
<?php if(is_array($tmlaws)): foreach($tmlaws as $key=>$tmlaw): $time=strtotime($tmlaw['post_date']); ?>
<li><em><?php echo (date("Y/m/d",$time)); ?></em><a href='<?php echo U('Article/info',array('id'=>9,'aid'=>$tmlaw['id'],'tid'=>6));?>' ><?php echo ($tmlaw["post_title"]); ?></a></li><?php endforeach; endif; ?>
</ul>
</div>
<div id="con_inTabBox_8" class="contable" style="display:none;">
<div class="more"><a href="<?php echo U('Article/news',array('id'=>8,'tid'=>6));?>" target="_blank">更多...</a></div>
<ul>
<?php $tmasks=getNews(8,7); ?>
<?php if(is_array($tmasks)): foreach($tmasks as $key=>$tmask): $time=strtotime($tmask['post_date']); ?>
<li><em><?php echo (date("Y/m/d",$time)); ?></em><a href='<?php echo U('Article/info',array('id'=>8,'aid'=>$tmask['id'],'tid'=>6));?>' ><?php echo ($tmask["post_title"]); ?></a></li><?php endforeach; endif; ?>
</ul>
</div>
</div>
</div>
<!--新闻资讯 end-->



<div class="connbox">
<h2>关注有惊喜</h2>
<ul>
<p><img src="<?php echo C('HTMLPATH');?>images/weixin.jpg" class="wx" />
<dfn>亲，扫一扫吧<br/>不会？点击<a href="weixin/index.html" target="_blank">查看详细教程！</a></dfn>
</p>
</ul>
</div>
</div>

<div class="adimgbox">
<ul>
<li><a href="<?php echo ($slide["18"]["ad_url"]); ?>" target="_blank"><img src="http://192.168.1.192<?php echo ($slide["18"]["ad_pic"]); ?>" /></a></li>
<li><a href="<?php echo ($slide["19"]["ad_url"]); ?>" target="_blank"><img src="http://192.168.1.192<?php echo ($slide["19"]["ad_pic"]); ?>" /></a></li>
<li class="last"><a href="<?php echo ($slide["20"]["ad_url"]); ?>" target="_blank"><img src="http://192.168.1.192<?php echo ($slide["20"]["ad_pic"]); ?>" /></a></li>
</ul>
</div>
</div>
<div class="clear"></div>

<!--底部-->
<div id="footer">
<div class="fLink">
<h2>友情链接</h2>
<ul>
<?php $links=M('Links')->select(); ?>
<?php if(is_array($links)): foreach($links as $key=>$link): $json=json_decode(htmlspecialchars_decode($link['show_where']),true); ?>
<?php if(ACTION_NAME == 'index'): if(($json['index']) == "1"): ?><a href="<?php echo ($link["link_url"]); ?>" target="<?php echo ($link["link_target"]); ?>"><?php echo ($link["link_name"]); ?></a><?php endif; ?>
<?php elseif((ACTION_NAME == 'tmclass') AND (!isset($_GET['page']))): ?>
	<?php if(is_array($json['cate'])): foreach($json['cate'] as $key=>$vo): if(($vo) == $_GET['id']): ?><a href="<?php echo ($link["link_url"]); ?>" target="<?php echo ($link["link_target"]); ?>"><?php echo ($link["link_name"]); ?></a><?php endif; endforeach; endif; ?>
<?php elseif((ACTION_NAME == 'tmclass') AND (isset($_GET['page']))): ?>
	<?php if(is_array($json['page'])): foreach($json['page'] as $key=>$vo): if(($vo) == $_GET['id']): ?><a href="<?php echo ($link["link_url"]); ?>" target="<?php echo ($link["link_target"]); ?>"><?php echo ($link["link_name"]); ?></a><?php endif; endforeach; endif; ?>
<?php elseif(ACTION_NAME == 'tmdetail'): ?>
	<?php if(($json['tmdetail']) == "1"): ?><a href="<?php echo ($link["link_url"]); ?>" target="<?php echo ($link["link_target"]); ?>"><?php echo ($link["link_name"]); ?></a><?php endif; ?>
<?php else: ?>
	<?php if(($json['other']) == "1"): ?><a href="<?php echo ($link["link_url"]); ?>" target="<?php echo ($link["link_target"]); ?>"><?php echo ($link["link_name"]); ?></a><?php endif; endif; endforeach; endif; ?>
</ul>
</div>
<div class="fonbox">
<div class="contact">
<h2><em>非工作时间也可以直接拨打手机热线：
<?php if(is_array($tel)): $i = 0; $__LIST__ = $tel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><strong><?php echo ($vo["tel"]); ?></strong><?php endforeach; endif; else: echo "" ;endif; ?>
</em><b>24小时服务热线：400-888-1139</b></h2>
<ul>
<li class="phone"><h3>北京电话（仅办理手续）：</h3>010-62218730（三线）、62215195</li>
<li class="phone"><h3>广州电话（询价及办理手续）：</h3>020-38819075、38866371、38690351、38810791、38866172、38808153、38807996、38813114、38846890、38817890</li>
<li class="phone"><h3>杭州电话(仅办理手续）：</h3>0571-56278880（三线）、87850793</li>
<li class="phone"><h3>香港电话：</h3>00852-30788896 00852-30789989</li>
<li class="site"><h3>北京地址：</h3>北京市丰台区广安路9号院国投财富广场(4号楼)306 邮编：100073</li>
<li class="site"><h3>广州地址：</h3>广州市天河区体育西路111号建和中心29层（全层）邮编：510620</li>
<li class="site"><h3>杭州地址：</h3>杭州市下城区凤起路139号1栋202 邮编：310003</li>
<li class="site"><h3>香港地址：</h3>香港湾仔轩尼诗道289-295号朱钧记商业中心16楼</li>
</ul>
</div>
<div class="clear"></div>
<div class="copyright">
<p><em><a href="<?php echo U('Article/index',array('id'=>1,'tid'=>1));?>" target="_blank">关于我们</a></em> | <em><a href="<?php echo U('Article/news',array('id'=>7,'tid'=>6));?>" target="_blank">新闻资讯</a></em> | <em><a href="<?php echo U('Article/index',array('id'=>25));?>" target="_blank">诚聘英才</a></em> | <em><a href="<?php echo U('Article/index',array('id'=>21));?>" target="_blank">版权声明</a></em> | <em><a href="<?php echo U('Article/index',array('id'=>22));?>" target="_blank">服务条款</a></em> | <em><a href="<?php echo U('Article/index',array('id'=>23));?>" target="_blank">法律声明</a></em> | <em><a href="<?php echo U('Article/help',array('id'=>28,'tid'=>27));?>" target="_blank">帮助中心</a></em> | <em><a href="<?php echo U('Article/index',array('id'=>24));?>" target="_blank">联系我们</a></em> | <em><a href="<?php echo U('Article/index',array('id'=>26));?>" target="_blank">网站地图</a></em></p>
<?php if(S(md5('copyright'))): $copyright=S(md5('copyright')); ?>
<?php else: ?>
<?php $copyright=htmlspecialchars_decode(D('ad')->where('ad_id = 36')->getField('ad_content'));S(md5('copyright'),$copyright,3600*24); endif; ?>
<?php echo ($copyright); ?>
</div>
</div>
</div>
<!--底部 end-->

<script type="text/javascript" src="<?php echo C('HTMLPATH');?>js/jquery-layer.js"></script>
<script type="text/javascript" src="<?php echo C('HTMLPATH');?>js/leftmenu.js"></script>
<script>//成功案例滚动
$(function(){ 
var $this = $(".rollbox"); 
var scrollTimer; 
$this.hover(function(){ 
clearInterval(scrollTimer); 
},function(){ 
scrollTimer = setInterval(function(){ 
scrollNews( $this ); 
}, 2000 ); 
}).trigger("mouseout"); 
}); 
function scrollNews(obj){ 
var $self = obj.find("ul:first"); 
var lineHeight = $self.find("li:first").height(); 
$self.animate({ "margin-top" : -lineHeight +"px" },600 , function(){ 
$self.css({"margin-top":"0px"}).find("li:first").appendTo($self); 
}) 
} 
</script>
</body>
</html>