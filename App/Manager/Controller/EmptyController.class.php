<?php
namespace Manager\Controller;
use Think\Controller;
class EmptyController extends Controller{
    public function index(){
        //根据当前控制器名来判断要执行那个城市的操作
      
       $this->display("Public:404");
    }
}