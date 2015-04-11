<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo ($tmpl_info["title"]); ?></title>
<meta name="Keywords" content="<?php echo ($tmpl_info["keywords"]); ?>" />
<meta name="Description" content="<?php echo ($tmpl_info["description"]); ?>" />
<link rel="stylesheet" href="<?php echo C('HTMLPATH');?>css/main.css">
<link rel="stylesheet" href="<?php echo C('HTMLPATH');?>css/tmStyle.css">
<link rel="stylesheet" href="<?php echo C('HTMLPATH');?>css/ion.rangeSlider.css"/><!--滑块样式-->
<script type="text/javascript" src="<?php echo C('HTMLPATH');?>js/jquery-1.7.1.js"></script>
<script type="text/javascript" src="<?php echo C('HTMLPATH');?>js/common.js"></script>
<script type="text/javascript" src="<?php echo C('HTMLPATH');?>js/ion.rangeSlider.js"></script>
<script type='text/javascript' src="<?php echo C('HTMLPATH');?>js/dropdown.js"></script>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
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
</head>

<body>
<!--登录-->
<div id="loginPop" class="ondiv" style="display:none;">
<div class="content">
<h2><span class="close"><input type="submit" id="" value="" class="closebtn" title="关闭" onclick="closeDiv('loginPop')" /></span>用户登录</h2>
<ul class="linebox">
<div class="leftbox">
<ul>
<h4>欢迎来到全国最大商标网站 -</h4>
<h3>华唯商标转让网</h3>
<li><input type="button" onclick='javascript:window.location.href="<?php echo U("User/reg");?>"' value="马上注册" class="btn" /></li>
<h4>您也可以使用以下方式直接登录：</h4>
<li><a href="#" title="QQ登录"><img src="<?php echo C('HTMLPATH');?>images/qqLogin.png" /></a> <a href="#" title="新浪微博登录"><img src="<?php echo C('HTMLPATH');?>images/sinaLogin.png" /></a></li>
</ul>
</div>
<div class="rightbox">
<ul>
<h4>用户登录</h4>
<form action='<?php echo U("User/index");?>' method='post' />
<li>用户名：<input type="text" name="name" class="ipt" /></li>
<li>密　码：<input type="password" name="password" class="ipt" /></li>
<li><input type="submit" name="Submit" value="登录" class="btn" /></li>
</form>
<li><a href="<?php echo U('User/getPwdWay');?>" target="_blank">忘记密码？果断找回。</a></li>
</ul>
</div>
<div class="clear"></div>
</ul>
</div>
</div>
<!--登录 end-->

<!--图形编码-->
<div id="graphicPop" class="ondiv" style="display:none;">
<div id="container"></div>

<div class="content">
<h2><span class="close"><input type="button" id="" value="" class="closebtn" title="关闭" subkey='25code' /></span>选择图形编码</h2>
<ul class="tree">
<?php if(is_array($txcode)): $i = 0; $__LIST__ = $txcode;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $checked=(in_array($key,explode(',',$con['25code'])))?'checked="checked"':''; ?>
<li><label><input type="checkbox" getkey='25code' owkey='13' value="<?php echo ($key); ?>" <?php echo ($checked); ?>/><span><?php echo ($key); ?> <?php echo ($vo["name"]); ?></span></label>
<ul style="display:none;" attr_ul='toggle_ul'>
<?php $upkey=$key; ?>
<?php if(is_array($vo["down"])): $i = 0; $__LIST__ = $vo["down"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vod): $mod = ($i % 2 );++$i;?><li><?php echo ($upkey); ?>.<?php echo ($key); ?> <?php echo ($vod); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
<p class="ptrbtm"><input type="button" subkey='unlimi'  unkey='13' value="不限" class="btn"  style='margin-right:10px;'/><input type="button" subkey='25code' value="确定" class="btn"  /></p>
</div>
</div>
<!--图形编码 end-->
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
<div class="all-sort1">
<h2 id="div_h2" >适用行业分类 <img id="img1" src="<?php echo C('HTMLPATH');?>images/ico_down.png" align="absmiddle"></h2>
<div class="showbox" id="tip1" style="display:none;">
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
</div>
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
<script type="text/javascript">

