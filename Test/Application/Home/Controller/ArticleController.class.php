<?php
namespace Home\Controller;
use Think\Controller;
/**
 * 文章
 */
class ArticleController extends Controller {
	public function __construct() {
		parent::__construct();
		// 页面追踪
		$trace_page_arr = trace_user_url();
		$this->assign('trace_page_arr', $trace_page_arr);// 'on'=控制|limit_time=时限|trace_id=追踪id
		// 获取head中title等的模板 如果模板有变量需要替换，在具体方法中替换
		$tmpl_info = get_title_tmpl(12);	// 默认 12 的一个模板
		$this->assign('tmpl_info', $tmpl_info);
	}

	//关于内页
	public function index() {
    	$id=intval($_GET['id']);
    	$tid=intval($_GET['tid']);
		$cate=M('Terms')->where("term_id='".$id."'")->find();
    	$this->assign('cate',$cate);
		$join = "".C('DB_PREFIX').'posts as b on a.object_id =b.id';
		$art=M('TermRelationships')->alias("a")->join($join)->where("term_id='".$id."' and post_status=1")->find();
    	$this->assign('art',$art);
    	$this->assign('tid',$tid);

		// 获取head中title等的模板
		$tmpl_info = $this->view->get('tmpl_info');	// 获取已设置的模板
		$tmpl_info['title'] = preg_replace('/\[article_name]/',$cate['name'], $tmpl_info['title']);
		$this->assign('tmpl_info', $tmpl_info);

    	$this->display(":service/about");
    }
	
	//文章列表
	public function news() {
		$id=intval($_GET['id']);
		$tid=intval($_GET['tid']);
		$term=M('Terms')->where("term_id='".$id."'")->find();
    	$this->assign('cate',$term);
		$total = M('TermRelationships')->where("term_id='".$id."'")->count();
		$pagesize=20;
		$page = new \Think\Page($total,$pagesize);
		$firstRow =$page->firstRow;
		$listRow = $page->listRows;
		$join = "".C('DB_PREFIX').'posts as b on a.object_id =b.id';
		$lists=M('TermRelationships')->alias("a")->join($join)->field('id,post_title,post_date')->where("term_id='".$id."' and post_status=1")->limit($firstRow.",".$listRow)->order('post_date desc')->select();
		$link = $page->show('default');
    	$this->assign('lists', $lists);
		$this->assign('link',$link);
		$this->assign('totalpages',ceil($total/$pagesize));
		$this->assign('tid',$tid);

		// 获取head中title等的模板
		$tmpl_info = get_title_tmpl();	// 13 的一个模板
		$tmpl_info['title'] = preg_replace('/\[article_name]/',$term['name'], $tmpl_info['title']);
		$this->assign('tmpl_info', $tmpl_info);

		$this->display(":service/tmNews");
    }
    	
	//成功案例
	public function cases() {
		$id=intval($_GET['id']);
		$term=M('Terms')->where("term_id='".$id."'")->find();
    	$this->assign('cate',$term);
		$join = "".C('DB_PREFIX').'posts as b on a.object_id =b.id';
		$sons=M('Terms')->where("parent='".$id."'")->select();
		$tb=M('TermRelationships')->alias("a")->join($join)->field('post_title,smeta')->where("term_id='".$sons[0]['term_id']."' and post_status=1")->select();
    	$this->assign('tb',$tb);
		$total = D('TermRelationships')->where("term_id='".$sons[1]['term_id']."'")->count();
		$pagesize=20;
		$page = new \Think\Page($total,$pagesize);
		$firstRow =$page->firstRow;
		$listRow = $page->listRows;
		$lists=M('TermRelationships')->alias("a")->join($join)->field('post_title,smeta')->where("term_id='".$sons[1]['term_id']."' and post_status=1")->order('post_date desc')->select();
		$this->assign("lists",$lists);
		$link = $page->show('default');
		$this->assign('link',$link);
		$this->assign('totalpages',ceil($total/$pagesize));

		// 获取head中title等的模板
		$tmpl_info = $this->view->get('tmpl_info');	// 获取已设置的模板
		$tmpl_info['title'] = preg_replace('/\[article_name]/',$term['name'], $tmpl_info['title']);
		$this->assign('tmpl_info', $tmpl_info);

    	$this->display(":service/case");
    }
	
