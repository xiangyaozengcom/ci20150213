<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class test20141125 extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}

	public function resourceid(){
		//$params_json='{"query":"���","filter":[["resource_id",[1],0,0,0],["city_id",[210100],0,0,0],["plaza_id",[1000544],0,0,0]],"offset":"0","limit":"1","order_type":"pricedesc"}';
		//$params_json='{"query":"���","offset":"0","limit":"1","order_type":"pricedesc"}';
		$params["query"]="asd";
		$params["offset"]=0;
		$params["limit"]=10;
		$params['filter'][] = array("resource_id", array(1),0,0,0);
		$params['filter'][] = array("city_id", array(100100),0,0,0);
		$params_json=json_encode($params);
		//var_dump($params_json);
	
		$params_arr=json_decode($params_json,true);
		//var_dump($params_arr);
		$this->get_resource_id_total($params_json);
		//echo $this->get_resource_id($params_json);
	}

	public function get_resource_id($params_json){
		$params_arr=json_decode($params_json,true);
		if(isset($params_arr["filter"]) && !empty($params_arr["filter"]) && is_array($params_arr["filter"])){
			foreach( $params_arr["filter"] as $value){
				if("resource_id"==$value[0]){
					return $value[1][0];
					break;
				}
			}
		}
	}
	/*
	array(4) { ["query"]=> NULL ["offset"]=> int(0) ["limit"]=> int(10) ["filter"]=> array(1) { [1]=> array(5) { [0]=> string(7) "city_id" [1]=> array(1) { [0]=> int(100100) } [2]=> int(0) [3]=> int(0) [4]=> int(0) } } } 
	��queryΪ����ʱ��ת����Ϊ�գ�Ϊ��ĸ������ʱ��������Ӧ�������ı���ת�������⣬
	����Ǿ���url���ݹ��������ģ��Ѿ�ʹ����urlencode���룬Ӧ�ÿ�����������
	����Ӧ��ֻ����["filter"]��������֣���ĸ����
	*/
	public function get_resource_id_total($params_json){
		$params_arr=json_decode($params_json,true);
		$params_total=array();
		$orgin_key='';
		if(isset($params_arr["filter"]) && !empty($params_arr["filter"]) && is_array($params_arr["filter"])){
			foreach( $params_arr["filter"] as $key => $value){
				if("resource_id"==$value[0]){
					unset($params_arr["filter"][$key]);
					//$orgin_key=$key;
					break;
				}
			}
		}
		$resource_id_arr=array(1,2,3,4,5,6,7,8,9);
		foreach($resource_id_arr as $key => $value){
			foreach( $params_arr["filter"] as $key1 => $value1){
				if("resource_id"==$value1[0]){
					unset($params_arr["filter"][$key1]);
					//$orgin_key=$key;
					break;
				}
			}
			$params_arr['filter'][] = array("resource_id", array($value),0,0,0);
			$infosr=$this->ApiGet($this->url.json_encode($params_arr));
			$total[$value]=$infosr['total'];
		}
		var_dump($params_arr);
	
	}
	 /*
  ��ҳ�Ż��б�ӿ�
  chengtao10(����)
  �ɷ�Web�Ƽ��ӿڶ����ĵ� .docx
  �Żݵĸ�ҳǩ�Ƽ�
  http://sandbox.api.wanhui.cn/recommender/web/v2/members/1/rec?mobile=13013601168&cityId=111&plazaId=1000293&isInPlaza=1&sex=1&age=2&prefer=1:2:3&productType=3&count=3&cursor=0&sortType=0&funcType=5

	���ղ�Ʒ����ƣ����4���ֶ��ֲ�ͼ���ұ�6��Сͼ��
	productId����Ʒid
	name������
	subName��������
	icon��ͼƬ
	isWanda���Ƿ��������
	oriPrice��ԭ��
	salePrice���ۼ�
	saleNum������
	��ǰ�˵��ֶΣ�productId-name-subName-icon
 */
	public function get_cheap_info(){
		$url='http://sandbox.api.wanhui.cn/recommender/web/v2/members/1/rec?';
		$params['mobile']=13013601168;
		$params['cityId']=111;
		$params['plazaId']=1000293;
		$params['isInPlaza']=1;
		$params['age']=2;
		$params['prefer']='1:2:3';
		$params['productType']=3;
		$params['count']=3;
		$params['cursor']=0;
		$params['sortType']=0;
		$params['funcType']=5;
		echo $url.http_build_query($params);
		$info='';


	}

	public function ApiGet($url){

	
	}

	public function getdayweek(){
		//date_default_timezone_set('PRC') ;
		$date=getdate(time());
		var_dump($date);
	}
	//TODO,array_rand()

