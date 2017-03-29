<?php
    namespace Manager\Controller;



    use Common\Model\JobCateModel;

    class JobCateController extends AdminBaseController
    {
        private $model;
        private $order;

        public function __construct()
        {
            parent::__construct();
            $this->model= new JobCateModel();
        }

        public function index()
        {
            $this->order = array('create_time'=>'desc', 'id' => 'desc');
            $data = $this->page_com($this->model, $this->order);
            foreach ($data['list'] as $k => $v) {
                $data['list'][$k]['statusName'] = JobCateModel::$STATUS_MAP[$v['status']];
            }
            $this->assign('data',$data);
            $this->display();
        }

        public function add()
        {
            if (IS_POST) {
                $data = I('post.');
                $data['create_time'] = date("Y-m-d H:i:s");
                $data['status'] = JobCateModel::STATUS_ENABLE;
                if (!$this->model->create($data)) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => $this->model->getError()));
                } else {
                    if (!$this->model->add()) {
                        $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => "添加失败"));
                    }
                    $this->ajaxReturn(array('error' => self::SUCCESS_NUMBER, 'message' => "添加成功"));
                }
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
                $data = I('post.');
                unset($data['id']);
                if (!$this->model->create($data)) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => $this->model->getError()));
                }
                if (!$this->model->where(array('id' => $id))->save($data)) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => "修改失败"));
                }
                $this->ajaxReturn(array('error' => self::SUCCESS_NUMBER, 'message' => "修改成功"));
            } else {
                if ($id <= 0) {
                    $this->error("不合法请求", U('Role/index'));
                }
                $this->assign('info',$this->model->getJobCateInfoById($id));
                $this->display();
            }
        }



        public function del()
        {
            if (($id = I('id', 0, 'intval')) <= 0) {
                $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => "数据格式有误"));
            }
            $status = intval(I('status', 0, 'intval')) == JobCateModel::STATUS_ENABLE ? JobCateModel::STATUS_DISABLE : JobCateModel::STATUS_ENABLE;
            if (!$this->model->where(array('id' => $id))->save(array('status' => $status))) {
                $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => '操作失败'));
            }
            $this->ajaxReturn(array('error' => self::SUCCESS_NUMBER, 'message' => '操作成功'));
        }
    }