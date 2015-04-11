<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
	public function __construct() {
		parent::__construct();

		// 页面追踪
		$trace_page_arr = trace_user_url();
		$this->assign('trace_page_arr', $trace_page_arr);// 'on'=控制|limit_time=时限|trace_id=追踪id
		// 获取head中title等的模板 如果模板有变量需要替换，在具体方法中替换
		$tmpl_info = get_title_tmpl();
		$this->assign('tmpl_info', $tmpl_info);

        if(!session('id')){
            if( ACTION_NAME =='index' || ACTION_NAME =='reg' || ACTION_NAME =='doreg' || ACTION_NAME =='getPwdWay' || ACTION_NAME =='collect_tm' || ACTION_NAME =='resetPwdMail' || ACTION_NAME == 'getVerify'){

            }else{
                $this->error('您还未登陆！',U('User/index'));
                exit;
            }
        }
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

	}
    public function index(){
        //print_r($_POST);exit;
        if(session('id')>0){
            $this->success('您已经登陆！',U('User/info'));
            exit;
        }
        if($_POST){
            if($_POST['name']=='' || $_POST['password']==''){
                $this->error('请填写账号密码');
                exit;
            }
            $map['username']=I('post.name');
            $map['password']=md5(I('post.password'));
            $re=D('user')->where($map)->find();
            if($re==''){
                $this->error('账号密码错误');
                exit;
            }    
            if(cookie('uid')!=$re['uid']){
                cookie('uid',$re['uid']);
            }
            $data['lastloginip'] = ip2long(get_client_ip());
            $data['uptime']=$data['lastlogintime'] = time();
            $data['logintimes'] = 1 + $rs['logintimes'];    // 登陆次数加1
            $cre=D('user')->where($map)->data($data)->save();
            if($cre){
                session('id',$re['id']);
                session('nick',$re['nick']);
                session('uid',$re['uid']);
				// $callback = $_GET['callback'] ? $_GET['callback'] : U('User/info');
				$callback = $_GET['callback'] ? $_GET['callback'] : I('server.HTTP_REFERER');
				// 
                $this->success('登录成功！',$callback);
            }else{
                $this->error('登录失败！');
            }
            exit;
        }

    	$this->display();
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
                $datas[$k]['time']=time();
                }
        if(D('Transfer')->create($datas[0])){
            foreach($datas as $data){
                if($data['tm_name']!='' || $data['regnum']!='' ||$data['applicant']!='' || $data['price']!=''){
                    $res[]=D('Transfer')->add($data);
                    }
                }
            if($res){
                $this->success('发布成功！',U('User/transfer_mana'));
                }else{
                    $this->error('发布失败！');
                    }
            }else{
                $this->error(D('Transfer')->getError());
                }
        }
    public function transfer(){
        if($_POST){
            $this->_transfer();
            exit;
        }

        $this->display();
    }
    public function transfer_mana(){
        $total = M('Transfer')->where("uid='".$_SESSION['uid']."' and del=1")->count();
        $pagesize=13;
        $Page = new \Think\Page($total,$pagesize);
        $firstRow = $Page->firstRow;
        $listRow = $Page->listRows;
        $datas=M('Transfer')->where("uid='".$_SESSION['uid']."' and del=1")->limit($firstRow.",".$listRow)->order('uptime desc')->select();
        $show       = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('datas',$datas);
        $this->display();
    }
    public function edit_transfer(){
        $data=M('Transfer')->where("id='".$_GET['id']."'")->find();
        $this->assign('data',$data);
        $this->display();
        }
        
    public function domod_transfer(){
        if(D('Transfer')->create($_POST,4)){
            $_POST['time']=time();
            if(D('Transfer')->where("id='".$_GET['id']."'")->save($_POST)){
                $this->success('修改成功！',U('User/transfer_mana'));
                }else{
                    $this->error('修改失败！');
                    }
            }else{
                $this->error(D('Transfer')->getError());
                }
    }
        
    public function del_transfer(){
        if(isset($_GET['id'])){
            $id = intval(I("get.id"));
            $data['del']=0;
            if (M('Transfer')->where("id='".$id."'")->save($data)) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }
        if(isset($_POST['ids'])){
            $ids=join(",",$_POST['ids']);
            $data['del']=0;
            if (M('Transfer')->where("id in ($ids)")->save($data)) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }
    }
    public function buy(){
        if(IS_POST){
            $this->_buy();
            exit;
        }
        $this->display();
    }
    public function _buy(){
        if(D('Demand')->create($_POST)){
            $_POST['uid']=$_COOKIE['uid'];
            $_POST['time']=time();
            if(D('Demand')->add($_POST)){
                $this->success('发布成功！',U('User/buy_mana'));
                }else{
                    $this->error('发布失败！');
                    }
            }else{
                $this->error(D('Demand')->getError());
                }
    }
    public function buy_mana(){
        $total = M('Demand')->where("uid='".$_SESSION['uid']."' and del=1")->count();
        $pagesize=13;
        $Page = new \Think\Page($total,$pagesize);
        $show       = $Page->show();// 分页显示输出
        $this->assign('page',$show);// 赋值分页输出
        $firstRow = $page->firstRow;
        $listRow = $page->listRows;
        $datas=M('Demand')->where("uid='".$_SESSION['uid']."' and del=1")->limit($firstRow.",".$listRow)->order('uptime desc')->select();
        $this->assign('datas',$datas);
        $this->display();
    }

    public function edit_buy(){
        $data=M('Demand')->where("id='".$_GET['id']."'")->find();
        $this->assign('data',$data);
        $this->display();
        }
        
    public function domod_buy(){
        if(D('Demand')->create($_POST)){
            $_POST['time']=time();
            if(D('Demand')->where("id='".$_GET['id']."'")->save($_POST)){
                $this->success('修改成功！',U('User/buy_mana'));
                }else{
                    $this->error('修改失败！');
                    }
            }else{
                $this->error(D('Demand')->getError());
                }
    }
    
    public function del_buy(){
        if(isset($_GET['id'])){
            $id = intval(I("get.id"));
            $data['del']=0;
            if (M('Demand')->where("id='".$id."'")->save($data)) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }
        if(isset($_POST['ids'])){
            $ids=join(",",$_POST['ids']);
            $data['del']=0;
            if (M('Demand')->where("id in ($ids)")->save($data)) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }
    }
    
    /*展示用户收藏夹*/
    public function collection(){
    	$page = isset($_GET['p']) ? intval($_GET['p']) : 1;
    	/*分页*/
    	$count = M('Collectfile')->where('uid='.$_SESSION['uid'])->count();// 查询满足要求的总记录数
    	$perrow = 8 ;//每页显示记录数
	$offset = ($page-1)*$perrow;
    	$Page       = new \Think\Page($count, $perrow);// 实例化分页类 传入总记录数和每页显示的记录数
    	$show       = $Page->show();// 分页显示输出
    	$this->assign('page',$show);// 赋值分页输出
    	 
    	$collfile = M('Collectfile')->where('uid='.$_SESSION['uid'])->limit($offset,$perrow)->select();
    	$temp = array();
    	foreach ($collfile as $file){
    		$file['tm_num'] = M('Collecttm')->where('file_id='.$file['id'].' and uid='.$_SESSION['uid'])->count();
    		$temp[] = $file;
    	}
    	$this->collfile = $temp;
    	$this->display();
    }
    /*展示收藏夹里的收藏商标*/
    public function show_collecttm(){
    	$file_id = isset($_GET['id'])?intval($_GET['id']):0;
    	$page = isset($_GET['p']) ? intval($_GET['p']) : 1;
    	if($file_id != 0){
    		$this->file = M('Collectfile')->where('id='.$file_id)->find();
    		/*分页*/
    		$count =M('Collecttm')->where('file_id='.$file_id.' and uid='.$_SESSION['uid'])->count();// 查询满足要求的总记录数
    		$perrow = 15 ;//每页显示记录数
		$offset = ($page-1)*$perrow;
    		$Page       = new \Think\Page($count, $perrow);// 实例化分页类 传入总记录数和每页显示的记录数
    		$show       = $Page->show();// 分页显示输出
    		$this->assign('page',$show);// 赋值分页输出
    		$tmids = M('Collecttm')->where('file_id='.$file_id.' and uid='.$_SESSION['uid'])->field('tm_id')->limit($offset,$perrow)->select();
    		foreach($tmids as $tmid){
    			foreach($tmid as $id){
    				$ids .= $id.",";
    			}
    		}
    		$ids = rtrim($ids,',');
    		$arr_post = array(
    				'ids' => $ids,
    				'fields' => 'tm_id,tm_categories,tm_name,belong_group,belong_groupdetail'
    		);
    		$tmlist = gettmlist($arr_post);
    		$tm_arr = array();
    		foreach ($tmlist as $v ){
    			$v['img'] = 'http://7vzoco.com2.z0.glb.qiniucdn.com/'.$v['tm_id'];
    			$tm_arr[] = $v;
    		}
    
    		$this->tmlist = $tm_arr;
    
    		$this->collectfiles = M('Collectfile')->where('uid='.$_SESSION['uid'])->select();
    	}
    	$this->display();
    }
    
    /*收藏商标*/
    public function collect_tm(){
    	if(!$_SESSION['uid']){
    		echo '请先登录！';exit;
    	}
    	$tm_id = isset($_POST['tm_id'])?intval($_POST['tm_id']):0;
    	if(!tm_id){
    		echo '收藏失败！';exit;
    	}
    	 
    	/*判断用户是否有默认的未处理收藏夹*/
    	if(!$file = M('Collectfile')->where("filename='未处理收藏夹' and uid=".$_SESSION['uid'])->find()){
    		$data = array(
    				'filename'=>'未处理收藏夹',
    				'uid'=>$_SESSION['uid'],
    				'describe'=>'默认',
    				'uptime'=>time()
    		);
    		$file = M('Collectfile')->add($data);
    	}else{
    		$file = $file['id'];
    	}
    	if(M('Collecttm')->where('tm_id='.$tm_id." and uid=".$_SESSION['uid'].' and file_id='.$file)->select()){
    		echo '该商标已收藏过！';exit;
    	}
    	$data = array(
    			'tm_id'=>$tm_id,
    			'file_id'=>$file,
    			'uid'=>$_SESSION['uid'],
    			'uptime'=>time()
    	);
    	if(M('Collecttm')->add($data)){
    		echo '收藏成功！';exit;
    	}else{
    		echo '收藏失败！';
    	}
    }
    /*通过商标id组装成收藏信息*/
    public function createcolltm(){
    	$id = isset($_POST['id']) ? $_POST['id'] : 0;
    	if(!$id){ echo '-1';exit;}
    	$arr_post = array('ids'=>$id,'fields'=>'tm_name,tm_id,tm_categories,belong_groupdetail');
    	$collinfo = gettmlist($arr_post);
    	$collinfo[0]['img'] = 'http://7vzoco.com2.z0.glb.qiniucdn.com/'.$collinfo[0]['tm_id'];
    	$vo = $collinfo[0];
    	$url = U('Index/tmdetail',array('id'=>$vo['tm_id']));
    	$str=<<<END
    	<li>
    	<a href="{$url}" target="_blank" title=""><img src="{$vo['img']}" alt="" />
    	<div>
    	<em>商标名称：</em>{$vo['tm_name']}<br />
    	<em>商标ID：</em>{$vo['tm_id']}<br />
    	<em>商标类别：</em>第{$vo['tm_categories']}类<br />
    	<em>商品或服务：</em>{$vo['belong_groupdetail']}</div>
    	</a>
    	<span></span></li>
END;
    	echo $str;		
    }
    /*删除商标*/
    public function delcoltm(){
    	$tm_id = isset($_GET['tmid']) ? $_GET['tmid'] : 0;
    	if(is_array($tm_id)){
    		$tm_id = implode($tm_id,',');
    	}
    	$file_id = isset($_GET['fileid']) ? $_GET['fileid'] : 0;
    	$uid = $_SESSION['uid'];
    	if(M('Collecttm')->where('tm_id in ('.$tm_id.') and file_id='.$file_id.' and uid='.$uid)->delete()){
    		$this->success('删除成功！');
    	}else{
    		$this->error('删除失败！');
    	}
    }
    /*添加收藏夹*/
    public function addcollfile(){
    	$newfile = isset($_POST['newfile']) ? $_POST['newfile'] : '';
    	if($newfile){
    		if(M('Collectfile')->where("filename='".$newfile."' and uid='".$_SESSION["ADMIN_ID"]."'")->find()){
    			$this->error('该收藏夹已存在！');exit;
    		}
    		$data = array('filename'=>$newfile,'describe'=>$_POST['describe'],'uid'=>$_SESSION['uid'],'uptime'=>time());
    		if(M('Collectfile')->add($data)){
    			$this->success('添加收藏夹成功！');
    		}else{
    			$this->error('添加失败！');
    		}
    	}else{
    		$this->error('添加失败！');
    	}
    }
    
    /*删除收藏夹*/
    public function delcollfile(){
    	$ids = isset($_GET['ids']) ? $_GET['ids'] : 0;
    	if(is_array($ids)){
    		$ids = implode($ids,',');
    	}
    	if(!$ids){
    		$this->error('删除失败！');exit;
    	}
    	if(M('Collectfile')->where('id in ('.$ids.')')->delete()){
    		M('Collecttm')->where('file_id in ('.$ids.') and uid='.$_SESSION['uid'])->delete();
    		$this->success('删除成功！');
    	}else{
    		$this->error('删除失败！');
    	}
    }
    /*重命名收藏夹*/
    public function renamefile(){
    	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    	$filename = isset($_POST['newfname']) ? $_POST['newfname'] : '';
    	if($id && $filename){
    		$data = array('id'=>$id,'filename'=>$filename,'describe'=>$_POST['describe'],'uptime'=>time());
    		if(M('Collectfile')->save($data)){
    			$this->success('重命名成功！');
    		}else{
    			$this->error('重命名失败！');
    		}
    	}else{
    		$this->error('重命名失败！');
    	}
    }
    /*移动商标至新收藏夹*/
    public function movetm(){
    	$oldfileid = isset($_POST['oldfileid']) ? intval($_POST['oldfileid']) : 0;
    	$newfileid = isset($_POST['newfile']) ? intval($_POST['newfile']) : 0;
    	$tm_id =  isset($_POST['tm_id']) ? intval($_POST['tm_id']) : 0;
    	if(!$oldfileid || !$newfileid || !$tm_id){
    		echo '0';exit;//0表示移动失败！
    	}
    	/*删除旧收藏夹里的指定商标*/
    	$data = array('tm_id'=>$tm_id,'file_id'=>$newfileid,'uid'=>$_SESSION['uid'],'uptime'=>time());
    	if( M('Collecttm')->where('file_id='.$oldfileid.' and tm_id='.$tm_id.' and uid='.$_SESSION['uid'])->delete() && M('Collecttm')->add($data) ){
    		echo '1';exit;//1表示移动成功！
    	}else{
    		echo '0';
    	}
    }
    /*批量移动商标*/
    public function movelottm(){
    	$oldfileid = isset($_GET['fileid']) ? intval($_GET['fileid']) : 0;
    	$newfileid = isset($_GET['newfile']) ? intval($_GET['newfile']) : 0;
    	$tmid =  isset($_GET['tmid']) ? $_GET['tmid'] : 0;
    	$tm_ids = implode($tmid,',');
    	if(!$oldfileid || !$newfileid || !$tmid){
    		echo '移动失败';exit;
    	}
    	if( M('Collecttm')->where('file_id='.$oldfileid.' and tm_id in ('.$tm_ids.') and uid='.$_SESSION['uid'])->delete() ){
    		foreach( $tmid as $tm_id){
    			$data = array('tm_id'=>$tm_id,'file_id'=>$newfileid,'uid'=>$_SESSION['uid'],'uptime'=>time());
    			M('Collecttm')->add($data);
    		}
    		$this->success('移动成功！');
    	}else{
    		$this->error('移动失败！');
    	}
    }
    
    /*批量导出文件里的商标*/
    public function outputLot(){
    	$tm_id = isset($_GET['tmid']) ? $_GET['tmid'] : 0;
    	if(!$tm_id){
    		$this->error('请先选择文件！');exit;
    	}else{
    		if(is_array($tm_id)){
    			$tm_id = implode($tm_id,',');
    		}
    		$this->outputdata($tm_id);
    	}
    	 
    }
    
    /* 导出Excel：1，从数据库获取需要导出的数据*/
    public function outputdata($tmids=''){
    	// 获取需要导出的数据
    	$uid = $_SESSION['uid'];
    	/*接收需要导出的字段编号*/
    	$field_num = array(1,2,3,4,5,6);
    	if(!$field_num){ $this->error('导出失败！请选择需要导出的列');exit; }
    	/*判断是否传入tmids参数*/
    	if(!$tmids){
    		/*判断是否导出整个文件夹*/
    		if($_GET['tm_ids']){
    			/*不是导出整个文件*/
    			$ids = $_GET['tm_ids'];
    		}else{
    			$file_id = isset($_GET['file_id']) ? intval($_GET['file_id']) : 0;
    			if($tmids = M('Collecttm')->where('file_id='.$file_id.' and uid='.$_SESSION['uid'])->field('tm_id')->select()){
    				foreach($tmids as $tmid){
    					foreach($tmid as $id){
    						$ids .= $id.",";
    					}
    				}
    				$ids = rtrim($ids,',');
    			}
    		}
    	}else{
    		$ids = $tmids;
    	}
    	 
    	/*获取所需要的字段*/
    	$arr_1=array(1=>'ID',2=>'商标图片',3=>'商标类别',4=>'商标名称',5=>'所属群组',6=>'服务项');
    	$arr_2=array(1=>'tm_id',3=>'tm_categories',4=>'tm_name',5=>'belong_group',6=>'belong_groupdetail');
    	$outfields = array();
    	 
    	foreach ($field_num as $v){
    		if($arr_1[$v] && $arr_2[$v]){
    			$fields .= $arr_2[$v].",";
    			$outfields[$v] = $arr_1[$v];
    		}
    	}
    	 
    	$fields = rtrim($fields,',');
    	$arr_post = array('ids'=>$ids,'fields'=>$fields);
    	$exportData = gettmlist($arr_post);
    	/*判断是否导出图片*/
    	if(in_array('2', $field_num)){
    		$tmp[1] = $outfields[1];
    		array_shift($outfields);
    		array_unshift($outfields,$arr_1[2]);
    		array_unshift($outfields,$tmp[1]);
    		$tm_arr = array();
    		foreach ($exportData as $v ){
    			$tempv['img'] = 'http://7vzoco.com2.z0.glb.qiniucdn.com/'.$v['tm_id'];
    			$tmpv['tm_id'] = $v['tm_id'];
    			array_shift($v);
    			array_unshift($v,$tempv['img']);
    			array_unshift($v,$tmpv['tm_id']);
    			$tm_arr[] = $v;
    		}
    
    		/* 如果图片不在本地，需要下载到本地后才能导出*/
    		foreach($tm_arr as $k=>$value){
    			foreach($value as $key=>$val){
    				// 如果是图片
    				if($key==1 && !file_exists($val)){
    					// 假设下载图片放在
    					$localpicname = getcwd().'/Public/images/output/';
    					if(!file_exists($localpicname)){mkdir($localpicname,'0777',true);}
    					$pinfo = pathinfo($val);
    					$localpicname .= $pinfo['basename'].'.jpg';/*加个图片后缀方便下载后存储*/
    					// 如果文件存在，使用本地图片
    					if(file_exists($localpicname)){
    						$tm_arr[$k][$key] = $localpicname;
    					}
    					// 下载到本地
    					// copy 如果本地已存在，会覆盖
    					elseif(copy($val, $localpicname)){
    						$tm_arr[$k][$key] = $localpicname;
    					}else{
    						// 失败
    						echo 'dowwn false';
    						exit;
    					}
    				}
    			}
    		}
    		$exportData = $tm_arr;
    	}
    	 
    	// 导出的第一行标题
    	$titleArr = $outfields;
    	// 导出的文件名
    	$filename = 'info_list';
    	// 调用导出函数
    	$this->exportExcel($filename, $titleArr, $exportData);
    }
    
    /* 导出Excel*/
    private function exportExcel($fileName, $headArr, $data){
    	// 导入PHPExcel类库，因为PHPExcel没有用命名空间，只能import导入
    	import("Org.Util.PHPExcel");
    	// import("Org.Util.PHPExcel.Writer.Excel5");
    	import("Org.Util.PHPExcel.Writer.Excel2007");
    	//import("Org.Util.PHPExcel.IOFactory.php");
    	//import("Org.Util.PHPExcel.Worksheet.Drawing.php");
    	// 导出文件名
    	$date = date("Y_m_d_H_i_s",time());
    	// $fileName .= "_{$date}.xls";		// Excel5
    	$fileName .= "_{$date}.xlsx";	// Excel2007
    
    	// 创建PHPExcel对象，注意，不能少了\
    	$objPHPExcel = new \PHPExcel();
    	$objProps = $objPHPExcel->getProperties();
    
    	// 设置文本对齐方式
    	$objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    	$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
    
    	// 设置表头
    	$key = ord("A");
    	foreach($headArr as $v){
    		$colum = chr($key);
    		$objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
    		// 如果是图片，列宽
    		if($v == '商标图片'){	// 假设图片对应字段是'图片',具体可更改
    			$objPHPExcel->getActiveSheet()->getColumnDimension($colum)->setWidth(20);
    		}
    		// 非图片的时候的列宽
    		else{
    			$objPHPExcel->getActiveSheet()->getColumnDimension($colum)->setWidth(15);
    		}
    		$key += 1;
    	}
    
    	// 导入数据部分
    	$column = 2;
    	foreach($data as $key => $rows){ //行写入
    		// 设置表格高度
    		$objPHPExcel->getActiveSheet()->getRowDimension($column)->setRowHeight(80);
    		$span = ord("A");
    		foreach($rows as $keyName=>$value){// 列写入
    			$j = chr($span);
    			// 非图片处理
    			if($keyName!=1){	// 假设图片对应字段是'pic',具体可更改
    				$objPHPExcel->getActiveSheet()->setCellValue($j.$column, ' '.$value);	
    			}
    			// 图片处理
    			else{
    				// 实例化插入图片类
    				$objDrawing = new \PHPExcel_Worksheet_Drawing();
    				// 设置图片路径 切记：只能是本地图片
    				$objDrawing->setPath($value);
    				
    				$objDrawing->setWidth(100);
    				$objDrawing->setHeight(90);
    				$objDrawing->setOffsetX(17);
    				$objDrawing->setOffsetY(8);
    				
    				$objDrawing->setCoordinates($j.$column);
    				$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
    			}
    			$span++;
    		}
    		$column++;
    	}
    
    	$fileName = iconv("utf-8", "gb2312", $fileName);
    	// 重命名表
    	// $objPHPExcel->getActiveSheet()->setTitle('test');
    
    	// 设置活动单指数到第一个表,所以Excel打开这是第一个表
    	$objPHPExcel->setActiveSheetIndex(0);
    
    	// 图片导出
    	header("Pragma: public");
    	header("Expires: 0");
    	header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
    	header("Content-Type:application/force-download");
    	header("Content-Type:application/vnd.ms-execl");
    	header("Content-Type:application/octet-stream");
    	header("Content-Type:application/download");;
    	// header('Content-Disposition:attachment;filename=\"$fileName\"');
    	header("Content-Disposition:attachment;filename=\"$fileName\"");
    	header("Content-Transfer-Encoding:binary");
    
    	$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    	$objWriter->save('php://output');exit;
    
    }
    
    public function info(){
        if(IS_POST){
            $data=I('post.');
            $data['id']=session('id');
            $re=D('user')->data($data)->save();
            if($re){
                $this->success('修改成功');
            }else{
                $this->error('修改失败');
            }
            exit;
        }
        $map['id']=session('id');
        $userinfo=D('user')->where($map)->find();
        $this->assign('userinfo',$userinfo);

		// 查询是否有绑定账号
		$oauth_user_model = M('OauthUser');
		$uid = $userinfo['uid'];	// 或者session('uid')
		$oauths = $oauth_user_model->field('from')->where(array('uid'=>$uid))->select();
		$new_oauths = array();
		foreach($oauths as $val){
			$new_oauths[strtolower($val['from'])] = true;	// 标记是否已绑定
		}
		$this->assign('oauths_status', $new_oauths);
    	$this->display();
    }
    public function password(){
        if(IS_POST){
            $map['id']=session('id');
            $userinfo=D('user')->where($map)->find();
            if(md5($_POST['ypassword'])!=$userinfo['password']){
                $this->error('原密码错误！');
            }
            if($_POST['npassword']!=$_POST['rnpassword']){
                $this->error('两次新密码不一样！');
            }
            if(md5($_POST['npassword'])==$userinfo['password']){
                $this->error('密码没变化！');
            }
            $map['password']=md5(I('post.npassword'));
            $re=D('user')->data($map)->save();
            if($re){
                $this->success('修改密码成功！');
            }else{
                $this->error('修改密码失败！');
            }
            exit;
        }
        $this->display();
    }
    public function logout(){
        session(null);
        $callback = $_GET['callback'] ? $_GET['callback'] : I('server.HTTP_REFERER');
        $this->success('退出成功', $callback);
    }
    public function reg() {
        $this->display(":User/register");
    }
    
	// 注册提交，或微博等登陆注册
	public function doreg(){
		if(D('User')->create($_POST,7)){
			if(!D('User')->where(array('username'=>$_POST['username']))->find()){
				$data=array('username'=>$_POST['username'],
					'password'=>md5($_POST['password']),
					'regip'=>ip2long(get_client_ip()),
					'regtime'=>time(),
					'uid'=>$_COOKIE['uid'],
					'nick'=>$_POST['nick'],
					'telephone'=>$_POST['telephone'],
					'cellphone'=>$_POST['cellphone'],
					'email'=>$_POST['email'],
					'qq'=>$_POST['qq'],
				    'uptime'=>time()
				);
				if($user=D('User')->where(array('uid'=>$_COOKIE['uid']))->find()){//如果用户表里存在该用户则重新生成
					$uid=time().mt_rand(1000,9999);
					cookie('uid',NULL);
					setcookie('uid',$uid,time()+10*360*24*60*60,"/");
					$ip=ip2long(get_client_ip());
					$datas=array('uid'=>$uid,'ip'=>$ip,'uptime'=>time());
					M('Visitors')->add($datas);
					$data['uid']=$uid;
					$res=D('User')->add($data);
				}else{
					$res=D('User')->add($data);
				}
				if($res){
					//标记为已注册用户
					M('Visitors')->where(array('uid'=>$_COOKIE['uid']))->save(array('reg'=>1));
					session('id',$res);
					session('nick',$data['nick']);
					session('uid',$data['uid']);
					$callback=$_GET['callback']?$_GET['callback']:U('User/info');

					// qq或微博等登陆时，若没有注册，关联注册微博
					if(session('oauth.token') && session('oauth.type') && session('oauth.user_info')){
						$user_info = session('oauth.user_info');
						$token = session('oauth.token');
						$type = session('oauth.type');
						//第三方用户表中创建数据
						$new_oauth_user_data = array(
							'from' => $type,
							'name' => $user_info['name'],
							'head_img' => $user_info['head'],
							'create_time' =>date("Y-m-d H:i:s"),
							'uid' => $data['uid'],
							'last_login_time' => date("Y-m-d H:i:s"),
							'last_login_ip' => get_client_ip(),
							'login_times' => 1,
							'status' => 1,
							'access_token' => $token['access_token'],
							'expires_date' => (int)(time()+$token['expires_in']),
							'openid' => $token['openid'],
						    'uptime' =>time()
						);
						$oauth_user_model = M('OauthUser');
						$new_oauth_user_id = $oauth_user_model->add($new_oauth_user_data);
						if($new_oauth_user_id){
							// 删除
							session('oauth.token', null);
							session('oauth.user_info', null);
							session('oauth.type', null);
						}else{
							D('User')->where(array("id"=>$res,"uid"=>$data['uid']))->delete();
							$this->error("注册失败");
						}
					}
					//
					$this->success('注册成功！',$callback);
				}
				else{
					$this->error("注册失败");
				}
			}else{
				$this->error("用户名不可用！");
			}
		}else{
			$this->error(D('User')->getError());
		}
	}

	
    // 找回密码
	public function getPwdWay(){
        $step = intval(I('post.step'))? : 1;  					 	// 如果没有值默认1
		// $step = in_array($step, array(1,2,3,4,5)) ? $step : 1;	// 可以将其他无效值默认为1

		// session(null);exit;

        // 显示会员填写用户名页面
        if($step == 1){
            $this->display(":User/resetUser");
			exit;
        }
		// 显示找回密码等页面(可以考虑如果手机号或邮箱不存在的页面显示)
        elseif($step == 2){
			$username = trim(I('post.uname'));
			// 如果为空
			if(!$username){
				$this->error('参数错误！1',U('User/getPwdWay'));
    		}
			// 查询会员名是否存在
			$User = M('User');
			$where = array('username'=>$username);
			$pwd_user = $User->field('id,username,cellphone,email')->where($where)->limit(1)->select();
			if(!$pwd_user){
				$this->error('用户名不存在！');
			}
			$pwd_user = $pwd_user[0];
			// 记录
			session('pwdinfo.id', $pwd_user['id']);
			session('pwdinfo.cellphone', trim($pwd_user['cellphone']));
			session('pwdinfo.email', $pwd_user['email']);
			session('pwdinfo.username', $pwd_user['username']);
			$pwd_user['cellphone'] = substr($pwd_user['cellphone'],0,3).'****'. substr($pwd_user['cellphone'],-4);
			$this->assign('pwd_uinfo', $pwd_user);
			// 显示
			$this->display();
			exit;
        }
		// 发送手机短信 或者 重新发送短信
		elseif($step == 3){
			$re_data = array('status'=>'0','msg'=>'');
			// 验证
			if(!session('pwdinfo.id')){
				$re_data['msg'] = "请重新确定用户名！";// 失效
				echo json_encode($re_data);
				exit;
			}
			// 手机号码简单验证
			$cellphone = session('pwdinfo.cellphone');
			if(!preg_match("/^\d{11}$/", $cellphone)){
				$re_data['msg'] = "手机号码不存在！";
				echo json_encode($re_data);
				exit;
			}
			// 如果存在时间限定，验证
			$old_time = intval(session('pwdinfo.timestamp'));
			$time_limit = 60;	// 假设时间限定为60秒
			if($old_time){
				$pwd_chk = time() - $old_time;
				if($pwd_chk <= $time_limit){
					$re_data['msg'] = "请在{$time_limit}秒后重试！";
					echo json_encode($re_data);
					exit;
				}else{
					session('pwdinfo.timestamp', time());
				}
			}else{
				// 记录时间
				session('pwdinfo.timestamp', time());
			}
			// 是否提交过图片验证
			if(!session('pwdinfo.aftcellcode')){
				$re_data['msg'] = "没有通过图片验证";// 失效
				echo json_encode($re_data);
				exit;
			}

			// 生成验证码
			$verificode = mt_rand(1111,9999);
			session('pwdinfo.verificode', $verificode);

			// 手机模板: [verificode]会被替换为验证码
			$model_msg = '您的手机验证码是:[verificode]【华唯商标转让网】';

			// 替换
			$pwd_msg = preg_replace('/\[verificode]/',$verificode, $model_msg);

			// 整理发送短信
			$p_res = $this->sendCellMsg($cellphone, $pwd_msg);
			// 如果失败
			if(!$p_res['status']){
				$re_data['msg'] = "发送手机短信失败，请稍后重试！";
			}else{
				$re_data['status'] = '1';
			}
			
			// test
			// $re_data['status'] = '1';

			// 记录时间
			$re_data['time'] = session('pwdinfo.timestamp');
			echo json_encode($re_data);
			exit;
		}
		// 短信验证 提交
		elseif($step == 4){
			// 用户名验证是否提交
			if(!session('pwdinfo.id')){
				$this->error('请重新确定用户名！');
			}
			// 手机号码简单验证
			$cellphone = session('pwdinfo.cellphone');
			if(!preg_match("/^\d{11}$/", $cellphone)){
				$this->error('手机号码不存在！');
			}
			// 限制时间验证
			$old_time = intval(session('pwdinfo.timestamp'));
			$time_limit = 180;	// 假设限制提交验证码时间为180秒，
			if(!$old_time || (time() - $old_time)>180){
				$this->error('验证码已失效！');
			}

			// 可以考虑验证是否进行过图片验证

			// 验证码 验证
			$code = intval(I("post.code"));
			if(!$code || $code!= session('pwdinfo.verificode')){
				$this->error('验证码错误！');
			}
			// 验证成功
			session('pwdinfo.cellsuccess', '1');

			// 跳转到验证成功后的页面
			$this->display(":User/resetPwd");
			exit;
		}
		// 重新设置密码 提交
		elseif($step == 5){
			// 验证
			$pwd = trim(I('post.pwd'));
			$repwd = trim(I('post.repwd'));
			// 两次输入不一样
			if(!$pwd || $pwd!=$repwd){
				$this->error('两次输入密码不一样！');
			}
			// \w{6,}
			if(!preg_match("/^\w{6,}$/", $pwd)){
				$this->error('密码必须是6位以上的数字字母！');
			}
			// session 状态验证
			if(!session('pwdinfo.id')){
				$this->error('请重新确定用户名！', U('User/index'));
			}

			// 手机验证成功
			if(session('pwdinfo.cellsuccess')){
				// 手机号码简单验证
				$cellphone = session('pwdinfo.cellphone');
				if(!preg_match("/^\d{11}$/", $cellphone)){
					$this->error('手机号码不存在！');
				}
			}
			// 邮箱验证成功
			elseif(session('pwdinfo.mailsuccess')){
				$email = trim(session("pwdinfo.email"));
				if(!$email || !preg_match("/^[^\s]+@[^\s]+$/", $email)){
					$this->error('邮箱无效或不存在！', U('User/index'));
				}
			}
			// 没有通过验证
			else{
				$this->error('没有通过验证！');
			}

			// 限制时间验证

			// 验证通过,重新设置密码
			$map = array();
			$map['id'] = intval(session('pwdinfo.id'));
			$map['password'] = md5($pwd);
			$res = D('user')->data($map)->save();
			if($res !== false){
				// 删除重置密码的相关session
				session('pwdinfo', null);
				// 跳转
                // $this->success('修改密码成功！', U('User/index'));
				$this->display('User/resetPwdMsg');
            }else{
                $this->error('修改密码失败！');
            }
			exit;
		}
		// 验证 手机图片验证码
		elseif($step == 6){
			$re_data = array('status'=>'0','msg'=>'');
			// 验证
			if(!session('pwdinfo.id')){
				$re_data['msg'] = "请重新确定用户名！";// 失效
				echo json_encode($re_data);
				exit;
			}
			// 手机号码简单验证
			$cellphone = session('pwdinfo.cellphone');
			if(!preg_match("/^\d{11}$/", $cellphone)){
				$re_data['msg'] = "手机号码不存在！";
				echo json_encode($re_data);
				exit;
			}
			// 验证码
			$code = trim(I('post.t_code'));
			//
			// 配置
			$vconfig = $this->getVconfig();
			$Verify = new \Think\Verify($vconfig);
			// $res = $Verify->check($code, 'cell');
			$res = $Verify->check($code);
			if(!$code || !$res){
				$re_data['msg'] = "验证码错误！";
				echo json_encode($re_data);
				exit;
			}

			// 验证成功
			session('pwdinfo.aftcellcode', '1');

			// 成功
			$re_data['status'] = "1";
			echo json_encode($re_data);
			exit;
		}
		// 未定义
		else{
			exit;
		}
    }
	// 发送手机短信
	private function sendCellMsg($phone, $msg){
		// 返回
		$re_data = array('status'=>false, 'msg'=>'');

		// 验证

		// 采用 普通接口发送短信

		// $apikey : 用户唯一标识,在 http://www.yunpian.com 注册后，会获得一个
		// 测试 当前的是 9b11127a9701975c734b8aee81ee3526
		$apikey = '9b11127a9701975c734b8aee81ee3526';

		// 调用 函数返回值等参考: http://www.yunpian.com
		$res = $this->re_send_sms($apikey, $msg, $phone);

		// 处理结果
		$res = json_decode($res, true);

		//
		if($res['code'] == 0){
			$re_data['status'] = true;
		}else{
			$re_data['msg'] = '发送失败！';	// 具体失败原因: $res['msg']
		}
		return $re_data;		
		// $res['code'] = 3	// 账户余额不足
	}
	// 邮箱找回密码
	public function resetPwdMail(){
		$step = intval(I('get.step'))? : 1;    // 如果没有值默认1
		$step = in_array($step, array(1,2,3,4)) ? $step : 1;		// 可以将其他无效值默认为1

		// 初始页面
		if($step == 1){
			if(!session("pwdinfo.id")){
				$this->error('请先确定用户名！', U('User/index'));
			}
			// 邮箱
			$email = trim(session("pwdinfo.email"));
			$mailfalse = "true";
			if(!$email || !preg_match("/^[^\s]+@[^\s]+$/", $email)){
				// $this->error('邮箱无效或不存在！', U('User/index'));
				$mailfalse = "false";
			}
			$this->assign('mailfalse', $mailfalse);
			// 进入提示
			$this->display();
			exit;
		}
		// AJAX请求 发送邮箱
		if($step == 2){
			$res_data = array('status'=>'0', 'msg'=>'');

			// 验证
			if(!session("pwdinfo.id")){
				$this->error('请先确定用户名！');
				// $res_data['msg'] = '请先确定用户名！';
				// echo json_encode($res_data);
				// exit;
			}
			// 邮箱
			$email = trim(session("pwdinfo.email"));
			if(!$email || !preg_match("/^[^\s]+@[^\s]+$/", $email)){
				$this->error('邮箱无效或不存在！');
				// $res_data['msg'] = '邮箱无效或不存在！';
				// echo json_encode($res_data);
				// exit;
			}
			// 时间限制 如果存在时间限定，验证
			
			//aftmailcode 没有通过图片验证
			if(!session("pwdinfo.aftmailcode")){
				$this->error('验证失败');
				// $res_data['msg'] = '验证失败';
				// echo json_encode($res_data);
				// exit;
			}

			// 发送邮件>>>>>>>>>

			// 邮箱邮件模板: [url]: 是重新设置密码的url，需要替换的
			$email_title_model = '重新设置密码-华唯商标转让网';	// 标题
			$email_content_model = '尊敬的用户：你可以通过下面的路径重新设置密码：<a href=\"[url]\" target=\"_balnk\">[url]</a>。';// 内容

			$mdcode = md5(time());	// 参数：$mdcode 邮箱认证码
			session("pwdinfo.mdcode", $mdcode);	// 记录,判断标识
			$step = 3;	// 参数：$step 当前第几步
			$url = C('WEBURL')."/index.php/Home/User/resetPwdMail/step/{$step}/code/{$mdcode}.html";

			// 替换
			$title = $email_title_model;
			$content = preg_replace('/\[url]/',$url, $email_content_model, -1);

			// 调用发送函数
			$res = sendMail($email,$title,$content);
			// 结果判断
			if($res){
				// $res_data['status'] = '1';
				$this->display(":User/remailsend");
				exit;
			}else{
				// $res_data['msg'] = '发送邮件失败！';
				$this->error('发送邮件失败！');
			}
			// echo json_encode($res_data);
			exit;
		}
		// 从邮箱url进入
		elseif($step == 3){
			$code = trim(I('get.code'));
			// 会员名验证
			if(!session("pwdinfo.id")){
				$this->error('请先确定用户名！', U('User/index'));
			}
			// 邮箱
			$email = trim(session("pwdinfo.email"));
			if(!$email || !preg_match("/^[^\s]+@[^\s]+$/", $email)){
				$this->error('邮箱无效或不存在！', U('User/index'));
			}
			// 时间限制 如果存在时间限定，验证

			// 邮箱认证码
			$mdcode = session("pwdinfo.mdcode");
			if(!$code || $code != $mdcode){
				 $this->error('链接已失效！', U('User/index'));// 验证码和记录的不一样
			}

			// 验证成功
			session('pwdinfo.mailsuccess', '1');

			// 跳转到验证成功后的页面
			$this->display(":User/resetPwd");
			exit;
		}
		// ajax 图片验证码验证
		elseif($step == 4){
			$res_data = array('status'=>'0', 'msg'=>'');
			// 验证码
			$code = trim(I('get.code'));

			// 配置
			$vconfig = $this->getVconfig();
			$Verify = new \Think\Verify($vconfig);
			// $res = $Verify->check($code, 'cell');
			$res = $Verify->check($code);
			if(!$code || !$res){
				$re_data['msg'] = "验证码错误！";
				echo json_encode($re_data);
				exit;
			}

			// 会员名验证
			if(!session("pwdinfo.id")){
				$re_data['msg'] = "请先确定用户名！";
				echo json_encode($re_data);
				exit;
			}
			// 邮箱
			$email = trim(session("pwdinfo.email"));
			if(!$email || !preg_match("/^[^\s]+@[^\s]+$/", $email)){
				$re_data['msg'] = "邮箱无效或不存在！";
				echo json_encode($re_data);
				exit;
			}
			// 时间限制 如果存在时间限定，验证

			// 验证成功
			session('pwdinfo.aftmailcode', '1');
			
			//
			$re_data['status'] = "1";
			echo json_encode($re_data);
			exit;
		}
		//
	}
