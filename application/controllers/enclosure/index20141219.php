<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//设定输出编码为utf-8
header("content-type:text/html;charset=utf8");



class index20141219 extends CI_Controller {
    //Asynchronous and synchronous,异步与同步
    private static $Expire=array(
        'resource'=>60,
        'rec'=>60,
        'list'=>60,
    );
    
    protected  $expire_resource=60;
    /***
     * 1222，预约数据部分，交给了chenlinfei去做，注释掉
     */
    protected static $Name_Method_Arr=array(
            //首页顶部轮播图资源位-1
            1=>array('name'=>'banner_info','method'=>'ResourceInfo','expire'=>60,'front'=>'','back'=>array('resourceId'=>26)),
            //首页电影资源位-2
            2=>array('name'=>'resource_film','method'=>'ResourceInfo','expire'=>60,'front'=>'','back'=>array('resourceId'=>38)),
            //首页亲子资源位-3
            3=>array('name'=>'resource_kid','method'=>'ResourceInfo','expire'=>60,'front'=>'','back'=>array('resourceId'=>39)),
            //首页休闲娱乐资源位-4
            4=>array('name'=>'resource_enjoy','method'=>'ResourceInfo','expire'=>60,'front'=>'','back'=>array('resourceId'=>40)),

            //首页推荐优惠券数据-5
            5=>array('name'=>'rec_coupon','method'=>'RecommenderInfo','expire'=>60,'front'=>'','back'=>array('location'=>'coupon','catg'=>0)),
            //首页推荐商户数据-6
            6=>array('name'=>'rec_merchant','method'=>'GetRecommenderInfo','expire'=>60,'front'=>'','back'=>array('location'=>'merchant','catg'=>0)),
            //首页优惠数据-全部-7，接口文档中，2.4 类目偏好一级分类(catg) 1 美食   2 电影  3 亲子   4 娱乐  5 购物  6 活动，@TODO这里是否使用常量？
            7=>array('name'=>'coupon_info','method'=>'RecommenderInfo','expire'=>60,'front'=>0,'back'=>array('location'=>'couponlist','catg'=>0)),
            //首页优惠数据-美食-8
            8=>array('name'=>'coupon_info','method'=>'RecommenderInfo','expire'=>60,'front'=>1,'back'=>array('location'=>'couponlist','catg'=>1)),
            //首页优惠数据-电影-9
            9=>array('name'=>'coupon_info','method'=>'RecommenderInfo','expire'=>60,'front'=>2,'back'=>array('location'=>'couponlist','catg'=>2)),
            //首页优惠数据-亲子-10
            10=>array('name'=>'coupon_info','method'=>'RecommenderInfo','expire'=>60,'front'=>3,'back'=>array('location'=>'couponlist','catg'=>3)),
            //首页优惠数据-娱乐-11
            11=>array('name'=>'coupon_info','method'=>'RecommenderInfo','expire'=>60,'front'=>4,'back'=>array('location'=>'couponlist','catg'=>4)),
            //首页优惠数据-购物-12
            12=>array('name'=>'coupon_info','method'=>'RecommenderInfo','expire'=>60,'front'=>5,'back'=>array('location'=>'couponlist','catg'=>5)),
            
            //首页娱乐数据-13，有则显示，无则不显示
            13=>array('name'=>'enjoy_info','method'=>'RecommenderInfo','expire'=>60,'front'=>'','back'=>array('location'=>'enjoylist','catg'=>0)),

            //首页预约数据-早教-14，预约类型。102=>早教，103=》摄影，106=》派对
            //14=>array('name'=>'bespeak_info','method'=>'BespeakInfo','expire'=>60,'front'=>102,'back'=>array('type'=>102)),
            //首页预约数据-摄影-15
            //15=>array('name'=>'bespeak_info','method'=>'BespeakInfo','expire'=>60,'front'=>103,'back'=>array('type'=>103)),
            //首页预约数据-派对-16
            //16=>array('name'=>'bespeak_info','method'=>'BespeakInfo','expire'=>60,'front'=>106,'back'=>array('type'=>106)),

            //首页活动数据-正在进行-17
            17=>array('name'=>'activity_info','method'=>'ActivityInfo','expire'=>60,'front'=>'now','back'=>array('status'=>1)),
            //首页活动数据-即将开始-18
            18=>array('name'=>'activity_info','method'=>'ActivityInfo','expire'=>60,'front'=>'coming','back'=>array('status'=>2)),

            //首页电影数据-正在热映-19，正在热映-1，即将上映-2
            19=>array('name'=>'film_info','method'=>'FilmInfo','expire'=>60,'front'=>1,'back'=>array('status'=>1)),
            //首页电影数据-即将上映-20
            20=>array('name'=>'film_info','method'=>'FilmInfo','expire'=>60,'front'=>2,'back'=>array('status'=>2)),

            //首页亲子数据-21，有则显示，无则不显示
            21=>array('name'=>'kids_info','method'=>'KidsInfo','expire'=>60,'front'=>'','back'=>array()),
            //首页积分数据-22
            22=>array('name'=>'integral_info','method'=>'IntegralInfo','expire'=>60,'front'=>'','back'=>array()),

            //首页品牌数据-精选品牌-23，按照产品的设计，默认为精选品牌-0，其他为美食-3，电影-1，亲子-2，购物-8，@TODO 娱乐-??
            23=>array('name'=>'brand_info','method'=>'BrandInfo','expire'=>60,'front'=>0,'back'=>array('type'=>0)),
            //首页品牌数据-电影-24
            24=>array('name'=>'brand_info','method'=>'BrandInfo','expire'=>60,'front'=>1,'back'=>array('type'=>1)),
            //首页品牌数据-亲子-25
            25=>array('name'=>'brand_info','method'=>'BrandInfo','expire'=>60,'front'=>2,'back'=>array('type'=>2)),
            //首页品牌数据-美食-26
            26=>array('name'=>'brand_info','method'=>'BrandInfo','expire'=>60,'front'=>3,'back'=>array('type'=>3)),
            //首页品牌数据-购物-27
            27=>array('name'=>'brand_info','method'=>'BrandInfo','expire'=>60,'front'=>8,'back'=>array('type'=>8)),
            //首页品牌数据- 娱乐-28
        );
    