function owkey(){
	var b='';
	var k=0;
	$('[owkey]').each(function(){
    			if($(this).attr('checked')=='checked'){
					var owk_int = $(this).attr('owkey');
					owk_int = parseInt(owk_int);
					if(owk_int>8){
						return true;
					}
    					if(k<6){
    						b=b+'<i>'+$(this).parent().text()+'</i>';
    					}else{
    						if(k==6){
    							b=b+'<i>...</i>';
    						}
    					}
    					k=k+1;
    			}
		});
		if(b==''){
			$('#25lei_text').html('<i>暂无选择条件</i>');	
		}else{
			$('#25lei_text').html('<b style="color:#f30;">'+b+'</b>');
		}
}
function sag25(v){
		var a='';
		var b='';
		var k=0;
		$('[getkey=25service]').each(function(){
			if($(this).val()!='如：手机'){
    					a=a+'<i>'+$(this).val()+'</i>';
			}
		});
		if(a==''){
			$('[getkey=25group]').each(function(){
    			if($(this).attr('checked')=='checked'){
    					if(k<4){
    						b=b+'<i>'+$(this).val()+'</i>';
    					}else{
    						if(k==4){
    							b=b+'<i>...</i>';
    						}
    					}
    					k=k+1;
    			}
			});
			if(b==''){
				if(v==1){
					che='<?php echo ($con["25group"]); ?>';
					if(che!=''){
						che=che.replace(',','</i><i>');
						che='<i>'+che+'</i>';
						$('#25sag').html(che);						
					}else{
						$('#25sag').html('<i>暂无定义</i>');
					}
				}else{
					$('#25sag').html('<i>暂无定义</i>');
				}
			}else{
				$('#25sag').html('<b style="color:#f30;">'+b+'</b>');
			}
			
		}else{
			$('#25sag').html('<b style="color:#f30;">'+a+'</b>');
		}
}
function sbtype(){
	var b='';
	$('#ch_num').hide();
	$('#en_num').hide();
	$('#chaxuntuxing').hide();
	$('[key]').each(function(){
    			if($(this).attr('checked')=='checked'){
    				var name=$(this).attr('name');
    				switch(name){
    					case 'chun_ch':
    						$('#ch_num').show();
    						break;
    					case 'chun_en':
    						$('#en_num').show();
    						break;
    					case 'chun_tx':
    						$('#chaxuntuxing').show();
    						break;
    					case 'chinese':
    						$('#ch_num').show();
    						break;
    					case 'english':
    						$('#en_num').show();
    						break;
    					case 'tuxing':
    						$('#chaxuntuxing').show();
    						break;
    				}
    						if(b==''){
    							b=$(this).parent().text();
    						}else{
    							b=b+','+$(this).parent().text();
    						}	
    			}
		});
		if(b==''){
			$('#sbtype').html('商标类型（中文/英文/图形/数字）');	
		}else{
			$('#sbtype').html('<b style="color:#f30;">'+"已选择 "+b+'</b>');
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
				b=b+"(包含以上)";
			}
			$('#ch_num').html('<b style="color:#f30;">'+"已选择 "+b+'</b>');
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
				b=b+"(包含以上)";
			}
			$('#en_num').html('<b style="color:#f30;">'+"已选择 "+b+'</b>');
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
			$('#regdate').html('<b style="color:#f30;">'+"已选择 "+b+'</b>');
		}
}
function cate(k){
	    	var a='';
	    	var k=<?php if($con["25group"] != ""): ?>1<?php else: ?>0<?php endif; ?>;
    		$('[checkedkey=cate]').each(function(){
    			if($(this).attr('checked')=='checked'){
    				if(a==''){
    					a=$(this).val();
    				}else{
    					if(k<4){
    						a=a+','+$(this).val();
    					}
    					if(k==4){
    						a=a+',...';
    					}
    					k=k+1;
    					
    				}
    			}
    		});
    		if(a==''){
				$('#category_text').html('未选择商标分类');
    		}else{
    			$('#category_text').html('已选择了'+a+'类');
    		}
    		if(a=="25"){
    			openP('more50', 50, 50, 'more');
    		}else{
    			$('#more50').hide();
    		}
    		if(k==1){
    			che='<?php echo ($con["25group"]); ?>';
    		}else{
    			var b='';
    			$('[getkey=25group]').each(function(){
	    			if($(this).attr('checked')=='checked'){
	    				if(b==''){
	    					b=$(this).val();
	    				}else{
	    					b=b+','+$(this).val();
	    				}
	    			}
			});
    			che=b;
    		}
    		$.get("<?php echo U('Index/getqunzu');?>?cate="+a+"&checked="+che,function(data,status){
				    $('#qunzu').html(data);
				  });
}
<?php $price=explode(',',$con['price']); ?>
$(document).ready(function(){
	var k1=<?php echo ((isset($price["0"]) && ($price["0"] !== ""))?($price["0"]):0); ?>;
	var k2=<?php echo ((isset($price["1"]) && ($price["1"] !== ""))?($price["1"]):50); ?>;
		if(k1==0 && k2==50){

		}else{
			$('.irs-min').show();
			$('.irs-max').show();
		}
    	$('.irs-from').text(k1);
    	$('.irs-to').text(k2);
    	var a1=8+k1*3.72+'px';
    	var a2=(194-(k1*3.72)-(50-k2)*3.72)+'px';
    	var a3=(194-(50-k2)*3.72)+'px';
    	var a4=k1*3.72+'px';
    	var a5=3+k1*3.66+'px';
    	var a6=(186-(50-k2)*3.66)+'px';
    	$('.irs-diapason').css({'left':a1,'width':a2});
    	$('.irs-slider.from').css('left',a4);
    	$('.irs-slider.to').css('left',a3);
    	$('.irs-from').css('left',a5);
    	$('.irs-to').css('left',a6);
	cate(1);
	owkey();
	sag25(1);
	sbtype();
	ch_num();
	en_num();
	regdate();
	var k25=<?php echo ($owkey); ?>;
	if(k25==1){
		$('#more50').show();
	}
	//初始化
	$('[subkey=25lei]').click(function(){
		owkey();
		closeDiv('fzPop');
	});
	$('[unkey]').click(function(){
		var a=$(this).attr("unkey");
		$('[owkey='+a+']').removeAttr('checked');
            ch_num();
            en_num();
            regdate();
	});
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
	$('[subkey=25service]').click(function(){
		sag25(0);
		closeDiv('groupPop');
	});
	$('[subkey=25code]').click(function(){
		var a='';
		$('[getkey=25code]').each(function(){
    			if($(this).attr('checked')=='checked'){
    				if(a==''){
    					a=$(this).val();
    				}else{
    					a=a+','+$(this).val();
    				}
    			}
    		});
		$('[name=25code]').val(a);
		closeDiv('graphicPop'); 
	});
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
    $('[checkedkey=cate]').each(function(){
    	$(this).click(function(){
    	cate(0);
    	})
    });
	$('[getkey=25code]').click(function(){
		var ul = $(this).parent().parent().find('ul');
		if(!$(this).attr('checked')){
			//ul.show();
			ul.toggle('slow');
		}else{
			//ul.hide();
			ul.toggle('slow');
		}
	});
	$('[attr_ul=toggle_ul]').click(function(){$(this).toggle('slow');});
});

