<?php

    namespace Manager\Controller;

    use Common\Model\JobCateModel;
    use Common\Model\JobModel;

    class  JobController extends AdminBaseController
    {

        private $model;
        private $jobCateModel;

        public function __construct()
        {
            parent::__construct();
            $this->model = new JobModel();
            $this->jobCateModel= new JobCateModel();

        }

        public function index()
        {
            $data = $this->page_com($this->model, ['id' => 'desc']);
            $jobCateList=$this->jobCateModel->getJobCateList();
            $jobCateList=array_column($jobCateList,'name','id');
            foreach ($data['list'] as $k => $v) {
                $data['list'][$k]['statusName'] = JobModel::$STATUS_MAP[$v['status']];
                $data['list'][$k]['typeName']='';
                if(in_array($v['type'],array_keys($jobCateList))){
                    $data['list'][$k]['typeName']=$jobCateList[$v['type']];
                }
            }
            $this->assign('data', $data);
            $this->display();
        }

        public function add()
        {
            if (IS_POST) {
                $data = I('post.');
                $data['create_time'] = date('Y-m-d H:i:s');
                if (!$this->model->create($data)) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => $this->model->getError()));
                }
                if (!$this->model->add()) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => "添加失败"));
                }
                $this->ajaxReturn(array('error' => self::SUCCESS_NUMBER, 'message' => "添加成功"));
            } else {

                $this->display();
            }
        }

        public function edit()
        {
            $id = I('id');
            if (IS_POST) {
                if ($id <= 0) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => "不合法请求"));
                }
                $data['name'] = I('post.name');
                if (!$this->model->create($data)) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => $this->model->getError()));
                }
                if (!$this->model->where(['id' => $id])->save()) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => "修改失败"));
                }
                $this->ajaxReturn(array('error' => self::SUCCESS_NUMBER, 'message' => "修改成功"));
            } else {
                if ($id <= 0) {
                    $this->error("不合法请求", U('Logistics/index'));
                }
                $this->assign('info', $this->model->getShipperInfoById($id));
                $this->display();
            }
        }

        public function del()
        {
            if (($id = I('id', 0, 'intval')) <= 0) {
                $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => "数据格式有误"));
            }

            $status = intval(I('status', 0, 'intval')) == JobModel::STATUS_ENABLE ? JobModel::STATUS_DISABLE : JobModel::STATUS_ENABLE;
            if (!$this->model->where(array('id' => $id))->save(array('status' => $status))) {
                $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => '操作失败'));
            }
            $this->ajaxReturn(array('error' => self::SUCCESS_NUMBER, 'message' => '操作成功'));
        }
    }