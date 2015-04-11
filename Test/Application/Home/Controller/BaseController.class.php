<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {
	public function __construct() {
		parent::__construct();
		//获取携带的cookie，如果存在则访问次数自增 1 ，否则生成入库并设cookie
		//判断是否存在
		if(empty($_COOKIE['uid'])){
			//生成uid
			$uid=time().mt_rand(1000,9999);
			//如果出现同样的则重新生成
			setcookie('uid',$uid,time()+10*360*24*60*60,"/");
			$ip=ip2long($_SERVER['REMOTE_ADDR']);
			$data=array('uid'=>$uid,'ip'=>$ip,'time'=>time());
			M('Visitors')->add($data);
			}else{
				//访问次数自增 1
				if(!$visit = S('visit')){  //设置了标志就不增
					$ip=ip2long($_SERVER['REMOTE_ADDR']);
					$data=array('ip'=>$ip,'time'=>time());
					M('Visitors')->where("uid='".$_COOKIE['uid']."'")->save($data);
					M('Visitors')->where("uid='".$_COOKIE['uid']."'")->setInc('times',1);
					S('visit',1,1800);
					}else{
					    S('visit',1,1800);
					     }
				}
		// 页面追踪
		$trace_page_arr = trace_user_url();
		$this->assign('trace_page_arr', $trace_page_arr);// 'on'=控制|limit_time=时限|trace_id=追踪id
    // 获取head中title等的模板 如果模板有变量需要替换，在具体方法中替换
    $tmpl_info = get_title_tmpl();
    $this->assign('tmpl_info', $tmpl_info);


        $tel=D('kefu')->field('tel')->where('is_show = 1')->limit(2)->select();
        $this->assign('tel',$tel);
        $sbhis=json_decode(cookie('history'),true);
        arsort($sbhis);
        $sbhis=array_keys($sbhis);
        $sbhis=join(',',$sbhis);
        //print_r($sbhis);
        $this->assign('history',$this->getadTm($sbhis));
        if(strpos($_SERVER['HTTP_REFERER'],C('WEBURL'))!==false){
            $seakey=$this->save_search_keyword($_SERVER['HTTP_REFERER']);
            if($seakey[0]!=0){
              cookie('keyword',$seakey[1]);
            }         
        }
        $more=D('ad')->where(' ad_id =26 ')->getField('ad_content');
        $more=explode(',', $more);
        $moren=$more[1].','.$more[2].','.$more[3].','.$more[4];
        $tuijian=$this->gettuijianneiye(Array(
            'keyword'=>cookie('keyword'),
            'cate'=>cookie('cate'),
            'ids'=>cookie('ids'),
            'moren'=>$moren
            ));
        /*
          $keyword,百度关键字
          $cate,指定查找的分类号群组，如1,2,3
          $ids,用于找预处理相似商标的商标id群组，如1,2,3
          $moren,默认显示的商标id群组，如1,2,3,4
        */
        $this->assign('tuijianneiye',$tuijian);
       // print_r($tuijian);
        //print_r($this->getadTm($sbhis));
	}
    function fenlei_all(){
        $key='fenlei_all';
        if(S('cache')==1){if(S($key)){return S($key);}}
        $a= file_get_contents(C('DATAPATH').'classshu.php');
        $a=json_decode($a,true);
        $fenlei=D('cate')->getField('cate_id,cate_name,hot,info');
        foreach($fenlei as $k=>$v){
            $fenlei1['f1'][$k]=$v;
            $fenlei1['f1'][$k]['count']=$a[$k];
            $fenlei1['all'] +=$a[$k];
        }
        $fenlei1['f2']=$this->multi_array_sort($fenlei1['f1'],'count');
        S($key,$fenlei1,3600*24);
        return $fenlei1;
    }
    function multi_array_sort($multi_array,$sort_key,$sort=SORT_DESC){ 
        if(is_array($multi_array)){ 
        foreach ($multi_array as $row_array){ 
        if(is_array($row_array)){ 
        $key_array[] = $row_array[$sort_key]; 
        }else{ 
        return false; 
        } 
        } 
        }else{ 
        return false; 
        } 
        array_multisort($key_array,$sort,$multi_array); 
        return $multi_array; 
    }
    public function getQData($title,$cate,$currpage,$perrow,$style,$pic){
    	if(S(md5($url))){return S(md5($url));}
        $title = !empty($title)?$title:'';
        $cate = !empty($cate)?$cate:'';
        $currpage = !empty($currpage)?$currpage:'';
        $perrow = !empty($perrow)?$perrow:'';
        $style = !empty($style)?$style:'';
        $pic = !empty($pic)?$pic:'';
        $url = C('DATAPATH')."data.php?title=$title&cate=$cate&currpage=$currpage&perrow=$perrow&style=$style&pic=$pic";
        $curl = curl_init ();
        curl_setopt ( $curl, CURLOPT_URL, $url );
        curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
        $value = curl_exec ( $curl );
        $data = json_decode($value,true);
        curl_close ( $curl );
        if ($data === 0 || $data === 1 || $data === 2|| $data === 3|| $data === 4|| $data === -1) {
            return $data;
        }
        S(md5($url),$data,3600*24);
        return $data;
    }
    function txcode(){
        //S('txcode',null);
        if(S('txcode')==''){
        $re=D('txcode')->where('belong_parent = 0')->select();
        foreach($re as $v){
            $data[$v['ranked_number']]['name']=$v['name'];
            $data[$v['ranked_number']]['down']=D('txcode')->where('belong_parent ='.$v['id'])->getField('Ranked_number,name');
        }
        S('txcode',$data);
        }
        return S('txcode');
    }
    function fenlei(){
        S('fenlei',null);
        if(S('fenlei')==''){
        $re=D('industry')->where('status = 1 AND parent = 0 AND id in (1,2)')->order('listorder asc')->select();
        foreach ($re as $k=>$v){
            $data[$k]['self']=$v;
            $data[$k]['down']=D('industry')->where('status = 1 AND  parent ='.$v['id'])->order('listorder asc')->select();
            foreach ($data[$k]['down'] as $kk=>$vv){
                unset($data[$k]['down'][$kk]);
                $data[$k]['down'][$kk]['self']=$vv;
                $data[$k]['down'][$kk]['down']=D('industry')->where('status = 1 AND  parent ='.$vv['id'])->order('listorder asc')->select();
                foreach($data[$k]['down'][$kk]['down'] as $kkk=>$vvv){
                    unset($data[$k]['down'][$kk]['down'][$kkk]);
                    $data[$k]['down'][$kk]['down'][$kkk]['self']=$vvv;
                    $data[$k]['down'][$kk]['down'][$kkk]['down']=D('industry')->where('status = 1 AND  parent ='.$vvv['id'])->order('listorder asc')->select();
                    foreach($data[$k]['down'][$kk]['down'][$kkk]['down'] as $kkkk=>$vvvv){
                        unset($data[$k]['down'][$kk]['down'][$kkk]['down'][$kkkk]);
                        $data[$k]['down'][$kk]['down'][$kkk]['down']=D('industry')->where('status = 1 AND  parent ='.$vvv['id'])->order('listorder asc')->select();
                    }
                }
            }
        }
        S('fenlei',$data);
        }
        return S('fenlei');
    }
    function getadTm($tmid){
       $ids=explode(',',$tmid);
       $key=$this->arrtokey($ids);
       if(S('cache')==1){if(S($key)){return S($key);}}
       $url=C('DATAPATH')."ids.php";
       $curl=curl_init();
       curl_setopt ( $curl, CURLOPT_URL, $url);
       curl_setopt ( $curl, CURLOPT_POST, 1 );
       curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
       curl_setopt ( $curl, CURLOPT_POSTFIELDS, $ids );
       $value=curl_exec($curl);
       curl_close($curl);
       $data=json_decode($value,true);
       S($key,$data,3600*24);
       return $data;
    } 
    public function zuijingengxin(){
      $list1=D('industry')->where('parent =29')->select();
      foreach ($list1 as $key => $value) {
        $fcate=json_decode($value['conditions'],true);
        $map['cate']=$fcate['category'];
        $map['number']=40;
        $list1[$key]['zuixin']=$this->getzuixin($map);
        $list1[$key]['down']=D('industry')->where('parent ='.$value['id'])->select();
      }
      return $list1;
    }
    public function gettejia(){
        $key='gettejia';
        if(S('cache')==1){if(S($key)){return S($key);}}
        $slide=D('ad')->where('ad_id in (28,29,30)')->order('listorder')->getField('ad_id,ad_chinese,ad_content');
        foreach ($slide as $key => $value) {
            $tejia['tm'][$key]=$this->getadTm($value['ad_content']);
            $tejia['tm'][$key]['name']=explode('-',$value['ad_chinese'])[1];
            $tejia['ids'] .=','.$value['ad_content'];
        }
        S($key,$tejia,3600*24);
        return $tejia;
    }
    function getsearch($post){
       $key=$this->arrtokey($post).'info';
       if(S('cache')==1){if(S($key)){return S($key);}}
       $url=C('DATAPATH')."common.php";
       $curl=curl_init();
       curl_setopt ( $curl, CURLOPT_URL, $url);
       curl_setopt ( $curl, CURLOPT_POST, 1 );
       curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
       curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post );
       $value=curl_exec($curl);
       curl_close($curl);
       $data=json_decode($value,true);
       S($key,$data,3600*24);
       return $data;
    }  
    function getsbbao($post){
       $key=$this->arrtokey($post);
       if(S('cache')==1){if(S($key)){return S($key);}}
       $url=C('DATAPATH')."tags.php";
       $curl=curl_init();
       curl_setopt ( $curl, CURLOPT_URL, $url);
       curl_setopt ( $curl, CURLOPT_POST, 1 );
       curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
       curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post );
       $value=curl_exec($curl);
       curl_close($curl);
       $data=json_decode($value,true);
       S($key,$data,3600*24);
       return $data;
    } 
    function getsamesearch($post){
       $key=$this->arrtokey($post);
       if(S('cache')==1){if(S($key)){return S($key);}}
       $url=C('DATAPATH')."samename.php";
       $curl=curl_init();
       curl_setopt ( $curl, CURLOPT_URL, $url);
       curl_setopt ( $curl, CURLOPT_POST, 1 );
       curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
       curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post );
       $value=curl_exec($curl);
       curl_close($curl);
       $data=json_decode($value,true);
       S($key,$data,3600*24);
       return $data;
    } 
    function getnears($post){
        $key=$this->arrtokey($post).'info';
       if(S('cache')==1){if(S($key)){return S($key);}}
       $url=C('DATAPATH')."likes.php";
       $curl=curl_init();
       curl_setopt ( $curl, CURLOPT_URL, $url);
       curl_setopt ( $curl, CURLOPT_POST, 1 );
       curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
       curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post );
       $value=curl_exec($curl);
       curl_close($curl);
       $data=json_decode($value,true);
       S($key,$data,3600*24);
       return $data;
    }  
    function getxuke($post){
        $key=$this->arrtokey($post).'info';
       if(S('cache')==1){if(S($key)){return S($key);}}
       $url=C('DATAPATH')."xuke.php";
       $curl=curl_init();
       curl_setopt ( $curl, CURLOPT_URL, $url);
       curl_setopt ( $curl, CURLOPT_POST, 1 );
       curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
       curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post );
       $value=curl_exec($curl);
       curl_close($curl);
       $data=json_decode($value,true);
       S($key,$data,3600*24);
       return $data;
    } 
    function gettuijian($post){
       $url=C('DATAPATH')."tuijian.php";
       $curl=curl_init();
       curl_setopt ( $curl, CURLOPT_URL, $url);
       curl_setopt ( $curl, CURLOPT_POST, 1 );
       curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
       curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post );
       $value=curl_exec($curl);
       curl_close($curl);
       $data=json_decode($value,true);
       return $data;
    }  
    function gettuijianneiye($post){
       $url=C('DATAPATH')."recom.php";
       $curl=curl_init();
       curl_setopt ( $curl, CURLOPT_URL, $url);
       curl_setopt ( $curl, CURLOPT_POST, 1 );
       curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
       curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post );
       $value=curl_exec($curl);
       curl_close($curl);
       $data=json_decode($value,true);
       return $data;
    }  
    public function gettuijian1(){
        $key='gettuijian';
        if(S('cache')==1){if(S($key)){return S($key);}}
        $slide=D('ad')->where('ad_id in (24,25)')->order('listorder')->getField('ad_id,ad_content');
        $tejia['ids'] =$slide[24].','.$slide[25];
        foreach ($slide as $key => $value) {
            $tejia['tm'][]=$this->getadTm($value);
        }
        S($key,$tejia,3600*24);
        return $tejia;
    }
    function getTm($post) {
        $url = C('DATAPATH')."classlist.php";
        $key=$this->arrtokey($post);
        if(S('cache')==1){if(S($key)){return S($key);}}
        $curl = curl_init ();
        curl_setopt ( $curl, CURLOPT_URL, $url );
        curl_setopt ( $curl, CURLOPT_POST, 1 );
        curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post );
        $value = curl_exec ( $curl );
        curl_close ( $curl );
        $data = json_decode ( $value,true );
        if ($data === 0 || $data === 1 || $data === 2) {
            return $data;
        }               
        S($key,$data,3600*24);
        return $data;
    }
    function getData($title,$cate,$currpage,$perrow,$style,$pic){
        $title = !empty($title)?$title:'';
        $cate = !empty($cate)?$cate:'';
        $currpage = !empty($currpage)?$currpage:'';
        $perrow = !empty($perrow)?$perrow:'';
        $style = !empty($style)?$style:'';
        $pic = !empty($pic)?$pic:'';
        $url = C('DATAPATH')."data.php?title=$title&cate=$cate&currpage=$currpage&perrow=$perrow&style=$style&pic=$pic";
        $key=md5($url);
        if(S('cache')==1){if(S($key)){return S($key);}}
        $curl = curl_init ();
        curl_setopt ( $curl, CURLOPT_URL, $url );
        curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
        $value = curl_exec ( $curl );
        $data = json_decode($value,true);
        curl_close ( $curl );
        if ($data === 0 || $data === 1 || $data === 2|| $data === 3|| $data === 4|| $data === -1) {
            return $data;
        }
        S($key,$data,3600*24);
        return $data;
    }
    public function sbinfo($id) {
        $url=C('DATAPATH')."port.php?id=$id";
        $key=md5($url);
        if(S('cache')==1){if(S($key)){return S($key);}}
        $curl=curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        $value=curl_exec($curl);
        curl_close($curl);
        if($value===0){
            $this->error('该商标不可出售!');
            exit;
            }elseif($value===1){
                $this->error('查无此商标!');
                exit;
                }elseif($value===2){
                    $this->error('参数错误!');
                    exit;
                    }
        $data=json_decode($value,true);
        S($key,$data,3600*24); 
        return  $data;

        
    }
    public function sbinfonear($post) {
       $key=$this->arrtokey($post);
       if(S('cache')==1){if(S($key)){return S($key);}}
       $url=C('DATAPATH')."similar.php";
       $curl=curl_init();
       curl_setopt ( $curl, CURLOPT_URL, $url);
       curl_setopt ( $curl, CURLOPT_POST, 1 );
       curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
       curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post );
       $value=curl_exec($curl);
       curl_close($curl);
       $data=json_decode($value,true);
       S($key,$data,3600*24); 
       return $data; 
    }
    function getfenlei($post){
       $key=$this->arrtokey($post);
       //if(S('cache')==1){if(S($key)){return S($key);}}
       $url=C('DATAPATH')."group.php";
       $curl=curl_init();
       curl_setopt ( $curl, CURLOPT_URL, $url);
       curl_setopt ( $curl, CURLOPT_POST, 1 );
       curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
       curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post );
       $value=curl_exec($curl);
       curl_close($curl);
       $data=json_decode($value,true);
       S($key,$data,3600*24); 
       return $data;
    }
    function getzuixin($post){
        $key=$this->arrtokey($post);
       if(S('cache')==1){if(S($key)){return S($key);}}
       $url=C('DATAPATH')."newtm.php";
       $curl=curl_init();
       curl_setopt ( $curl, CURLOPT_URL, $url);
       curl_setopt ( $curl, CURLOPT_POST, 1 );
       curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
       curl_setopt ( $curl, CURLOPT_POSTFIELDS, $post );
       $value=curl_exec($curl);
       curl_close($curl);
       $data=json_decode($value,true);
       S($key,$data,3600*24); 
       return $data;
    }
    function GetMonth(){  
        //得到系统的年月  
        $tmp_date=date("Ym");  
        //切割出年份  
        $tmp_year=substr($tmp_date,0,4);  
        //切割出月份  
        $tmp_mon =substr($tmp_date,4,2);  
        for($i=0;$i<12;$i++){
            $tmp_forwardmonth=mktime(0,0,0,$tmp_mon-$i,1,$tmp_year);
            $tmp[$i] ='"'.date("Ym",$tmp_forwardmonth).'"';
        } 
        $tmp=join(',',$tmp);
        return $tmp;           
    }  
    function arrtokey($arr){
        foreach ($arr as $key => $value) {
            $re .=$key.$value;
        }
        return md5($re);
    }