	//团队风采
	public function team() {
		$id=intval($_GET['id']);
		$tid=intval($_GET['tid']);
		$term=M('Terms')->where("term_id='".$id."'")->find();
    	$this->assign('cate',$term);
		$total = D('TermRelationships')->where("term_id='".$id."'")->count();
		$pagesize=20;
		$page = new \Think\Page($total,$pagesize);
		$firstRow =$page->firstRow;
		$listRow = $page->listRows;
		$join = "".C('DB_PREFIX').'posts as b on a.object_id =b.id';
		$lists=M('TermRelationships')->alias("a")->join($join)->field('post_title,smeta')->where("term_id='".$id."' and post_status=1")->limit($firstRow.",".$listRow)->order('post_date desc')->select();		
    	$this->assign('lists', $lists);
		$link = $page->show('default');
		$this->assign('link',$link);
		$this->assign('totalpages',ceil($total/$pagesize));
		$this->assign('tid',$tid);

		// 获取head中title等的模板
		$tmpl_info = $this->view->get('tmpl_info');	// 获取已设置的模板
		$tmpl_info['title'] = preg_replace('/\[article_name]/',$term['name'], $tmpl_info['title']);
		$this->assign('tmpl_info', $tmpl_info);

		$this->display(":service/team");
    }
	    
	//帮助中心
	public function help() {
    	$id=intval($_GET['id']);
    	$tid=intval($_GET['tid']);
		$term=M('Terms')->where("term_id='".$id."'")->find();
    	$this->assign('cate',$term);
    	$total = D('TermRelationships')->where("term_id='".$id."'")->count();
    	$pagesize=5;
		$page = new \Think\Page($total,$pagesize);
    	$firstRow =$page->firstRow;
    	$listRow = $page->listRows;
    	$join = "".C('DB_PREFIX').'posts as b on a.object_id =b.id';
		$lists=M('TermRelationships')->alias("a")->join($join)->field('id,post_title,post_content')->where("term_id='".$id."' and post_status=1")->limit($firstRow.",".$listRow)->order('post_date desc')->select();
        $link = $page->show('default');
        $this->assign('link',$link);
        $this->assign('totalpages',ceil($total/$pagesize));
		$this->assign('lists',$lists);
    	$this->assign('tid',$tid);

		// 获取head中title等的模板
		$tmpl_info = $this->view->get('tmpl_info');	// 获取已设置的模板
		$tmpl_info['title'] = preg_replace('/\[article_name]/',$term['name'], $tmpl_info['title']);
		$this->assign('tmpl_info', $tmpl_info);

    	$this->display(":service/help");
    }

    //文书下载
    public function documents() {
        $id=intval($_GET['id']);
        $tid=intval($_GET['tid']);
        $term=M('Terms')->where("term_id='".$id."'")->find();
        $this->assign('cate',$term);
        $total = D('TermRelationships')->where("term_id='".$id."'")->count();
        $pagesize=72;
        $page = new \Think\Page($total,$pagesize);
        $firstRow =$page->firstRow;
        $listRow = $page->listRows;
        $join = "".C('DB_PREFIX').'posts as b on a.object_id =b.id';
        $lists=M('TermRelationships')->alias("a")->join($join)->field('post_content,post_title')->where("term_id='".$id."' and post_status=1")->limit($firstRow.",".$listRow)->order('post_date desc')->select();
        foreach($lists as $key=>$list){
            if(preg_match('/href.+"/',$list['post_content'],$href)){
                $url[$key]['post_content']=$href[0];
                $url[$key]['post_title']=$list['post_title'];
            }            
        }
        $this->assign('lists', $url);
        $link = $page->show('default');
        $this->assign('link',$link);
        $this->assign('totalpages',ceil($total/$pagesize));
        $this->assign('tid',$tid);

		// 获取head中title等的模板
		$tmpl_info = $this->view->get('tmpl_info');	// 获取已设置的模板
		$tmpl_info['title'] = preg_replace('/\[article_name]/',$term['name'], $tmpl_info['title']);
		$this->assign('tmpl_info', $tmpl_info);

        $this->display(":service/download");
    }
    
