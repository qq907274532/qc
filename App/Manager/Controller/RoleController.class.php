<?php
    namespace Manager\Controller;

    use Manager\Model\AuthGroupModel;
    use Manager\Model\AuthRuleModel;

    class RoleController extends AdminBaseController
    {
        private $model;
        private $order;

        public function __construct()
        {
            parent::__construct();
            $this->model = new AuthGroupModel();
        }

        public function index()
        {
            $this->order = array('create_time', 'id' => 'desc');
            $data = $this->page_com($this->model, $this->order);
            foreach ($data['list'] as $k => $v) {
                $data['list'][$k]['statusName'] = AuthGroupModel::$STATUS_MAP[$v['status']];
            }
            $this->assign('data',$data);
            $this->display();
        }

        public function add()
        {
            if (IS_POST) {
                $data = I('post.');
                $data['create_time'] = date("Y-m-d H:i:s");
                $data['status'] = AuthGroupModel::STATUS_ENABLE;
                if (!$this->model->create($data)) {
                    $this->ajaxReturn(array('error' => 100, 'message' => $this->model->getError()));
                } else {
                    if (!$this->model->add()) {
                        $this->ajaxReturn(array('error' => 100, 'message' => "添加失败"));
                    }
                    $this->ajaxReturn(array('error' => 200, 'message' => "添加成功"));
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
                    $this->ajaxReturn(array('error' => 100, 'message' => "不合法请求"));
                }
                $data = I('post.');
                if (!$this->model->where(array('id' => $id))->save($data)) {
                    $this->ajaxReturn(array('error' => 100, 'message' => "修改失败"));
                }
                $this->ajaxReturn(array('error' => 200, 'message' => "修改成功"));
            } else {
                if ($id <= 0) {
                    $this->error("不合法请求", U('Role/index'));
                }
                $this->assign('info',$this->model->getAuthGroupInfoById($id));
                $this->display();
            }
        }

        public function rbac()
        {
            $id = I('id', 0, 'intval');
            if (IS_POST) {
                if ($id <= 0) {
                    $this->ajaxReturn(array('error' => 100, 'message' => "不合法请求"));
                }
                $node = I('node');
                arsort($node);
                $data['rules'] = implode(',', $node);
                if (!$this->model->where(array('id' => $id))->save($data)) {
                    $this->ajaxReturn(array('error' => 100, 'message' => "授权失败"));
                }
                $this->ajaxReturn(array('error' => 200, 'message' => "授权成功"));
            } else {
                $authRuleModel = new AuthRuleModel();
                /*查询权限组id*/
                $infoRule = $this->model->getAuthGroupInfoById($id);
                $node = $authRuleModel->getAuthRuleList(['sort', 'id' => 'desc']);
                $this->assign('list',node_merges($node, explode(',', $infoRule['rules'])));
                $this->assign('id',$id);
                $this->display();
            }
        }

        public function del()
        {
            if (($id = I('id', 0, 'intval')) <= 0) {
                $this->ajaxReturn(array('error' => 100, 'message' => "数据格式有误"));
            }
            $status = intval(I('status', 0, 'intval')) == AuthGroupModel::STATUS_ENABLE ? AuthGroupModel::STATUS_DISABLE : AuthGroupModel::STATUS_ENABLE;
            if (!$this->model->where(array('id' => $id))->save(array('status' => $status))) {
                $this->ajaxReturn(array('error' => 100, 'message' => '操作失败'));
            }
            $this->ajaxReturn(array('error' => 200, 'message' => '操作成功'));
        }
    }