/**
*功能：获取搜索引擎跳转过来的关键字
*名称：save_search_keyword
*参数：char @domain=$_SERVER['HTTP_HTTP_REFERER'] char @path=$_SERVER['HTTP_HTTP_REFERER']
*结果：返回关键字 char @keywords
*/
function save_search_keyword($domain,$path){
  $searchengine=0;
  $keywords=0;
if(strpos($domain, 'google.com.tw')!==false && preg_match('/q=([^&]*)/i',$path,$regs)){
$searchengine = 'GOOGLE TAIWAN';
$keywords = urldecode($regs[1]); // google taiwan
}
if(strpos($domain,'google.cn')!==false && preg_match('/q=([^&]*)/i',$path,$regs)){
$searchengine = 'GOOGLE CHINA';
$keywords = urldecode($regs[1]); // google china
}
if(strpos($domain,'google.com')!==false && preg_match('/q=([^&]*)/i',$path,$regs)){
$searchengine = 'GOOGLE';
$keywords = urldecode($regs[1]); // google
}elseif(strpos($domain,'baidu.')!==false && preg_match('/wd=([^&]*)/i',$path,$regs)){
$searchengine = 'BAIDU';
$keywords = urldecode($regs[1]); // baidu
}elseif(strpos($domain,'baidu.')!==false && preg_match('/word=([^&]*)/i',$path,$regs)){
$searchengine = 'BAIDU';
$keywords = urldecode($regs[1]); // baidu
}elseif(strpos($domain,'114.vnet.cn')!== false && preg_match('/kw=([^&]*)/i',$path,$regs)){
$searchengine = 'CT114';
$keywords = urldecode($regs[1]); // ct114
}elseif(strpos($domain,'iask.com')!==false && preg_match('/k=([^&]*)/i',$path,$regs)){
$searchengine = 'IASK';
$keywords = urldecode($regs[1]); // iask
}elseif(strpos($domain,'soso.com')!==false && preg_match('/w=([^&]*)/i',$path,$regs)){
$searchengine = 'SOSO';
$keywords = urldecode($regs[1]); // soso
}elseif(strpos($domain, 'sogou.com')!==false && preg_match('/query=([^&]*)/i',$path,$regs)){
$searchengine = 'SOGOU';
$keywords = urldecode($regs[1]); // sogou
}elseif(strpos($domain,'so.163.com')!==false && preg_match('/q=([^&]*)/i',$path,$regs)){
$searchengine = 'NETEASE';
$keywords = urldecode($regs[1]); // netease
}elseif(strpos($domain,'yodao.com')!== false && preg_match('/q=([^&]*)/i',$path,$regs)){
$searchengine = 'YODAO';
$keywords = urldecode($regs[1]); // yodao
}elseif(strpos($domain,'zhongsou.com')!==false && preg_match('/word=([^&]*)/i',$path,$regs)){
$searchengine = 'ZHONGSOU';
$keywords = urldecode($regs[1]); // zhongsou
}elseif(strpos($domain,'search.tom.com')!==false && preg_match('/w=([^&]*)/i',$path,$regs)){
$searchengine = 'TOM';
$keywords = urldecode($regs[1]); // tom
}elseif(strpos($domain,'live.com')!==false && preg_match('/q=([^&]*)/i',$path,$regs)){
$searchengine = 'MSLIVE';
$keywords = urldecode($regs[1]); // MSLIVE
}elseif(strpos($domain, 'tw.search.yahoo.com')!==false && preg_match('/p=([^&]*)/i',$path,$regs)){
$searchengine = 'YAHOO TAIWAN';
$keywords = urldecode($regs[1]); // yahoo taiwan
}elseif(strpos($domain,'cn.yahoo.')!==false && preg_match('/p=([^&]*)/i',$path,$regs)){
$searchengine = 'YAHOO CHINA';
$keywords = urldecode($regs[1]); // yahoo china
}elseif(strpos($domain,'yahoo.')!==false && preg_match('/p=([^&]*)/i',$path,$regs)){
$searchengine = 'YAHOO';
$keywords = urldecode($regs[1]); // yahoo
}elseif(strpos($domain,'msn.com.tw')!==false && preg_match('/q=([^&]*)/i',$path,$regs)){
$searchengine = 'MSN TAIWAN';
$keywords = urldecode($regs[1]); // msn taiwan
}elseif(strpos($domain,'msn.com.cn')!==false && preg_match('/q=([^&]*)/i',$path,$regs)){
$searchengine = 'MSN CHINA';
$keywords = urldecode($regs[1]); // msn china
}elseif(strpos($domain,'msn.com')!==false && preg_match('/q=([^&]*)/i',$path,$regs)){
$searchengine = 'MSN';
$keywords = urldecode($regs[1]); // msn
}
$re[0]=$searchengine;
$re[1]=$keywords;
return $re;
} 



}