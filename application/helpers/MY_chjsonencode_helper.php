<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//设定输出编码为utf-8
header("content-type:text/html;charset=utf8");
/**
* 将中文编码
* @param array $data
* @returnstring
*/
function ch_json_encode($data) {	
	$ret = ch_urlencode($data);
	$ret =json_encode($ret);
	return urldecode($ret);
}

function ch_urlencode($data) {
		if (is_array($data) || is_object($data)) {
			foreach ($data as $k => $v) {
				if (is_scalar($v)) {
						if (is_array($data)) {
							$data[$k] = urlencode($v);
						} elseif (is_object($data)) {
							$data->$k =urlencode($v);
						}
					} 
				elseif (is_array($data)) {
					$data[$k] = ch_urlencode($v);//递归调用该函数
					}
				elseif (is_object($data)) {
					$data->$k = ch_urlencode($v);
				}
			}
		}
		return$data;
	}

	/*
		http://www.cnblogs.com/xiangxiaodong/archive/2012/10/25/2739307.html
		用PHP将Unicode 转化为UTF-8 - 简单--生活 - 博客园.html
	
	*/

	 //将内容进行UNICODE编码
function unicode_encode($name)
{
    $name = iconv('UTF-8','UCS-2//IGNORE', $name);
    $len = strlen($name);
    $str = '';
    for ($i = 0; $i < $len - 1; $i = $i + 2)
    {
        $c = $name[$i];
        $c2 = $name[$i + 1];
        if (ord($c) > 0)
        {    // 两个字节的文字
            $str .= '\u'.base_convert(ord($c), 10, 16).base_convert(ord($c2), 10, 16);
        }
        else
        {
            $str .= $c2;
        }
    }
    return $str;
}

// 将UNICODE编码后的内容进行解码
function unicode_decode($name)
{
    // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
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