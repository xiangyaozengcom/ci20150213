<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//设定输出编码为utf-8
header("content-type:text/html;charset=utf8");

class test20150106 extends CI_Controller {
    public function chengtao10(){
        $str='{"data":"[]","message":"没有相关信息","status":"200"}';
        $str='{"data":{"plazaid":"1000265"},"message":"","status":"200"}';
        $info=  json_decode($str, true);
        var_dump($info);
//        if (is_array($info) && isset($info['status']) && 200==$info['status'] && isset($info['data']['plazaid']) && $info['data']['plazaid'] && 7==strlen($info['data']['plazaid'])) {
//            $return['plazaId']=$info['data']['plazaid'];
//        }else{
//            $return['plazaId']=1000265;
//        }
        var_dump($info['data']['plazaid']);
        if (is_array($info) && isset($info['data']['plazaid']) && $info['data']['plazaid'] ) {
            $return['plazaId']=$info['data']['plazaid'];
        }else{
            $return['plazaId']=1000265;
        }
        var_dump($return['plazaId']);
    }
    /***
     * http://phpway.blog.163.com/blog/static/21211200520121029101728147/
     * php迭代寻找家谱树(应用于面包屑导航) - php之路的日志 - 网易博客.html
     */
    public function breadcrumb(){
      echo "<pre>";
        $area = array(
          array('id'=>1,'area'=>'北京','pid'=>0),
          array('id'=>2,'area'=>'广西','pid'=>0),
          array('id'=>3,'area'=>'广东','pid'=>0),
          array('id'=>4,'area'=>'福建','pid'=>0),
          array('id'=>11,'area'=>'朝阳区','pid'=>1),
          array('id'=>12,'area'=>'海淀区','pid'=>1),
          array('id'=>21,'area'=>'南宁市','pid'=>2),
          array('id'=>45,'area'=>'福州市','pid'=>4),
          array('id'=>113,'area'=>'亚运村','pid'=>11),
          array('id'=>115,'area'=>'奥运村','pid'=>11),
          array('id'=>234,'area'=>'武鸣县','pid'=>21)
        ); 

        function familytree($arr,$id){
         $list = array();
         while($id){
          $flag = false;
          foreach($arr as $v){
           if($v['id']==$id){
            array_unshift($list,$v['area']);
            $id = $v['pid'];
            $flag = true;
           }
          }
          if(!$flag){
           break;
          }
         }
         return $list;
        }
        //echo familytree($area,113);
        print_r(familytree($area,113));
    }
}


