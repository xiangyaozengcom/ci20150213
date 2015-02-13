<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//设定输出编码为utf-8
header("content-type:text/html;charset=utf8");

class test20141202 extends CI_Controller {
	#
	public function __construct(){
		parent::__construct();
		$this->load->helper('MY_chjsonencode');
	}
        
        
        
        public function serach_form() {
            echo '123';
            $this->load->view('test/serach_form.html');
        }
        /*
          先直接对接到搜索接口，传递pageinfo，
          http://dev.wanhui.cn/#/api_version_detail/218
		https://sandbox.api.wanhui.cn/v1/search
         * 
         * 能拿到结果了，需要把结果显示到页面上，然后把结果
         * 携带pageinfo，可以考虑发送多次请求
         * 那现在的意思，我自己可以直接在PHP中测试了，不用依赖于前端的js联通了，先
         */
        public function search(){
            //var_dump($_GET);
            if (!empty($_GET['query'])) {
                $params['query']=  $_GET['query'];
            }else{
                echo '请传递query参数';
                return;
            }
           
            $http_params['url']='https://sandbox.api.wanhui.cn/v1/search?params=';
            $http_params['method']='GET';
            $http_params['multi']=true;
            $http_params['extheaders']=array();
            $http_params['params']['query']=$_GET['query'];
            $http_params['params']['limit']=3;
            $http_params['params']['offset']=0;
            
            $info = $this->GetHttpCurlResponse($http_params);
            $info_arr=  json_decode($info,true);
            if(isset($info_arr["pageinfo"]) && !empty($info_arr["pageinfo"])){
                var_dump($info_arr["pageinfo"]);
                var_dump(json_encode($info_arr["pageinfo"]));
            }
            
            echo '<hr/>';
            
            $http_params['params']['pageinfo']=$info_arr["pageinfo"];
            $info1 = $this->GetHttpCurlResponse($http_params);
            $info_arr1=  json_decode($info1,true);
            if(isset($info_arr1["pageinfo"]) && !empty($info_arr1["pageinfo"])){
                var_dump($info_arr1["pageinfo"]);
                var_dump(json_encode($info_arr1["pageinfo"]));
            }
            
            echo '<hr/>';
            
            $http_params['params']['pageinfo']=$info_arr1["pageinfo"];
            $info2 = $this->GetHttpCurlResponse($http_params);
            $info_arr2=  json_decode($info2,true);
            if(isset($info_arr2["pageinfo"]) && !empty($info_arr2["pageinfo"])){
                var_dump($info_arr2["pageinfo"]);
                var_dump(json_encode($info_arr2["pageinfo"]));
            }
        }
        
