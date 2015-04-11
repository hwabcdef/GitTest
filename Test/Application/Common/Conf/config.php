<?php
return array(
	'MAIL_HOST' =>'smtp.163.com',//smtp服务器的名称
    'MAIL_SMTPAUTH' =>TRUE, //启用smtp认证
    'MAIL_USERNAME' =>'bwsxmail@163.com',//你的邮箱名
    'MAIL_FROM' =>'bwsxmail@163.com',//发件人地址
    'MAIL_FROMNAME'=>'Tanchin',//发件人姓名
    'MAIL_PASSWORD' =>'taiyang',//邮箱密码
    'MAIL_CHARSET' =>'utf-8',//设置邮件编码
    'MAIL_ISHTML' =>TRUE, // 是否HTML格式邮件

	//腾讯QQ登录配置
	'THINK_SDK_QQ' => array(
		'APP_KEY'    => 'dsfdsjfkk23', //应用注册成功后分配的 APP ID
		'APP_SECRET' => 'sdfdsf4f34f', //应用注册成功后分配的KEY
		// 'CALLBACK'   => URL_CALLBACK . 'qq',
		'CALLBACK'   => 'http://127.0.0.1/wwwroot/index.php/Home/Oauth/callback/type/qq',
	),
	//新浪微博配置
	'THINK_SDK_SINA' => array(
		'APP_KEY'    => '2312656759', //应用注册成功后分配的 APP ID
		'APP_SECRET' => 'ae2707047bfe57c6b8c8d9fc8fc0663f', //应用注册成功后分配的KEY
		// 'CALLBACK'   => 'http://127.0.0.1/wwwroot/index.php/Home/Oauth/callback/type/sina',
		'CALLBACK'   => 'http://192.168.1.148/index.php/Home/Oauth/callback/type/sina',
		// 需要 APP_KEY 和 APP_SECRET 获取的地方设置 返回路径
	),
	// 页面追踪
	// 'TRACE_PAGE_ON'=> true,		// 是否开启页面追踪: true=开启; false=关闭;
	'TRACE_PAGE_ON'=> false,		// 是否开启页面追踪: true=开启; false=关闭;
	'TRACE_PAGE_TIMELIMIT'=> 5,	// 页面追踪定时提交AJAX,时间 5 秒


	'INDEXPATH'=>'/',
	// 'HTMLPATH'=>'/Public/',
	'HTMLPATH'=>'/wwwroot/Public/',

	// 'WEBURL'=>'192.168.1.148',
	'PIC4'=>'http://7xi92o.com2.z0.glb.qiniucdn.com',  //原始普通图
	'PIC11'=>'http://7vzocs.com2.z0.glb.qiniucdn.com',  //精品横幅图
	'PIC12'=>'http://7vzoct.com2.z0.glb.qiniucdn.com',  //精品小图标展示图
	'PIC13'=>'http://7vzocu.com2.z0.glb.clouddn.com',   //精品小图
	'PIC7'=>'http://7vzocp.com2.z0.glb.clouddn.com',    //无用
	'PIC9'=>'http://7vzocq.com2.z0.glb.clouddn.com',    //精品中图
	'PIC15'=>'http://7vztqh.com2.z0.glb.qiniucdn.com',         //广告大图
	'PIC16'=>'http://7vztqj.com2.z0.glb.qiniucdn.com',         //广告中图
	'HWPIC1'=>'http://7vikxl.com2.z0.glb.qiniucdn.com',    //封面图
	'DATAPATH'=>'http://192.168.1.192/ports/', //数据服务器接口地址

	'TMPL_CACHE_ON'=>false,
	'LOCALHOST'=>'127.0.0.1',
	'WEBURL'=>'127.0.0.1',
    /* 数据库设置 */
    // 'DB_TYPE'               =>  'mysql',     // 数据库类型
    // 'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    // 'DB_NAME'               =>  'hwtm',          // 数据库名
    // 'DB_USER'               =>  'root',      // 用户名
    // 'DB_PWD'                =>  '',          // 密码
    // 'DB_PORT'               =>  '',        // 端口
    // 'DB_PREFIX'             =>  'sp_',    // 数据库表前缀
    // 'DB_PARAMS'          	=>  array(), // 数据库连接参数    
    // 'DB_DEBUG'  			=>  TRUE, // 数据库调试模式 开启后可以记录SQL日志
    // 'DB_FIELDS_CACHE'       =>  true,        // 启用字段缓存
    // 'DB_CHARSET'            =>  'utf8',      // 数据库编码默认采用utf8
    // 'DB_DEPLOY_TYPE'        =>  0, // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    // 'DB_RW_SEPARATE'        =>  false,       // 数据库读写是否分离 主从式有效
    // 'DB_MASTER_NUM'         =>  1, // 读写分离后 主服务器数量
    // 'DB_SLAVE_NO'           =>  '', // 指定从服务器序号	
);