        protected static $Ajax_Default_Arr=array(
            //首页优惠数据-全部-7，接口文档中，2.4 类目偏好一级分类(catg) 1 美食   2 电影  3 亲子   4 娱乐  5 购物  6 活动，@TODO这里是否使用常量？
            7=>array('name'=>'coupon_info','method'=>'GetAjaxCoupon','expire'=>60,'front'=>0,'back'=>array('location'=>'couponlist','catg'=>0)),
            //首页预约数据-早教-14，预约类型。102=>早教，103=》摄影，106=》派对
            //14=>array('name'=>'bespeak_info','method'=>'GetAjaxBespeak','expire'=>60,'front'=>102,'back'=>array('type'=>102)),
            //首页活动数据-正在进行-17
            17=>array('name'=>'activity_info','method'=>'GetAjaxActivity','expire'=>60,'front'=>'now','back'=>array('status'=>1)),
            //首页电影数据-正在热映-19，正在热映-1，即将上映-2
            19=>array('name'=>'film_info','method'=>'GetAjaxFilm','expire'=>60,'front'=>1,'back'=>array('status'=>1)),
            //首页品牌数据-精选品牌-23，按照产品的设计，默认为精选品牌-0，其他为美食-3，电影-1，亲子-2，购物-8，@TODO 娱乐-??
            23=>array('name'=>'brand_info','method'=>'GetAjaxBrand','expire'=>60,'front'=>0,'back'=>array('type'=>0)),
        );

        //首页同步数据
        protected static $Syn_Arr=array(1,2,3,4,5,6,13,21,22);

    protected  $plazaId=1000265;//默认广场id，北京市石景山万达广场
    protected  $cityId=110100;//默认城市id，北京市
    
    protected $ajax=0;//先默认为0，不使用ajax默认，待杨强联调完成，再修改为默认1，get方式修改
    protected $memtime=30;//默认为30,get方式修改
    
    protected $env='default';
    protected static $Env_Arr=array('default','batch','ajaxmemapi');


    public function GetResponse_() {
    $response = new Response();
//    var_dump($this->GetEnjoyInfo());
//    exit;
    $this->env=  (isset($_GET['env']) && $_GET['env'] && in_array($_GET['env'], self::$Env_Arr))?$_GET['env']:$this->env;
    if('default'==$this->env){
        $response->data=$this->GetIndexMemData();
    }  
    elseif ('batch'==$this->env) {
        $response->data=$this->GetBatchMemData();
    }
    elseif ('ajaxmemapi'==$this->env) {
        $response->data=$this->GetBatchMemData();
    }

    //从mem中获取数据的测试
    $response->data=$this->GetAjaxMemApiData();
    
    //$response->data=$this->GetBatchMemData();
    
    //假数据
    //$response->data = $this->GetFakeData();
    
    return $response;
  }
  
  public function GetBatchMemApiData(){
      return $this->GetMemApiData(self::$Name_Method_Arr);
  }
   /***
    * 初始化，获取广场实时信息，更新cityId，plazaId
    */
   private function _init(){
      $plaza=new PlazaRtInfoModel();//先获取广场实时信息，拿到广场id，城市id
      $return['plazaRt_Info']=$plaza->GetData();//首页广场实时信息，右侧浮层
      $this->plazaId=$return['plazaRt_Info']['plazaId'];
      $this->cityId=$return['plazaRt_Info']['cityId'];
   }
    
    /***
     * 把ajax部分的数据单独拿出来，做另一个mem批处理
     * 
     */
    public function GetAjaxMemApiData(){
        $return1=  $this->GetSynData();
        $return2=$this->GetAsynData();
        return array_merge($return1, $return2);
    }
    