        public function json20141202(){
            $info='{"data":[{"attention_num":-1,"average_price":-1,"begin_time":{"date":20,"day":4,"hours":9,"minutes":16,"month":10,"seconds":13,"time":1416446173000,"timezoneOffset":-480,"year":114},"brand_id":0,"category_id":3,"category_name":"","city_id":[350200],"create_time":{"date":20,"day":4,"hours":16,"minutes":20,"month":10,"seconds":20,"time":1416471620000,"timezoneOffset":-480,"year":114},"create_time_server":null,"create_type":0,"deleted":-1,"deliver_type":-1,"description":"成立于2005年，隶属于万达集团，是亚洲银幕数排名第一的电影院线，开业五星级影城86家，730块银幕，其中IMAX银幕47块，占有全国15%的票房份额，成为排名全球前列的电影院线。2011年票房收入超过178亿元，稳居中国第一的市场份额。2010年12月，万达院线荣获第18届亚太电影博览会(CineAsia)“年度放映商”大奖，这是中国内地电影放映商第一次获得这一备受推崇的国际大奖。","description_original":"","end_time":{"date":20,"day":4,"hours":9,"minutes":16,"month":10,"seconds":13,"time":1416446173000,"timezoneOffset":-480,"year":114},"icon":"h0046ed00cdaaba3de066ffe6448f053e6b","id":"1#2065518","is_activity":0,"is_coup":0,"is_entity":1,"is_order":0,"is_takeout":0,"is_wd":1,"is_wisdom":0,"like_num":-1,"name":"","name_original":"","ori_price":0,"pay_type":0,"plaza_id":[1000546],"plaza_latitude":24.5732,"plaza_longitude":118.093,"product_id":"2065518","product_type":0,"pub_time":{"date":13,"day":4,"hours":1,"minutes":13,"month":10,"seconds":28,"time":1415812408000,"timezoneOffset":-480,"year":114},"resource_id":1,"return_policy":-1,"sale_num":-1,"sale_point":-1,"sale_price":-1,"sale_time_end":{"date":20,"day":4,"hours":9,"minutes":16,"month":10,"seconds":13,"time":1416446173000,"timezoneOffset":-480,"year":114},"sale_time_start":{"date":13,"day":4,"hours":1,"minutes":13,"month":10,"seconds":28,"time":1415812408000,"timezoneOffset":-480,"year":114},"score":4.885228,"show_type":"","status":1,"stock":-1,"store_id":[2065518],"store_type_name":"文华","store_x":0,"store_y":0,"store_z":0,"subtitle":"万达影城","time_length":0,"title":"万达影城","title_original":"","update_time":{"date":13,"day":4,"hours":1,"minutes":13,"month":10,"seconds":28,"time":1415812408000,"timezoneOffset":-480,"year":114},"update_time_server":null,"voted_num":-1},{"attention_num":-1,"average_price":-1,"begin_time":{"date":20,"day":4,"hours":9,"minutes":10,"month":10,"seconds":54,"time":1416445854000,"timezoneOffset":-480,"year":114},"brand_id":0,"category_id":3,"category_name":"","city_id":[500100],"create_time":{"date":20,"day":4,"hours":11,"minutes":20,"month":10,"seconds":1,"time":1416453601000,"timezoneOffset":-480,"year":114},"create_time_server":null,"create_type":0,"deleted":-1,"deliver_type":-1,"description":"重庆万达电影院（万州店）1号双机3D厅，双机3D放映画面更加平滑流畅，全无高频闪烁和画面模糊现象，避免了屏幕亮点或光反射不均匀，消除了单机3D系统放映的长时间观看带来的视觉疲劳和眩晕感；重庆万达电影院（万州店）2号、3号影厅安装了RealD3D放映设备，并配设专用高增益幕金属幕布，使3D影片色彩更绚烂更亮丽，观众不仅不会头晕，更能够体会到最具冲击力的3D立体特效。","description_original":"","end_time":{"date":20,"day":4,"hours":9,"minutes":10,"month":10,"seconds":54,"time":1416445854000,"timezoneOffset":-480,"year":114},"icon":"h00363000b08818684d9d071d2a0a705bc2","id":"1#2064831","is_activity":0,"is_coup":0,"is_entity":1,"is_order":0,"is_takeout":0,"is_wd":1,"is_wisdom":0,"like_num":-1,"name":"","name_original":"","ori_price":0,"pay_type":0,"plaza_id":[1000563],"plaza_latitude":30.8117,"plaza_longitude":108.384,"product_id":"2064831","product_type":0,"pub_time":{"date":13,"day":4,"hours":2,"minutes":13,"month":10,"seconds":7,"time":1415815987000,"timezoneOffset":-480,"year":114},"resource_id":1,"return_policy":-1,"sale_num":-1,"sale_point":-1,"sale_price":-1,"sale_time_end":{"date":20,"day":4,"hours":9,"minutes":10,"month":10,"seconds":54,"time":1416445854000,"timezoneOffset":-480,"year":114},"sale_time_start":{"date":13,"day":4,"hours":2,"minutes":13,"month":10,"seconds":7,"time":1415815987000,"timezoneOffset":-480,"year":114},"score":4.885228,"show_type":"","status":1,"stock":-1,"store_id":[2064831],"store_type_name":"文华","store_x":0,"store_y":0,"store_z":0,"subtitle":"万达影城","time_length":0,"title":"万达影城","title_original":"","update_time":{"date":13,"day":4,"hours":2,"minutes":13,"month":10,"seconds":7,"time":1415815987000,"timezoneOffset":-480,"year":114},"update_time_server":null,"voted_num":-1},{"attention_num":-1,"average_price":-1,"begin_time":{"date":20,"day":4,"hours":9,"minutes":12,"month":10,"seconds":11,"time":1416445931000,"timezoneOffset":-480,"year":114},"brand_id":0,"category_id":3,"category_name":"","city_id":[330300],"create_time":{"date":20,"day":4,"hours":12,"minutes":20,"month":10,"seconds":18,"time":1416457218000,"timezoneOffset":-480,"year":114},"create_time_server":null,"create_type":0,"deleted":-1,"deliver_type":-1,"description":"成立于2005年，隶属于万达集团，是亚洲银幕数排名第一的电影院线，开业五星级影城86家，730块银幕，其中IMAX银幕47块，占有全国15%的票房份额，成为排名全球前列的电影院线。2011年票房收入超过178亿元，稳居中国第一的市场份额。2010年12月，万达院线荣获第18届亚太电影博览会(CineAsia)“年度放映商”大奖，这是中国内地电影放映商第一次获得这一备受推崇的国际大奖。","description_original":"","end_time":{"date":20,"day":4,"hours":9,"minutes":12,"month":10,"seconds":11,"time":1416445931000,"timezoneOffset":-480,"year":114},"icon":"h00f87c949421471af2d96cd06a4b13da4f","id":"1#2063786","is_activity":0,"is_coup":0,"is_entity":1,"is_order":0,"is_takeout":0,"is_wd":1,"is_wisdom":0,"like_num":-1,"name":"","name_original":"","ori_price":0,"pay_type":0,"plaza_id":[1000385],"plaza_latitude":27.9204,"plaza_longitude":120.812,"product_id":"2063786","product_type":0,"pub_time":{"date":13,"day":4,"hours":1,"minutes":13,"month":10,"seconds":58,"time":1415812438000,"timezoneOffset":-480,"year":114},"resource_id":1,"return_policy":-1,"sale_num":-1,"sale_point":-1,"sale_price":-1,"sale_time_end":{"date":20,"day":4,"hours":9,"minutes":12,"month":10,"seconds":11,"time":1416445931000,"timezoneOffset":-480,"year":114},"sale_time_start":{"date":13,"day":4,"hours":1,"minutes":13,"month":10,"seconds":58,"time":1415812438000,"timezoneOffset":-480,"year":114},"score":4.885228,"show_type":"","status":1,"stock":-1,"store_id":[2063786],"store_type_name":"度假","store_x":0,"store_y":0,"store_z":0,"subtitle":"万达影城","time_length":0,"title":"万达影城","title_original":"","update_time":{"date":13,"day":4,"hours":1,"minutes":13,"month":10,"seconds":58,"time":1415812438000,"timezoneOffset":-480,"year":114},"update_time_server":null,"voted_num":-1}],"message":"success","sale_cat":[],"status":0,"tcost":12,"total":522}';
            var_dump(json_decode($info,true));
        } 

