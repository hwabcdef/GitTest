<?php
namespace Home\Controller;
use Think\Controller;
// QQ登陆或微博登陆
class OauthController extends Controller{
	// QQ登陆或微博登陆等 login
	public function oauthlogin($type = null){
		empty($type) && $this->error('参数错误');
		session('login_http_referer', I('server.HTTP_REFERER'));
		// 加载ThinkOauth类并实例化一个对象
		vendor('ThinkSDK.ThinkOauth','','.class.php');
		$sns = \ThinkOauth::getInstance($type);
		// 跳转到授权页面
		redirect($sns->getRequestCodeURL());
	}
	// 授权回调地址
	public function callback($type = null, $code = null){
		empty($type) && $this->error('参数错误');
		if(empty($code)){
			redirect(__ROOT__."/");
		}
		// 加载ThinkOauth类并实例化一个对象
		vendor('ThinkSDK.ThinkOauth','','.class.php');
		$sns = \ThinkOauth::getInstance($type);

		// 腾讯微博需传递的额外参数
		$extend = null;
		if($type == 'tencent'){
			$extend = array('openid' => $this->_get('openid'), 'openkey' => $this->_get('openkey'));
		}

		//请妥善保管这里获取到的Token信息，方便以后API调用
		//调用方法，实例化SDK对象的时候直接作为构造函数的第二个参数传入
		//如： $qq = ThinkOauth::getInstance('qq', $token);
		$token = $sns->getAccessToken($code , $extend);

		//获取当前登录用户信息
		if(is_array($token)){
			$user_info = A('Type', 'Event')->$type($token);

			if(!empty($_SESSION['oauth_bang'])){
				$this->_bang_handle($user_info, $type, $token);
			}else{
				$this->_login_handle($user_info, $type, $token);
			}
		}else{
			$this->success('登录失败！',$this->_get_login_redirect());
		}
	}
	//
	private function _get_login_redirect(){
		return empty($_SESSION['login_http_referer'])?__ROOT__."/":$_SESSION['login_http_referer'];
	}

	// 绑定第三方账号
	private function _bang_handle($user_info, $type, $token){
		$current_uid = trim(session('uid'));
		$oauth_user_model = M('OauthUser');
		$type=strtolower($type);
		$find_oauth_user = $oauth_user_model->where(array("from"=>$type,"openid"=>$token['openid']))->find();
		$need_bang=true;
		// 信息已存在
		if($find_oauth_user){
			if($find_oauth_user['uid'] == $current_uid){
				$this->error("您之前已经绑定过此账号！");exit;
			}else{
				$this->error("该帐号已被本站其他账号绑定！");exit;
			}
		}
		if($need_bang){
			if($current_uid){
				// 第三方用户表中创建数据
				$new_oauth_user_data = array(
						'from' => $type,
						'name' => $user_info['name'],
						'head_img' => $user_info['head'],
						'create_time' =>date("Y-m-d H:i:s"),
						'uid' => $current_uid,
						'last_login_time' => date("Y-m-d H:i:s"),
						'last_login_ip' => get_client_ip(),
						'login_times' => 1,
						'status' => 1,
						'access_token' => $token['access_token'],
						'expires_date' => (int)(time()+$token['expires_in']),
						'openid' => $token['openid'],
				);
				$new_oauth_user_id = $oauth_user_model->add($new_oauth_user_data);
				if($new_oauth_user_id){
					$this->success("绑定成功！", U('User/info'));
				}else{
					$this->error("绑定失败！");
				}
			}else{
				$this->error("绑定失败！");
			}
		}
	}

	// 登陆 或 绑定注册
	private function _login_handle($user_info, $type, $token){
		$type=strtolower($type);
		$oauth_user_model = M('OauthUser');
		$find_oauth_user = $oauth_user_model->where(array("from"=>$type,"openid"=>$token['openid']))->find();
		$need_register=true;
		if($find_oauth_user){
			$find_user = M('User')->where(array("uid"=>$find_oauth_user['uid']))->find();
			if($find_user){
				if($find_user['status'] == '2'){
					$this->error('您可能已经被列入黑名单，请联系网站管理员！');// status 在 users 表
				}
				$need_register=false;
				$data_u = array();
				$data_u['lastloginip'] = ip2long(get_client_ip());
	            $data_u['lastlogintime'] = time();
	            $data_u['logintimes'] = 1 + $find_user['logintimes'];    // 登陆次数加1
	            $data_u['id'] = $find_user['id'];
	            $cre=D('user')->data($data_u)->save();
	            if($cre){
	            	// 记录信息
					session('id',$find_user['id']);
					session('nick',$find_user['nick']);
					session('uid',$find_user['uid']);
					//同步该账号绑定的cookie
					cookie('uid',NULL);
					setcookie('uid',$find_user['uid'],time()+10*360*24*60*60,"/");
	            }else{
	            	$this->error('登陆失败！cre');
	            }
				//
				redirect($this->_get_login_redirect());
			}else{
				$need_register=true;
			}
		}

		// 需要注册
		if($need_register){
			// 记录	在注册成功后存入 // 是否立即存在第三方表
			session('oauth.token', $token);
			session('oauth.user_info', $user_info);
			session('oauth.type', $type);

			// 跳转到注册页面
			redirect(U('User/reg'));
			exit;
		}
	}

	// 用户中心绑定 qq或微博
	function bang($type=""){
		$uid = I('session.uid');	// 获取用户uid
		if($uid){
			empty($type) && $this->error('参数错误！');
			//加载ThinkOauth类并实例化一个对象
			vendor('ThinkSDK.ThinkOauth','','.class.php');
			$sns  = \ThinkOauth::getInstance($type);
			//跳转到授权页面
			$_SESSION['oauth_bang'] = 1;
			session('login_http_referer', I('server.HTTP_REFERER'));
			redirect($sns->getRequestCodeURL());
		}else{
			$this->error('您还没有登录！');
		}
	}
	//
}