    /***
     * 首页中同步数据，不使用ajax部分的数据整理
     * 
     */
    public function GetSynData(){
        $mem_arr=array();
        foreach(self::$Syn_Arr as $index){
            $mem_arr[$index]=  (isset(self::$Name_Method_Arr[$index]) && self::$Name_Method_Arr[$index])?self::$Name_Method_Arr[$index]:'';
        }
        return $this->GetMemApiData($mem_arr);
    }
    /***
     * 获取异步数据
     * 把异步获取的数据拿出来，分作ajax与非ajax处理
     * ajax时，第一次获取，只取默认项的数据
     * 非ajax时
     * 做一个总的配置项，直接从其中取一部分即可
     * 
     * ajax返回数据的格式，需要保持统一，与其他的数据分开
     * 一种是返回curtab的值，一种是数组中套一层为分类的名称或值，这样与之前的保持一致了
     */
    public function GetAsynData(){
        if((isset($_GET['ajax']) && $_GET['ajax']) || 1==$this->ajax){
             return $this->GetMemApiData(self::$Ajax_Default_Arr);
        }else{
            $asyn_noajax_arr= array_diff_key(self::$Name_Method_Arr, self::$Syn_Arr);
            $mem_arr=array();
            foreach($asyn_noajax_arr as $index){
                $mem_arr[$index]=  (isset(self::$Name_Method_Arr[$index]) && self::$Name_Method_Arr[$index])?self::$Name_Method_Arr[$index]:'';
            }
            return $this->GetMemApiData($mem_arr);
        }
    }
    
    /***
     * 依次从mem，api中获取数据
     */
    public function GetMemApiData($mem_arr){
        
        $key_pre='ffan-web-index-'.$this->plazaId.'-';
        $key1_arr=array();
        foreach($mem_arr as $key1 => $value1){
            $key1_arr[$key1]=$key_pre.$key1;
        }
        //如果传递了memtime，则重新从api接口获取，并存储到memcache中，过期时间为memtime，限制为0-86400
        if(isset($_GET['memtime']) && $_GET['memtime'] && intval($_GET['memtime'])>0 && intval($_GET['memtime']) <86400 && is_array($key1_arr) && $key1_arr){
            return $this->GetMemtimeData($mem_arr,$key1_arr);
        }else{
            return $this->GetMemData($mem_arr,$key1_arr);
        }
    }
    /***
     * url中get得到memtime时
     */
    public function GetMemtimeData($mem_arr,$key1_arr){
        $return=array();
        $memcached_client = MemCachedClient::GetInstance('default');
        if(is_array($key1_arr) && $key1_arr && is_array($mem_arr) && $mem_arr){
             foreach($key1_arr as $key3 => $value3){
                $method=$mem_arr[$key3]['method'];
                $api_result=$this->$method();
                if($api_result){
                    if(isset($mem_arr[$key3]['front']) && strlen($mem_arr[$key3]['front'])>0){
                        $return[$mem_arr[$key3]['name']][$mem_arr[$key3]['front']]=$api_result;
                    }else{
                        $return[$mem_arr[$key3]['name']]=$api_result;
                    }
                  $memcached_client->set($value3,$api_result,intval($_GET['memtime']));
                }else{
                    if(isset($mem_arr[$key3]['front']) && strlen($mem_arr[$key3]['front'])>0){
                        $return[$mem_arr[$key3]['name']][$mem_arr[$key3]['fornt']]=array();
                    }else{
                        $return[$mem_arr[$key3]['name']]=array();
                    }
                }
            }
        }
        return $return;
    }
    
    /***
     * 依次从mem，api中获取数据
     */
    public function GetMemData($mem_arr,$key1_arr){
        $return=array();
        $memcached_client = MemCachedClient::GetInstance('default');
        //从memcache中获取
        if(is_array($key1_arr) && $key1_arr  && is_array($mem_arr) && $mem_arr){
            $cached_result = $memcached_client->getMulti($key1_arr);
          if ($cached_result) {
            foreach ($cached_result as $key2 => $value2) {
              $arr_key2=  explode('-', $key2);
              $num_key2=$arr_key2[count($arr_key2)-1];

              unset($key1_arr[$num_key2]);
              //$return[$mem_arr[$num_key2]['name']] = $value2;
              if(isset($mem_arr[$num_key2]['front']) && strlen($mem_arr[$num_key2]['front'])>0){
                    $return[$mem_arr[$num_key2]['name']][$mem_arr[$num_key2]['front']]=$api_result;
                }else{
                    $return[$mem_arr[$num_key2]['name']]=$api_result;
                }
            }
          }
        }

        //memcache中没有拿到的数据，从api接口获取，并存储到memcache中
        if(is_array($key1_arr) && $key1_arr  && is_array($mem_arr) && $mem_arr){
            foreach($key1_arr as $key3 => $value3){
                $method=$mem_arr[$key3]['method'];
                $api_result=$this->$method();
                if($api_result){
                  //$return[$mem_arr[$key3]['name']]=$api_result;
                    if(isset($mem_arr[$key3]['front']) && strlen($mem_arr[$key3]['front'])>0){
                        $return[$mem_arr[$key3]['name']][$mem_arr[$key3]['front']]=$api_result;
                    }else{
                        $return[$mem_arr[$key3]['name']]=$api_result;
                    }
                  $memcached_client->set($value3,$api_result,$mem_arr[$key3]['expire']);
                }else{
                    $return[$mem_arr[$key3]['name']]=array();
                }
            }
        }
        return $return;
    }
    
