<?php

    namespace Manager\Controller;

    use Common\Model\MessagesModel;

    class  MessageController extends AdminBaseController
    {

        private $model;

        public function __construct()
        {
            parent::__construct();
            $this->model = new MessagesModel();

        }

        public function index()
        {
            $data = $this->page_com($this->model, ['id' => 'desc']);
            foreach ($data['list'] as $k => $v) {
                $data['list'][$k]['statusName'] = MessagesModel::$STATUS_MAP[$v['status']];
            }
            $this->assign('data', $data);
            $this->display();
        }


        public function look()
        {
            $id = I('id');
            if ($id <= 0) {
                $this->error("不合法请求", U('Logistics/index'));
            }
            $this->model->where(['id'=>$id])->save(['is_read'=>MessagesModel::READ_ENABLE]);
            $this->assign('info', $this->model->getMessageInfoById($id));
            $this->display();
        }

        public function del()
        {
            if (($id = I('id', 0, 'intval')) <= 0) {
                $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => "数据格式有误"));
            }

            $status = intval(I('status', 0, 'intval')) == MessagesModel::STATUS_ENABLE ? MessagesModel::STATUS_DISABLE : MessagesModel::STATUS_ENABLE;
            if (!$this->model->where(array('id' => $id))->save(array('status' => $status))) {
                $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => '操作失败'));
            }
            $this->ajaxReturn(array('error' => self::SUCCESS_NUMBER, 'message' => '操作成功'));
        }
    }