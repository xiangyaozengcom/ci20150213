<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//设定输出编码为utf-8
header("content-type:text/html;charset=utf8");

class test20141208 extends CI_Controller {
    
    public function funDataName(){
        $ffanweb_index_mem_arr=array(
          1=>'banner_info',2=>'resource_film',3=>'resource_kid',4=>'resource_enjoy',5=>'rec_coupon',
          6=>'rec_merchant',7=>'coupon_info',8=>'activity_info',9=>'film_info',10=>'kids_info',
          11=>'integral_info',12=>'brand_info'
          );
        //$funcName_arr=  explode('_', $ffanweb_index_mem_arr[1]);
        
        //$funcName_arr_2=ucfirst($funcName_arr_1);
        //$funcName=  'Get'.ucfirst($funcName_arr_1[0]).ucfirst($funcName_arr_1[1]);
                
        //echo $funcName;
        for($i=1;$i<13;$i++){
            $funcName='';
            $funcName_arr=  explode('_', $ffanweb_index_mem_arr[$i]);
            $funcName=  'Get'.ucfirst($funcName_arr[0]).ucfirst($funcName_arr[1]);
            echo $funcName.'<br/>';
        }
    }
    
    public function underline(){
        //<div style="text-decoration:line-through; color:#FF0000"><A style="color:#000000">dfsdfsd</A></div> 
        //$str['price']='<span style="text-decoration:line-through olor:#00FF00" >原始价格</span>';
        $str['price']='<s style="color:gray">原始价格</s>';
        $str['salePrice']='<span style="color:red">现在价格</span>';
        echo $str['price'];echo $str['salePrice'];
    }
}

