<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//设定输出编码为utf-8
header("content-type:text/html;charset=utf8");

class test20141215 extends CI_Controller {
    /***
     * zhanglibin 1215：已和韩超确认，直接用 jiathis.com 第三方服务。具体需求与唐铭？对接
     * zhanglibin 1215：已转邮件《飞凡分享文案》
     * 不是很急，不要花太多时间，写一个方案出来，12345
     * 
     * http://www.jiathis.com/
     * JiaThis - 中国最大的社会化分享按钮及分享代码提供商！.html
     * 
     * http://www.zuluo.net/2011/2011-08/phpcms-one-key-to-share.html
     * phpcms增加一键分享功能   zuluo博客.html
     * 
     */
    public function jiathis() {
        $this->load->view('test/jia_this_20141215.html');
    }
    
    public function jiathisbottom() {
        $this->load->view('test/jia_this_20141215_bottom.html');
    }
    
    public function memcachetest(){
        $this->load->driver('cache');
        $key = 'testmckey';
        $data = time();
        if($this->cache->memcached->is_supported()){
            echo "supported memcached";
        }else{
            echo "not supported memcached";
        }
        echo "<br><br>";
        
        $is_success = $this->cache->memcached->save($key, $data, 60);
        if($is_success){
        echo "save success";
        }else{
        echo "save false";
        }
        echo "<br>===========<br>";
        
        $str = $this->cache->memcached->get($key);
        print_r("testMc str=".$str);
        print_r($str);
    }
    
    /***
     * memcache的批处理
     * is_supported，使用extension_loaded，是否支持该服务
     * key的模板
     * 对从方法中获取的结果进行判断，如果为空，或出错，则不存储到memcache中
     * 
     * http://www.9enjoy.com/memcached-getMulti/
     * $arrs = $mem->getMulti($arr_id, $cas, Memcached::GET_PRESERVE_ORDER);
     * 这个方法有效吗？需要测试
     *  Class 'Memcached' not found in
     */
    public function membatch(){
        $this->load->driver('cache');
        if($this->cache->memcached->is_supported()){
            $arr_key=array(20141217-1,20141217-2,20141217-3,20141217-4);
            foreach ($arr_key as $key =>$value){
                $data=$value.'---'.$value;
                $this->cache->memcached->save($key, $data, 60);
            }
            $arrs = $this->cache->memcached->getMulti($arr_key, $cas, Memcached::GET_PRESERVE_ORDER);
            var_dump($arrs );
            var_dump($cas);
            
        }else{
            echo '无memcache或memcached';
        }
    }
    /***
     * 110100，1000265=> "北京石景山万达广场",1000772=> "北京通州万达广场"
     * 150200， 1000302=> "包头万达广场"
     * 340300，1000623=>"蚌埠万达广场"
     * 
     * 包头万达广场时的返回
     * $resourceId=26;$cityId=150200;$plazaId=1000302;
     * {"status":200,"msg":"\u6210\u529f","data":{"cityId":150200,"plazaId":1000302,"resourceId":26,"number":5,"plans":[{"position":1},{"position":2},{"position":3},{"position":4},{"position":5}]}}
     * 
     * 城市广场id，不匹配时，
     * $resourceId=26;$cityId=110100;$plazaId=1000302;
     * {"status":102,"msg":"\u83b7\u53d6\u5e7f\u573a\u4fe1\u606f\u5931\u8d25"}
     * 
     * 只有广场id，没有城市id时，
     * $resourceId=26;$cityId='';$plazaId=1000302;
     * {"status":101,"msg":"\u83b7\u53d6\u57ce\u5e02\u4fe1\u606f\u5931\u8d25"}
     * 
     * 只有城市id，没有广场id时，
     * $resourceId=26;$cityId=150200;$plazaId='';
     * {"status":200,"msg":"\u6210\u529f","data":{"cityId":150200,"plazaId":1000302,"resourceId":26,"number":5,"plans":[{"position":1},{"position":2},{"position":3},{"position":4},{"position":5}]}}
     * 
     * 没有城市id，广场id时，
     * $resourceId=26;$cityId='';$plazaId='';
     * {"status":101,"msg":"\u83b7\u53d6\u57ce\u5e02\u4fe1\u606f\u5931\u8d25"}
     * 
     * 重点需要测的是，匹配的城市广场id时的返回，status为200
     * 
     * 1217-916，初步确认，
     * $info_arr['data']['plans'][0]['serialName']
     * is_array($value) && isset($value ["image"]) && $value ["image"]
     * 基本可能判断出是否返回了真实有效数据
     * 
     * 
     */
    public function getbannerinfo(){
        $resourceId=26;
        $cityId=110100;
        $plazaId=1000265;
        
//        $resourceId=26;$cityId=150200;$plazaId=1000302;
        
        var_dump($this->GetResourceInfo($resourceId, $cityId, $plazaId)) ;
    }
    
    
    
