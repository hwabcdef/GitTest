<?php
namespace Home\Controller;
use Think\Controller;
class KefuController extends Controller {
	public function __construct() {
		parent::__construct();
		// 预留
	}
// Kefuadmin
// :Kefuadmin/login
		// array('username','require','用户名不能为空！',1,'',3),
		// array('password','require','密码不能为空！',1,'',3),

    // login
	public function login(){
		$this->display(':Kefuadmin/login');
		}
	// logout
	public function logout(){
		session('kefu',null);
		if($_SESSION['kefu']['isLogin']!=1){
			$this->success('退出成功！', U('Kefu/index'));
			}
		}
	// dologin
    public function dologin(){
		if(D('Kefu')->create($_POST)){
			$_POST['password']=md5($_POST['password']);
			if($data=D('Kefu')->where("username='".$_POST['username']."' and password='".$_POST['password']."'")->find()){
				$_SESSION['kefu']['id']=$data['id'];
				$_SESSION['kefu']['name']=$data['name'];
				$_SESSION['kefu']['isLogin']=1;
				$this->success('登录成功！',U('Kefu/index'));
				}else{
					$this->error('登录失败！');
					}
			}else{
				$this->error(D('Kefu')->getError());
				}
    	}
	//
	public function index(){
		if(!isset($_SESSION['kefu'])){$this->error('你还未登录！',U('Kefu/login'));}
		$start=strtotime(date('Y-m-d'));
		$end=strtotime(date('Y-m-d',$start+24*3600));
		$visitor=M('Visitors')->count();
		$user=M('User')->where("regtime !=''")->count();
		$todayvisit=M('Visitors')->where("time>'".$start."' and time<'".$end."'")->count();
		$todayreg=M('User')->where("regtime>'".$start."' and regtime<'".$end."'")->count();
		$todaylogin=M('User')->where("lastlogintime>'".$start."' and lastlogintime<'".$end."'")->count();
		$this->assign('visitor',$visitor);
		$this->assign('user',$user);
		$this->assign('todayvisit',$todayvisit);
		$this->assign('todayreg',$todayreg);
		$this->assign('todaylogin',$todaylogin);
		/*获取最新访客*/
		/*判断查看的是否是历史访客*/
		if($_GET['lishi']==1){
			$con = '';
		}else{
			$con = 'time >'.strtotime(date('Y-m-d')).' and ';
		}
		/*按日期区间查看访客*/
		if($_POST['ld']){
			$ld = strtotime($_POST['ld']);
			if($_POST['gd']){
				$gd = strtotime($_POST['gd']);
				$con = "time between "."$ld"." and "."$gd"." and ";
			}else{
				$con = "time >"."$ld"." and ";
			}
		}
		/*获得访问的用户id*/
		$uids = D('Contact')->where($con.'keid='.$_SESSION['kefu']['id'])->field('uid,time,ktype')->order('time desc')->select();
		$user = D('User');
		$userdata = array();
		foreach($uids as $uid){
			if(!$data = $user->where("uid=".$uid['uid'])->find()){
				$data['username'] = '未注册用户';
				$data['uid']=$uid['uid'];
			}
			/*查询用户是否有另外的uid*/
			$visiinfo = M('Note')->where('uid='.$data['uid'])->field('username,usertel')->find();
			$alluid = M('Note')->where("username='".$visiinfo['username']."' and usertel='".$visiinfo['usertel']."'")->field('uid')->select();
			foreach ($alluid as $sid){
				$data['uids'] .= $sid['uid'].",";
			}
			$data['uids'] = rtrim($data['uids'],',');
			$data['time'] = $uid['time'];
			$data['ktype'] = $uid['ktype'];
			$userdata[] = $data;
		}
		$this->assign('userdata',$userdata);
		$this->display(':Kefuadmin/index');
		}