//'DLOG_DIR'=>'./log/' ,//��̨������־���Ŀ¼
//'DLOG_LEVEL'=>array('debug','run','error','fatal') ,//��̨������־����
/**
 * ��¼ϵͳ��־
 * @param string $log_content ��־����
 * @param string $log_level ��־����      debug, run, error, fatal
 * @param string $log_name ��־�ļ���ǰ׺���ɲ�����
 * @��־�ļ��� = $log_name + ".��-��-��" + .log ��: abc.2012-03-19.log
 */
function DLOG($log_content='', $log_level='', $log_name='')
{

    if(empty($log_level)||empty($log_content))
        return;

    if(!in_array($log_level, C('DLOG_LEVEL')))
        return;

    if(empty($log_name) && $log_level <> 'run')
        $log_name = 'diyibu';
    elseif(empty($log_name) && $log_level == 'run')
        $log_name = 'run';

    $log_dir = C('DLOG_DIR');
    $log_file = $log_dir.$log_name.".".date('Y-m-d').".log";

    //Ĭ��ÿ����־��д�����ݣ�ͳһ�����ﴦ��
    $time = date('H:i:s');
    session_start();
    $session_id = session_id();
    session_write_close();
    $head = str_replace("\\","",$_POST['header']);
    $head = json_decode($head,1);
    $mac = $head['mac'];
    $ip = getenv('REMOTE_ADDR');

    //�����������
    $cn = Cookie::get('cn');
    if(empty($cn))
        $cn = "-";

    $content_prefix = "[ ".$time." ".$ip." ".$cn." ".$mac." ".$session_id." ".$log_level." ".MODULE_NAME." ".ACTION_NAME." ] ";

    $fp = fopen($log_file, 'a+');
    fwrite($fp, $content_prefix.$log_content." [".getmypid()."]\n");
    fclose($fp);
    return;
}

	public function log_rec(){
		$content=date('Y-m-d H:i:s');
		$file='./log/'.'ffan.'.date('YmdH').'.txt';
		$fp=fopen($file,'a+');
		fwrite($fp,$content."\r\n");
		fclose($fp);
		echo $content;
	}

	public function filter(){
		$arr['query']='abc';
		$arr['offset']=0;
		$arr['limit']=1;
		$arr['filter'][] = array("resource_id", array(1),0,0,0);
		$arr['filter'][] = array("city_id", array(2),0,0,0);
		
		$params=array();
		if(isset($arr['filter'])){
			foreach($arr['filter'] as $key1 => $value1){
				if("resource_id"==$value1[0])
					var_dump($value1);
			}
		}
	}


	public function catename(){
	//$json='{"status":200,"message":"�ɹ�","data":{"categoryId":5,"categoryName":"����","categoryLevel":1,"parent":null,"sort":1,"isLeaf":0,"version":4,"categoryPicSrc":null,"createTime":null,"updateTime":null,"categoryLevelOption":null,"categoryParentOption":null}}';{"status":200,"message":"��Ŀ������","data":null}
	//$json='{"status":200,"message":"��Ŀ������","data":null}';
	//$arr=json_decode($json,true);
	//var_dump($arr);
//	$arr1['status']=200;
//	$arr1['message']='�ɹ�';
//	$arr1['data']['categoryId']=5;
//	$arr1['data']['categoryName']='����';
//
//	$arr1['message']=urlencode($arr1['message']);
//	$arr1['data']['categoryName']=urlencode($arr1['data']['categoryName']);
//
//	$arr2['status']=200;
//	$arr2['message']='ʧ��';
//	$arr2['data']=null;
//
//	$json1=json_encode($arr1);
//	$json2=json_encode($arr2);
//
//	$arr_de1=json_decode($json1,true);
//	$arr_de2=json_decode($json2,true);
//	 //echo $json1;
//	// echo $json2;
//	//echo $arr_de1["message"];
//	//var_dump($arr_de1);
//	//var_dump($arr_de2);
//
//	if(!empty($arr_de1['data'])){
//		echo $arr_de1['data']['categoryName'];
//	}
//
	$json3='{"status":200,"message":"��Ŀ������","data":null}';
//	$json3=urlencode($json3);
//	//echo $json3;

$json='{"status":200,"message":"�ɹ�","data":{"categoryId":5,"categoryName":"����","categoryLevel":1,"parent":null,"sort":1,"isLeaf":0,"version":4,"categoryPicSrc":null,"createTime":null,"updateTime":null,"categoryLevelOption":null,"categoryParentOption":null}}';
//	$pos_start=strpos($json,'categoryName')+14;
//	$pos_end=strpos($json,'categoryLevel')-2;
//	$len=$pos_end-$pos_start;
//	echo $sub1=substr($json,$pos_start,$pos_end-$pos_start);
//var_dump(strpos($json,'abcd'));
echo strpos($json3,'}');//�ɹ�ʱ252����Ŀ������ʱ48




	}

	public function urlcode(){
		$query="\u5723\u9a6c\u7f57";
		$url='xapi.hrc.ffan.com/ffan/search?params={"query":"\u5723\u9a6c\u7f57","limit":16,"filter":[["resource_id",[1],0,0,0]],"offset":0,"hl":1,"hlpre":"highlightpre","hlpost":"highlightpost","order_type":"wisdom"}';
		$pos_query=strpos($url,'query')+7;
		$pos_dot=strpos($url,',');
		//echo $pos_query.'&&'.$pos_dot;
		echo $query1=substr($url,$pos_query,$pos_dot-$pos_query);
		echo strpos($query1,'\\u');
		if(strpos($query1,'\\u')==1){
			//echo json_encode($query);
			echo $this->unicode_decode($query1);
		}
	}

	/**
 * $str ԭʼ�����ַ���
 * $encoding ԭʼ�ַ����ı��룬Ĭ��GBK
 * $prefix ������ǰ׺��Ĭ��"&#"
 * $postfix �����ĺ�׺��Ĭ��";"
 */
