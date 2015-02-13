<?php
/*
http://blog.163.com/weibin_li/blog/static/190146417201261010584482/
Curl HTTP 封装好的类 - 小彬子的日志 - 网易博客.html

*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * HTTP请求类
 * @author 
 * @version 2.0 2012-04-20
 */
class Http_curl
{
	protected $url;
	protected $params = array();
	protected $method = 'GET';
	protected $multi = false;
	protected $extheaders = array();


	//构造函数，按照CI的要求，初始化相关的参数
	 public function __construct($http_params)
    {
        // Do something with $params
		$this->url=$http_params['url'];
		$this->params=$http_params['params'];
		$this->method=$http_params['method'];
		$this->multi=$http_params['multi'];
		$this->extheaders=$http_params['extheaders'];
    }


    /**
     * 发起一个HTTP/HTTPS的请求
     * @param $url 接口的URL 
     * @param $params 接口参数   array('content'=>'test', 'format'=>'json');
     * @param $method 请求类型    GET|POST
     * @param $multi 图片信息
     * @param $extheaders 扩展的包头信息
     * @return string
	 * public static function request( $url , $params = array(), $method = 'GET' , $multi = false, $extheaders = array())
     */
    public function request()
    {
		$url=$this->url;
		$params=$this->params;
		$method=$this->method;
		$multi=$this->multi;
		$extheaders=$this->extheaders;

		var_dump($url,$params,$method,$multi,$extheaders);
		//exit;


        if(!function_exists('curl_init')) exit('Need to open the curl extension');
        $method = strtoupper($method);
        $ci = curl_init();
        curl_setopt($ci, CURLOPT_USERAGENT, 'PHP-SDK OAuth2.0');
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ci, CURLOPT_TIMEOUT, 3);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ci, CURLOPT_HEADER, false);
        $headers = (array)$extheaders;
        switch ($method)
        {
            case 'POST':
                curl_setopt($ci, CURLOPT_POST, TRUE);
                if (!empty($params))
                {
                    if($multi)
                    {
                        foreach($multi as $key => $file)
                        {
                            $params[$key] = '@' . $file;
                        }
                        curl_setopt($ci, CURLOPT_POSTFIELDS, $params);
                        $headers[] = 'Expect: ';
                    }
                    else
                    {
                        curl_setopt($ci, CURLOPT_POSTFIELDS, http_build_query($params));
                    }
                }
                break;
            case 'DELETE':
				$method == 'DELETE' && curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
            case 'GET':
                if(!empty($params))
				{
                    $url = $url.(strpos($url, '?')?'&' : '?').(is_array($params)?http_build_query($params):$params);
				}
                break;
        }
        curl_setopt($ci, CURLINFO_HEADER_OUT, TRUE );
        curl_setopt($ci, CURLOPT_URL, $url);
        if($headers)
        {
            curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
        }

        $response = curl_exec($ci);
        curl_close ($ci);
		var_dump($response);
        return $response;
    }
}











