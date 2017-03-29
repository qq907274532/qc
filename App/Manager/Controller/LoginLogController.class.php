<?php

    namespace Manager\Controller;

    use Common\Model\LoginLogModel;
    use Manager\Model\AdminUserModel;

    class  LoginLogController extends AdminBaseController
    {

        private $model;

        public function __construct()
        {
            parent::__construct();
            $this->model = new LoginLogModel();

        }

        public function index()
        {
            $adminUserModel = new AdminUserModel();
            $data = $this->page_com($this->model, ['id' => 'desc']);
            $adminUserList=$adminUserModel->getListByStatus();
            $adminUserList=array_column($adminUserList,'username','id');
            foreach ($data['list'] as $k => $v) {
                $data['list'][$k]['adminUserName'] ='';
                if(in_array($v['user_id'],array_keys($adminUserList))){
                    $data['list'][$k]['adminUserName'] =$adminUserList[$v['user_id']];
                }

            }
            $this->assign('data', $data);
            $this->display();
        }



    }