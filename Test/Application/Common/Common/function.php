<?php
function sp_get_asset_upload_path($file,$withhost=false){
	if(strpos($file,"http")===0){
		return $file;
	}else if(strpos($file,"/")===0){
		return $file;
	}else{
		$filepath=C("TMPL_PARSE_STRING.__UPLOAD__").$file;
		if($withhost){
			if(strpos($filepath,"http")!==0){
				$http = 'http://';
				$http =is_ssl()?'https://':$http;
				$filepath = $http.$_SERVER['HTTP_HOST'].$filepath;
			}
		}
		return $filepath;
		
	}                    			
                        		
}
//获取文章
function getNews($term,$limit){
		$join = "".C('DB_PREFIX').'posts as b on a.object_id =b.id';
		$res=M('TermRelationships')->alias("a")->join($join)->where("term_id='".$term."'")->limit($limit)->field('id,post_title,post_date')->order("id desc")->select();
		return $res;
	}	
//获取转让
function getTransfer($state,$limit){
		$res=D('Transfer')->where("state!='".$state."'and del=1")->limit($limit)->order("id desc")->select();
		return $res;
	}
function getprices($price){
        if($price != 0){
        //非面议情况
        if($price<2.3){
            $up=100;
            $down=0;
        }
        if($price>=2.3&&$price<6){
            $up=100;
            $down=30;   
        }
        if($price>=6&&$price<9){
            $up=60;
            $down=20;
        }
        if($price>=9){
            $up=50;
            $down=20;
        }
        }else{
        //面议情况
            $up=0;
            $down=0;
        }
        if($price!=0){
        $a=rand(2,8);
        $b=array(0,1,2,3,4,5,6,7,8,9,10,11);
        $k=array_rand($b,$a);
        //print_r($k);exit;

        for($i=0;$i<12;$i++){
            if(isset($k[$i])){
                $rand=rand($down+100,$up)/100;
            }else{
                $rand=rand(105,95)/100;
            }
            $quxian[$i]=$price*$rand;
        }
        }else{
            $quxian=array(0,0,0,0,0,0,0,0,0,0,0,0);
        }
        $quxian=join(',',$quxian);
        return $quxian;
    }
    
    /*通过商标id获取商标列表信息*/
    function gettmlist($arr){
    	$url = C('DATAPATH')."collect.php";
    	$curl = curl_init();
    	curl_setopt ( $curl, CURLOPT_URL, $url);
    	curl_setopt ( $curl, CURLOPT_POST, 1 );
    	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 );
    	curl_setopt ( $curl, CURLOPT_POSTFIELDS, $arr );
    	$value = curl_exec($curl);
    	$data = json_decode($value,true);
    	curl_close($curl);
    	return $data;
    }