//

	/**
	* url 为服务的url地址
	* query 为请求串
	*/
	private function re_sock_post($url,$query){
		$data = "";
		$info=parse_url($url);
		$fp=fsockopen($info["host"],80,$errno,$errstr,30);
		if(!$fp){
			return $data;
		}
		$head="POST ".$info['path']." HTTP/1.0\r\n";
		$head.="Host: ".$info['host']."\r\n";
		$head.="Referer: http://".$info['host'].$info['path']."\r\n";
		$head.="Content-type: application/x-www-form-urlencoded\r\n";
		$head.="Content-Length: ".strlen(trim($query))."\r\n";
		$head.="\r\n";
		$head.=trim($query);
		$write=fputs($fp,$head);
		$header = "";
		while ($str = trim(fgets($fp,4096))) {
			$header.=$str;
		}
		while (!feof($fp)) {
			$data .= fgets($fp,4096);
		}
		fclose($fp);
		return $data;
	}
	/**
	* 普通接口发短信
	* apikey 为云片分配的apikey
	* text 为短信内容
	* mobile 为接受短信的手机号
	*/
	private function re_send_sms($apikey, $text, $mobile){
		$url="http://yunpian.com/v1/sms/send.json";
		$encoded_text = urlencode("$text");
		$post_string="apikey=$apikey&text=$encoded_text&mobile=$mobile";
		return $this->re_sock_post($url, $post_string);
	}

	// 生成图片验证码 仅对于cell和email验证
	public function getVerify(){
		$type = intval(I('get.type')) ? 'cell' : 'mail';	// 0=cell,1=邮件
		// tests
		$type = '';

		// 没有通过验证
		if(!session('pwdinfo.id')){
			exit;
		}
		// 配置
		$vconfig = $this->getVconfig();
		//
		$Verify = new \Think\Verify($vconfig);

		// 输出
		$Verify->entry($type);
	}
	// 获取 生成图片验证码 配置
	private function getVconfig(){
		return array(
			// 'seKey'     =>  'sfsdfsdfsd',   	// 验证码加密密钥
			// 'codeSet'   =>  '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY',             // 验证码字符集合
			// 'codeSet'   =>  '0123456789',    	// 验证码字符集合
			// 'useImgBg'  =>  false,           // 使用背景图片
			'fontSize'  =>  25,              // 验证码字体大小(px)
			// 'useCurve'  =>  true,            // 是否画混淆曲线
			// 'useNoise'  =>  true,            // 是否添加杂点
			'imageH'    =>  50,               // 验证码图片高度
			'imageW'    =>  200,               // 验证码图片宽度
			'length'    =>  4,               // 验证码位数
			// 'fontttf'   =>  '',              // 验证码字体，不设置随机获取
			// 'bg'        =>  array(243, 251, 254),  // 背景颜色
			// 'reset'     =>  true,           // 验证成功后是否重置
		);
	}

	
}