	//新闻内页
	public function info() {
		$id=intval($_GET['id']);
		$tid=intval($_GET['tid']);
		$term=M('Terms')->where("term_id='".$id."'")->find();
    	$this->assign('cate',$term);
		$aid=intval($_GET['aid']);
		$art=M('Posts')->where("id='".$aid."'")->find();
    	$this->assign('art', $art);
		$ids=M('TermRelationships')->where("term_id='".$id."'")->field('object_id')->select();
		foreach($ids as $id){
			$post_ids[]=$id['object_id'];
			}
		$key=array_search($aid,$post_ids);
		$upid=$key-1;
		$downid=$key+1;
		$up_id=$post_ids[$upid];
		$down_id=$post_ids[$downid];
		$up=M('Posts')->where("id='".$up_id."'")->find();
		$down=M('Posts')->where("id='".$down_id."'")->find();
		$this->assign('up',$up);
		$this->assign('down',$down);
		$this->assign('tid',$tid);

		// 获取head中title等的模板
		$tmpl_info = get_title_tmpl();	// 14 的一个模板
		$tmpl_info['title'] = preg_replace('/\[article_name]/',$art['post_title'], $tmpl_info['title']);
		$this->assign('tmpl_info', $tmpl_info);

    	$this->display(":service/tmNewsInfo");
    }
	
	//求购列表
	public function demand() {
		$id=intval($_GET['id']);
		$term=M('Terms')->where("term_id='".$id."'")->find();
    	$this->assign('cate',$term);		
		$total = D('Demand')->where("state!=2 and del=1")->count();
		$pagesize=20;
		$page = new \Think\Page($total,$pagesize);
		$firstRow =$page->firstRow;
		$listRow = $page->listRows;
		$lists=D('Demand')->where("state!=2 and del=1")->limit($firstRow.",".$listRow)->order('uptime desc')->select();
		$link = $page->show('default');
    	$this->assign('lists', $lists);
		$this->assign('link',$link);
		$this->assign('totalpages',ceil($total/$pagesize));

		// 获取head中title等的模板
		$tmpl_info = $this->view->get('tmpl_info');	// 获取已设置的模板
		$tmpl_info['title'] = preg_replace('/\[article_name]/',$term['name'], $tmpl_info['title']);
		$this->assign('tmpl_info', $tmpl_info);

    	$this->display(":service/demandlist");
    }
	
	//转让列表
	public function transfer() {
		$id=intval($_GET['id']);
		$tid=intval($_GET['tid']);
		$term=M('Terms')->where("term_id='".$id."'")->find();
    	$this->assign('cate',$term);		
		$total = D('Transfer')->where("state!=2 and del=1")->count();
		$pagesize=20;
		$page = new \Think\Page($total,$pagesize);
		$firstRow =$page->firstRow;
		$listRow = $page->listRows;
		$lists=D('Transfer')->where("state!=2 and del=1")->limit($firstRow.",".$listRow)->order('uptime desc')->select();
		$link = $page->show('default');
    	$this->assign('lists', $lists);
		$this->assign('link',$link);
		$this->assign('totalpages',ceil($total/$pagesize));
		$this->assign('tid',$tid);

		// 获取head中title等的模板
		$tmpl_info = $this->view->get('tmpl_info');	// 获取已设置的模板
		$tmpl_info['title'] = preg_replace('/\[article_name]/',$term['name'], $tmpl_info['title']);
		$this->assign('tmpl_info', $tmpl_info);

    	$this->display(":service/transferlist");
    }
	
