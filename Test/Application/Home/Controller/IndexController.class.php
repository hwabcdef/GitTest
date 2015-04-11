<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends BaseController {
	public function __construct() {
		parent::__construct();
		$sblist=array(
			1=>'化学品',
			2=>'涂料油漆',
			3=>'化妆日用',
			4=>'油脂燃料',
			5=>'医药品',
			6=>'五金金属',
			7=>'电动机械',
			8=>'手工器械',
			9=>'电子电脑',
			10=>'医疗器械',
			11=>'家用电器',
			12=>'运输工具',
			13=>'烟火',
			14=>'珠宝钟表',
			15=>'乐器',
			16=>'文具办公',
			17=>'橡胶制品',
			18=>'皮革皮具',
			19=>'建筑材料',
			20=>'家具',
			21=>'洁具厨房',
			22=>'袋篷绳网',
			23=>'纺织纱线',
			24=>'布料床单',
			25=>'服装鞋帽',
			26=>'花边衬料',
			27=>'地毯席垫',
			28=>'运动用品',
			29=>'食品',
			30=>'方便食品',
			31=>'水果花木',
			32=>'啤酒饮料',
			33=>'酒',
			34=>'烟草烟具',
			35=>'广告贸易',
			36=>'金融物管',
			37=>'建筑修理',
			38=>'通讯传媒',
			39=>'运输旅游',
			40=>'材料加工',
			41=>'教育娱乐',
			42=>'科学服务',
			43=>'餐饮住宿',
			44=>'医疗园艺',
			45=>'法律');
    	$this->assign('sblist',$sblist);
    	$this->assign('txcode',$this->txcode());
    	$this->assign('fenlei',$this->fenlei());
    	$remen=D('industry')->where('parent = 26')->order('listorder desc')->limit(7)->getField('id,name');
        $this->assign('remen',$remen);//热门搜索
        //print_r($remen);exit;
    	//print_r($this->fenlei());exit;
	}
    public function sentemail(){
        $email='junyupang@qq.com';
        $title='测试的哈哈';
        $content='新建内容';
        sendMail($email,$title,$content);
    }
    public function tuijiansb(){
/*        cookie('keyword','好媳妇');
        cookie('cate','');*/
        cookie('ids','');
        $more=D('ad')->where(' ad_id =26 ')->getField('ad_content');
        //print_r($more);
        $more=explode(',', $more);
        $moren1=$more[0];
        $moren2=$more[1].','.$more[2].','.$more[3].','.$more[4].','.$more[5].','.$more[6].','.$more[7].','.$more[8].','.$more[9].','.$more[10].','.$more[11].','.$more[12];
        $moren3=$more[13].','.$more[14].','.$more[15].','.$more[16].','.$more[17].','.$more[18].','.$more[19].','.$more[20].','.$more[21].','.$more[22].','.$more[23].','.$more[24];
        $moren4=$more[25].','.$more[26];
        $noids=cookie('noids');
        $tuij = Array(
            'keyword'=>cookie('keyword'),
            'cate'=>cookie('cate'),
            'ids'=>cookie('ids'),
            'noids'=>$noids,
            'moren1'=>$moren1,
            'moren2'=>$moren2,
            'moren3'=>$moren3,
            'moren4'=>$moren4
            );
        $tuijian=$this->gettuijian($tuij);
        /*
            $keyword,百度关键字
            $noids,排除掉的商标id群组，如1,2,3
            $cate,指定查找的分类号群组，如1,2,3
            $ids,用于找预处理相似商标的商标id群组，如1,2,3
            $moren1,一号位默认显示的商标id，数量只有1个
            $moren2,二号位默认显示的商标id，数量12个
            $moren3,三号位默认显示的商标id，数量12个
            $moren4,四号位默认显示的商标id，数量只有2个
        */
            /*print_r(Array(
            'keyword'=>cookie('keyword'),
            'cate'=>cookie('cate'),
            'ids'=>cookie('ids'),
            'noids'=>$noids,
            'moren1'=>$moren1,
            'moren2'=>$moren2,
            'moren3'=>$moren3,
            'moren4'=>$moren4
            ));*/
        $this->assign('tuijian',$tuijian);
        $ad=D('ad')->where(' ad_id =31 ')->getField('ad_content');
       	$this->assign('ad',$ad);
        //print_r($tuij);
        $this->display();
    }
    public function index(){
    	//print_r(cookie('keyword'));
    	$slide=D('ad')->where('ad_id in (1,2,3,4,5,6,16,17,18,19,20)')->getField('ad_id,ad_pic,ad_url');
    	$this->assign('slide',$slide);//广告图
        $fenlei_all=$this->fenlei_all();
        $this->assign('fenlei_all',$fenlei_all['f1']);//分类表
        $this->assign('fenlei_order',$fenlei_all['f2']);//已排序的分类表
        $this->assign('fenlei_order_a',$fenlei_all['all']);//总量
        //print_r($fenlei_all);exit;
        $gettejia=$this->gettejia();
        $this->assign('gettejia',$gettejia['tm']);//特价商标
        $tuijianurl=D('ad')->where('ad_id in (22,23,34,35)')->getField('ad_id,ad_content');
        //print_r($tuijianurl);exit;
        $this->assign('tuijianurl',$tuijianurl);//推荐商标右上角自定义链接
        $gettuijian=$this->gettuijian1();
        //print_r($gettuijian);exit;
        $this->assign('gettuijian',$gettuijian['tm']);//推荐商标数据
        cookie('noids',$gettuijian['ids'].$gettejia['ids']);
        //print_r(cookie('noids'));exit;
        $zuijin=$this->zuijingengxin();
        //print_r($zuijin);exit;
        $this->assign('zuijin',$zuijin);
        $this->assign('qiugou',D('demand')->field(array('id','title','uptime'=>'time'))->where(array('state'=>1,'status'=>1,'del'=>1))->order('id desc')->limit(5)->select());

		// 增加成功案例列表，显示在首页下面的
		$firstRow = 0;
		$listRow = 30;
		$join = "".C('DB_PREFIX').'posts as b on a.object_id =b.id';
		$lists=M('TermRelationships')->alias("a")->join($join)->field('id,post_title,post_date,term_id')->where("post_status=1")->limit($firstRow.",".$listRow)->order('a.listorder desc, post_date desc')->select();
		$this->assign('lists', $lists);

        $this->display();
    }
    public function tmclass(){
    	$info='';
    	$con['like']=1;
    	$con['hzall']=1;
    	$con['middle']=1;
    	$con['zmall']=1;
    	$con['discu']=1;
    	$vk=$_POST['pf']==1?2:1;
    	$this->assign('pf',$vk);
    	$vk=$_POST['sj']==1?2:1;
    	$this->assign('sj',$vk);
    	$vk=$_POST['sl']==1?2:1;
    	$this->assign('sl',$vk);
    	$vk=$_POST['jg']==1?2:1;
    	$this->assign('jg',$vk);
    	$page1 = "tmclass";
    	if($_POST){
    		if(!empty($_POST['pricea'][0])||!empty($_POST['pricea'][1])){
	    		$price = implode($_POST['pricea'],',');
	    		$_POST['price'] = $price;
    		}
    		unset($_POST['pricea']);
    		unset($_POST['Submit']);
    		$perrow=20;
    		$_POST['perrow']=$perrow;   		
    		$key=$this->arrtokey($_POST);
    		S($key,$_POST,60*60*24);
    		$data['id']=$key;
    		$data['value']=json_encode($_POST);$data['uptime']=time();
    		if(D('search')->where('id ="'.$key.'"')->find() ==''){
    			D('search')->data($data)->add();
    		}
    		header('Location:http://'.C('WEBURL').U('Index/'.$page1.'?skey='.$key));
    		exit;
    	}elseif ($_GET['skey']){
    		$con1=S($_GET['skey']);
    		if($con1==''){
    			$con1=D('search')->where('id ="'.$key.'"')->find();
    			$con1=json_decode($con1['value'],true);
    			S($key,$con,60*60*24);
    		}
    		$con = array_merge($con,$con1);
    		if($_GET['price']){
    			$con['price'] = $_GET['price'];
    			$key=$this->arrtokey($con);
    			S($key,$con,60*60*24);
    			$data['id']=$key;
    			$data['value']=json_encode($con);
    			if(D('search')->where('id ="'.$key.'"')->find() ==''){
    				D('search')->data($data)->add();
    			}
    			header('Location:http://'.C('WEBURL').U('Index/'.$page1.'?skey='.$key));
    			exit;
    		}
    		$con['currpage']=$_GET['p']?$_GET['p']:1;
    		//print_r($con);exit;
    		$info=$this->getTm($con);
    		if($info=='-1'){
    			$info='1';
    		}
    	}else{
	        if($_GET['id']>46 || $_GET['id']<1){
	            echo '错误';
	            exit;
	        }
	        $perrow=20;
	        //print_r($_GET);exit;
	        $con['class'] = $_GET['id'];
	        $con['perrow']=$perrow;
	        $con['discu']=1;
	        $key=$this->arrtokey($con);
	        S($key,$con,60*60*24);
	        $data['id']=$key;
	        $data['value']=json_encode($con);
	        if(D('search')->where('id ="'.$key.'"')->find() ==''){
	        	D('search')->data($data)->add();
	        }
	        header('Location:http://'.C('WEBURL').U('Index/'.$page1.'?skey='.$key));
	        exit;
    	}
        $count      = $info['list']['rows'];// 查询满足要求的总记录数
        $this->assign('count',$count);
        $Page       = new \Think\Page($count, $con['perrow']);// 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('url',U('Index/'.$page1.'?skey='.$_GET['skey']));
        $bread_nav='<a href="'.U('Index/sblist').'">商标分类</a> &gt; <em>第'.$con['class'].'类</em>';
        $this->assign('bread_nav',$bread_nav);
        $this->assign('con',$con);
        if($con['category']==25){
            $this->assign('owkey',1);
        }else{
            $this->assign('owkey',0);
        }
        if($con['class']!=''){
            $this->assign('category_text','已选择了<strong style="color:red">'.$con['class'].'</strong>类');
        }
        unset($info['list']['rows']);
        $this->assign('date',$this->GetMonth());
        $this->assign('info',$info['list']);
        if(!isset($con['discu'])){
        	$this->assign('discu','不包括面议商标');
        }else{
        	$this->assign('discu','包括面议商标');
        }
        $classes = S('fenlei_all')[f1][$con['class']]['count'];
        $this->assign('classes',$classes);
        $this->assign('class',$con['class']);

		// 获取head中title等的模板
		$tmpl_info = $this->view->get('tmpl_info');	// 获取已设置的模板
        $tmpl_info['title'] = preg_replace('/\[cate_id]/',$con['class'], $tmpl_info['title']);
        $tmpl_info['title'] = preg_replace('/\[current_page]/',$con['currpage'], $tmpl_info['title']);
        $tmpl_info['keywords'] = preg_replace('/\[cate_id]/',$con['class'], $tmpl_info['keywords']);
        $tmpl_info['description'] = preg_replace('/\[cate_id]/',$con['class'], $tmpl_info['description'],-1);
        // 替换模板中的变量
        $tmpl_cate = M('cate');
        $tmpl_cate = $tmpl_cate->field('info')->find($con['category']);
        // 商标相关信息包括[cate_desc]商标，如果有更好的相关信息，可以在这里替换
        $tmpl_info['description'] = preg_replace('/\[cate_desc]/',mb_substr($tmpl_cate['info'],0,20,'utf-8').'...', $tmpl_info['description']);
        $this->assign('tmpl_info', $tmpl_info);

	 if($con['class']){
    		$ids = explode(',',$con['class']);
        	if(count($ids) > 5){
        		for($i=0; $i<5;$i++){
        			$idstr .= $ids[$i].',';
        		}
        		$idstr = rtrim($idstr,',');
        	}else{
        		if(cookie('cate')){
        			$old = explode(',',cookie('cate'));
        			for($i=count($old)-1;$i>=0;$i--){
        				if(count($ids)<5){
        					if(!in_array($old[$i],$ids)){
        						$ids[]=$old[$i];
        					}
        				}
        			}
        		}
        		if(count($ids)>1){
        			$idstr = implode(',',$ids);
        		}else{
        			$idstr = $ids[0];
        		}
    			
        	}    		
		cookie('cate',$idstr,3600*24*365*10);
    		if(cookie('catetime')){
    			cookie('catetime',cookie('catetime')+1,3600);
    			if(cookie('catetime')>2){
    				cookie('keyword',null);
    			}
    		}else{
    			cookie('catetime',1,3600);
    		}
    	}
        
        /*获取收藏夹信息*/
        if($_SESSION['uid']){
        	$fileid = M('Collectfile')->where('uid='.$_SESSION['uid']." and filename='未处理收藏夹'")->getField('id');
        	$tmids = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->order('id desc')->field('tm_id')->limit(6)->select();
        	$count = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->field('tm_id')->select();
        	$count = count($count);
        	$this->assign('coll_num',$count);
        	$ids = '';
        	foreach( $tmids as $tmid){
        		$ids .= $tmid['tm_id'].',';
        	}
        	$ids = rtrim($ids,',');
        	$arr_post = array('ids'=>$ids,'fields'=>'tm_name,tm_id,tm_categories,belong_groupdetail');
        	$collinfo = gettmlist($arr_post);
        	$colltminfo = array();
        	foreach ($collinfo as $coll){
        		$coll['img'] = C('PIC4').'/'.$coll['tm_id'];
        		$colltminfo[] = $coll;
        	}
        	$this->assign('colltminfo',$colltminfo);
        }
		
        $this->display('tmClass/tmClassList');
    }
    public function tmdetail(){
        //cookie('history',null);
	        if(!$_GET['id']){
	                $this->error('查无此商标');
	                exit;
	        }
            $id=intval($_GET['id']);
            $data=$this->sbinfo($id);
            if($data=="1"){
                $this->error('查无此商标');
                exit;
            }
            $history=json_decode(cookie('history'),true);
            arsort($history);
            if(sizeof($history)>9){
                if(!$history[I('get.id')]){
                    array_pop($history);
                }
                $history[I('get.id')]=time();
            }else{
                $history[I('get.id')]=time();
            }
            cookie('history',json_encode($history));
            //print_r($data);exit;
            $this->assign('res',$data);
            $this->assign('date',$this->GetMonth());

            // 获取head中title等的模板
			$tmpl_info = $this->view->get('tmpl_info');	// 获取已设置的模板
            $tmpl_info['title'] = preg_replace('/\[cate_id]/',$data['self']['tm_categories'], $tmpl_info['title']);
            $tmpl_info['title'] = preg_replace('/\[tm_name]/',$data['self']['tm_name'], $tmpl_info['title']);
            $tmpl_info['keywords'] = preg_replace('/\[tm_name]/',$data['self']['tm_name'], $tmpl_info['keywords']);
            $tmpl_info['description'] = preg_replace('/\[tm_name]/',$data['self']['tm_name'], $tmpl_info['description'],-1);
            $tmpl_info['description'] = preg_replace('/\[belong_groupdetail]/',$data['self']['belong_groupdetail'], $tmpl_info['description']);
            $this->assign('tmpl_info', $tmpl_info);
            
            /*获取收藏夹信息*/
            if($_SESSION['uid']){
            	$fileid = M('Collectfile')->where('uid='.$_SESSION['uid']." and filename='未处理收藏夹'")->getField('id');
            	$tmids = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->order('id desc')->field('tm_id')->limit(6)->select();
            	$count = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->field('tm_id')->select();
            	$count = count($count);
            	$this->assign('coll_num',$count);
            	$ids = '';
            	foreach( $tmids as $tmid){
            		$ids .= $tmid['tm_id'].',';
            	}
            	$ids = rtrim($ids,',');
            	$arr_post = array('ids'=>$ids,'fields'=>'tm_name,tm_id,tm_categories,belong_groupdetail');
            	$collinfo = gettmlist($arr_post);
            	$colltminfo = array();
            	foreach ($collinfo as $coll){
            		$coll['img'] = C('PIC4').'/'.$coll['tm_id'];
            		$colltminfo[] = $coll;
            	}
            	$this->assign('colltminfo',$colltminfo);
            }
            if(empty($data['self']['picture_num'])){
                $this->display(":tmClass/tmDetail");
            }else{
                $this->display(":tmClass/tmShow");
            }
    }

    public function getqunzu(){
    	if($_GET['cate']){
    		if($_GET['cate']==''){echo '<center>还未选择分类</center>';exit;};
    		$re=D('typegroup')->where('type_id in ('.I('get.cate').')')->select();
    		@$checked=explode(',', $_GET['checked']);
    		@$this->assign('checked1',$checked);
    		//print_r($checked);
    		$this->assign('re',$re);
    		$this->display('public/getqunzu');
    	}else{
    		$this->error('页面不存在');
    	}
    }
    
    public function funsearch(){
    	$this->_search($page='funsearch',$type=1);
    }

    public function _search($page,$type){
    	$info='';
    	$con['middle']=1;
        $con['like']=1;
        $con['hzall']=1;
        $con['zmall']=1;
        $con['discu']=1;
        if($_POST){
            if($_POST['hzall']==1&&$_POST['ch_num']!=''){
                $_POST['ch_num']=explode(',', $_POST['ch_num']);
                $_POST['ch_num'][1]=999;
                $_POST['ch_num']=join(',',$_POST['ch_num']);
            }
            if($_POST['zmall']==1&&$_POST['en_num']!=''){
                $_POST['en_num']=explode(',', $_POST['en_num']);
                $_POST['en_num'][1]=999;
                $_POST['en_num']=join(',',$_POST['en_num']);
            }
            if($_POST['content']=='中文/英文/注册号/ID号'){
                unset($_POST['content']);
            }
            if($_POST['content1']=='商标名称、注册号、编号、介绍' || ($_POST['content']!='中文/英文/注册号/ID号'&&$_POST['content']!='')){
                unset($_POST['content1']);
            }
            if($_POST['price'][0]!=''&&$_POST['price'][1]!=''){
                $_POST['price']=join(',',$_POST['price']);
            }else{
                unset($_POST['price']);
            }

            if($_POST['category']==''){
            	unset($_POST['category']);
            }
            if(!is_array($_POST['category'])){
                if(strpos($_POST['category'],"类")){
                    $_POST['category']=str_replace("类","",$_POST['category']);
                    $_POST['category']=str_replace("第","",$_POST['category']);
                }
            }
            if($_POST['category']&&is_array($_POST['category'])){
				$_POST['category']=join(',',$_POST['category']);
            }
            if($_POST['25group']&&is_array($_POST['25group'])){
				$_POST['25group']=join(',',$_POST['25group']);
            }
            $_POST['perrow']=20;
            if($_POST['25service']&&is_array($_POST['25service'])){
            	foreach($_POST['25service'] as $v){
            		if($v!='如：手机'){
            			$tmp[]=$v;
            		}
            	}
            	$_POST['25service']=join(',',$tmp);
            }
            if($_POST['25service']==''){
                unset($_POST['25service']);
            }
            if($_POST['25code']=='请输入商标图形编码'){
				unset($_POST['25code']);
            }
            if($_POST['content']){
                cookie('keyword',$_POST['content']);
            }
            //print_r($_POST);exit;
            $key=$this->arrtokey($_POST);
            S($key,$_POST,60*60*24);
            $data['id']=$key;
            $data['value']=json_encode($_POST);$data['uptime']=time();
            if(D('search')->where('id ="'.$key.'"')->find() ==''){
                D('search')->data($data)->add();
            }
            header('Location:http://'.C('WEBURL').U('Index/'.$page.'?skey='.$key));
            exit;
        }
        
    	if($_GET['skey']){
            $con=S($_GET['skey']);
            if($con==''){
                $con=D('search')->where('id ="'.$key.'"')->find();
                $con=json_decode($con['value']);
                S($key,$con,60*60*24);
            }
            unset($con['submit']);
            unset($con['Submit']);
            $con1=array();
            if($_GET['pf']){
                #unset($con['pf']);
                unset($con['sj']);
                unset($con['sl']);
                unset($con['jg']);
                $con1['pf']=$_GET['pf'];
            }
            elseif($_GET['sj']){
                unset($con['pf']);
                #unset($con['sj']);
                unset($con['sl']);
                unset($con['jg']);
                $con1['sj']=$_GET['sj'];
            }
            elseif($_GET['sl']){
                unset($con['pf']);
                unset($con['sj']);
                #unset($con['sl']);
                unset($con['jg']);
                $con1['sl']=$_GET['sl'];
            }
            elseif($_GET['jg']){
                unset($con['pf']);
                unset($con['sj']);
                unset($con['sl']);
                #unset($con['jg']);
                $con1['jg']=$_GET['jg'];
            }
            elseif($_GET['zh']){
                unset($con['pf']);
                unset($con['sj']);
                unset($con['sl']);
                unset($con['jg']);
                $con1['zh']=1;
            }
            if($_GET['discu']){
                $con1['discu']=$_GET['discu'];
            }
            if($_GET['outsale']){
                $con1['outsale']=$_GET['outsale'];
            }
            if($_GET['recommend']){
                $con1['recommend']=$_GET['recommend'];
            }           
            if($_GET['pricea']){
                if($_GET['pricea'][0]!=''&&$_GET['pricea'][1]!=''){
                    $con1['price']=join(',',I('get.pricea'));
                } 
            }
            if($_GET['price']){
                $con1['price']=I('get.price');
            }
            if(!isset($_GET['discu'])&&isset($_GET['qqq'])){
            	unset($con['discu']);
            }
            if(!isset($_GET['outsale'])&&isset($_GET['qqq'])){
            	unset($con['outsale']);
            }
            if(!isset($_GET['recommend'])&&isset($_GET['qqq'])){
            	unset($con['recommend']);
            }
            //print_r($con);exit;
            if(!empty($con1) || isset($_GET['qqq'])){
                $con=array_merge($con,$con1);
                $key=$this->arrtokey($con);
                S($key,$con,60*60*24);
                $data['id']=$key;
                $data['value']=json_encode($con);
                if(D('search')->where('id ="'.$key.'"')->find() ==''){
                    D('search')->data($data)->add();
                }
                header('Location:http://'.C('WEBURL').U('Index/'.$page.'?skey='.$key));
                exit;
            }
            $con['currpage']=$_GET['p']?$_GET['p']:1;
            if(!isset($con['discu'])){
            	$this->assign('discu','不包括面议商标');
            }else{
            	$this->assign('discu','包括面议商标');
            }
            //print_r($con);exit;
            $info=$this->getsearch($con);
            if($info=='-1'){
                $info='1';
            }else{
	            $count      = $info['list']['rows'];// 查询满足要求的总记录数
	            $this->assign('count',$count);
	            unset($info['list']['rows']);
	            $this->assign('info',$info['list']);
	            $Page       = new \Think\Page($count, $con['perrow']);// 实例化分页类 传入总记录数和每页显示的记录数
	            $show       = $Page->show();// 分页显示输出
	            $this->assign('page',$show);// 赋值分页输出
            }
            $this->assign('url',U('Index/'.$page));
            $this->assign('url1',U('Index/'.$page.'?skey='.$_GET['skey']));
    	}
    	//print_r($con);
    	if($con['category']==25){
    		$this->assign('owkey',1);
    	}else{
    		$this->assign('owkey',0);
    	}
    	if($con['category']!=''){
            $clist=explode(',',$con['category']);
            if(sizeof($clist)>5){
                foreach($clist as $kc=>$vc){
                    if($kc<5){
                        $clist1[$kc]=$vc;
                    }
                }              
                $clist=join(',',$clist1);
                $this->assign('category_text','已选择了<strong style="color:red">'.$clist.',...</strong>类');
            }else{
                $this->assign('category_text','已选择了<strong style="color:red">'.$con['category'].'</strong>类');
            }
            foreach($clist as $v){
            	$classes += S('fenlei_all')[f1][$v]['count'];
            	if($v==25){
            		$classes += S('fenlei_all')[f1][46]['count'];
            	}
            }
            $this->assign('classes',$classes);
    	}else{
    		$this->assign('category_text','全部分类');
    		$classes += S('fenlei_all')[all];
    		$this->assign('classes',$classes);
    	}
        switch ($type) {
            case 1:
                if($_GET['skey']){
                    $bread_nav='<a href="'.U('Index/search').'">商标搜索</a> &gt; <em>'.$con['content'].'搜索结果</em>';
                    $this->assign('bread_nav',$bread_nav);
                }else{
                    $bread_nav='<a href="'.U('Index/search').'">商标搜索</a>';
                    $this->assign('bread_nav',$bread_nav);
                }
                break;
            
            case 2:
                if($_GET['skey']){
                        $bread_nav='<a href="'.U('Index/search').'">商标搜索</a> &gt; <em>'.$con['content1'].'搜索结果</em>';
                        $this->assign('bread_nav',$bread_nav);
                    }else{
                        $bread_nav='<a href="'.U('Index/search').'">商标搜索</a>';
                        $this->assign('bread_nav',$bread_nav);
                    }
                break;            
            default:
                break;
        }
        $this->assign('date',$this->GetMonth());
    	//print_r($this->txcode());exit;
    	//print_r($con);
    	if($con['25service']!=''){
    		unset($con['25group']);
    	}
	
	if($con['category']){
    		$ids = explode(',',$con['category']);
        	if(count($ids) > 5){
        		for($i=0; $i<5;$i++){
        			$idstr .= $ids[$i].',';
        		}
        		$idstr = rtrim($idstr,',');
        	}else{
        		if(cookie('cate')){
        			$old = explode(',',cookie('cate'));
        			for($i=count($old)-1;$i>=0;$i--){
        				if(count($ids)<5){
        					if(!in_array($old[$i],$ids)){
        						$ids[]=$old[$i];
        					}
        				}
        			}
        		}
        		if(count($ids)>1){
        			$idstr = implode(',',$ids);
        		}else{
        			$idstr = $ids[0];
        		}
    			
        	}
    		cookie('cate',$idstr,3600*24*365*10);
    		if(cookie('catetime')){
    			cookie('catetime',cookie('catetime')+1,3600);
    			if(count(explode(',',cookie('catetime')))>2){
    				cookie('keyword',null);
    			}
    		}else{
    			cookie('catetime',1,3600);
    		}
    		 
    	}	

        $this->assign('con',$con);
        $this->assign('info',$info['list']);

			/*获取收藏夹信息*/
            if($_SESSION['uid']){
            	$fileid = M('Collectfile')->where('uid='.$_SESSION['uid']." and filename='未处理收藏夹'")->getField('id');
				$tmids = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->order('id desc')->field('tm_id')->limit(6)->select();
				$count = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->field('tm_id')->select();
            	$count = count($count);
            	$this->assign('coll_num',$count);
            	$ids = '';
            	foreach( $tmids as $tmid){
            		$ids .= $tmid['tm_id'].',';
            	}
            	$ids = rtrim($ids,',');
            	$arr_post = array('ids'=>$ids,'fields'=>'tm_name,tm_id,tm_categories,belong_groupdetail');
            	$collinfo = gettmlist($arr_post);
            	$colltminfo = array();
            	foreach ($collinfo as $coll){
            		$coll['img'] = C('PIC4').'/'.$coll['tm_id'];
            		$colltminfo[] = $coll;
            	}
            	$this->assign('colltminfo',$colltminfo);
            }
            
    		if($page=='funsearch'){
            	$this->display(':tmClass/tmSearchFull');
            }else{
            	$this->display('tmClass/tmList');
            }
  	  }
    public function buy(){
        if(session('id')>0){
            header('Location:http://'.C('WEBURL').U('User/buy'));
            exit;
        }
        if(IS_POST){
            $this->_buy();
            exit;
        }

        $this->display('tmClass/regsupply');
    }
    public function _buy(){
        if(D('Demand')->create($_POST)){
            $_POST['uid']=$_COOKIE['uid'];
            $_POST['uptime']=time();
            if(D('Demand')->add($_POST)){
                $this->success('发布成功！',U('Index/buy'));
                }else{
                    $this->error('发布失败！');
                    }
            }else{
                $this->error(D('Demand')->getError());
                }
    }
    public function _transfer(){
            foreach($_POST['cate_id'] as $k=>$vo){
                $datas[$k]['cate_id']=$_POST['cate_id'][$k];
                $datas[$k]['tm_name']=$_POST['tm_name'][$k];
                $datas[$k]['regnum']=$_POST['regnum'][$k];
                $datas[$k]['applicant']=$_POST['applicant'][$k];
                $datas[$k]['price']=$_POST['price'][$k];
                $datas[$k]['note']=$_POST['note'][$k];
                $datas[$k]['uid']=$_COOKIE['uid'];
                $datas[$k]['uptime']=time();
                }
        if(D('Transfer')->create($datas[0])){
            foreach($datas as $data){
                if($data['tm_name']!='' || $data['regnum']!='' ||$data['applicant']!='' || $data['price']!=''){
                    $res[]=D('Transfer')->add($data);
                    }
                }
            if($res){
                $this->success('发布成功！',U('Index/transfer'));
                }else{
                    $this->error('发布失败！');
                    }
            }else{
                $this->error(D('Transfer')->getError());
                }
        }
    public function transfer(){
        if(session('id')>0){
            header('Location:http://'.C('WEBURL').U('User/transfer'));
            exit;
        }
        if($_POST){
            $this->_transfer();
            exit;
        }

        $this->display('tmClass/regzr');
    }
    public function test(){
 	/*print_r($this->fenlei_all());
        exit;*/ 
    	S('cache',1);
    }
    public function quality(){
        $title=3;
        $cate=$_GET['id']?$_GET['id']:25;
        $this->assign('cate',$cate);
        $currpage=$_GET['p']?$_GET['p']:1;
        $type=$_GET['type']?$_GET['type']:1;
        $perrow=16;
        $style='';
        $pic=1;
        $info=$this->getData($title,$cate,$currpage,$perrow,$style,$pic);
        $count      = $info['rows'];// 查询满足要求的总记录数
        unset($info['rows']);
        $this->assign('info',$info);
        $Page       = new \Think\Page($count,12);// 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        //第25类详细分类
        $women=$this->getQData(4,25,'','',1);
        $man=$this->getQData(4,25,'','',2);
        $child=$this->getQData(4,25,'','',3);
        $sport=$this->getQData(4,25,'','',4);
        $this->assign('womens',$women);
        //print_r($women);exit;
        $this->assign('mans',$man);
        $this->assign('childs',$child);
        $this->assign('sports',$sport);

        // 获取head中title等的模板
		$tmpl_info = $this->view->get('tmpl_info');	// 获取已设置的模板
		// 替换模板中的变量
        $tmpl_cate = M('cate');
        $tmpl_cate = $tmpl_cate->field('cate_name')->find($cate);
        $tmpl_info['title'] = preg_replace('/\[cate_id]/',$cate, $tmpl_info['title']);
        $tmpl_info['title'] = preg_replace('/\[cate_name]/',$tmpl_cate['cate_name'], $tmpl_info['title']);
        $tmpl_info['title'] = preg_replace('/\[current_page]/',$currpage, $tmpl_info['title']);
        $this->assign('tmpl_info', $tmpl_info);


        if($type==1){
            //大图
            $this->display('good/tmList');
        }else{
            $this->display('good/tmMode');
        }
        
    }
    public function sblist(){
    	$con['middle']=1;
        $con['like']=1;
        $con['hzall']=1;
        $con['zmall']=1;
        $con['discu']=1;
        if($con['category']==25){
            $this->assign('owkey',1);
        }else{
            $this->assign('owkey',0);
        }
        if($con['category']!=''){
            $this->assign('category_text','已选择了<strong style="color:red">'.$con['category'].'</strong>类');
        }
        $bread_nav='<a href="'.U('Index/sblist').'">商标分类</a> &gt; <em>';
                    $this->assign('bread_nav',$bread_nav);
        $this->assign('con',$con);
        $fenlei_all=$this->fenlei_all();
        $this->assign('fenlei_all',$fenlei_all['f1']);//分类表

        /*获取收藏夹信息*/
        if($_SESSION['uid']){
        	$fileid = M('Collectfile')->where('uid='.$_SESSION['uid']." and filename='未处理收藏夹'")->getField('id');
        	$tmids = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->order('id desc')->field('tm_id')->limit(6)->select();
        	$count = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->field('tm_id')->select();
        	$count = count($count);
        	$this->assign('coll_num',$count);
        	$ids = '';
        	foreach( $tmids as $tmid){
        		$ids .= $tmid['tm_id'].',';
        	}
        	$ids = rtrim($ids,',');
        	$arr_post = array('ids'=>$ids,'fields'=>'tm_name,tm_id,tm_categories,belong_groupdetail');
        	$collinfo = gettmlist($arr_post);
        	$colltminfo = array();
        	foreach ($collinfo as $coll){
        		$coll['img'] = C('PIC4').'/'.$coll['tm_id'];
        		$colltminfo[] = $coll;
        	}
        	$this->assign('colltminfo',$colltminfo);
        }
        $this->display('tmClass/tmClassification');

    }
    public function tmlike(){
        $info='';
        $con['like']=1;
        $con['hzall']=1;
        $con['zmall']=1;
        $con['discu']=1;
        $vk=$_GET['pf']==1?2:1;
        $this->assign('pf',$vk);
        $vk=$_GET['sj']==1?2:1;
        $this->assign('sj',$vk);
        $vk=$_GET['jg']==1?2:1;
        $this->assign('jg',$vk);
        $page=$_GET['p']?$_GET['p']:1;
        $id=$_GET['id'];
    	$map['id']=$id;
    	$map['title']=$_GET['type']?$_GET['type']:3;
    	$map['currpage']=$page;
    	$map['perrow']=20;
        $sbinfo=$this->getadTm($id);
        $info=$this->sbinfonear($map);
        if($info=='-1'){
                $info['list']='1';
            }
        #print_r($sbinfo);exit;
        $count      = $info['list']['rows'];// 查询满足要求的总记录数
        $this->assign('count',$count);
        $Page       = new \Think\Page($count, $map['perrow']);// 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('url',U('Index/indeustry'));
        $bread_nav="<a href='".U('Index/sblist')."'>“<strong style='color:red'>".$sbinfo[$id]['tm_name'].'</strong>”的相似商标</a>';
        $this->assign('bread_nav',$bread_nav);
        $this->assign('con',$con);
        if($con['category']==25){
            $this->assign('owkey',1);
        }else{
            $this->assign('owkey',0);
        }
        if($con['category']!=''){
            $this->assign('category_text','已选择了<strong style="color:red">'.$con['category'].'</strong>类');
        }
        unset($info['list']['rows']);
        $this->assign('date',$this->GetMonth());
        $this->assign('info',$info['list']);

		/*获取收藏夹信息*/
        if($_SESSION['uid']){
        	$fileid = M('Collectfile')->where('uid='.$_SESSION['uid']." and filename='未处理收藏夹'")->getField('id');
        	$tmids = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->order('id desc')->field('tm_id')->limit(6)->select();
        	$count = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->field('tm_id')->select();
        	$count = count($count);
        	$this->assign('coll_num',$count);
        	$ids = '';
        	foreach( $tmids as $tmid){
        		$ids .= $tmid['tm_id'].',';
        	}
        	$ids = rtrim($ids,',');
        	$arr_post = array('ids'=>$ids,'fields'=>'tm_name,tm_id,tm_categories,belong_groupdetail');
        	$collinfo = gettmlist($arr_post);
        	$colltminfo = array();
        	foreach ($collinfo as $coll){
        		$coll['img'] = C('PIC4').'/'.$coll['tm_id'];
        		$colltminfo[] = $coll;
        	}
        	$this->assign('colltminfo',$colltminfo);
        }
        $this->display('tmClass/tmLikeList');
    }
    public function indeustry(){
        $info='';
        $con['like']=1;
        $con['hzall']=1;
        $con['zmall']=1;
        $con['discu']=1;
        $vk=$_GET['pf']==1?2:1;
        $this->assign('pf',$vk);
        $vk=$_GET['sj']==1?2:1;
        $this->assign('sj',$vk);
        $vk=$_GET['sl']==1?2:1;
        $this->assign('sl',$vk);
        $vk=$_GET['jg']==1?2:1;
        $this->assign('jg',$vk);
        $page=$_GET['p']?$_GET['p']:1;
        $page1 = "indeustry";
        if($_POST){
        	if(!empty($_POST['pricea'][0])||!empty($_POST['pricea'][1])){
        		$price = implode($_POST['pricea'],',');
        		$_POST['price'] = $price;
        	}
        	unset($_POST['pricea']);
        	unset($_POST['Submit']);
        	$perrow=20;
        	$_POST['perrow']=$perrow;
        	//print_r($_POST);exit;
        	$key=$this->arrtokey($_POST);
        	S($key,$_POST,60*60*24);
        	$data['id']=$key;
        	$data['value']=json_encode($_POST);$data['uptime']=time();
        	if(D('search')->where(array('id'=>$key))->find() ==''){
        		D('search')->data($data)->add();
        	}
        	header('Location:http://'.C('WEBURL').U('Index/'.$page1.'?skey='.$key));
        	exit;
        }elseif ($_GET['skey']){
        	$con1=S($_GET['skey']);
        	$key=$_GET['skey'];
        	if($con1==''){
        		$con1=D('search')->where(array('id'=>$key))->find();
        		$con1=json_decode($con1['value'],true);
        		S($key,$con1,60*60*24);
        	}
        	if(!isset($con1['discu'])){
        		unset($con['discu']);
        	}
        	$con = array_merge($con,$con1);
        	//print_r($con);exit;
        	if($_GET['price']){
        		$con['price'] = $_GET['price'];
        		$key=$this->arrtokey($con);
        		S($key,$con,60*60*24);
        		$data['id']=$key;
        		$data['value']=json_encode($con);
        		if(D('search')->where('id ="'.$key.'"')->find() ==''){
        			D('search')->data($data)->add();
        		}
        		header('Location:http://'.C('WEBURL').U('Index/'.$page1.'?skey='.$key));
        		exit;
        	}
        	$con['currpage']=$page;
        	//print_r($con);exit;
        	$this->assign('id',$con['id']);
        	$map=D('industry')->where(array('id'=>$con['id']))->find();
        	if($map==''){
        		$this->error('错误id');
        		exit;
        	}      	
        	$map['conditions']=json_decode($map['conditions'],true);
        	//print_r($map['conditions']);exit;
        	$con['category']=$map['conditions']['category'];
        	$con['groups']=$map['conditions']['25group'];
        	$row=sizeof($map['conditions']['product']);
        	for($i=0;$i<$row;$i++){
        		$con['group'][$i]=$map['conditions']['product'][$i][0];
        		$con['chanp'][$i]=$map['conditions']['product'][$i][1];
        	}
        	$pmap['con']=json_encode($con);
        	//print_r($pmap);exit;
        	$info=$this->getfenlei($pmap);
        	//print_r($info);exit;
        	$this->assign('url1',U('Index/'.$page1.'?skey='.$_GET['skey']));
        	if($info=='-1'){
        		$info='1';
        	}
        }else{
        	$id=$_GET['id'];
        	$map=D('industry')->where('id ='.$id)->find();
        	if($map==''){
        		$this->error('错误id');
        		exit;
        	}
        	$map['conditions']=json_decode($map['conditions'],true);
        	//print_r($map['conditions']);
        	unset($con['product']);
        	$fmap['currpage']=$page;
        	$fmap['perrow']=20;
        	$fmap['category']=$map['conditions']['category'];
        	$fmap['groups']=$map['conditions']['25group'];
        	//print_r($map);exit;
        	$row=sizeof($map['conditions']['product']);
        	for($i=0;$i<$row;$i++){
        		$fmap['group'][$i]=$map['conditions']['product'][$i][0];
        		$fmap['chanp'][$i]=$map['conditions']['product'][$i][1];
        	}
        	if($_GET['price']){
        		$con['price'] = $_GET['price'];
        		$fmap['price'] = $_GET['price'];
        	}
        	$con=array_merge($fmap,$con);
        	$pmap['con']=json_encode($fmap);
        	//print_r($pmap);        	
        	//print_r($con);exit;
        	$info=$this->getfenlei($pmap);
        	if($info=='-1'){
        		$info='1';
        	}
        	$this->assign('url1',U('Index/'.$page1.'?id='.$id));
        	$this->assign('id',$id);
        	$key=$this->arrtokey($con);
        	S($key,$con,60*60*24);
        	$data['id']=$key;
        	$data['value']=json_encode($con);
        	if(D('search')->where('id ="'.$key.'"')->find() ==''){
        		D('search')->data($data)->add();
        	}
        }
        $count      = $info['rows'];// 查询满足要求的总记录数
        $this->assign('count',$count);
        $Page       = new \Think\Page($count, 20);// 实例化分页类 传入总记录数和每页显示的记录数
        $show       = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('url',U('Index/'.$page1));
        $bread_nav='<a href="'.U('Index/sblist').'">行业分类</a> &gt; <em>'.$map['name'].'</em>';
        $this->assign('bread_nav',$bread_nav);
        $con['25group'] = $con['groups'];
        unset($con['groups']);
        $this->assign('con',$con);
        if(!isset($con['discu'])){
        	$this->assign('discu','不包括面议商标');
        }else{
        	$this->assign('discu','包括面议商标');
        }
        $classes += S('fenlei_all')[f1][$fmap['category']]['count'];
        if($fmap['category']==25){
        	$classes += S('fenlei_all')[f1][46]['count'];
        }
        $this->assign('classes',$classes);
        if($con['category']==25){
            $this->assign('owkey',1);
        }else{
            $this->assign('owkey',0);
        }
        if($con['category']!=''){
            $this->assign('category_text','已选择了<strong style="color:red">'.$con['category'].'</strong>类');
        }
        unset($info['rows']);
        $this->assign('date',$this->GetMonth());
        $this->assign('info',$info);

        // 获取head中title等的模板
		$tmpl_info = $this->view->get('tmpl_info');	// 获取已设置的模板
        $tmpl_info['title'] = preg_replace('/\[search_name]/',$map['name'], $tmpl_info['title']);
        $this->assign('tmpl_info', $tmpl_info);
	
		/*获取收藏夹信息*/
        if($_SESSION['uid']){
        	$fileid = M('Collectfile')->where('uid='.$_SESSION['uid']." and filename='未处理收藏夹'")->getField('id');
        	$tmids = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->order('id desc')->field('tm_id')->limit(6)->select();
        	$count = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->field('tm_id')->select();
        	$count = count($count);
        	$this->assign('coll_num',$count);
        	$ids = '';
        	foreach( $tmids as $tmid){
        		$ids .= $tmid['tm_id'].',';
        	}
        	$ids = rtrim($ids,',');
        	$arr_post = array('ids'=>$ids,'fields'=>'tm_name,tm_id,tm_categories,belong_groupdetail');
        	$collinfo = gettmlist($arr_post);
        	$colltminfo = array();
        	foreach ($collinfo as $coll){
        		$coll['img'] = C('PIC4').'/'.$coll['tm_id'];
        		$colltminfo[] = $coll;
        	}
        	$this->assign('colltminfo',$colltminfo);
        }
        $this->display('tmClass/tmIndeustryList');

    }
    public function search(){
    	//print_r(S('fenlei_all'));exit;
    	$this->_search($page='search',$type=1);
    }
    public function tradeindex(){
        if(IS_POST){
            if($_POST[1]){
                //商标分类
                $key=($_POST['typec']=='请输入关键字或ID')?'':I('post.typec');
                if(is_numeric($key)){
                    $map1['cate_id']=$key;
                    $re1=D('cate')->where($map1)->find();
                    $map['cate_id']=array('like','%'.$key.'%');
                    $re=D('cate')->where($map)->getField('cate_id,cate_name,info');
                    if(!sizeof($re)){
                        $this->assign('re',0);
                    }else{
                        $this->assign('re',1);
                    }
                    $this->assign('re1',$re1);
                    $this->assign('info',$re);
                    
                }else{
                    $map['cate_name']=array('like','%'.$key.'%');
                    $re=D('cate')->where($map)->getField('cate_id,cate_name,info');
                    if(!sizeof($re)){
                        $this->assign('re',0);
                    }else{
                        $this->assign('re',1);
                    }
                    $this->assign('info',$re);
                }
            }
            if($_POST[2]){
                //群组
                $key=($_POST['typey']=='请输入关键字或ID')?'':I('post.typey');
                if(is_numeric($key)){
                    $map1['group_id']=$key;
                    $re1=D('typegroup')->where($map1)->find();
                    $map['group_id']=array('like','%'.$key.'%');
                    $re=D('typegroup')->where($map)->getField('type_id,group_id,title');
                    if(!sizeof($re)){
                        $this->assign('re',0);
                    }else{
                        $this->assign('re',1);
                    }
                    $this->assign('re1',$re1);
                    $this->assign('info',$re);
                    
                }else{
                    $map['title']=array('like','%'.$key.'%');
                    $re=D('typegroup')->where($map)->getField('type_id,group_id,title');
                    if(!sizeof($re)){
                        $this->assign('re',0);
                    }else{
                        $this->assign('re',1);
                    }
                    $this->assign('info',$re);
                }
            }
            if($_POST[3]){
                //商品
				$key=($_POST['typesp']=='请输入关键字或ID')?'':I('post.typesp');
                
                if(is_numeric($key)){
                    $map1['pro_num']=$key;
                    $re1=D('typegroupdetail')->where($map1)->find();
                    $map['pro_num']=array('like','%'.$key.'%');
                    $re=D('typegroupdetail')->where($map)->getField('typegroup_id,pro_num,proname_china,proname_english,pro_content');
                    if(!sizeof($re)){
                        $this->assign('re',0);
                    }else{
                        $this->assign('re',1);
                    }
                    $this->assign('re1',$re1);
                    $this->assign('info',$re);
                    
                }else{
                    $map['proname_china']=array('like','%'.$key.'%');
                    $map['proname_english']=array('like','%'.$key.'%');
                    $map['_logic'] = 'OR';
                    $re=D('typegroupdetail')->where($map)->getField('typegroup_id,pro_num,proname_china,proname_english,pro_content');
                    if(!sizeof($re)){
                        $this->assign('re',0);
                    }else{
                        $this->assign('re',1);
                    }
                    $this->assign('re1',$re1);
                    $this->assign('info',$re);
                }
            }
            if($_POST[4]){
                //图形编码
                $key=($_POST['typetx']=='请输入商标图形编码')?'':I('post.typetx');
                //print_r($key);
            }
            $this->assign('con',$key);
        }else{
            $_POST[1]=1;
            $this->assign('re',1);
        }
        $fenlei_all=$this->fenlei_all();
        $this->assign('fenlei_all',$fenlei_all['f1']);//分类表

        $this->display('tradeTm/tradeIndex');
    }
    public function tmtype(){
    	$_POST[1]=1;
    	$id= I('get.id');
    	$info=D('cate')->where('cate_id ='.$id)->find();
    	$this->assign('info',$info);
    	$list=D('typegroup')->where('type_id ='.$id)->select();
    	$this->assign('list',$list);    	

        // 获取head中title等的模板
		$tmpl_info = $this->view->get('tmpl_info');	// 获取已设置的模板
        $tmpl_info['title'] = preg_replace('/\[cate_id]/',$info['cate_id'], $tmpl_info['title']);
        $tmpl_info['title'] = preg_replace('/\[cate_name]/',$info['cate_name'], $tmpl_info['title']);
        $this->assign('tmpl_info', $tmpl_info);


    	$this->display('tradeTm/c01');
    }

    /*更多浏览记录*/
    public function myhistory(){
    	$this->display('tmClass/historyTm');
    }	

    public function fzMold(){
    	//print_r($_GET);exit;
    	$info='';
        $con['discu']=1;
        $vk=$_GET['pf']==1?2:1;
        $this->assign('pf',$vk);
        $vk=$_GET['sj']==1?2:1;
        $this->assign('sj',$vk);
        $vk=$_GET['sl']==1?2:1;
        $this->assign('sl',$vk);
        $vk=$_GET['jg']==1?2:1;
        $this->assign('jg',$vk);
        $page='fzMold';
        if($_POST){
        	//print_r($_POST);exit;
            if($_POST['price'][0]!=''&&$_POST['price'][1]!=''){
                $_POST['price']=join(',',$_POST['price']);
            }else{
                unset($_POST['price']);
            }
            $_POST['perrow']=20;
            $key=$this->arrtokey($_POST);
            S($key,$_POST,60*60*24);
            $data['id']=$key;
            $data['value']=json_encode($_POST);$data['uptime']=time();
            if(D('search')->where('id ="'.$key.'"')->find() ==''){
                D('search')->data($data)->add();
            }
            header('Location:http://'.C('WEBURL').U('Index/'.$page.'?skey='.$key));
            exit;
        }

    	if($_GET['skey']){
            $con=S($_GET['skey']);
            if($con==''){
                $con=D('search')->where('id ="'.$key.'"')->find();
                $con=json_decode($con['value']);
                S($key,$con,60*60*24);
            }
            
            unset($con['submit']);
            unset($con['Submit']);
            $con1=array();
            if($_GET['pf']){
            	#unset($con['pf']);
            	unset($con['sj']);
            	unset($con['sl']);
            	unset($con['jg']);
            	$con1['pf']=$_GET['pf'];
            }
            elseif($_GET['sj']){
            	unset($con['pf']);
            	#unset($con['sj']);
            	unset($con['sl']);
            	unset($con['jg']);
            	$con1['sj']=$_GET['sj'];
            }
            elseif($_GET['sl']){
            	unset($con['pf']);
            	unset($con['sj']);
            	#unset($con['sl']);
            	unset($con['jg']);
            	$con1['sl']=$_GET['sl'];
            }
            elseif($_GET['jg']){
            	unset($con['pf']);
            	unset($con['sj']);
            	unset($con['sl']);
            	#unset($con['jg']);
            	$con1['jg']=$_GET['jg'];
            }
            elseif($_GET['zh']){
            	unset($con['pf']);
            	unset($con['sj']);
            	unset($con['sl']);
            	unset($con['jg']);
            	$con1['zh']=1;
            }
            if($_GET['pf']){
                $con1['pf']=I('get.pf');
            }
            if($_GET['sj']){
                $con1['sj']=I('get.sj');
            }
            if($_GET['sl']){
            	$con1['sl']=I('get.sl');
            }
            if($_GET['jg']){
                $con1['jg']=I('get.jg');
            }
            if(($_GET['discu'])){
            	$con1['discu']=$_GET['discu'];
            }
            if($_GET['outsale']){
            	$con1['outsale']=$_GET['outsale'];
            }
            if($_GET['recommend']){
            	$con1['recommend']=$_GET['recommend'];
            }
            
            if($_GET['pricea']){
            	if($_GET['pricea'][0]!=''&&$_GET['pricea'][1]!=''){
            		$con1['price']=join(',',I('get.pricea'));
            	}
            }
            if($_GET['price']){
                $con1['price']=I('get.price');
            }
            if(!isset($_GET['discu'])&&isset($_GET['qqq'])){
            	unset($con['discu']);
            }
            if(!isset($_GET['outsale'])&&isset($_GET['qqq'])){
            	unset($con['outsale']);
            }
            if(!isset($_GET['recommend'])&&isset($_GET['qqq'])){
            	unset($con['recommend']);
            }
           //print_r($con);
            
            if(!empty($con1) || isset($_GET['qqq'])){
            	$con=array_merge($con,$con1);
            	$key=$this->arrtokey($con);
            	S($key,$con,60*60*24);
            	$data['id']=$key;
            	$data['value']=json_encode($con);
            	if(D('search')->where('id ="'.$key.'"')->find() ==''){
            		D('search')->data($data)->add();
            	}
            	header('Location:http://'.C('WEBURL').U('Index/'.$page.'?skey='.$key));
            	exit;
            }           
            $con['currpage']=$_GET['p']?$_GET['p']:1;
            if(!isset($con['discu'])){
            	$this->assign('discu','不包括面议商标');
            }else{
            	$this->assign('discu','包括面议商标');
            }
            $info=$this->getsearch($con);
            if($info=='-1'){
                $info='1';
            }else{
	            $count      = $info['list']['rows'];// 查询满足要求的总记录数
	            $this->assign('count',$count);
	            unset($info['list']['rows']);
	            $this->assign('info',$info['list']);
	            $Page       = new \Think\Page($count, $con['perrow']);// 实例化分页类 传入总记录数和每页显示的记录数
	            $show       = $Page->show();// 分页显示输出
	            $this->assign('page',$show);// 赋值分页输出
            }
            $this->assign('url',U('Index/'.$page.'?skey='.$_GET['skey']));
            $this->assign('info',$info['list']);
    	}
        $this->assign('date',$this->GetMonth());
        $this->assign('con',$con);


	/*获取收藏夹信息*/
        if($_SESSION['uid']){
        	$fileid = M('Collectfile')->where('uid='.$_SESSION['uid']." and filename='未处理收藏夹'")->getField('id');
        	$tmids = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->order('id desc')->field('tm_id')->limit(6)->select();
        	$count = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->field('tm_id')->select();
        	$count = count($count);
        	$this->assign('coll_num',$count);
        	foreach( $tmids as $tmid){
        		$ids .= $tmid['tm_id'].',';
        	}
        	$ids = rtrim($ids,',');
        	$arr_post = array('ids'=>$ids,'fields'=>'tm_name,tm_id,tm_categories,belong_groupdetail');
        	$collinfo = gettmlist($arr_post);
        	$colltminfo = array();
        	foreach ($collinfo as $coll){
        		$coll['img'] = C('PIC4').'/'.$coll['tm_id'];
        		$colltminfo[] = $coll;
        	}
        	$this->assign('colltminfo',$colltminfo);
        }
        $classes = S('fenlei_all')[f1][25]['count']+S('fenlei_all')[f1][46]['count'];;
        $this->assign('classes',$classes);

	if($con['category']){
    		$ids = explode(',',$con['category']);
        	if(count($ids) > 5){
        		for($i=0; $i<5;$i++){
        			$idstr .= $ids[$i].',';
        		}
        		$idstr = rtrim($idstr,',');
        	}else{
        		if(cookie('cate')){
        			$old = explode(',',cookie('cate'));
        			for($i=count($old)-1;$i>=0;$i--){
        				if(count($ids)<5){
        					if(!in_array($old[$i],$ids)){
        						$ids[]=$old[$i];
        					}
        				}
        			}
        		}
        		if(count($ids)>1){
        			$idstr = implode(',',$ids);
        		}else{
        			$idstr = $ids[0];
        		}
    			
        	}
    		cookie('cate',$idstr,3600*24*365*10);
    		if(cookie('catetime')){
    			cookie('catetime',cookie('catetime')+1,3600);
    			if(count(explode(',',cookie('catetime')))>2){
    				cookie('keyword',null);
    			}
    		}else{
    			cookie('catetime',1,3600);
    		}    		 
    	}

    	$this->display('tmClass/fzMold');
    }
    public function graphSearch(){
    	$info='';
        $con['like']=1;
        $con['discu']=1;
        $vk=$_GET['pf']==1?2:1;
        $this->assign('pf',$vk);
        $vk=$_GET['sj']==1?2:1;
        $this->assign('sj',$vk);
        $vk=$_GET['sl']==1?2:1;
        $this->assign('sl',$vk);
        $vk=$_GET['jg']==1?2:1;
        $this->assign('jg',$vk);
        $page='graphSearch';
        if($_POST){
            if($_POST['price'][0]!=''&&$_POST['price'][1]!=''){
                $_POST['price']=join(',',$_POST['price']);
            }else{
                unset($_POST['price']);
            }
            if($_POST['category']==''){
            	unset($_POST['category']);
            }
            if(!is_array($_POST['category'])){
                if(strpos($_POST['category'],"类")){
                    $_POST['category']=str_replace("类","",$_POST['category']);
                    $_POST['category']=str_replace("第","",$_POST['category']);
                }
            }
            if($_POST['category']&&is_array($_POST['category'])){
				$_POST['category']=join(',',$_POST['category']);
            }
            $_POST['perrow']=20;

            if($_POST['25code']=='请输入商标图形编码'){
				unset($_POST['25code']);
            }
            $key=$this->arrtokey($_POST);
            S($key,$_POST,60*60*24);
            $data['id']=$key;
            $data['value']=json_encode($_POST);$data['uptime']=time();
            if(D('search')->where('id ="'.$key.'"')->find() ==''){
                D('search')->data($data)->add();
            }
            header('Location:http://'.C('WEBURL').U('Index/'.$page.'?skey='.$key));
            exit;
        }

    	if($_GET['skey']){
            $con=S($_GET['skey']);
            if($con==''){
                $con=D('search')->where('id ="'.$key.'"')->find();
                $con=json_decode($con['value']);
                S($key,$con,60*60*24);
            }
            unset($con['submit']);
            unset($con['Submit']);
    		$con1=array();
            if($_GET['pf']){
            	#unset($con['pf']);
            	unset($con['sj']);
            	unset($con['sl']);
            	unset($con['jg']);
            	$con1['pf']=$_GET['pf'];
            }
            elseif($_GET['sj']){
            	unset($con['pf']);
            	#unset($con['sj']);
            	unset($con['sl']);
            	unset($con['jg']);
            	$con1['sj']=$_GET['sj'];
            }
            elseif($_GET['sl']){
            	unset($con['pf']);
            	unset($con['sj']);
            	#unset($con['sl']);
            	unset($con['jg']);
            	$con1['sl']=$_GET['sl'];
            }
            elseif($_GET['jg']){
            	unset($con['pf']);
            	unset($con['sj']);
            	unset($con['sl']);
            	#unset($con['jg']);
            	$con1['jg']=$_GET['jg'];
            }
            elseif($_GET['zh']){
            	unset($con['pf']);
            	unset($con['sj']);
            	unset($con['sl']);
            	unset($con['jg']);
            	$con1['zh']=1;
            }
            if($_GET['pf']){
                $con1['pf']=I('get.pf');
            }
            if($_GET['sj']){
                $con1['sj']=I('get.sj');
            }
            if($_GET['sl']){
            	$con1['sl']=I('get.sl');
            }
            if($_GET['jg']){
                $con1['jg']=I('get.jg');
            }
            if(($_GET['discu'])){
            	$con1['discu']=$_GET['discu'];
            }
            if($_GET['outsale']){
            	$con1['outsale']=$_GET['outsale'];
            }
            if($_GET['recommend']){
            	$con1['recommend']=$_GET['recommend'];
            }
            
            if($_GET['pricea']){
            	if($_GET['pricea'][0]!=''&&$_GET['pricea'][1]!=''){
            		$con1['price']=join(',',I('get.pricea'));
            	}
            }
            if($_GET['price']){
                $con1['price']=I('get.price');
            }
            if(!isset($_GET['discu'])&&isset($_GET['qqq'])){
            	unset($con['discu']);
            }
            if(!isset($_GET['outsale'])&&isset($_GET['qqq'])){
            	unset($con['outsale']);
            }
            if(!isset($_GET['recommend'])&&isset($_GET['qqq'])){
            	unset($con['recommend']);
            }
           //print_r($con);   
            if(!empty($con1) || isset($_GET['qqq'])){
            	$con=array_merge($con,$con1);
            	$key=$this->arrtokey($con);
            	S($key,$con,60*60*24);
            	$data['id']=$key;
            	$data['value']=json_encode($con);
            	if(D('search')->where('id ="'.$key.'"')->find() ==''){
            		D('search')->data($data)->add();
            	}
            	header('Location:http://'.C('WEBURL').U('Index/'.$page.'?skey='.$key));
            	exit;
            }           
            $con['currpage']=$_GET['p']?$_GET['p']:1;
            if(!isset($con['discu'])){
            	$this->assign('discu','不包括面议商标');
            }else{
            	$this->assign('discu','包括面议商标');
            }
            $info=$this->getsearch($con);
            //print_r($con);
            //print_r($info);exit;
            if($info=='-1'){
                $info='1';
            }else{
	            $count      = $info['list']['rows'];// 查询满足要求的总记录数
	            $this->assign('count',$count);
	            unset($info['list']['rows']);
	            $this->assign('info',$info['list']);
	            $Page       = new \Think\Page($count, $con['perrow']);// 实例化分页类 传入总记录数和每页显示的记录数
	            $show       = $Page->show();// 分页显示输出
	            $this->assign('page',$show);// 赋值分页输出
            }
            $this->assign('url',U('Index/'.$page.'?skey='.$_GET['skey']));
    	}
    	if($con['category']!=''){
            $clist=explode(',',$con['category']);
            if(sizeof($clist)>5){
                foreach($clist as $kc=>$vc){
                    if($kc<5){
                        $clist1[$kc]=$vc;
                    }
                }
                $clist=join(',',$clist1);
                $this->assign('category_text','已选择了<strong style="color:red">'.$clist.',...</strong>类');
            }else{
                $this->assign('category_text','已选择了<strong style="color:red">'.$con['category'].'</strong>类');
            }
            foreach($clist as $v){
            	$classes += S('fenlei_all')[f1][$v]['count'];
            	if($v==25){
            		$classes += S('fenlei_all')[f1][46]['count'];
            	}
            }
            $this->assign('classes',$classes);
    	}else{
    		$this->assign('category_text','全部分类');
    		$classes += S('fenlei_all')[all];
    		$this->assign('classes',$classes);
    	}
        $this->assign('date',$this->GetMonth());
    	//print_r($this->txcode());exit;
    	//print_r($con);
        $this->assign('con',$con);
        $this->assign('info',$info['list']);

		/*获取收藏夹信息*/
        if($_SESSION['uid']){
        	$fileid = M('Collectfile')->where('uid='.$_SESSION['uid']." and filename='未处理收藏夹'")->getField('id');
        	$tmids = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->order('id desc')->field('tm_id')->limit(6)->select();
        	$count = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->field('tm_id')->select();
        	$count = count($count);
        	$this->assign('coll_num',$count);
        	$ids = '';
        	foreach( $tmids as $tmid){
        		$ids .= $tmid['tm_id'].',';
        	}
        	$ids = rtrim($ids,',');
        	$arr_post = array('ids'=>$ids,'fields'=>'tm_name,tm_id,tm_categories,belong_groupdetail');
        	$collinfo = gettmlist($arr_post);
        	$colltminfo = array();
        	foreach ($collinfo as $coll){
        		$coll['img'] = C('PIC4').'/'.$coll['tm_id'];
        		$colltminfo[] = $coll;
        	}
        	$this->assign('colltminfo',$colltminfo);
        }

		if($con['category']){
    		$ids = explode(',',$con['category']);
        	if(count($ids) > 5){
        		for($i=0; $i<5;$i++){
        			$idstr .= $ids[$i].',';
        		}
        		$idstr = rtrim($idstr,',');
        	}else{
        		if(cookie('cate')){
        			$old = explode(',',cookie('cate'));
        			for($i=count($old)-1;$i>=0;$i--){
        				if(count($ids)<5){
        					if(!in_array($old[$i],$ids)){
        						$ids[]=$old[$i];
        					}
        				}
        			}
        		}
        		if(count($ids)>1){
        			$idstr = implode(',',$ids);
        		}else{
        			$idstr = $ids[0];
        		}
    			
        	}
    		cookie('cate',$idstr,3600*24*365*10);
    		if(cookie('catetime')){
    			cookie('catetime',cookie('catetime')+1,3600);
    			if(count(explode(',',cookie('catetime')))>2){
    				cookie('keyword',null);
    			}
    		}else{
    			cookie('catetime',1,3600);
    		}
    		 
    	}

    	$this->display('tmClass/graphSearch');
    }
    public function similarSearch(){
    	$info='';
    	$con['discu']=1;
    	$con['type']=1;
        $vk=$_GET['pf']==1?2:1;
        $this->assign('pf',$vk);
        $vk=$_GET['sj']==1?2:1;
        $this->assign('sj',$vk);
        $vk=$_GET['sl']==1?2:1;
        $this->assign('sl',$vk);
        $vk=$_GET['jg']==1?2:1;
        $this->assign('jg',$vk);
        $page = 'similarSearch';
        if($_POST){
        	//print_r($_POST);
        	for($i=1;$i<7;$i++){
        		$name='ways'.$i;
        		if($_POST['type']==$i){
        			$_POST['ways']=$_POST[$name];
        		}
        		unset($_POST[$name]);
        		
        	}
        	$_POST['ways']=join(',',$_POST['ways']);
            if($_POST['content']=='请输入查询关键字'){
                unset($_POST['content']);
            }
            if($_POST['price'][0]!=''&&$_POST['price'][1]!=''){
                $_POST['price']=join(',',$_POST['price']);
            }else{
                unset($_POST['price']);
            }
            if($_POST['category']==''){
            	unset($_POST['category']);
            }
            $_POST['perrow']=20;
            if($_POST['category']&&is_array($_POST['category'])){
				$_POST['category']=join(',',$_POST['category']);
            }
            $_POST['perrow']=20;
            if($_POST['25code']=='请输入商标图形编码'){
				unset($_POST['25code']);
            }
            //print_r($_POST);exit;
            $key=$this->arrtokey($_POST);
            S($key,$_POST,60*60*24);
            $data['id']=$key;
            $data['value']=json_encode($_POST);$data['uptime']=time();
            if(D('search')->where('id ="'.$key.'"')->find() ==''){
                D('search')->data($data)->add();
            }
            header('Location:http://'.C('WEBURL').U('Index/'.$page.'?skey='.$key));
            exit;
        }

    	if($_GET['skey']){
            $con=S($_GET['skey']);
            if($con==''){
                $con=D('search')->where('id ="'.$key.'"')->find();
                $con=json_decode($con['value']);
                S($key,$con,60*60*24);
            }
            $con['currpage']=$_GET['p']?$_GET['p']:1;
            unset($con['submit']);
            unset($con['Submit']);
    		$con1=array();
            if($_GET['pf']){
            	#unset($con['pf']);
            	unset($con['sj']);
            	unset($con['sl']);
            	unset($con['jg']);
            	$con1['pf']=$_GET['pf'];
            }
            elseif($_GET['sj']){
            	unset($con['pf']);
            	#unset($con['sj']);
            	unset($con['sl']);
            	unset($con['jg']);
            	$con1['sj']=$_GET['sj'];
            }
            elseif($_GET['sl']){
            	unset($con['pf']);
            	unset($con['sj']);
            	#unset($con['sl']);
            	unset($con['jg']);
            	$con1['sl']=$_GET['sl'];
            }
            elseif($_GET['jg']){
            	unset($con['pf']);
            	unset($con['sj']);
            	unset($con['sl']);
            	#unset($con['jg']);
            	$con1['jg']=$_GET['jg'];
            }
            elseif($_GET['zh']){
            	unset($con['pf']);
            	unset($con['sj']);
            	unset($con['sl']);
            	unset($con['jg']);
            	$con1['zh']=1;
            }
            if($_GET['pf']){
                $con1['pf']=I('get.pf');
            }
            if($_GET['sj']){
                $con1['sj']=I('get.sj');
            }
            if($_GET['sl']){
            	$con1['sl']=I('get.sl');
            }
            if($_GET['jg']){
                $con1['jg']=I('get.jg');
            }
            if(($_GET['discu'])){
            	$con1['discu']=$_GET['discu'];
            }
            if($_GET['outsale']){
            	$con1['outsale']=$_GET['outsale'];
            }
            if($_GET['recommend']){
            	$con1['recommend']=$_GET['recommend'];
            }
            
            if($_GET['pricea']){
            	if($_GET['pricea'][0]!=''&&$_GET['pricea'][1]!=''){
            		$con1['price']=join(',',I('get.pricea'));
            	}
            }
            if($_GET['price']){
                $con1['price']=I('get.price');
            }
            if(!isset($_GET['discu'])&&isset($_GET['qqq'])){
            	unset($con['discu']);
            }
            if(!isset($_GET['outsale'])&&isset($_GET['qqq'])){
            	unset($con['outsale']);
            }
            if(!isset($_GET['recommend'])&&isset($_GET['qqq'])){
            	unset($con['recommend']);
            }
            //print_r($con);
            if(!empty($con1)||isset($_GET['qqq'])){
            	$con=array_merge($con,$con1);
            	$key=$this->arrtokey($con);
            	S($key,$con,60*60*24);
            	$data['id']=$key;
            	$data['value']=json_encode($con);
            	if(D('search')->where('id ="'.$key.'"')->find() ==''){
            		D('search')->data($data)->add();
            	}
            	header('Location:http://'.C('WEBURL').U('Index/'.$page.'?skey='.$key));
            	exit;
            }
            $con['currpage']=$_GET['p']?$_GET['p']:1;
            if(!isset($con['discu'])){
            	$this->assign('discu','不包括面议商标');
            }else{
            	$this->assign('discu','包括面议商标');
            }
            //print_r($con);exit;
            $info=$this->getnears($con);
            if($info=='-1'){
                $info='1';
            }else{
	            $count      = $info['list']['rows'];// 查询满足要求的总记录数
	            $this->assign('count',$count);
	            unset($info['list']['rows']);
	            $this->assign('info',$info['list']);
	            $Page       = new \Think\Page($count, $con['perrow']);// 实例化分页类 传入总记录数和每页显示的记录数
	            $show       = $Page->show();// 分页显示输出
	            $this->assign('page',$show);// 赋值分页输出
            }
            $this->assign('url',U('Index/'.$page.'?skey='.$_GET['skey']));        
    	}

    	if($con['category']!=''){
            $clist=explode(',',$con['category']);
            if(sizeof($clist)>5){
                foreach($clist as $kc=>$vc){
                    if($kc<5){
                        $clist1[$kc]=$vc;
                    }
                }
                $clist=join(',',$clist1);
                $this->assign('category_text','已选择了<strong style="color:red">'.$clist.',...</strong>类');
            }else{
                $this->assign('category_text','已选择了<strong style="color:red">'.$con['category'].'</strong>类');
            }
            foreach($clist as $v){
            	$classes += S('fenlei_all')[f1][$v]['count'];
            	if($v==25){
            		$classes += S('fenlei_all')[f1][46]['count'];
            	}
            }
            $this->assign('classes',$classes);
    	}else{
    		$this->assign('category_text','全部分类');
    		$classes += S('fenlei_all')[all];
    		$this->assign('classes',$classes);
    	}
        $this->assign('date',$this->GetMonth());
    	//print_r($this->txcode());exit;
    	//print_r($con);
        $this->assign('con',$con);
        $this->assign('info',$info['list']);

		/*获取收藏夹信息*/
        if($_SESSION['uid']){
        	$fileid = M('Collectfile')->where('uid='.$_SESSION['uid']." and filename='未处理收藏夹'")->getField('id');
        	$tmids = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->order('id desc')->field('tm_id')->limit(6)->select();
        	$count = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->field('tm_id')->select();
        	$count = count($count);
        	$this->assign('coll_num',$count);
        	$ids = '';
        	foreach( $tmids as $tmid){
        		$ids .= $tmid['tm_id'].',';
        	}
        	$ids = rtrim($ids,',');
        	$arr_post = array('ids'=>$ids,'fields'=>'tm_name,tm_id,tm_categories,belong_groupdetail');
        	$collinfo = gettmlist($arr_post);
        	$colltminfo = array();
        	foreach ($collinfo as $coll){
        		$coll['img'] = C('PIC4').'/'.$coll['tm_id'];
        		$colltminfo[] = $coll;
        	}
        	$this->assign('colltminfo',$colltminfo);
        }

		if($con['category']){
    		$ids = explode(',',$con['category']);
        	if(count($ids) > 5){
        		for($i=0; $i<5;$i++){
        			$idstr .= $ids[$i].',';
        		}
        		$idstr = rtrim($idstr,',');
        	}else{
        		if(cookie('cate')){
        			$old = explode(',',cookie('cate'));
        			for($i=count($old)-1;$i>=0;$i--){
        				if(count($ids)<5){
        					if(!in_array($old[$i],$ids)){
        						$ids[]=$old[$i];
        					}
        				}
        			}
        		}
        		if(count($ids)>1){
        			$idstr = implode(',',$ids);
        		}else{
        			$idstr = $ids[0];
        		}
    			
        	}
    		cookie('cate',$idstr,3600*24*365*10);
    		if(cookie('catetime')){
    			cookie('catetime',cookie('catetime')+1,3600);
    			if(count(explode(',',cookie('catetime')))>2){
    				cookie('keyword',null);
    			}
    		}else{
    			cookie('catetime',1,3600);
    		}
    		 
    	}
    	$this->display('tmClass/similarSearch');
    }
    public function permisTm(){
        $page='permisTm';
        $info='';
        $con['discu']=1;
        $vk=$_GET['pf']==1?2:1;
        $this->assign('pf',$vk);
        $vk=$_GET['sj']==1?2:1;
        $this->assign('sj',$vk);
        $vk=$_GET['sl']==1?2:1;
        $this->assign('sl',$vk);
        $vk=$_GET['jg']==1?2:1;
        $this->assign('jg',$vk);
        
        if($_POST){
            if($_POST['price'][0]!=''&&$_POST['price'][1]!=''){
                $_POST['price']=join(',',$_POST['price']);
            }else{
                unset($_POST['price']);
            }
            if($_POST['category']==''){
                unset($_POST['category']);
            }
            if($_POST['category']&&is_array($_POST['category'])){
                $_POST['category']=join(',',$_POST['category']);
            }
            $_POST['perrow']=20;
            $key=$this->arrtokey($_POST);
            $this->assign('keys',$key);
            S($key,$_POST,60*60*24);
            $data['id']=$key;
            $data['value']=json_encode($_POST);$data['uptime']=time();
            if(D('search')->where('id ="'.$key.'"')->find() ==''){
                D('search')->data($data)->add();
            }
            header('Location:http://'.C('WEBURL').U('Index/'.$page.'?skey='.$key));
            exit;
        }

        if($_GET['skey']){
        	//print_r($_GET);exit;
            $con=S($_GET['skey']);
            if($con==''){
                $con=D('search')->where('id ="'.$key.'"')->find();
                $con=json_decode($con['value']);
                S($key,$con,60*60*24);
            }
            $con['currpage']=$_GET['p']?$_GET['p']:1;
            unset($con['submit']);
            unset($con['Submit']);
        	$con1=array();
            if($_GET['pf']){
            	#unset($con['pf']);
            	unset($con['sj']);
            	unset($con['sl']);
            	unset($con['jg']);
            	$con1['pf']=$_GET['pf'];
            }
            elseif($_GET['sj']){
            	unset($con['pf']);
            	#unset($con['sj']);
            	unset($con['sl']);
            	unset($con['jg']);
            	$con1['sj']=$_GET['sj'];
            }
            elseif($_GET['sl']){
            	unset($con['pf']);
            	unset($con['sj']);
            	#unset($con['sl']);
            	unset($con['jg']);
            	$con1['sl']=$_GET['sl'];
            }
            elseif($_GET['jg']){
            	unset($con['pf']);
            	unset($con['sj']);
            	unset($con['sl']);
            	#unset($con['jg']);
            	$con1['jg']=$_GET['jg'];
            }
            elseif($_GET['zh']){
            	unset($con['pf']);
            	unset($con['sj']);
            	unset($con['sl']);
            	unset($con['jg']);
            	$con1['zh']=1;
            }
            if($_GET['pf']){
                $con1['pf']=I('get.pf');
            }
            if($_GET['sj']){
                $con1['sj']=I('get.sj');
            }
            if($_GET['sl']){
            	$con1['sl']=I('get.sl');
            }
            if($_GET['jg']){
                $con1['jg']=I('get.jg');
            }
            if(($_GET['discu'])){
            	$con1['discu']=$_GET['discu'];
            }
            if($_GET['outsale']){
            	$con1['outsale']=$_GET['outsale'];
            }
            if($_GET['recommend']){
            	$con1['recommend']=$_GET['recommend'];
            }
            
            if($_GET['pricea']){
            	if($_GET['pricea'][0]!=''&&$_GET['pricea'][1]!=''){
            		$con1['price']=join(',',I('get.pricea'));
            	}
            }
            if($_GET['price']){
                $con1['price']=I('get.price');
            }
            if(!isset($_GET['discu'])&&isset($_GET['qqq'])){
            	unset($con['discu']);
            }
            if(!isset($_GET['outsale'])&&isset($_GET['qqq'])){
            	unset($con['outsale']);
            }
            if(!isset($_GET['recommend'])&&isset($_GET['qqq'])){
            	unset($con['recommend']);
            }
            //print_r($con);exit;
            if(!empty($con1)||isset($_GET['qqq'])){
            	$con=array_merge($con,$con1);
				//print_r($con);exit;
            	$key=$this->arrtokey($con);
            	S($key,$con,60*60*24);
            	$this->assign('keys',$key);
            	$data['id']=$key;
            	$data['value']=json_encode($con);
            	if(D('search')->where('id ="'.$key.'"')->find() ==''){
            		D('search')->data($data)->add();
            	}
            	header('Location:http://'.C('WEBURL').U('Index/'.$page.'?skey='.$key));
            	exit;
            }
            $key=$this->arrtokey($con);
            S($key,$con,60*60*24);
            $this->assign('keys',$key);
            $con['currpage']=$_GET['p']?$_GET['p']:1;
            if(!isset($con['discu'])){
            	$this->assign('discu','不包括面议商标');
            }else{
            	$this->assign('discu','包括面议商标');
            }
            $info=$this->getxuke($con);
            //print_r($info);exit;
            if($info=='-1'){
                $info='1';
            }else{
	            $count      = $info['list']['rows'];// 查询满足要求的总记录数
	            $this->assign('count',$count);
	            unset($info['list']['rows']);
	            $this->assign('info',$info['list']);
	            $Page       = new \Think\Page($count, $con['perrow']);// 实例化分页类 传入总记录数和每页显示的记录数
	            $show       = $Page->show();// 分页显示输出
	            $this->assign('page',$show);// 赋值分页输出
            }
            $this->assign('url',U('Index/'.$page.'?skey='.$_GET['skey']));
        }else{           
	        $con['currpage']=$_GET['p']?$_GET['p']:1;
	        $con['category']=25;
	        $con['perrow']=20;
	        $key=$this->arrtokey($con);
	        S($key,$con,60*60*24);
	        $this->assign('keys',$key);
	        if(!isset($con['discu'])){
	        	$this->assign('discu','不包括面议商标');
	        }else{
	        	$this->assign('discu','包括面议商标');
	        }
	        $info=$this->getxuke($con);
	        $count      = $info['list']['rows'];// 查询满足要求的总记录数
	        $this->assign('count',$count);
	        unset($info['list']['rows']);
	        $this->assign('info',$info['list']);
	        $Page       = new \Think\Page($count, $con['perrow']);// 实例化分页类 传入总记录数和每页显示的记录数
	        $show       = $Page->show();// 分页显示输出
	        $this->assign('page',$show);// 赋值分页输出
	        $this->assign('url',U('Index/'.$page));
        }

        if($con['category']!=''){
            $clist=explode(',',$con['category']);
            if(sizeof($clist)>5){
                foreach($clist as $kc=>$vc){
                    if($kc<5){
                        $clist1[$kc]=$vc;
                    }
                }
                $clist=join(',',$clist1);
                $this->assign('category_text','已选择了<strong style="color:red">'.$clist.',...</strong>类');
            }else{
                $this->assign('category_text','已选择了<strong style="color:red">'.$con['category'].'</strong>类');
            }
        }
        $this->assign('date',$this->GetMonth());
        //print_r($this->txcode());exit;
        //print_r($con);
        $this->assign('con',$con);
        $this->assign('info',$info['list']);

		if($con['category']){
    		$ids = explode(',',$con['category']);
        	if(count($ids) > 5){
        		for($i=0; $i<5;$i++){
        			$idstr .= $ids[$i].',';
        		}
        		$idstr = rtrim($idstr,',');
        	}else{
        		if(cookie('cate')){
        			$old = explode(',',cookie('cate'));
        			for($i=count($old)-1;$i>=0;$i--){
        				if(count($ids)<5){
        					if(!in_array($old[$i],$ids)){
        						$ids[]=$old[$i];
        					}
        				}
        			}
        		}
        		if(count($ids)>1){
        			$idstr = implode(',',$ids);
        		}else{
        			$idstr = $ids[0];
        		}
    			
        	}
    		cookie('cate',$idstr,3600*24*365*10);
    		if(cookie('catetime')){
    			cookie('catetime',cookie('catetime')+1,3600);
    			if(count(explode(',',cookie('catetime')))>2){
    				cookie('keyword',null);
    			}
    		}else{
    			cookie('catetime',1,3600);
    		}		    		 
    	}
        
        /*获取收藏夹信息*/
        if($_SESSION['uid']){
        	$fileid = M('Collectfile')->where('uid='.$_SESSION['uid']." and filename='未处理收藏夹'")->getField('id');
        	$tmids = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->order('id desc')->field('tm_id')->limit(6)->select();
        	$count = M('Collecttm')->where(array('uid'=>$_SESSION['uid'],'file_id'=>$fileid))->field('tm_id')->select();
        	$count = count($count);
        	$this->assign('coll_num',$count);
        	$ids = '';
        	foreach( $tmids as $tmid){
        		$ids .= $tmid['tm_id'].',';
        	}
        	$ids = rtrim($ids,',');
        	$arr_post = array('ids'=>$ids,'fields'=>'tm_name,tm_id,tm_categories,belong_groupdetail');
        	$collinfo = gettmlist($arr_post);
        	$colltminfo = array();
        	foreach ($collinfo as $coll){
        		$coll['img'] = C('PIC4').'/'.$coll['tm_id'];
        		$colltminfo[] = $coll;
        	}
        	$this->assign('colltminfo',$colltminfo);
        }
        foreach($clist as $v){
        	$classes += S('fenlei_all')[f1][$v]['count'];
        	if($v==25){
        		$classes += S('fenlei_all')[f1][46]['count'];
        	}
        }
        $this->assign('classes',$classes);
    	$this->display('tmClass/permisTm');
    }
    
      public function cookieids(){
     	if(cookie('ids')){
     		if (!in_array($_POST['id'], explode(',',cookie('ids')))){
     			cookie('ids',cookie('ids').','.$_POST['id'],3600*24*365*10);
     		}
     		if (count(explode(',',cookie('ids')))>5){
     			$ids = explode(',',cookie('ids'));
     			$ids = array_shift($ids);
     			$ids = implode(',',cookie('ids'));
     			cookie('ids',$ids,3600*24*365*10);
     			cookie('cate',null);
     			cookie('keyword',null);
     		}
     	}else{
     		cookie('ids',$_POST['id'],3600*24*365*10);
     	}
    }

    public function tmWrapSearch(){
            $con['currpage']=$_GET['p']?$_GET['p']:1;
            $con['perrow']=5;
            $info=$this->getsbbao($con);
            //$this->assign('date',$this->GetMonth());
            $Page       = new \Think\Page($info['rows'], $con['perrow']);// 实例化分页类 传入总记录数和每页显示的记录数
            $show       = $Page->show();// 分页显示输出
            unset($info['rows']);
            $this->assign('info',$info);
            //print_r($info);
            $this->assign('page',$show);// 赋值分页输出
        
    		$this->display('tmClass/tmWrapSearch');
    }
    public function tmwrap(){
        if($_GET['name']){
            $con['currpage']=$_GET['p']?$_GET['p']:1;
            $con['perrow']=20;
            $con['tagname']=I('get.name');
            $info=$this->getsbbao($con);
            $this->assign('count',$info['rows']);
            $this->assign('date',$this->GetMonth());
            $Page       = new \Think\Page($info['rows'], $con['perrow']);// 实例化分页类 传入总记录数和每页显示的记录数
            $show       = $Page->show();// 分页显示输出
            unset($info['rows']);
            $this->assign('info',$info);
           // print_r($info);
            $this->assign('page',$show);// 赋值分页输出

            $this->display('tmClass/baoTmList');
        }else{
            $this->error('页面错误');
        }
    }
    public function sameSearch(){
    	if($_GET['cate']){
    		//print_r($_GET['cate']);exit;
    		if(is_array($_GET['cate'])){
    			header('Location:http://'.C('WEBURL').U('Index/sameSearch',array('cate'=>join(',',$_GET['cate']))));
    			exit;
    		}
    		$con['cate']=$_GET['cate'];
    		$con['currpage']=$_GET['p']?$_GET['p']:1;
    		$con['perrow']=10;
    		$info=$this->getsamesearch($con);
    		$this->assign('date',$this->GetMonth());
            $Page       = new \Think\Page($info['rows'], $con['perrow']);// 实例化分页类 传入总记录数和每页显示的记录数
            $show       = $Page->show();// 分页显示输出
    		unset($info['rows']);
    		$this->assign('info',$info);
            $this->assign('page',$show);// 赋值分页输出
    		$this->display('tmClass/sameList');
    		exit;
    	}
    		
    	$this->display('tmClass/sameSearch');
    }
    public function sameTmlist(){
    	if($_GET['id']){
    		$con['id']=$_GET['id'];
    		$info=$this->getsamesearch($con);
    		$this->assign('info',$info);
    		//print_r($info);
    		$this->display('tmClass/sameTmList');
    	}else{
    		$this->error('错误');
    	}
    }
    public function tmclassg(){
    	//群组搜索
    	$_POST['25group']=I('get.id');
    	$cate=D('typegroup')->where('group_id ='.I('get.id'))->find();
    	$_POST['category']= $cate['type_id'];

    	$this->_search($page='search',$type=1);

    }
    public function tmgroup(){
    	//群组产品列表
    	$_POST[1]=1;
    	$id= I('get.id');
    	$map['pro_num']=array('like',$id.'%');
    	$list=D('typegroupdetail')->where($map)->select();
    	$this->assign('list',$list);    	

        // 获取head中title等的模板
		$tmpl_info = $this->view->get('tmpl_info');	// 获取已设置的模板
        // 类似[group_id]的-商品/服务分类表-华唯商标转让网
        $tmpl_info['title'] = preg_replace('/\[group_id]/',$id, $tmpl_info['title']);
        $this->assign('tmpl_info', $tmpl_info);


    	$this->display('tradeTm/g0101');
    }
    public function tmpro(){
    	//产品列表
    }
    public function header_search(){
    	$this->_search($page='header_search',$type=2);
    }
    public function quxiantu(){
        /*echo htmlspecialchars_decode(I('get.date'));
        echo htmlspecialchars_decode(I('get.data'));
        exit;*/
        $this->assign('date',htmlspecialchars_decode(I('get.date')));
        $this->assign('data',htmlspecialchars_decode(I('get.data')));
        $this->display();
    }
    public function kefu(){
		$field = 'b.user_nicename as name,a.sno,a.admin_id as id,a.qq,a.ali,a.cc,a.weixin';
		$table = '__KEFU__ a';
		$join = '__USERS__ b on a.admin_id=b.id';
		$ccbuy=M()->table($table)->join($join)->where("cc_status=1 and stype=1 and status=1")->field($field)->select();
		$ccsell=M()->table($table)->join($join)->where("cc_status=1 and stype=2 and status=1")->field($field)->select();
		$ccreg=M()->table($table)->join($join)->where("cc_status=1 and stype=3 and status=1")->field($field)->select();
		$qqbuy=M()->table($table)->join($join)->where("qq_status=1 and stype=1 and status=1")->field($field)->select();
		$qqsell=M()->table($table)->join($join)->where("qq_status=1 and stype=2 and status=1")->field($field)->select();
		$qqreg=M()->table($table)->join($join)->where("qq_status=1 and stype=3 and status=1")->field($field)->select();
		$wwbuy=M()->table($table)->join($join)->where("ali_status=1 and stype=1 and status=1")->field($field)->select();
		$wwsell=M()->table($table)->join($join)->where("ali_status=1 and stype=2 and status=1")->field($field)->select();
		$wwreg=M()->table($table)->join($join)->where("ali_status=1 and stype=3 and status=1")->field($field)->select();
		$wxbuy=M()->table($table)->join($join)->where("weixin_status=1 and stype=1 and status=1")->field($field)->select();
		$wxsell=M()->table($table)->join($join)->where("weixin_status=1 and stype=2 and status=1")->field($field)->select();
		$wxreg=M()->table($table)->join($join)->where("weixin_status=1 and stype=3 and status=1")->field($field)->select();
		$this->assign('ccbuy',$ccbuy);
        $this->assign('ccsell',$ccsell);
        $this->assign('ccreg',$ccreg);
        $this->assign('qqbuy',$qqbuy);
        $this->assign('qqsell',$qqsell);
        $this->assign('qqreg',$qqreg);
        $this->assign('wwbuy',$wwbuy);
        $this->assign('wwsell',$wwsell);
        $this->assign('wwreg',$wwreg);
        $this->assign('wxbuy',$wxbuy);
        $this->assign('wxsell',$wxsell);
        $this->assign('wxreg',$wxreg);

        $this->display('kefu/index');
    }
    /*判断客户点击客服*/
    public function getMa(){
        /*判断cookie是否存在*/
        $coo = $_POST['uid'].$_POST['keid'].$_POST['ktype'];
        if(empty($_COOKIE[$coo])){
            setcookie($coo,1,time()+10,'/');
            $_POST['uptime']=time();
            M('Contact')->add($_POST);
        }
    }
    // 发表评论
    public function addPost() {
        $rules = array(
                array('level','require','请选择评价等级！',1,'',3),
                array('content','require','评论内容不能为空！',1,'',3)
            );
        if(D('Comments')->validate($rules)->create($_POST)){
            $_POST['tm_id']=$_GET['id'];
            $_POST['uid']= session('uid')?:$_COOKIE['uid'];
            $_POST['uptime']=time();
            if(D('Comments')->add($_POST)){
                $this->success('评论成功！');
                }else{
                    $this->error('评论失败！');
                    }
            }else{
                $this->error(D('Comments')->getError());
                }
    }
	// 检查手机是否在黑名单中
    public function chkCellphone(){
        $cellphone = trim(I('get.chkc')); // 获取手机号码
        // 手机11位 或者 电话(3-4位区号)7-8为主机号(3-4位分机号)
        if(!(preg_match('/^\d{11}$/',$cellphone) || preg_match('/^(\d{3,4}-)?\d{7,8}(-\d{1,4})?$/', $cellphone))){
            echo 'fail';
            exit;
        }
        $blacklist = M('blacklist');
        $where = array('cellphone'=>$cellphone);
        $res = $blacklist->where($where)->limit(1)->select();
        if($res){
            echo 'fail';
        }else{
            echo 'success';
        }
    }
	// 页面跟踪的关闭时间，或更新时间
	public function traceUrl(){
		// 如果没有开启
		if(!C('TRACE_PAGE_ON')){
			exit;
		}
		$opt_type = I('post.type') ? true : false;		// true = 更新; false=关闭;
		$url_id = intval(I('post.id'));					// url id

		$current_time = time();			// 当前时间
		// 非正常关闭情况 检查 处理
		$time_limit = C('TRACE_PAGE_TIMELIMIT') ? : 5;;// 'TRACE_PAGE_TIMELIMIT'=> 5,	// 页面追踪定时提交AJAX,时间 5 秒
		// 时间限定 6 秒||,考虑程序运行时间,比页面定时传入多1秒或更多
		$time_limit_true = $time_limit + 3;
		// 更新或关闭
		if($url_id){
			$uid = I('session.uid') ? : I('cookie.uid');
			// 检验
			$where = array('uid'=>$uid, 'id'=>$url_id);
			$chk_data = M('Url')->field('id,endtime,uptime')->where($where)->find();
			if($chk_data && !$chk_data['endtime']){// 没有关闭
				$uptime = intval($chk_data['uptime']);
				if($opt_type){	// 更新
					if(($uptime+$time_limit_true) >= $current_time){
						M('Url')->where($where)->data(array('uptime'=>$current_time))->save();
						// exit('update traceUrl');	//test
					}
				}else{	// 关闭
					$endtime = ($uptime<$current_time)? $current_time : $uptime;
					if(($uptime + $time_limit_true)<=$current_time){ // 关闭时间 修正
						$endtime = $uptime + $time_limit;
					}
                    // 更新一次，需要更新 uptime
					M('Url')->where($where)->data(array('endtime'=>$endtime,'uptime'=>$current_time))->save();
					// exit('close traceUrl');	//test
				}
			}
		}
		// exit('end traceUrl');	//test
	}
	//
}