    public function GetAjaxActivity(){
      require_once(WEB_ROOT . 'models/ajax/index/ActivityModel.php');
      $model = new ActivityModel();
      $info=get_object_vars($model->GetResponse());
      $return=array();
      if (is_array($info) && isset($info['status']) && $info['status']==0 && isset($info['data']) && $info['data']){
          return $info['data'];
      }
      return $return;
  }
  
  public function GetAjaxCoupon(){
      require_once(WEB_ROOT . 'models/ajax/index/CouponModel.php');
      $model = new CouponModel();
      $info=get_object_vars($model->GetResponse());
      $return=array();
      if (is_array($info) && isset($info['status']) && $info['status']==200 && isset($info['data']) && $info['data']){
          return $info['data'];
      }
      return $return;
  }
  
  public function GetAjaxFilm(){
      require_once(WEB_ROOT . 'models/ajax/index/FilmModel.php');
      $model = new FilmModel();
      $info=get_object_vars($model->GetResponse());
      $return=array();
      if (is_array($info) && isset($info['status']) && $info['status']==200 && isset($info['data']) && $info['data']){
          return $info['data'];
      }
      return $return;
  }
  
  public function GetAjaxBrand(){
      require_once(WEB_ROOT . 'models/ajax/index/BrandModel.php');
      $model = new BrandModel();
      $info=get_object_vars($model->GetResponse());
      $return=array();
      if (is_array($info) && isset($info['status']) && $info['status']==200 && isset($info['data']) && $info['data']){
          return $info['data'];
      }
      return $return;
  }
    
   

