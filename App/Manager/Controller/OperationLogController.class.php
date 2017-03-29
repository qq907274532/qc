<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 2017/3/6
     * Time: 13:31
     */

    namespace Manager\Controller;


    use Common\Model\LogModel;
    use Manager\Model\AdminUserModel;

    class OperationLogController extends AdminBaseController
    {
        public function index()
        {
            $logModel= new LogModel();
            $adminUserModel= new AdminUserModel();
            $adminUserList=$adminUserModel->getListByStatus();
            $newAdminUserList=array_combine(array_column($adminUserList,'id'),array_column($adminUserList,'username'));
            $data=$this->page_com($logModel,['create_time'=>'desc']);
            foreach ($data['list'] as $k =>$v){
                $data['list'][$k]['userName']='';
                if(in_array($v['uid'],array_keys($newAdminUserList))){
                    $data['list'][$k]['userName']=$newAdminUserList[$v['uid']];
                }
            }
            $this->assign('data',$data);
            $this->display();
        }
    }