        public function pageinfo(){
		//"pageinfo":{"4":3,"3":3,"5":2,"0":1,"7":2,"1":2,"6":3}
		$http_params['params']['params']['query']='���';
		$http_params['params']['params']['offset']=0;
		$http_params['params']['params']['limit']='1';

		//echo http_build_query($http_params['params']);
		$this->log_rec(http_build_query($http_params['params']));

		$arr['query']='���';
		$arr['offset']=0;
		$arr['limit']='1';
		$arr['filter']['id']='1';

		$this->log_rec(http_build_query($arr));
	}
	/*
		http://dev.wanhui.cn/#/api_version_detail/218
		https://sandbox.api.wanhui.cn/v1/search

		{"data":[],"message":"errornet.sf.json.JSONException: JSONObject[\"limit\"] is not a number.","sale_cat":[],"status":500,"tcost":0,"total":0}

		string(75) "https://sandbox.api.wanhui.cn/v1/search?params={"query":"���","limit":"1"}" 
		resource(34) of type (curl) 
		string(21) "internal server error" internal server error

	*/
	public function service1201(){

		$http_params['url']='https://sandbox.api.wanhui.cn/v1/search?params=';
		  $http_params['method']='GET';
		  $http_params['multi']=true;
		  $http_params['extheaders']=array();
		  $http_params['params']['query']='万达';
		  $http_params['params']['limit']=1;
		  $http_params['params']['offset']=0;

		  //echo urlencode($http_params['params']['query']);
			echo unicode_encode($http_params['params']['query']);

		 //echo  $this->GetHttpCurlResponse($http_params);
	}
	
	private function GetHttpCurlResponse($http_params){
    $url=$http_params['url'];
    $params=$http_params['params'];
    $method=$http_params['method'];
    $multi=$http_params['multi'];
    $extheaders=$http_params['extheaders'];

    if(!function_exists('curl_init')) return array();
        $method = strtoupper($method);
        $curlInit = curl_init();
        curl_setopt($curlInit, CURLOPT_USERAGENT, 'PHP-SDK OAuth2.0');
        curl_setopt($curlInit, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curlInit, CURLOPT_TIMEOUT, 3);
        curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlInit, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlInit, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curlInit, CURLOPT_HEADER, false);
        $headers = (array)$extheaders;
        switch ($method)
        {
            case 'POST':
                curl_setopt($curlInit, CURLOPT_POST, TRUE);
                if (!empty($params))
                {
                    if($multi)
                    {
                        foreach($multi as $key => $file)
                        {
                            $params[$key] = '@' . $file;
                        }
                        curl_setopt($curlInit, CURLOPT_POSTFIELDS, $params);
                        $headers[] = 'Expect: ';
                    }
                    else
                    {
                        curl_setopt($curlInit, CURLOPT_POSTFIELDS, http_build_query($params));
                    }
                }
                break;
            case 'DELETE':
              $method == 'DELETE' && curl_setopt($curlInit, CURLOPT_CUSTOMREQUEST, 'DELETE');
            case 'GET':
                if(!empty($params))
                {
                    //$url = $url.(strpos($url, '?')?'&' : '?').(is_array($params)?http_build_query($params):$params);
					$url.=ch_json_encode($params);
                 }
                break;
        }
        curl_setopt($curlInit, CURLINFO_HEADER_OUT, TRUE );
        curl_setopt($curlInit, CURLOPT_URL, $url);
        if($headers)
        {
            curl_setopt($curlInit, CURLOPT_HTTPHEADER, $headers );
        }
		var_dump($url);
		var_dump($curlInit);

        $response = curl_exec($curlInit);
		var_dump($response);
        curl_close ($curlInit);
        return $response;
  }

  public function log_rec($content){
	  date_default_timezone_set('PRC') ;
		$content=date('Y-m-d H:i:s').$content;
		$file='./log/'.'ffan.'.date('YmdH').'.txt';
		$fp=fopen($file,'a+');
		fwrite($fp,$content."\r\n");
		fclose($fp);
		echo $content;
	}

}