</script>
<form action='<?php echo U("Index/search");?>' method="post" />
<!--定义群组-->
<div id="groupPop" class="ondiv" style="display:none;">
<div class="content">
<script type="text/javascript">
$(function(){
// 选择控制
$("#qunzu").click(function(){
	chk_status(2);
});
// 输入控制
$("[getkey=25service]").change(function(){
	chk_status(1);
});
// 选择和输入只能选择一种控制
function chk_status(type){
	if(!type){return ;}
	if(type == 1){
		var chk = false;
		$("[getkey=25service]").each(function(){
			var val = $(this).attr('value');
			var def = $(this).attr('attr_val');
			if(val && val != def){
				chk = true;
				return false;
			}
		});
		$("#qunzu").find('input').each(function(){
			$(this).attr('disabled', chk);
		});
		return ;
	}
	if(type==2){
		var chk = false;
		$('[getkey=25group]').each(function(){
			if($(this).attr('checked')=='checked'){
				chk = true; return false;
			}
		});
		$("[getkey=25service]").each(function(){
			$(this).attr('disabled', chk);
		});
		return ;
	}
}
});
</script>
<h2><span class="close"><input type="botton" id="" value="" subkey='25service' class="closebtn" title="关闭" /></span>选择群组</h2>
<ul class="cluster">
<div class="note">请选择直接输入服务或选择群组号(服务优先)：<br/>手动输入产品与群组只选一种进行搜索，在对商标分类表不了解的时候，两个选项较易产生逻辑矛盾的错误，造成搜不出结果。</div>
<div class="gro">包含具体商标/服务：
<?php if($con['25service']){ $servicelist=explode(',',$con['25service']); } for($i=0;$i<5;$i++){ if(!$servicelist[$i]){ $servicelist[$i]=''; } } ?>
<?php if(is_array($servicelist)): $i = 0; $__LIST__ = $servicelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type="text" value="<?php echo ((isset($vo ) && ($vo !== ""))?($vo ):'如：手机'); ?>" name='25service[]' getkey='25service' onfocus="if(this.value==this.attributes.attr_val.value)this.value='';" onblur="if(!this.value)this.value=this.attributes.attr_val.value;" attr_val="如：手机"/><?php endforeach; endif; else: echo "" ;endif; ?>
</div>

<div id='qunzu'>
	<center>还未选择分类</center>
