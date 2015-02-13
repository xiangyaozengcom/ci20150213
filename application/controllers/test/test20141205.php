<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//设定输出编码为utf-8
header("content-type:text/html;charset=utf8");

class test20141205 extends CI_Controller {
    public function PeakHour(){
        $http_params['url']='https://sandbox.api.wanhui.cn/PeakPeriod-1/v1/peakPeriod?plazaId=1000265';
        $http_params['method']='GET';
        $http_params['multi']=true;
        $http_params['extheaders']=array();
        $http_params['params']=1000265;
        
       $info=$this->GetHttpCurlResponse($http_params);
       $info_arr=  json_decode($info,true);
       echo $info_arr['data']['hourStr'];
    }
    
    public function resourceinfo(){
        //$http_params['url']='https://sandbox.api.wanhui.cn/advertise/v1/materials/?cityId=110100&resourceId=26&plazaId=1000265';
        $http_params['url']='https://sandbox.api.wanhui.cn/advertise/v1/materials/?cityId=110100&resourceId=26&plazaId=1000276';
        $http_params['method']='GET';
        $http_params['multi']=true;
        $http_params['extheaders']=array();
        $http_params['params']='';
        
       $info=$this->GetHttpCurlResponse($http_params);
       echo $info;
       $info_arr=  json_decode($info,true);
       $return=array();
       if (is_array($info_arr) && isset($info_arr['status']) && $info_arr['status']==200 && isset($info_arr['data']['plans']) && !empty($info_arr['data']['plans']) && is_array($info_arr['data']['plans'])) {
            foreach ($info_arr['data']['plans'] as $key => $value) {

                $return[$key]["picid"]= $value ["image"];
                $return[$key]["link"]= $value["urlContent"];
                $return[$key]["urlSort"]= $value["urlSort"];
            }
        }
        var_dump($return);
        return $return;
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