	//求购内页
	public function demandinfo() {
		$id=intval($_GET['id']);
		$term=M('Terms')->where("term_id='".$id."'")->find();
    	$this->assign('cate',$term);		
		$aid=intval($_GET['aid']);
		$art=M('Demand')->where("id='".$aid."'")->find();
    	$this->assign('art', $art);
		$ids=M('Demand')->where("state!=2 and del=1")->field('id')->select();
		foreach($ids as $id){
			$post_ids[]=$id['id'];
			}
		$key=array_search($aid,$post_ids);
		$upid=$key-1;
		$downid=$key+1;
		$up_id=$post_ids[$upid];
		$down_id=$post_ids[$downid];
		$up=M('Demand')->where("id='".$up_id."'")->find();
		$down=M('Demand')->where("id='".$down_id."'")->find();
		$this->assign('up',$up);
		$this->assign('down',$down);

		// 获取head中title等的模板
		$tmpl_info = get_title_tmpl(14);	// = Article/info 的模板
		$tmpl_info['title'] = preg_replace('/\[article_name]/',$art['title'], $tmpl_info['title']);
		$this->assign('tmpl_info', $tmpl_info);

    	$this->display(":service/demandInfo");
    }
	
	//转让内页
	public function transferinfo() {
		$id=intval($_GET['id']);
		$tid=intval($_GET['tid']);
		$term=M('Terms')->where("term_id='".$id."'")->find();
    	$this->assign('cate',$term);
		$aid=intval($_GET['aid']);
		$art=M('Transfer')->where("id='".$aid."'")->find();
    	$this->assign('art', $art);
		$ids=M('Transfer')->where("state!=2 and del=1")->field('id')->select();
		foreach($ids as $id){
			$post_ids[]=$id['id'];
			}
		$key=array_search($aid,$post_ids);
		$upid=$key-1;
		$downid=$key+1;
		$up_id=$post_ids[$upid];
		$down_id=$post_ids[$downid];
		$up=M('Transfer')->where("id='".$up_id."'")->find();
		$down=M('Transfer')->where("id='".$down_id."'")->find();
		$this->assign('up',$up);
		$this->assign('down',$down);
		$this->assign('tid',$tid);

		// 获取head中title等的模板
		$tmpl_info = $this->view->get('tmpl_info');	// 获取已设置的模板
		$name_tmpl = "第".$art['cate_id']."类".$art['tm_name'];
		$tmpl_info['title'] = preg_replace('/\[article_name]/',$name_tmpl, $tmpl_info['title']);
		$this->assign('tmpl_info', $tmpl_info);

    	$this->display(":service/transferInfo");
    }
    
    //加盟合作
    public function joinus() {
    	$id=intval($_GET['id']);
    	$tid=intval($_GET['tid']);
		$cate=M('Terms')->where("term_id='".$id."'")->find();
    	$this->assign('cate',$cate);
        $this->assign('tid',$tid);

		// 获取head中title等的模板
		$tmpl_info = $this->view->get('tmpl_info');	// 获取已设置的模板
		$tmpl_info['title'] = preg_replace('/\[article_name]/',$cate['name'], $tmpl_info['title']);
		$this->assign('tmpl_info', $tmpl_info);

        $this->display(":service/joinUs");
    }
    
    //申请加盟合作
    public function joinuspost(){
        $_POST['uptime']=time();
        if(D('Join')->create()){
            if(D('Join')->add($_POST)){
                $this->success('提交成功！',U('Article/joinus',array('id'=>33,'tid'=>33)));
            }else{
                $this->error('提交失败！');
            }
        }else{
            $this->error(D('Join')->getError());
        }        
    }
}