</div>
<div class="clear"></div>
</ul>
<p class="ptrbtm"><input type="button" subkey='unlimi'  unkey='12' value="不限" class="btn"  style='margin-right:10px;'/><input type="button" subkey='25service' value="确定" class="btn"  /></p>
</div>
</div>
<!--定义群组 end-->
<!--25类条件-->
<div id="fzPop" class="ondiv" style="display:none;">
<div class="content">
<h2><span class="close"><input type="button" id="" subkey='25lei' value="" class="closebtn" title="关闭" /></span>25类适应风格类型搜索</h2>
<ul>
<dl>
<dt>适合性别</dt>
<dd class="unlimi"><label subkey='unlimi' unkey='1' class="on">不限</label></dd>
<dd><label><input type="checkbox" owkey='1' name='man' <?php if(($con["man"]) == "1"): ?>checked<?php endif; ?> value="1"/> 男性</label></dd>
<dd><label><input type="checkbox" owkey='1' name='women' <?php if(($con["women"]) == "1"): ?>checked<?php endif; ?> value="1" /> 女性</label></dd>
<dd><label><input type="checkbox" owkey='1' name='normal' <?php if(($con["normal"]) == "1"): ?>checked<?php endif; ?> value="1" /> 中性</label></dd>
</dl>
<dl>
<dt>大类风格</dt>
<dd class="unlimi"><label subkey='unlimi' unkey='2' class="on">不限</label></dd>
<dd><label><input type="checkbox" owkey='2' name='europe' <?php if(($con["europe"]) == "1"): ?>checked<?php endif; ?> value="1" /> 欧式</label></dd>
<dd><label><input type="checkbox" owkey='2' name='tradition' <?php if(($con["tradition"]) == "1"): ?>checked<?php endif; ?> value="1" /> 传统</label></dd>
</dl>
<dl>
<dt>适合产品</dt>
<dd class="unlimi"><label subkey='unlimi' unkey='3' class="on">不限</label></dd>
<dd><label><input type="checkbox" owkey='3' name="clothes" <?php if(($con["clothes"]) == "1"): ?>checked<?php endif; ?> value="1" /> 服装</label></dd>
<dd><label><input type="checkbox" owkey='3' name="shoes" <?php if(($con["shoes"]) == "1"): ?>checked<?php endif; ?> value="1" /> 鞋类</label></dd>
<dd><label><input type="checkbox" owkey='3' name="kids" <?php if(($con["kids"]) == "1"): ?>checked<?php endif; ?> value="1" /> 童装</label></dd>
</dl>
<dl>
<dt>产品风格</dt>
<dd class="unlimi"><label subkey='unlimi' unkey='4' class="on">不限</label></dd>
<dd><label><input type="checkbox" owkey='4'  name="formal" <?php if(($con["formal"]) == "1"): ?>checked<?php endif; ?> value="1" /> 正装/皮鞋/商务</label></dd>
<dd><label><input type="checkbox" owkey='4' name="relax" <?php if(($con["relax"]) == "1"): ?>checked<?php endif; ?> value="1"/> 休闲</label></dd>
<dd><label><input type="checkbox" owkey='4' name="sport" <?php if(($con["sport"]) == "1"): ?>checked<?php endif; ?> value="1"/> 运动</label></dd>
<dd><label><input type="checkbox" owkey='4'  name="tide" <?php if(($con["tide"]) == "1"): ?>checked<?php endif; ?> value="1"/> 潮流/现代</label></dd>
<dd><label><input type="checkbox" owkey='4'  name="rihan" <?php if(($con["rihan"]) == "1"): ?>checked<?php endif; ?> value="1"/> 日韩/卡娃依</label></dd>
<dd><label><input type="checkbox" owkey='4'  name="nation" <?php if(($con["nation"]) == "1"): ?>checked<?php endif; ?> value="1"/> 民族/古典</label></dd>
<dd><label><input type="checkbox" owkey='4'  name="street" <?php if(($con["street"]) == "1"): ?>checked<?php endif; ?> value="1"/> 街头/嬉皮士</label></dd>
<dd onclick="openP('more3', 3, 5, 'more')" class="more">更多<span id="state3" class="arrow-down"></span></dd>
<div class="subContent" id="more3" style="display:none;">
<ul>
<li><label><input type="checkbox" owkey='4'  name="tongqin" <?php if(($con["tongqin"]) == "1"): ?>checked<?php endif; ?> value="1"/> 通勤/OL</label></li>
<li><label><input type="checkbox" owkey='4'  name="china" <?php if(($con["china"]) == "1"): ?>checked<?php endif; ?> value="1"/> 中华元素</label></li>
<li><em class="other"><label><input type="checkbox" owkey='' name="qinlv" <?php if(($con["qinlv"]) == "1"): ?>checked<?php endif; ?> value="1"/> 波西米亚/情侣/小调</label></em></li>
</ul>
</div>
</dl>
<dl>
<dt>服装产品</dt>
<dd class="unlimi"><label subkey='unlimi' unkey='5' class="on">不限</label></dd>
<dd><label><input type="checkbox" owkey='5' name="underwear" <?php if(($con["underwear"]) == "1"): ?>checked<?php endif; ?> value="1"/> 内衣/卫衣</label></dd>
<dd><label><input type="checkbox" owkey='5' name="down" <?php if(($con["down"]) == "1"): ?>checked<?php endif; ?> value="1"/> 羽绒/毛衣/针织</label></dd>
<dd><label><input type="checkbox" owkey='5' name="uniform" <?php if(($con["uniform"]) == "1"): ?>checked<?php endif; ?> value="1"/> 制服/工作服</label></dd>
<dd><label><input type="checkbox" owkey='5' name="leather" <?php if(($con["leather"]) == "1"): ?>checked<?php endif; ?> value="1"/> 皮衣/西装/衬衫</label></dd>
<dd><label><input type="checkbox" owkey='5' name="pants" <?php if(($con["pants"]) == "1"): ?>checked<?php endif; ?> value="1"/> 裤子</label></dd>
<dd><label><input type="checkbox" owkey='5' name="skirt" <?php if(($con["skirt"]) == "1"): ?>checked<?php endif; ?> value="1"/> 裙子</label></dd>
<dd><label><input type="checkbox" owkey='5' name="elder" <?php if(($con["elder"]) == "1"): ?>checked<?php endif; ?> value="1"/> 中老年服装</label></dd>
<dd onclick="openP('more4', 4, 5, 'more')" class="more">更多<span id="state4" class="arrow-down"></span></dd>
<div class="subContent" id="more4" style="display:none;">
<ul>
<li><label><input type="checkbox" owkey='' name="jeans" <?php if(($con["jeans"]) == "1"): ?>checked<?php endif; ?> value="1"/> 牛仔</label></li>
<li><label><input type="checkbox" owkey='' name="other" <?php if(($con["other"]) == "1"): ?>checked<?php endif; ?> value="1"/> 其它</label></li>
</ul>
</div>
</dl>
<dl>
<dt>鞋类产品</dt>
<dd class="unlimi"><label subkey='unlimi' unkey='6' class="on">不限</label></dd>
<dd><label><input type="checkbox" owkey='6' name="sneaker" <?php if(($con["sneaker"]) == "1"): ?>checked<?php endif; ?> value="1"/> 波鞋/运动鞋</label></dd>
<dd><label><input type="checkbox" owkey='6' name="slipper" <?php if(($con["slipper"]) == "1"): ?>checked<?php endif; ?> value="1"/> 拖鞋/家居鞋</label></dd>
<dd><label><input type="checkbox" owkey='6' name="workshoes" <?php if(($con["workshoes"]) == "1"): ?>checked<?php endif; ?> value="1"/> 功能鞋/工作鞋</label></dd>
</dl>
<dl>
<dt>童装产品</dt>
<dd class="unlimi"><label subkey='unlimi' unkey='7' class="on">不限</label></dd>
<dd><label><input type="checkbox" owkey='7' name="midchild" <?php if(($con["midchild"]) == "1"): ?>checked<?php endif; ?> value="1"/> 中童</label></dd>
<dd><label><input type="checkbox" owkey='7' name="youngchild" <?php if(($con["youngchild"]) == "1"): ?>checked<?php endif; ?> value="1" /> 幼童</label></dd>
<dd><label><input type="checkbox" owkey='7' name="cartoon" <?php if(($con["cartoon"]) == "1"): ?>checked<?php endif; ?> value="1"/> 卡通</label></dd>
<dd><label><input type="checkbox" owkey='7' name="fairy" <?php if(($con["fairy"]) == "1"): ?>checked<?php endif; ?> value="1"/> 童话故事</label></dd>
</dl>
<dl>
<dt>商标特点</dt>
<dd class="unlimi"><label subkey='unlimi' unkey='8' class="on">不限</label></dd>
<dd class="o1"><label><input type="checkbox" owkey='8' name="foreign" <?php if(($con["foreign"]) == "1"): ?>checked<?php endif; ?> value="1"/> 有外文商标（除英文外）</label></dd>
<dd class="o1"><label><input type="checkbox" owkey='8'  name="story" <?php if(($con["story"]) == "1"): ?>checked<?php endif; ?> value="1"/> 有商标故事</label></dd>
<dd class="o1"><label><input type="checkbox" owkey='8' name="tophigh" <?php if(($con["tophigh"]) == "1"): ?>checked<?php endif; ?> value="1"/> 跟国际大牌商标擦边</label></dd>
<dd class="o1"><label><input type="checkbox" owkey='8' name="common" <?php if(($con["common"]) == "1"): ?>checked<?php endif; ?> value="1"/> 跟有名的商标擦边</label></dd>
</dl>
<div class="clear"></div>
<p><input type="button" name="Submit" value="确定" subkey='25lei' class="btn" /></p>
</ul>
</div>
</div>
<!--25类条件 end-->
<div class="mainbox">
<ul id="crumbs">您所在的位置：<a href="<?php echo C('INDEXPATH');?>">首页</a> &gt; <?php echo ($bread_nav); ?></ul>
<!--商标搜索-->
<div class="s_tabox">
<div class="title">
<dl>
<dt class="hover"><span id='category_text'><?php echo ((isset($category_text ) && ($category_text !== ""))?($category_text ):'未选择商标分类'); ?></span> <span class="slipbox" data-kone="b1">
<a href="javascript:void(0);">点击选择商标类型</a>
<div class="slipmore" style='display:none'>
<div class="mold">
<h4>请选择商标类型</h4>
<ul>
<?php if(is_array($sblist)): $i = 0; $__LIST__ = $sblist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $checked=(in_array($key,explode(',',$con['category'])))?'checked="checked"':''; ?>
<?php if(($key) == "25"): ?><label><input  checkedkey='cate' type="checkbox" name="category[]" value="<?php echo ($key); ?>" <?php echo ($checked); ?>/> <span>第25类</span></label>
<?php else: ?>
<label><input checkedkey='cate' type="checkbox" name="category[]" value="<?php echo ($key); ?>" <?php echo ($checked); ?>/>第<?php echo ($key); ?>类</label><?php endif; endforeach; endif; else: echo "" ;endif; ?>


