<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//设定输出编码为utf-8
header("content-type:text/html;charset=utf8");

class test20141223 extends CI_Controller {
    /***
     * http://dev.wanhui.cn/#/api_version_detail/98
     * https://sandbox.api.wanhui.cn/ffan/v1/uploadpicture
     */
    public function uploadpicture(){
        $url='https://sandbox.api.wanhui.cn/ffan/v1/uploadpicture';
        $http_params['url']=$url;
        
        $info=  $this->GetHttpCurlResponse($http_params);
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
                        $url = $url.(strpos($url, '?')?'&' : '?').(is_array($params)?http_build_query($params):$params);
                                            
                     }
                    break;
            }
            curl_setopt($curlInit, CURLINFO_HEADER_OUT, TRUE );
            curl_setopt($curlInit, CURLOPT_URL, $url);
            if($headers)
            {
                curl_setopt($curlInit, CURLOPT_HTTPHEADER, $headers );
            }
                    //var_dump($url);
                    //var_dump($curlInit);

            $response = curl_exec($curlInit);
                   // var_dump($response);
            curl_close ($curlInit);
            return $response;
      }
    
    
}