	/*判断客户点击客服*/
	public function getMa(){
		/*判断cookie是否存在*/
		$coo = $_POST['uid'].$_POST['keid'].$_POST['ktype'];
 		if(empty($_COOKIE[$coo])){
			setcookie($coo,1,time()+10,'/');


			$_POST['time']=time();
		    M('Contact')->add($_POST);
  		}
	}


	/*设置上班客服类型状态*/
	public function kefuStatus(){
		$datas = $_POST['kefu'];
		$id = intval($_POST[id]);
		if($_POST['do']=='shangban'){
			$num=1;
		}else{
			$num=0;
		}
		$kefu = D('Kefu');
		$data = array();
		foreach($datas as $v){
			$data[$v.'_status']=$num;
		}
		if($kefu->where('id='.$id)->data($data)->save()){
			$this->success('修改成功','Index');
		}
	}

	/**获取用户浏览轨迹*/
	public function getUrl(){
		$this->getAjaxList();
	}
	//
	public function getAjaxList(){
		// $name=array(1=>'首页',2=>'服装商标',3=>'精品商标大图',4=>'精品商标小图',5=>'发布求购',6=>'求购管理',7=>'我的收藏',8=>'登录',9=>'修改密码',10=>'个人资料',11=>'注册',12=>'注册成功',13=>'发布转让',14=>'转让管理',15=>'我要买商标',16=>'我要卖商标',17=>'商标分类',18=>'商标详细',19=>'商标分类列表',20=>'商标搜索',21=>'商品/服务分类',22=>'商品/服务分类群组列表',23=>'微信页',24=>'关于华唯',25=>'成功案例',26=>'求购内容',27=>'求购列表',28=>'帮助中心',29=>'新闻资讯列表',30=>'新闻资讯内容',31=>'团队风采',32=>'转让内容',33=>'转让列表',34=>'客服中心',35=>'许可商标',36=>'国际商标转让',37=>'图形编码帮助',38=>'详细城市商标转让',39=>'全国城市商标转让',40=>'商品/服务分类群组详细',41=>'找回密码',42=>'短信重置密码',43=>'邮箱重置密码',44=>'密码重置成功',45=>'登陆成功跳转',46=>'修改个人资料',47=>'修改发布求购',48=>'修改发布转让',49=>'求购信息详情',50=>'求购信息列表',51=>'转让信息列表',52=>'转让信息详情',);
		// 获取关系数组
		$trace_rel_arr = trace_relation();
		$name = array();
		foreach($trace_rel_arr as $val){
			$name[$val['id']] = $val['name'];	// 2=>'精品商标'
			// array('id'=>2,		'con_act'=>'Index/quality',			'name'=>'精品商标'),
		}
		//
		$url=M('Url')->where("uid in (".$_GET['uids'].")")->order('starttime desc')->limit(200)->select();
		// if(!$_GET['uids']){
			// exit('没有浏览轨迹');
		// }

		foreach($url as $u){
			if(preg_match('/\/class\/[0-9]{1,}/',$u['url'],$class)){
				if(preg_match('/\/page\/[0-9]{1,}/',$u['url'],$page)){
				$u['name']="第".substr($class[0],strrpos($class[0],'/')+1)."类 第".substr($page[0],strrpos($page[0],'/')+1)."页 ".$name["$u[name]"];
					}else{
						$u['name']="第".substr($class[0],strrpos($class[0],'/')+1)."类 ".$name["$u[name]"];
						}
				}else if(preg_match('/\/Detail\/index\/id\/[0-9]{1,}/',$u['url'],$pid)){
					$u['name']=substr($pid[0],strrpos($pid[0],'/')+1).$name["$u[name]"];
					}else{
						$u['name']=$name["$u[name]"];
						}
			$urls[]=$u;
			}
		foreach($url as $value){
			if(preg_match('/\/Detail\/index\/id\/[0-9]{1,}/',$value['url'],$pid)){
			$str.=','.substr($pid[0],strrpos($pid[0],'/')+1);
				}
			}
		$datas=array_unique(explode(',',substr($str,1)));/*对数组去重复值*/
		foreach($datas as $data){
			$vals[]=$this->getProduct($data,$_GET['uids']);
			}
		$users=M('User')->where("uid in (".$_GET['uids'].")")->select();
		if($users){
			foreach ($users as $us){
				$user .= $us['nick'].",";
			}
			$user = rtrim($user,',');
		}
		$this->assign('vals',$vals);
		$this->assign('url',$urls);
		$this->assign('user',$user);
		$this->assign('uids',$_GET['uids']);
		$this->display(':Kefuadmin/refresh');
		}
	//
	public function getProduct($pid,$uid){
		$url="http://192.168.1.192/port.php?id=$pid";
		$curl=curl_init();
		curl_setopt($curl,CURLOPT_URL,$url);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$value=curl_exec($curl);
		curl_close($curl);
		$data=json_decode($value,true);
		$product=$data['self'];
		$time=M('Url')->where("url='http://192.168.1.148/index.php/Home/Index/tmdetail/id/".$pid."' and uid='".$uid."'")->find();
		$product['starttime']=$time['starttime'];
		$product['endtime']=$time['endtime'];
		return $product;
		}
	//
	public function getAjaxState(){
		$start=strtotime(date('Y-m-d'));
		$end=strtotime(date('Y-m-d',$start+24*3600));
		$visitor=M('Visitors')->count();
		$user=M('User')->where("username !=''")->count();
		$todayvisit=M('Visitors')->where("time>'".$start."' and time<'".$end."'")->count();
		$todayreg=M('User')->where("regtime>'".$start."' and regtime<'".$end."'")->count();
		$todaylogin=M('User')->where("lastlogintime>'".$start."' and lastlogintime<'".$end."'")->count();
		$this->assign('visitor',$visitor);
		$this->assign('user',$user);
		$this->assign('todayvisit',$todayvisit);
		$this->assign('todayreg',$todayreg);
		$this->assign('todaylogin',$todaylogin);
		$this->display(':Kefuadmin/state');
		}