</ul>

</div>
</div>
</span></dt>
<dt class="ot1"><a href="<?php echo U('Index/sameSearch');?>">同商标名多类</a></dt>
<dt class="ot1"><a href="<?php echo U('Index/tmWrapSearch');?>">商标包</a></dt>
<dt class="ot1"><a href="<?php echo U('Index/similarSearch');?>">近似搜索</a></dt>
<dt class="ot1"><a href="<?php echo U('Index/graphSearch');?>">图形搜索</a></dt>
<dt class="ot1"><a href="<?php echo U('Index/fzMold');?>">25类适应风格类型搜索</a></dt>
</dl>
</div>
<script type="text/javascript">
$(function(){
	$("#j_k_key dfn").click(function(){
		var chk = $(this).find('input[type=checkbox]').attr('checked');
		if(typeof(chk) == 'undefined'){
			$(this).removeClass('s_tabox_dfn_hover');
		}else{
			$(this).addClass('s_tabox_dfn_hover');
		}	
	});

});
</script>
<div class="contable" style="display:block;">
<ul class="pad">
<dl>
<dt>关键字</dt>
<dd class="m1" id="j_k_key">
<?php if($con["content1"] != ""): ?><input type='hidden' value='<?php echo ($con["content1"]); ?>' name='content1' /><?php endif; ?>
<input type="text" value="<?php echo ((isset($con["content"]) && ($con["content"] !== ""))?($con["content"]):'中文/英文/注册号/ID号'); ?>" name='content' class="ipt2" onfocus="if(this.value==this.attributes.attr_val.value)this.value='';" onblur="if(!this.value)this.value=this.attributes.attr_val.value;" attr_val="中文/英文/注册号/ID号"/>
<?php if(($con["before"]) == "1"): ?><dfn class="s_tabox_dfn_hover"><label><input type="checkbox"  name='before' value="1" checked /> 前包含</label></dfn>
	<?php else: ?>
<dfn><label><input type="checkbox"  name='before' value="1" /> 前包含</label></dfn><?php endif; ?>
<?php if(($con["middle"]) == "1"): ?><dfn class="s_tabox_dfn_hover"><label><input type="checkbox" name='middle' value="1" checked /> 任意包含</label></dfn>
	<?php else: ?>
<dfn><label><input type="checkbox" name='middle' value="1" /> 任意包含</label></dfn><?php endif; ?>
<?php if(($con["end"]) == "1"): ?><dfn class="s_tabox_dfn_hover"><label><input type="checkbox" name='end' value="1" checked /> 结尾包含</label></dfn>
	<?php else: ?>
<dfn><label><input type="checkbox" name='end' value="1" /> 结尾包含</label></dfn><?php endif; ?>
<?php if(($con["like"]) == "1"): ?><dfn class="s_tabox_dfn_hover"><label><input type="checkbox" name='like' value="1" checked /> 包含近似商标</label></dfn>
	<?php else: ?>
<dfn><label><input type="checkbox" name='like' value="1" /> 包含近似商标</label></dfn><?php endif; ?>

</dd>
</dl>

<dl>
<dt>商标类型</dt>
<dd class="m1">
<div>
<ul id="jDropDown">
<li><a id='sbtype' href="#"></a>
<div class="column_3">
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
<li><a id='ch_num' href="#" style='display:none;'></a>
<div class="column_3">
<div class="column">
<ul>
<?php $hz_arr=array('1个汉字'=>'1,1','2个汉字'=>'2,2','3个汉字'=>'3,3','4个汉字'=>'4,999'); $con['ch_num']=explode(',', $con['ch_num']); $con['ch_num'][1]=$con['ch_num'][0]; if($con['ch_num'][0]==4){ $con['ch_num'][1]=999; } $con['ch_num']=join(',',$con['ch_num']); ?>