    /***
     * 调用一次接口，对应memcache中的唯一key，以处理有时能拿到有时拿不到的情况
     * 从地址栏，get的memtime，用来修改memcache的过期时间
     * 配置数组，memcache中键的模板，序号，返回的字段名称，方法的名称，缓存时间
     * 有交互切换，无交互切换，是否需要重新处理，
     * 方法套方法，再从mem中去获取，相应的组合，统一修改缓存时间，修改各个分类的缓存时间
     * @TODO，getMulti也是遍历获取，有空看一下源码，记录获取到的，未获取到的，静态数组
     * 未获取到的，记录下来，尝试三次，或者递归获取
     * 这里需要抽取一个memcache处理方法，对各个方法做组装，返回字段，方法名，方法参数数组，缓存时间
     * 这样基本不需要修改返回给前端的数据结构
     * 重复获取未拿到的接口数据源的次数，可以设置
     * 
     * name,输出给前端的数组字段的名称
     * method,调用的相关方法
     * expire,memcache过期时间
     * params_front,输出给前端的数组深一层字段的名称
     * params_back,调用数据源接口时需要的参数数组
     * count，当接口没有拿到数据时，尝试的次数
     * 
     * 封装方法，资源，推荐，预订，活动，电影，亲子，娱乐，积分，品牌
     * 
     * 在url地址栏，默认配置项，都可以设置获取数据的方式，过期时间
     * 怎么区分接口依赖，广场id，按照产品逻辑，城市广场商圈切换
     * 把mem_arr写成什么比较准确达意？
     * @TODO全部为0，空判断时怎么处理,使用trim，===，做一下测试
     * 方法修改，分类+info
     * 拆分时，
     * 把mem_arr，写成类的一个属性，常量数组，配置,index_config
     * 把过期时间，配置成一个数组，
     * 增加一个选项，env，debug时，保证数据的完整性，dev时，保证数据的准确性，都是从接口数据源获取的，类的属性参考程峰，杨国强的
     * 
     * 1219，除了调用广场实时信息的，都可以在这里直接调用，影子政府，那就在这里测试好后，再切换过去
     * 
     */
    public function GetBatchMemData(){
        $plaza=new PlazaRtInfoModel();//先获取广场实时信息，拿到广场id，城市id
        $return['plazaRt_Info']=$plaza->GetData();//首页广场实时信息，右侧浮层
        $this->plazaId=$return['plazaRt_Info']['plazaId'];
        $this->cityId=$return['plazaRt_Info']['cityId'];
        //定义几个缓存变量，按照类型区分
        $expire_resource=60;
        $expire_rec=60;
        $expire_list=60;

        $memcached_client = MemCachedClient::GetInstance('default');
        $mem_arr=array(
            //首页顶部轮播图资源位-1
            1=>array('name'=>'banner_info','method'=>'ResourceInfo','expire'=>$expire_resource,'front'=>'','back'=>array('resourceId'=>26)),
            //首页电影资源位-2
            2=>array('name'=>'resource_film','method'=>'ResourceInfo','expire'=>$expire_resource,'front'=>'','back'=>array('resourceId'=>38)),
            //首页亲子资源位-3
            3=>array('name'=>'resource_kid','method'=>'ResourceInfo','expire'=>$expire_resource,'front'=>'','back'=>array('resourceId'=>39)),
            //首页休闲娱乐资源位-4
            4=>array('name'=>'resource_enjoy','method'=>'ResourceInfo','expire'=>$expire_resource,'front'=>'','back'=>array('resourceId'=>40)),

            //首页推荐优惠券数据-5
            5=>array('name'=>'rec_coupon','method'=>'RecommenderInfo','expire'=>$expire_rec,'front'=>'','back'=>array('location'=>'coupon','catg'=>0)),
            //首页推荐商户数据-6
            6=>array('name'=>'rec_merchant','method'=>'GetRecommenderInfo','expire'=>$expire_rec,'front'=>'','back'=>array('location'=>'merchant','catg'=>0)),
            //首页优惠数据-全部-7，接口文档中，2.4 类目偏好一级分类(catg) 1 美食   2 电影  3 亲子   4 娱乐  5 购物  6 活动，@TODO这里是否使用常量？
            7=>array('name'=>'coupon_info','method'=>'RecommenderInfo','expire'=>$expire_rec,'front'=>0,'back'=>array('location'=>'couponlist','catg'=>0)),
            //首页优惠数据-美食-8
            8=>array('name'=>'coupon_info','method'=>'RecommenderInfo','expire'=>$expire_rec,'front'=>1,'back'=>array('location'=>'couponlist','catg'=>1)),
            //首页优惠数据-电影-9
            9=>array('name'=>'coupon_info','method'=>'RecommenderInfo','expire'=>$expire_rec,'front'=>2,'back'=>array('location'=>'couponlist','catg'=>2)),
            //首页优惠数据-亲子-10
            10=>array('name'=>'coupon_info','method'=>'RecommenderInfo','expire'=>$expire_rec,'front'=>3,'back'=>array('location'=>'couponlist','catg'=>3)),
            //首页优惠数据-娱乐-11
            11=>array('name'=>'coupon_info','method'=>'RecommenderInfo','expire'=>$expire_rec,'front'=>4,'back'=>array('location'=>'couponlist','catg'=>4)),
            //首页优惠数据-购物-12
            12=>array('name'=>'coupon_info','method'=>'RecommenderInfo','expire'=>$expire_rec,'front'=>5,'back'=>array('location'=>'couponlist','catg'=>5)),
            //首页娱乐数据-13，有则显示，无则不显示
            13=>array('name'=>'enjoy_info','method'=>'RecommenderInfo','expire'=>$expire_rec,'front'=>'','back'=>array('location'=>'enjoylist','catg'=>0)),

            //首页预约数据-早教-14，预约类型。102=>早教，103=》摄影，106=》派对
            14=>array('name'=>'bespeak_info','method'=>'BespeakInfo','expire'=>$expire_list,'front'=>102,'back'=>array('type'=>102)),
            //首页预约数据-摄影-15
            15=>array('name'=>'bespeak_info','method'=>'BespeakInfo','expire'=>$expire_list,'front'=>103,'back'=>array('type'=>103)),
            //首页预约数据-派对-16
            16=>array('name'=>'bespeak_info','method'=>'BespeakInfo','expire'=>$expire_list,'front'=>106,'back'=>array('type'=>106)),

            //首页活动数据-正在进行-17
            17=>array('name'=>'activity_info','method'=>'ActivityInfo','expire'=>$expire_rec,'front'=>'now','back'=>array('status'=>1)),
            //首页活动数据-即将开始-18
            18=>array('name'=>'activity_info','method'=>'ActivityInfo','expire'=>$expire_rec,'front'=>'coming','back'=>array('status'=>2)),

            //首页电影数据-正在热映-19，正在热映-1，即将上映-2
            19=>array('name'=>'film_info','method'=>'FilmInfo','expire'=>$expire_list,'front'=>1,'back'=>array('status'=>1)),
            //首页电影数据-即将上映-20
            20=>array('name'=>'film_info','method'=>'FilmInfo','expire'=>$expire_list,'front'=>2,'back'=>array('status'=>2)),

            //首页亲子数据-21，有则显示，无则不显示
            21=>array('name'=>'kids_info','method'=>'KidsInfo','expire'=>$expire_list,'front'=>'','back'=>array()),
            //首页积分数据-22
            22=>array('name'=>'integral_info','method'=>'IntegralInfo','expire'=>$expire_list,'front'=>'','back'=>array()),

            //首页品牌数据-精选品牌-23，按照产品的设计，默认为精选品牌-0，其他为美食-3，电影-1，亲子-2，购物-8，@TODO 娱乐-??
            23=>array('name'=>'brand_info','method'=>'BrandInfo','expire'=>$expire_list,'front'=>0,'back'=>array('type'=>0)),
            //首页品牌数据-电影-24
            24=>array('name'=>'brand_info','method'=>'BrandInfo','expire'=>$expire_list,'front'=>1,'back'=>array('type'=>1)),
            //首页品牌数据-亲子-25
            25=>array('name'=>'brand_info','method'=>'BrandInfo','expire'=>$expire_list,'front'=>2,'back'=>array('type'=>2)),
            //首页品牌数据-美食-26
            26=>array('name'=>'brand_info','method'=>'BrandInfo','expire'=>$expire_list,'front'=>3,'back'=>array('type'=>3)),
            //首页品牌数据-购物-27
            27=>array('name'=>'brand_info','method'=>'BrandInfo','expire'=>$expire_list,'front'=>8,'back'=>array('type'=>8)),
            //首页品牌数据- 娱乐-28
        );
        $key_pre='ffan-web-index-'.$this->plazaId.'-';
        $key1_arr=array();
        foreach($mem_arr as $key1 => $value1){
            $key1_arr[$key1]=$key_pre.$key1;
        }
        //如果传递了memtime，则重新从api接口获取，并存储到memcache中，过期时间为memtime，限制为0-86400
        if(isset($_GET['memtime']) && $_GET['memtime'] && intval($_GET['memtime'])>0 && intval($_GET['memtime']) <86400 && is_array($key1_arr) && $key1_arr){
            //echo '###################################################################################################';
            foreach($key1_arr as $key3 => $value3){
                $method=$mem_arr[$key3]['method'];
                $api_result=$this->$method();
                if($api_result){
                  $return[$mem_arr[$key3]['name']]=$api_result;
                  $memcached_client->set($value3,$api_result,  intval($_GET['memtime']));
              }else{
                  $return[$mem_arr[$key3]['name']]=array();
              }
            }
            return $return;
        }

        //从memcache中获取
        if(is_array($key1_arr) && $key1_arr){
            $cached_result = $memcached_client->getMulti($key1_arr);
          if ($cached_result) {
            foreach ($cached_result as $key2 => $value2) {
              $arr_key2=  explode('-', $key2);
              $num_key2=$arr_key2[count($arr_key2)-1];

              unset($key1_arr[$num_key2]);
              $return[$mem_arr[$num_key2]['name']] = $value2;
            }
          }
        }

        //memcache中没有拿到的数据，从api接口获取，并存储到memcache中
        if(is_array($key1_arr) && $key1_arr){
            foreach($key1_arr as $key3 => $value3){
                $method=$mem_arr[$key3]['method'];
                $api_result=$this->$method();
                  if($api_result){
                    $return[$mem_arr[$key3]['name']]=$api_result;
                    $memcached_client->set($value3,$api_result,$mem_arr[$key3]['expire']);
                  }else{
                      $return[$mem_arr[$key3]['name']]=array();
                  }
            }
        }

        return $return;
    }
  
