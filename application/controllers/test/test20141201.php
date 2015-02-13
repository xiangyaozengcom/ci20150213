<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//设定输出编码为utf-8
header("content-type:text/html;charset=utf8");

class test20141201 extends CI_Controller {
	#
	public function __construct(){
		parent::__construct();
		$this->load->helper('MY_chjsonencode');
	}

	public function pageinfo(){
//		//"pageinfo":{"4":3,"3":3,"5":2,"0":1,"7":2,"1":2,"6":3}
//		$http_params['params']['params']['query']='���';
//		$http_params['params']['params']['offset']=0;
//		$http_params['params']['params']['limit']='1';
//
//		//echo http_build_query($http_params['params']);
//		$this->log_rec(http_build_query($http_params['params']));
//
//		$arr['query']='���';
//		$arr['offset']=0;
//		$arr['limit']='1';
//		$arr['filter']['id']='1';
//
//		$this->log_rec(http_build_query($arr));
            $json='{6:1}';
           // var_dump(json_decode($json),true);
            $arr=array(6=>1);
            echo json_encode($arr);
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
		//var_dump($response);
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