<?php if(is_array($hz_arr)): $i = 0; $__LIST__ = $hz_arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $checked=($con['ch_num']==$vo)?'checked':''; ?>
<li><label><input type="radio" name="ch_num" owkey='9' value="<?php echo ($vo); ?>" <?php echo ($checked); ?>/><?php echo ($key); ?></label></li><?php endforeach; endif; else: echo "" ;endif; ?>
<li><label><input type="checkbox"  name="hzall" value='1' <?php if(($con["hzall"]) == "1"): ?>checked<?php endif; ?>/>包含所选及以上</label></li>
<li><label subkey='unlimi'  unkey='9' class="on">不限</label></li>
</ul>
</div>
</div>
</li>
<li><a id='en_num' href="#" style='display:none;'></a>
<div class="column_3">
<div class="column">
<ul>
<?php $zm_arr=array('1个字母'=>'1,1','2个字母'=>'2,2','3个字母'=>'3,3','4个字母'=>'4,4','5个字母'=>'5,5','6个字母'=>'6,6','7个字母'=>'7,7','8个字母'=>'8,999'); $con['en_num']=explode(',', $con['en_num']); $con['en_num'][1]=$con['en_num'][0]; if($con['en_num'][0]==4){ $con['en_num'][1]=999; } $con['en_num']=join(',',$con['en_num']); ?>
<?php if(is_array($zm_arr)): $i = 0; $__LIST__ = $zm_arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $checked=($con['en_num']==$vo)?'checked':''; ?>
<li><label><input type="radio" owkey='10' name="en_num" value="<?php echo ($vo); ?>" <?php echo ($checked); ?>/><?php echo ($key); ?></label></li><?php endforeach; endif; else: echo "" ;endif; ?> 
<li><label><input type="checkbox"  name="zmall" value='1' <?php if(($con["zmall"]) == "1"): ?>checked<?php endif; ?>/>包含所选及以上</label></li>
<li><label subkey='unlimi'  unkey='10' class="on">不限</label></li>
</ul>
</div>
</div>
</li>
<li><a id='regdate' href="#"></a>
<div class="column_3">
<div class="column">
<ul>
<?php $zc_arr=array('已注册1年以下'=>'0,1','已注册1年以上'=>'1,999','已注册2年以上'=>'2,999','已注册3年以上'=>'3,999','已注册4年以上'=>'4,999','已注册5年以上'=>'5,999'); ?>
<?php if(is_array($zc_arr)): $i = 0; $__LIST__ = $zc_arr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; $checked=($con['regdate']==$vo)?'checked':''; ?>
<li><label><input  type="radio" name="regdate" owkey='11' value="<?php echo ($vo); ?>" <?php echo ($checked); ?>/><?php echo ($key); ?></label></li><?php endforeach; endif; else: echo "" ;endif; ?>
<li><label subkey='unlimi'  unkey='11' class="on">不限</label></li>
</ul>
</div>
</div>
</li>
</ul>
</div>
</dd>
</dl>

<dl>
<dt>查询内容</dt>
<dd class="m3" id='chaxuntuxing' style='display:none;'>查询内容：
<input type="text" name='25code' value="<?php echo ((isset($con["25code"]) && ($con["25code"] !== ""))?($con["25code"]):'请输入商标图形编码'); ?>" onfocus="if(this.value==this.attributes.attr_val.value)this.value='';" onblur="if(!this.value)this.value=this.attributes.attr_val.value;" attr_val="请输入商标图形编码" class="ipt2"/>
<a href="javascript:void(0);" class="blue" onclick="showDiv('graphicPop')">选择图形编码</a>
</dd>
<dd class="m3">定义群组/服务：
<span id='25sag'><i>暂无定义</i></span><a href="javascript:void(0);" class="blue" onclick="showDiv('groupPop')">选择群组</a>
</dd>
</dl>
<dl class="cloth" id="more50" style="display:none;">
<dt>25类商标</dt>
<dd class="m2"><span id='25lei_text'><i>暂无选择条件</i></span> <a href="javascript:void(0);" class="blue" onclick="showDiv('fzPop')">重新选择搜索条件</a>
</dd>
</dl>
<div class="clear"></div>
</ul>
<p class="btm"><input type="submit" name="Submit" value="提交&#13;&#10;搜索" class="btn"/><br/>
<a href="<?php echo U('Index/search');?>">清空所有条件</a>
</p>

</div>
</div>
<!--商标搜索 end-->
<?php if($info == ''): ?><input type='hidden' name="discu" value="1" />
</form>
<?php elseif($info == 1): ?>
<input type='hidden' name="discu" value="1" />
</form>
<div class='clear'></div>
<center><h1 style="font-size:24px;margin:20px;">查无结果，如果你的各种搜索条件有矛盾，可能导致无结果，<br>
本站包括所有市面上可以卖的商标，如不知道如何查询，请咨询我们的在线客服
</h1></center>
<?php else: ?>
<input type='hidden' name="discu" value="1" />
</form>

<div class="clear"></div>
<div id="tmleftbox">
<!--查询结果列表-->
<?php $con['price']=explode(',',$con['price']); ?>
<div class="resultbox">
<script type="text/javascript">
    /*拖动滑块*/
$(document).ready(function(){
    $("#range_5").ionRangeSlider({
        min: 0,
        max: 50,
        from:<?php echo ((isset($con["price"]["0"]) && ($con["price"]["0"] !== ""))?($con["price"]["0"]):0); ?>,
        to: <?php echo ((isset($con["price"]["1"]) && ($con["price"]["1"] !== ""))?($con["price"]["1"]):50); ?>,
        type: 'double',//设置类型
        step: 1,
        prefix: "",//设置数值前缀
        postfix: "",//设置数值后缀
        prettify: true,
        hasGrid: true,
        onChange: function(obj){        // function-callback, is called on every change
        $('#price1').val($('.irs-from').text());
        $('#price2').val($('.irs-to').text());
        }
    }); 
     $(".slipbox").children(".slipmore").css("display","none");
});