    private function GetResourceInfo($resourceId,$cityId,$plazaId){
    $return=array();
    $url='https://sandbox.api.wanhui.cn/advertise/v1/materials?resourceId='.$resourceId.'&cityId='.$cityId.'&plazaId='.$plazaId;
    $return=array();
    
    $info=$this->GetHttpCurlResponse($url);
    //echo $info_arr;
    $info_arr=  json_decode($info, TRUE);
    
    if (is_array($info_arr) && isset($info_arr['status']) && $info_arr['status']==200 && isset($info_arr['data']['plans'][0]['serialName']) && $info_arr['data']['plans'][0]['serialName']) {
      foreach ($info_arr['data']['plans'] as $key => $value) {
          if(is_array($value) && isset($value ["image"]) && $value ["image"]){
              if ($resourceId==26) {
                $return[$key]["picid"]= $value ["image"];
                $return[$key]["link"]= $value["urlContent"];
                $return[$key]["urlSort"]= $value["urlSort"];
              } else {
                $return["picid"]= $value ["image"];
                $return["link"]= $value["urlContent"];
                $return["urlSort"]= $value["urlSort"];
              }
          }
      }
    }
    return $return;
}
    /***
     * 1000298，宜昌万达广场
     * 1000265=> "北京石景山万达广场",1000772=> "北京通州万达广场"
     * 测试的，1000876
     * "plazaId":1000276,"plazaName":"长春红旗街万达广场"	
     * type，正在进行1，即将开始2
     * 
     * 1000876，测试的，不存在
     * {"status":0,"msg":"","list":[]}array(3) { ["status"]=> int(0) ["msg"]=> string(0) "" ["list"]=> array(0) { } } 
     */
     /***
      * 使用1000876来测试时，
      * 资源位的全部出错非空，需要修改规则，依赖于广场-城市id
      * 推荐商户，推荐优惠券，优惠列表，依赖于广场-城市id
      * 活动的因为分为now-coming，也出错了，依赖于广场id
      * 电影，依赖于城市id，现写死了
      * 亲子，参数门店可选，不依赖于城市或广场id
      * 积分商城，不依赖于城市或广场id
      * 品牌列表，精选品牌依赖于广场id，其他不依赖于城市或广场id
      * 服务预订的宝贝王，早教-摄影-派对，依赖于广场id
      * 广场实时信息，依赖于广场id
      */
    public function getactivityinfo() {
        
//        $plazaId=1000265;
//        $type=1;
        
        $plazaId=1000876;
        $type=1;
        
        $activitylist_url='https://sandbox.api.wanhui.cn/market/v2/activities?offset=0&pageSize=2&wpid=%s&type=%s';
        $url=  sprintf($activitylist_url,$plazaId,$type);
        
        $info=$this->GetHttpCurlResponse($url);
        echo $info;
        var_dump(json_decode($info, true));
        exit;
        
    $activitylist_url='https://sandbox.api.wanhui.cn/market/v2/activities?offset=0&pageSize=7&wpid='.$this->plazaId.'&type=';
    //$now=$this->ApiGetList($activitylist_url.'1');
    //$coming=$this->ApiGetList($activitylist_url.'2');
    
    $now=$this->ApiGet($activitylist_url.'1');
    $coming=$this->ApiGet($activitylist_url.'2');
    
    $return=array();
    if (is_array($now) && isset($now['status']) && $now['status']==0 && isset($now['list'][0]['id']) && $now['list'][0]['id']){
  
        foreach ($now['list'] as $key => $value) { 
          if ($key < 1) {
              
            $return['now']["left"]["id"]=$value["id"];
            $return['now']["left"]["title"]=$value["title"];
            $return['now']["left"]["img"]=  isset($value["image_path"][0]["img"])?$value["image_path"][0]["img"]:'';
            if (empty($value["start_date"]) || empty($value["end_date"])) {
              $return['now']["left"]["duration"]='';
            } else {
              $return['now']["left"]["duration"]=$this->GetActivityDateString($value["start_date"]).' - '.$this->GetActivityDateString($value["end_date"]);
            }
          } 
          if( $key > 0 && $key <7)
          {
            $return['now']["right"][$key]["id"]=$value["id"];
            $return['now']["right"][$key]["title"]=$value["title"];
            $return['now']["right"][$key]["img"]=isset($value["image_path"][0]["img"])?$value["image_path"][0]["img"]:'';
            if (empty($value["start_date"]) || empty($value["end_date"])) {
              $return['now']["right"][$key]["duration"]='';
            } else {
              $return['now']["right"][$key]["duration"]=$this->GetActivityDateString($value["start_date"]).' - '.$this->GetActivityDateString($value["end_date"]);
            }
          }
        }
    }else{
      $return['now']=array();
    }

    if (is_array($coming) && isset($coming['status']) && $coming['status']==0 && isset($coming['list'][0]['id']) && $coming['list'][0]['id']){
        foreach ($coming['list'] as $key => $value) {
          if ($key < 1) {
            $return['coming']["left"]["id"]=$value["id"];
            $return['coming']["left"]["title"]=$value["title"];
            $return['coming']["left"] ["img"]=isset($value["image_path"][0]["img"])?$value["image_path"][0]["img"]:'';
            if (empty($value["start_date"]) || empty($value["end_date"])) {
              $return['coming']["left"]["duration"]='';
            } else {
              $return['coming']["left"]["duration"]=$this->GetActivityDateString($value["start_date"]).' - '.$this->GetActivityDateString($value["end_date"]);
            }
          } 
          else if( $key >0 && $key < 7){
            $return['coming']["right"][$key]["id"]=$value["id"];
            $return['coming']["right"][$key]["title"]=$value["title"];
            $return['coming']["right"][$key]["img"]=isset($value["image_path"][0]["img"])?$value["image_path"][0]["img"]:'';
            if (empty($value["start_date"]) || empty($value["end_date"])) {
              $return['coming']["right"][$key]["duration"]='';
            } else {
              $return['coming']["right"][$key]["duration"]=$this->GetActivityDateString($value["start_date"]).' - '.$this->GetActivityDateString($value["end_date"]);
            }
          }
        }
    }else{
      $return['coming']=array();
    }
    return $return;
  }