	public function getAjaxInfo(){
		$user=M('Note')->where("uid='".$_GET['uids']."'")->field('info,username,usertel')->select();
		echo json_encode($user);
		}

	public function getAjaxSave(){
		if(M('Note')->add(array('uid'=>$_POST['uid'],'info'=>$_POST['info'],'infotime'=>time(),'kid'=>$_SESSION['kefu']['id'],'username'=>$_POST['username'],'usertel'=>$_POST['usertel']))){
				echo '保存成功';
			}else{
				echo '保存失败';
			}
		}

	// 未定义
	public function Productindex(){
		$total = M('Product')->count();
		$pager = new \Think\Page($total,20);
		$firstRow = $pager->firstRow;
		$listRow = $pager->listRows;
		$datas=M('Product')->limit($firstRow.",".$listRow)->select();
		$pager->setConfig('header','条记录');
		$pager->setConfig('first','首页');
		$pager->setConfig('prev','上一页');
		$pager->setConfig('next','下一页');
		$pager->setConfig('last','尾页');
		$link = $pager->show();
		$this->assign('link',$link);
		$this->assign('datas',$datas);
		// $this->display('index');
		}

	public function productDetail(){
		$id=intval($_GET['id']);
		$url="http://192.168.1.192/port.php?id=$id";
		$curl=curl_init();
		curl_setopt($curl,CURLOPT_URL,$url);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$value=curl_exec($curl);
		curl_close($curl);
		$data=json_decode($value,true);
		$this->assign('data',$data['self']);
		$this->display(':Kefuadmin/detail');
		}
	// 未定义
	public function Producttop(){
		$datas=M('Product')->order('click desc')->limit(100)->select();
		$this->assign('datas',$datas);
		$this->assign('i',1);
		// $this->display('top');
		}
	//
}