/*拖动滑块 end*/
</script>
<form method="get">
<input type='hidden' value="<?php echo $_GET['skey']; ?>" name='skey' />
<div class="sortbox">排序：
<button type="submit" name='zh' value='1'  class="ascbtn" />综合</button>
<button type="submit" name='pf' value="<?php if(($con["pf"]) == "1"): ?>2<?php else: ?>1<?php endif; ?>" class="<?php if(($con["pf"]) == "1"): ?>desbtn<?php else: ?>ascbtn<?php endif; ?>" />评分</button>
<button type="submit" name='sj' value="<?php if(($con["sj"]) == "1"): ?>2<?php else: ?>1<?php endif; ?>" class="<?php if(($con["sj"]) == "1"): ?>desbtn<?php else: ?>ascbtn<?php endif; ?>" />更新时间</button>
<button type="submit" name='sl' value="<?php if(($con["sl"]) == "1"): ?>2<?php else: ?>1<?php endif; ?>" class="<?php if(($con["sl"]) == "1"): ?>desbtn<?php else: ?>ascbtn<?php endif; ?>" />浏览数量</button>
<button type="submit" name='jg' value="<?php if(($con["jg"]) == "1"): ?>2<?php else: ?>1<?php endif; ?>" class="<?php if(($con["jg"]) == "1"): ?>desbtn<?php else: ?>ascbtn<?php endif; ?>" />价格</button>
<span class="slipbox" data-kone="groom"><input type="text" name="pricea[]" id='price1' value="<?php echo ($con["price"]["0"]); ?>" class="ipt" /> - <input type="text" name="pricea[]"  value="<?php echo ($con["price"]["1"]); ?>" id='price2' class="ipt" /> 万元
<div class="slipmore">
<div class="ranSlider"><input type="text" id="range_5" /><p><input type="Submit" name="Submit" value="确定" class="btn1" /></p></div>
<dl class="groom">
<dt><a href="<?php echo ($url1); ?>?price=0,3">特价商标</a></dt><dd>27.2%选择</dd>
<dt><a href="<?php echo ($url1); ?>?price=4,6">五万左右商标</a></dt><dd>35.3%选择</dd>
<dt><a href="<?php echo ($url1); ?>?price=8,12">十万左右商标</a></dt><dd>23.4%选择</dd>
<dt><a href="<?php echo ($url1); ?>?price=10,1000">十万以上商标</a></dt><dd>14.1%选择</dd>
</dl>
</div>
</span>
<em>
<input type='hidden' value="1" name='qqq' />
<label><input type="checkbox" name="discu" value="1" <?php if(($con["discu"]) == "1"): ?>checked<?php endif; ?> /> 包括面议</label>
<label><input type="checkbox" name="outsale" value="1" <?php if(($con["outsale"]) == "1"): ?>checked<?php endif; ?>/> 推荐特价</label>
<label><input type="checkbox" name="recommend" value="1" <?php if(($con["recommend"]) == "1"): ?>checked<?php endif; ?>/> 推荐</label>
<input type="Submit" name="Submit" value="确定" class="btn" />
</em>
</div>
</form>

<div class="home_hot" >
    <div class="pub_title"><h2>商标展示  <span style='margin-left:10px;font-size:80%'>查询<?php echo ($category_text); ?>(总数<strong style='color:red'><?php echo ($classes); ?></strong>个，按您的条件得到<strong style='color:red'><?php echo ((isset($count) && ($count !== ""))?($count):0); ?></strong>条数据，<?php echo ($discu); ?>)</span><a style="float:right;font-size:14px;color:red" href="<?php $url=U('Index/funsearch?skey='.$_GET['skey']);echo $url; ?>">全屏幕版，看商标不伤眼</a></h2></div>
<ul class="logo_img">
<?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><span class="slipbox" data-kone="c"><a href="<?php $urlname='Index/tmdetail?id='.$vo["tm_id"];echo U($urlname); ?>" title="<?php echo ($vo["tm_name"]); ?>" target="_blank"><img src="<?php if(($vo["is_fine"]) == "1"): echo C('PIC9');?>/<?php echo ($vo["tm_id"]); else: echo C('PIC4');?>/<?php echo ($vo["tm_id"]); endif; ?>" /></a>
<p><a href="<?php $urlname='Index/tmdetail?id='.$vo["tm_id"];echo U($urlname); ?>" title="<?php echo ($vo["tm_name"]); ?>" class="title" target="_blank"><?php echo ($vo["tm_name"]); ?></a></p><div class="lop">
<?php if($_SESSION['id']> 0): ?>ID：<?php echo ($vo["tm_id"]); ?>
	<?php if($vo['tm_categories'] == 25): if($vo[tm_price] > 0){ echo '<em class="main_nav">价格：&yen;'.$vo[tm_price].'万</em>'; }else{ echo '<em class="main_nav">面议</em>'; } ?>
	</span></p>
	<?php else: ?>