  /***
   * 活动日期字符串的处理，
   * 现在活动接口获取到的为，["start_date"]=>string(10) "2014-11-10"  ["end_date"]=>string(10) "2014-11-26"
   * 处理为月.日的形式
   */
  private function GetActivityDateString($date){
    if (empty($date)) {
      return '';
    }else{
      return str_replace('-','.',substr($date,strpos($date,'-')+1));
    }  
  }
    
    private function GetHttpCurlResponse($arr){
        $url=$arr['url'];
        $params=  isset($arr['params'])?$arr['params']:'';
        $method=  isset($arr['method'])?$arr['method']:'GET';
        $multi=FALSE;
        $extheaders=array();
        

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
      
      public function getstrpos(){
          $pre='ffan-web-index-';
          $key=$pre.'15666';
//          $start=strrchr($key, '-');
//          echo $start;
//          echo '<hr/>';
//          echo substr($key, $start);
          $arr=  explode('-', $key);
          echo $arr[count($arr)-1];
      }
      
      /***
       * http://dev.wanhui.cn/#/api_version_detail/27
       * https://sandbox.api.wanhui.cn/kids/bespeaksubmit
       * 
       * 
       */
      public function bespeaksubmit(){
          $url='https://sandbox.api.wanhui.cn/kids/bespeaksubmit';
          $params['type']=102;
          $params['wpid']=1000664;
          $params['birthday']='2013-12-11';
          $params['mobile']='13520641864';
          $params['bespeakDate']='2014-12-24';
          $params['courseId']=29;
          $params['uid']='14090916202701501';
          $params['name']='宝贝王';
          
          $params['seriesId']='';
          $params['num']='';
          $params['lensmanId']='';
          $params['seriesId']='';
          $params['themeId']='';
          
          $post['url']=$url;
          $post['params']=$params;
          $post['method']='POST';
          
          $info=$this->GetHttpCurlResponse($post);
      
          var_dump(json_decode($info,true));        
      }
    
    
}



