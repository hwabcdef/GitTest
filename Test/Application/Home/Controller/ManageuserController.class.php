<?php
namespace Home\Controller;
use Think\Controller;
class ManageuserController extends Controller {
	public function __construct(){
		parent::__construct();

		// $_SESSION['ADMIN_ID'] 验证
		if(!session('ADMIN_ID')){
			$this->error('您还未登陆！');
		}
	}
	// 会员管理列表
	public function index(){
		$txt_search = trim(I('get.txt_search'));				// 全文搜索内容

        // 收索条件
		$where = array();
		$map = array();
		if($txt_search){	// 全文收索
			// 根据现有字段值类型减少一些不必的 like
			$field_search = 'username';// username	varchar
			if(preg_match("/^\d+$/", $txt_search)){// uid	varchar	\d+
				$field_search .= '|uid';
			}
			if(preg_match("/^\d+$/", $txt_search)){// cellphone	varchar	\d+
				$field_search .= '|cellphone';
			}
			if(preg_match("/^(\d{1,4}-)?\d+(-\d{1,4})?$/", $txt_search)){// telephone	varchar	\d+
				$field_search .= '|telephone';
			}
			if(preg_match("/^\d+$/", $txt_search)){// qq	varchar	\d+
				$field_search .= '|qq';
			}
			$field_search .= '|email';		// email	varchar
			$field_search .= '|nick';		// nick	varchar
			$field_search .= '|cname';		// cname	varchar
			$field_search .= '|address';	// address	varchar
			if(preg_match("/^\d+$/", $txt_search)){// logintimes	int	\d+
				$field_search .= '|logintimes';
			}
			$field_search .= '|user_nicename';	// user_nicename varchar 是 join usrs 获得的
			// status	int	\d+		// 或者需要匹配其他值
			if($txt_search == '活动'){
				$map['status'] = 1;
			}elseif($txt_search == '屏蔽'){
				$map['status'] = 2;
			}elseif($txt_search == '跟进'){
				$map['status'] = array('not in', '1,2');
			}
			// 如果有时间查询// 如 2015-01-12 10:20:30
			if(preg_match('/^[\d-\s:\/]+$/', $txt_search) && strtotime($txt_search)){// regtime lastlogintime
				$field_search .= '|date_reg|date_log';// 注意 date_reg 是 regtime 转换的; date_log 是 lastlogintime 转换的;
			}
			$map[$field_search] = array('like', "%$txt_search%");
			if($map['status']){
				$map['_logic'] = 'or';
			}
			$where['_complex'] = $map;
		}

		// 默认条件
		$where['deletetime'] = array('EXP', 'is null');			// 没有 删除时间
		$subfield = 'b.*,FROM_UNIXTIME(regtime) as date_reg,FROM_UNIXTIME(lastlogintime) as date_log';
		$subsql = M()->table('__USER__ b')->field($subfield)->buildSql();								// 子视图
		$count = M()->table($subsql.' a')->join('LEFT JOIN __USERS__ c on c.id=a.admin_id')->where($where)->count();	// 总记录数量
		$pagesize = 100;									// 每页显示记录条数
		$Page = new \Think\Page($count, $pagesize);		// 实例化分页类
		$show = $Page->show();							// 分页输出显示
		// 分页数据查询 排序 qq,cellphone,telephone,email,a.id desc
		$list = M()->table($subsql.' a')->field('a.*,c.user_nicename')->join('LEFT JOIN __USERS__ c on c.id=a.admin_id')->where($where)
			->order('a.cellphone,a.qq,a.telephone,a.email,a.id desc')->limit($Page->firstRow.','.$Page->listRows)->select();// limit方式
		// 对显示数据进行整理
		$prev_key = '';
		$prev_val = array();
		foreach($list as $key=>$val){
			$list[$key]['same'] = 0;
			if($prev_val){
				// 判断和上一次的记录是否存在 qq,cellphone,telephone 相同
				$qq_flg = $val['qq'] && ($val['qq']==$prev_val['qq']);
				$cellphone_flg = $val['cellphone'] && ($val['cellphone']==$prev_val['cellphone']);
				$telephone_flg = $val['telephone'] && ($val['telephone']==$prev_val['telephone']);
				$email_flg = $val['email'] && ($val['email']==$prev_val['email']);
				if($qq_flg || $cellphone_flg || $telephone_flg || $email_flg){
					$list[$prev_key]['same'] = 1;
					$list[$key]['same'] = 1;
				}
			}
			$prev_key = $key;
			$prev_val = $val;
		}
		//
		$this->assign('list_data', $list);				// 视图数据集
		$this->assign('page', $show);					// 视图分页
		$this->assign('txt_search', $txt_search);
		//
    	$this->display();
    }
	// 跟进或查看 页面
	public function traceUser(){
		$uid = intval(I('get.pid'));		// uid
		$user_model = M('user');
		$user_info = $user_model->find($uid);
		if(!$user_info){
			$this->error('用户不存在！');
		}
		$this->assign('user_info', $user_info);
		$this->display();
	}
	// 跟进 提交
	public function doTrace(){
		$admin_id = I('session.ADMIN_ID');	// 获取当前操作的 操作员 id 或者名称
		// 密码验证
		$password = trim($_POST['password']);
		if($password){
			if(!preg_match('/^\w{6,}$/', $password)){
				$this->error('密码必须是6位或以上的数字字母！');
			}
			$_POST['password'] = md5($password);
		}else{
			unset($_POST['password']);
		}
		// id 验证
		$_POST['id'] = trim($_POST['pid']);		// 记录Id
		if(!$_POST['id'] || !preg_match('/^\d+$/', $_POST['id'])){
			$this->error('参数错误!');
		}
		// 是否屏蔽
		$audit = trim($_POST['audit']);
		if($audit == '1'){	// 屏蔽
			$_POST['status'] = '2';// 状态:1=审核通过; 2=屏蔽;新注册用户默认1;
		}else{				// 取消屏蔽	如果不允许取消, 注释掉
			$_POST['status'] = '1';// 状态:1=审核通过; 2=屏蔽;新注册用户默认1;
		}
		$_POST['admin_id'] = $admin_id;		// 管理员ID
		$_POST['audittime'] = time();		// 管理员操作时间
		$user_model = M('user');
		if(!$user_model->create($_POST)){
			$this->error($user_model->getError());
		}
		if($user_model->save()){
			$this->success('修改成功！');
		}else{
			$this->error('修改失败！');
		}
	}
	// 删除	// 页面 ajax 成功输出 1
	public function deleteUser(){
		$admin_id = I('session.ADMIN_ID');	// 获取当前操作的 操作员 id 或者名称
		// 验证 id
		$id = trim($_POST['id']);			// 记录Id
		if(!$id || !preg_match('/^\d+$/', $id)){
			exit('参数错误！');
		}
		$data = array('adimn_id'=>$admin_id, 'deletetime'=>time(), 'id'=>$id);
		if(M('user')->data($data)->save()){
			echo '1';	// 删除成功 = 更新删除时间
		}else{
			echo '删除失败!';
		}
	}
	// 查看黑名单电话
	public function blackList(){
		$txt_search = trim(I('get.txt_search'));			// 全文搜索内容
		$where = array();
		if($txt_search){	// 全文收索
			// 根据现有字段值类型减少一些不必的 like
			// user_nicename	varchar
			$field_search = 'user_nicename';	// 是 join usrs 获得的
			// cellphone	varchar	\d+
			if(preg_match("/^(\d{1,4}-)?\d+(-\d{1,4})?$/", $txt_search)){
				$field_search .= '|cellphone';
			}
			// 如果有时间查询// 如 2015-01-12 10:20:30
			if(preg_match('/^[\d-\s:\/]+$/', $txt_search) && strtotime($txt_search)){// create_time
				$field_search .= '|date_cteate';	// 注意 date_cteate 是 create_time 转换的;
			}
			$where[$field_search] = array('like', "%$txt_search%");
		}
		$subsql = M()->table('__BLACKLIST__ b')->field('b.*,FROM_UNIXTIME(create_time) as date_cteate')->buildSql();// 子视图
		$count = M()->table($subsql.' a')->join('__USERS__ b on b.id=a.admin_id')->where($where)->count();	// 总记录数量
		$pagesize = 20;			// 每页显示数量
		$Page = new \Think\Page($count, $pagesize);
		$show = $Page->show();
		$field = 'a.*, b.user_nicename';
		$list = M()->table($subsql.' a')->field($field)->join('__USERS__ b on b.id=a.admin_id')->where($where)
			->limit($Page->firstRow.','.$Page->listRows)->select();
		//
		$this->assign('txt_search', $txt_search);
		$this->assign('blacklist', $list);
		$this->assign('page', $show);
		$this->display();
	}
	//
}