function unicode_encode1($str, $encoding = 'GBK', $prefix = '&#', $postfix = ';') {
    $str = iconv($encoding, 'UCS-2', $str);
    $arrstr = str_split($str, 2);
    $unistr = '';
    for($i = 0, $len = count($arrstr); $i < $len; $i++) {
        $dec = hexdec(bin2hex($arrstr[$i]));
        $unistr .= $prefix . $dec . $postfix;
    } 
    return $unistr;
} 
 
/**
 * $str Unicode�������ַ���
 * $decoding ԭʼ�ַ����ı��룬Ĭ��GBK
 * $prefix �����ַ�����ǰ׺��Ĭ��"&#"
 * $postfix �����ַ����ĺ�׺��Ĭ��";"
 */
function unicode_decode1($unistr, $encoding = 'GBK', $prefix = '&#', $postfix = ';') {
    $arruni = explode($prefix, $unistr);
    $unistr = '';
    for($i = 1, $len = count($arruni); $i < $len; $i++) {
        if (strlen($postfix) > 0) {
            $arruni[$i] = substr($arruni[$i], 0, strlen($arruni[$i]) - strlen($postfix));
        } 
        $temp = intval($arruni[$i]);
        $unistr .= ($temp < 256) ? chr(0) . chr($temp) : chr($temp / 256) . chr($temp % 256);
    } 
    return iconv('UCS-2', $encoding, $unistr);
}

function unicode_decode($name)
{
    // ת�����룬��Unicode����ת���ɿ��������utf-8����
    $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
    preg_match_all($pattern, $name, $matches);
    if (!empty($matches))
    {
        $name = '';
        for ($j = 0; $j < count($matches[0]); $j++)
        {
            $str = $matches[0][$j];
            if (strpos($str, '\\u') === 0)
            {
                $code = base_convert(substr($str, 2, 2), 16, 10);
                $code2 = base_convert(substr($str, 4), 16, 10);
                $c = chr($code).chr($code2);
                $c = iconv('UCS-2', 'UTF-8', $c);
                $name .= $c;
            }
            else
            {
                $name .= $str;
            }
        }
    }
    return $name;
}
}