<?php $data=$vo['price_group']?$vo['price_group']:getprices($vo['tm_price']); $urlname='Index/quxiantu?data='.$data.'&date='.$date; if($vo[tm_price] > 0){ echo '
<em class="main_nav" onmouseover="showSubNav(this);" onmouseout="hideSubNav(this);">查看价格曲线
<div class="sub_nav">
<div class="a">
<h4>价格曲线（单位：万元）</h4>
<iframe src="'.U($urlname).'" scrolling="no" frameborder="0" width="100%" height="300" id="mainFrame" onload=\'IFrameReSize("mainFrame");IFrameReSizeWidth("mainFrame");\'></iframe>
</div>
</div>
</em>'; }else{ echo '<em class="main_nav">面议</em>'; } ?>
	</p><?php endif; ?>
<?php else: ?>ID：<?php echo ($vo["tm_id"]); ?>
<em href="javascript:void(0);" class="main_nav" onclick="showDiv('loginPop')">登录查看价格</em><?php endif; ?>
</div>
<p class="grey">所属类别：<a href="<?php $urlname='Index/tmclass?id='.$vo["tm_categories"];echo U($urlname); ?>" target="_blank" title="<?php echo $sblist[$vo['tm_categories']]; ?>">第<?php echo ($vo["tm_categories"]); ?>类</a></p>
<p class="grey" title="类似群组：<?php echo ($vo["belong_group"]); ?>">类似群组：<?php echo (subtext($vo["belong_group"],18)); ?></p>
<p class="grey" title="<?php echo ($vo["belong_groupdetail"]); ?>"><?php echo (subtext($vo["belong_groupdetail"],14)); ?></p>
<div class="slipmore imgmore">
<em><a href="<?php echo U('Index/tmlike',array('id'=>$vo['tm_id']));?>" target="_blank" class="i1">查找近似商标</a><span style="display:none"><?php echo ($vo["tm_id"]); ?></span><a href="javascript:void(0);" class="i2">收藏</a></em>
</div>
</span>
</li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul> 
</div>

</ul>
</div>
<!--查询结果列表 end-->

<!--分页-->
<?php echo ($page); ?>
<!--分页 end-->
</div>


<div id="tmrightbox" >
<!--联系电话-->
<div class="tmContact">
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
</div>
<!--联系电话 end-->
<!--推荐商标-->
<div class="recombox">
<h2>推荐商标</h2>
<ul>
<?php if(is_array($tuijianneiye)): $i = 0; $__LIST__ = $tuijianneiye;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Index/tmdetail',array('id'=>$vo['tm_id']));?>" target="_blank" title="<?php echo ($vo["tm_name"]); ?>"><img src="<?php if(($vo["is_fine"]) == "1"): echo C('PIC9');?>/<?php echo ($vo["tm_id"]); else: echo C('PIC4');?>/<?php echo ($vo["tm_id"]); endif; ?>" alt="<?php echo ($vo["tm_name"]); ?>" /></a><p><a href="<?php echo U('Index/tmdetail',array('id'=>$vo['tm_id']));?>" target="_blank"><?php echo ($vo["tm_name"]); ?></a></p></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>
<!--推荐商标 end-->
<!--收藏夹-->
<div class="mycollection">
<h2>未处理收藏夹<?php if(($_SESSION['uid']) != ""): ?><span>(<span class="collecttmnum"><?php echo ((isset($coll_num) && ($coll_num !== ""))?($coll_num):"0"); ?></span> )</span><a href="<?php echo U('User/collection');?>" target="_blank">查看更多</a><?php else: ?><a href="###" onclick="showDiv('loginPop')">登录查看收藏夹</a><?php endif; ?></h2>
<ul>
<?php if(Think.session.uid != '' ): if(is_array($colltminfo)): $i = 0; $__LIST__ = $colltminfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
<a href="<?php echo U('Index/tmdetail',array('id'=>$vo['tm_id']));?>" target="_blank" title=""><img src="<?php echo ($vo["img"]); ?>" alt="" />
<div>
<em>商标名称：</em><?php echo ($vo["tm_name"]); ?><br />
<em>商标ID：</em><?php echo ($vo["tm_id"]); ?><br />
<em>商标类别：</em>第<?php echo ($vo["tm_categories"]); ?>类<br />
<em>商品或服务：</em><?php echo ($vo["belong_groupdetail"]); ?></div>
</a>
<span></span></li><?php endforeach; endif; else: echo "" ;endif; ?>
<?php else: ?>
<a href="<?php echo U('User/index');?>">请先注册/登陆查看收藏信息</a><?php endif; ?>
</ul>
<script>
$(".mycollection ul li span").click(function(){
$(this).parent().children("a").hide();
$(this).hide();
});
</script>
</div>
<!--收藏夹 end-->
<!--浏览记录-->
<div class="recombox hm_history">
<h2>最近浏览的商标<a href="<?php echo U('Index/myhistory');?>">查看更多</a></h2>
<ul>
<?php if(is_array($history)): $i = 0; $__LIST__ = $history;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Index/tmdetail',array('id'=>$vo['tm_id']));?>" target="_blank" title="<?php echo ($vo["tm_name"]); ?>"><img src="http://7vzoco.com2.z0.glb.qiniucdn.com/<?php echo ($vo["tm_id"]); ?>" alt="<?php echo ($vo["tm_name"]); ?>" /></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul>
</div>
<!--浏览记录 end-->
</div><?php endif; ?>

<div class="clear"></div>
</div>
<!--底部-->
<div id="footer">
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

<!--背景层-->
<div id="bg" class="bg" style="display:none;"></div>
<iframe id="popIframe" class="popIframe" frameborder="0" ></iframe>
<!--背景层-->
<script type="text/javascript">
	$(function(){
		$('.i2').click(function(){
			var tm_id = $(this).prev().html();
			$.post("<?php echo U('User/collect_tm');?>",{'tm_id':tm_id},function(msg){
				if(msg == '收藏成功！'){
					alert(msg+'进入个人中心，编缉你收藏过的商标，可以整理成不同的文件夹，导出成excel');
					$.post("<?php echo U('User/createcolltm');?>",{'id':tm_id},function(msg){
						if(msg != '-1'){
							var lileng= $('.mycollection ul li').length;
							if(lileng == 0){
								$('.mycollection ul').append(msg);
							}else if(lileng == 6){
								$('.mycollection ul li').eq(5).remove();
								$('.mycollection ul li').eq(0).before(msg);
							}else{
								$('.mycollection ul li').eq(0).before(msg);
							}
							var count = Number($('.collecttmnum').html()) + 1;
							$('.collecttmnum').html(count);
						}
					});
				}else if(msg == '请先登录！'){
					showDiv('loginPop');
				}else{
					alert(msg);
				}
			});
		});
	});
</script>
</body>
</html>