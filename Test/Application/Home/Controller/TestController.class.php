<?php
namespace Home\Controller;
use Think\Controller;
// 测试控制器

class TestController extends BaseController {
    public function __construct() {
        parent::__construct();
        //
        
    }
    // header('Content-Type:text/html;charset=utf8;');
    // 测试页面
    public function index() {
        // header('Content-Type:text/html;charset=utf8;');
        // dump($_SERVER);exit;
        // dump(session());
        // dump(cookie());
        // exit;
        $this->display();
    }
    //
    //
    public function test() {
        // 调用index下面的方法
        // $indexc = A('Index');$indexc->index(); // Index/index 中的 $this->display(); 会相当于当前位置调用
        $this->display();
    }
    //
    // 会员管理
    public function manageUser() {
        $this->display();
    }
    // 修改顶部搜索框
    public function headerInput() {
        $this->display();
    }
    //
    // firefox 曲线图有问题
    public function firefoxPic() {
        // 1,在显示ifram前，先验证是否有错误，再刷新ifram的url+Math.random()。
        // 2,加载时先显示div+block，后js控制隐藏。
        //
        //
        $this->display();
    }
}