    public function ApiGet($url) {
        return FeifanApiClient::ApiGet($url);
    }
    
    /***
     * 资源位，zhangfumu
     */
    public function ResourceInfo($params){
        $return=array();
        $resoure_arr=array(26,38,39,40);
        $url_template='https://sandbox.api.wanhui.cn/advertise/v1/materials?cityId='.$this->cityId.'&plazaId='.$this->plazaId.'&resourceId=';
        if(is_array($params) && isset($params['resourceId']) && in_array($params['resourceId'],$resoure_arr) ){
            $url=$url_template.$params['resourceId'];
            $info=$this->ApiGet($url);
            
            if (is_array($info) && isset($info['status']) && $info['status']==200 && isset($info['data']['plans'][0]['serialName']) && $info['data']['plans'][0]['serialName']) {
                foreach ($info['data']['plans'] as $key => $value) {
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
     * 推荐，chengtao10，调用杨国强写的推荐类
     */
    public function RecommenderInfo($params){
        $return=array();
        $location_arr=array('coupon','merchant','couponlist','enjoylist');
        $catg_arr=array(0,1,2,3,4,5,6);
        if(is_array($params) && isset($params['location']) && in_array($params['location'],$location_arr) && isset($params['catg']) && in_array($params['catg'], $catg_arr)){
            $location=$params['location'];
            $catg=$params['catg'];
        }else{
            return $return;
        }
        $rname='';
        $count=1;

        //首页推荐优惠券
        if ($location=='coupon') {
          $rname='couponRcmdForIndex';
        } 
        //首页推荐商户
        else if($location=='merchant') {
          $rname='storeRcmdForIndex';
        }
        //首页优惠列表
        else if ($location=='couponlist') {
          $rname='couponList';
          $count=7;
        }
        //首页娱乐列表
        else if ($location=='enjoylist') {
          $rname='amusementModel';
          $count=3;
        }
    
        $params[$rname]['rname']=$rname;
        $params[$rname]['data']['count']=$count;

        /***
         * catg，只对couponList有效，推荐券-商户时为0，
         */
        if ($location=='couponlist' && in_array($catg, array(1,2,3,4,5,6))) {
            $params['couponList']['data']['prefer']=$catg;
        }

        $rcmdHandler = new Recommend();
        $rcmdHandler->add($params);
        $info = $rcmdHandler->getDatas();
      

        if (is_array($info) && isset($info[$rname]['status']) && $info[$rname]['status'] == 200 && isset($info[$rname]['data']) && is_array($info[$rname]['data'])) {
            foreach ($info[$rname]['data'] as $key => $value) {
                //推荐商户，字段storeId，storeName，icon，isPlaza，isWanda
                if ('merchant'==$location) {
                    $return['storeId']=$value['storeId'];
                    $return['storeName']=$value['storeName'];
                    $return['icon']=$value['icon'];
                    $return['isPlaza']=$value['isPlaza'];
                    $return['isWanda']=$value['isWanda'];
                } 
                //推荐优惠券，字段productId，itemId，name，subName，icon
                else if ('coupon'==$location)  {
                    $return['productId']=$value['productId'];
                    $return['name']=$value['name'];
                    $return['subName']=$value['subName'];
                    $return['icon']=$value['icon'];
                }
                //首页优惠列表，字段productId，itemId，name，subName，icon
                else if ('couponlist'==$location)  {
                    if ($key < 1) {
                        $return['left']['productId']=$value['productId'];
                        $return['left']['name']=$value['name'];
                        $return['left']['subName']=$value['subName'];
                        $return['left']['icon']=$value['icon'];
                    } 
                    else if($key > 0 && $key < 7) {
                      $return['right'][$key]['productId']=$value['productId'];
                      $return['right'][$key]['name']=$value['name'];
                      $return['right'][$key]['subName']=$value['subName'];
                      $return['right'][$key]['icon']=$value['icon'];
                    }
                }
                //首页娱乐列表，字段productId，itemId，name，subName，icon，oriPrice，salePrice，isWanda
                else if ('enjoylist'==$location)  {
                    $return[$key]['productId']=$value['productId'];
                    $return[$key]['name']=$value['name'];
                    $return[$key]['subName']=$value['subName'];
                    $return[$key]['oriPrice']=$value['oriPrice'];
                    $return[$key]['salePrice']=$value['salePrice'];
                    $return[$key]['isWanda']=$value['isWanda'];
                }
            }
        } else {
          # code...
        }
    return $return;
    }
    
    /***
     * 预约，
     * zhangjianshan，chenlinfei
     * http://dev.wanhui.cn/#/api_version_detail/15
     * https://sandbox.api.wanhui.cn/kids/bespeakinit/{{wpid}}/{{bespeak_type}}
     * bespeak_type：预约类型。102=>早教，103=》摄影，106=》派对
     * demo，https://sandbox.api.wanhui.cn/kids/bespeakinit/1000664/102 获取广场ID为1000664类型为早教的预约信息
     */
    private function BespeakInfo($params){
        $return=array();
        $type_arr=array(102,103,106);
        if(is_array($params) && isset($params['type']) && in_array($params['type'],$type_arr)){
        }else{
            return $return;
        }
        $url_template='https://sandbox.api.wanhui.cn/kids/bespeakinit/%s/%s';
        
        //$url=  sprintf($url_template,1000664,$type);
        $url=  sprintf($url_template,$this->cityId,$type);
        $info=$this->ApiGet($url);
        if(is_array($info) && isset($info['status']) && $info['status']==0 && isset($info['shopList'][0]['id']) && $info['shopList'][0]['id']){
            foreach($info['shopList'] as $key => $value){
                $return[$type][$key]['id']=$value['id'];
                $return[$type][$key]['name']=$value['name'];
                $return[$type][$key]['cityId']=$value['cityId'];
                $return[$type][$key]['merchantId']=$value['merchantId'];
                $return[$type][$key]['storeId']=$value['storeId'];
            }
        }
        return $return;
    }
    /***
     * xielei14
     * http://dev.wanhui.cn/#/api_version_detail/96
     * demo,https://sandbox.api.wanhui.cn/market/activitylist?type=1&pageSize=20&wpid=1000298&offset=0
     */
    private function ActivityInfo($params) {
        $return=array();
        $type_arr=array(1,2);
        if(is_array($params) && isset($params['type']) && in_array($params['type'],$type_arr)){
        }else{
            return $return;
        }

    $url_template='https://sandbox.api.wanhui.cn/market/v2/activities?offset=0&pageSize=7&wpid='.$this->plazaId.'&type=';
    $url=$url_template.$params['type'];
    $info=$this->ApiGet($url);

    if (is_array($info) && isset($info['status']) && $info['status']==0 && isset($info['list'][0]['id']) && $info['list'][0]['id']){
        foreach ($info['list'] as $key => $value) { 
            if ($key < 1) {
                $return["left"]["id"]=$value["id"];
                $return["left"]["title"]=$value["title"];
                $return["left"]["img"]=  isset($value["image_path"][0]["img"])?$value["image_path"][0]["img"]:'';

                if($value["start_date"] && $value["end_date"]){
                    $return["left"]["duration"]=$this->GetActivityDateString($value["start_date"]).' - '.$this->GetActivityDateString($value["end_date"]);
                }else{
                    $return["left"]["duration"]='';
                }
            } 
            if( $key > 0 && $key <7)
            {
                $return["right"][$key]["id"]=$value["id"];
                $return["right"][$key]["title"]=$value["title"];
                $return["right"][$key]["img"]=isset($value["image_path"][0]["img"])?$value["image_path"][0]["img"]:'';
                if($value["start_date"] && $value["end_date"]){
                    $return["right"]["duration"]=$this->GetActivityDateString($value["start_date"]).' - '.$this->GetActivityDateString($value["end_date"]);
                }else{
                    $return["right"]["duration"]='';
                }
            }
        }
    }else{
    }
    return $return;
  }

  /***
   * 活动日期字符串的处理，
   * 现在活动接口获取到的为，["start_date"]=>string(10) "2014-11-10"  ["end_date"]=>string(10) "2014-11-26"
   * 处理为月.日的形式
   */
  private function GetActivityDateString($date){
    if($date){
        return str_replace('-','.',substr($date,strpos($date,'-')+1));
    }else{
        return '';
    }
  }
  
  /***
   * 电影的，需要调用搜索的接口，卢康乐，杨国强
   * 
   * 
   */
  private function FilmInfo(){
      return array();
  }
  
  /***
   * 亲子的，需要调用wanghuidong1的接口，12.24出
   */
  private function KidsInfo(){
      return array();
  }
  
  /***
   * wanghuidong1，
   * http://dev.wanhui.cn/#/api_version_detail/432
   * http://pointgoods.test.wanhui.cn/api/ffan
   * 过期时间中设置全国，积分-金融-
   */
  private function IntegralInfo(){
    $return =array();
    $info=$this->ApiGet('https://sandbox.api.wanhui.cn/wdpoint/v1/api/ffan');
    if (is_array($info) && isset($info['status']) && $info['status']==0 && isset($info["data"]["lotteryUrl"]) && $info["data"]["lotteryUrl"]) {
        $return['lotteryUrl']=$info["data"]["lotteryUrl"];
    }
    if (is_array($info) && isset($info['status']) && $info['status']==0 && isset($info["data"]["list"]) && !empty($info["data"]["list"]) && is_array($info["data"]["list"])) {
        foreach ($info["data"]["list"] as $key => $value) {
            if($key <3){
              $return['list'][$key]["id"]=$value["goods_id"];
              $return['list'][$key]["name"]=$value["goods_name"];
              $return['list'][$key]["pic"]=$value["goods_pic"];
              $return['list'][$key]["point"]=$value["sale_point"];
              $return['list'][$key]["url"]=$value["detailUrl"];
            }
        }
    }
    return $return;
  }
    /***
     * 
     */
    private function BrandInfo($params){
        $return=array();
        $type_arr=array(0,1,2,3,4,5,6);
        if(is_array($params) && isset($params['type']) && in_array($params['type'],$type_arr)){
        }else{
            return $return;
        }
        
        if($params['type']>0){
            $url_template = 'https://sandbox.api.wanhui.cn/cdaservice/businessTypes/%s/stores';
            $url = sprintf($url_template, $params['type']);
            $info=$this->ApiGet($url);
            if (is_array($info) && isset($info['status']) && $info['status']==200 && isset($info['data']["stores"][0]["storeId"]) && $info['data']["stores"][0]["storeId"]) {
                foreach($info['data']["stores"] as $key => $value){
                    $return[$key]['id']=$value["storeId"];
                    $return[$key]['picid']=$value["storePicsrc"];
                }
            } 
        }else{
            $url='https://sandbox.api.wanhui.cn/cdaservice/stores/optimum?plazaId='.$this->plazaId;
            $info=$this->ApiGet($url);
            foreach($info['data']["stores"] as $key => $value){
                $return[$key]['id']=$value["storeId"];
                $return[$key]['picid']=$value["storePicsrc"];
            }
        }
        return $return;
    }
  
  
  
  /***
   * 1219,chengtao10
   * https://sandbox.api.wanhui.cn/recommender/v1/categorytable?cityId=420100&plazaId=420100
   * 基本的结构形成了，需要杨国强封装的卢康乐的搜索接口，来形成搜索，然后跳转到哪里？
   * 
   */
  public function FeifanService(){
      $return =array();
      //$url_template='https://sandbox.api.wanhui.cn/recommender/v1/categorytable?cityId=%s&plazaId=%s';
      //$url=sprintf($url_template, $this->cityId,$this->plazaId);
      $url='https://sandbox.api.wanhui.cn/recommender/v1/categorytable?cityId=420100&plazaId=420100';
      $info=$this->ApiGet($url);
      if(is_array($info) && isset($info['status']) && 200==$info['status'] && isset($info['data']['0']['categoryId']) && $info['data']['0']['categoryId']){
          foreach($info['data'] as $key1 => $value1){
              $return[$key1]['categoryId']=$value1['categoryId'];
              $return[$key1]['categoryName']=$value1['categoryName'];
              $return[$key1]['url']='';
              if(isset($info['data'][$key1]['subCategoryInfoList']) && $info['data'][$key1]['subCategoryInfoList']){
                  foreach($info['data'][$key1]['subCategoryInfoList'] as $key2 => $value2){
                      $return[$key1]['subCategoryInfoList'][$key2]['categorySubId']=$value2['categorySubId'];
                      $return[$key1]['subCategoryInfoList'][$key2]['categorySubName']=$value2['categorySubName'];
                      $return[$key1]['subCategoryInfoList'][$key2]['url']='';
                  }
              }
          }
      }else{
          return $return;
      }
      return $return;
  }
}


