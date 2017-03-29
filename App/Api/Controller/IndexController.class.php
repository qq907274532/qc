<?php
namespace  Api\Controller;
use Common\Model\CateModel;

class IndexController extends IndexBaseController {
    public function index(){
        $cateModel= new CateModel();
        $result=$cateModel->getCateList();
        $this -> response(node_merges($result),'请求成功');
    }
}