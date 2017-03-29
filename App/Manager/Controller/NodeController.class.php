<?php
    namespace Manager\Controller;

    use Manager\Model\AuthRuleModel;

    class NodeController extends AdminBaseController
    {
        private $model;
        private $order;

        public function __construct()
        {
            parent::__construct();
            $this->model = new AuthRuleModel();
        }

        public function index()
        {
            $list = $this->model->order(array('sort', 'id' => 'desc'))->select();
            foreach ($list as $key => $value) {
                $list[$key]['nodeStatus'] = AuthRuleModel::$STATUS_MAP[$value['status']];
            }
            $this->list = node_merges($list);
            $this->display();
        }

        public function add()
        {
            if (IS_POST) {
                $data = I('post.');
                if (!is_numeric($data['sort'])) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'msg' => '排序必须是数字'));
                }
                if (intval($data['menu']) < 0) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'msg' => '请选择是否是菜单'));
                }
                $data['create_time']=date('Y-m-d H:i:s');
                if (!$this->model->create($data)) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'msg' => $this->model->getError()));
                } else {
                    if (!$this->model->add()) {
                        $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'msg' => '添加失败'));
                    }
                    $this->ajaxReturn(array('error' => self::SUCCESS_NUMBER, 'msg' => '添加成功'));
                }

            } else {
                $list = $this->model->where(array('status' => AuthRuleModel::STATUS_ENABLE))->order(array('sort', 'id' => 'desc'))->select();
                $this->assign('list', node_merges($list));
                $this->assign('menu', AuthRuleModel::$MENU_MAP);
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
                if (!is_numeric($data['sort'])) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => "排序必须是数字"));
                }
                if (intval($data['menu']) < 0) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => "请选择是否是菜单"));
                }
                if (empty($data['icon'])) {
                    unset($data['icon']);
                }
                unset($data['id']);
                if (!$this->model->create()) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => $this->model->getError()));
                }
                if (!$this->model->where(array('id' => $id))->save($data)) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => "修改失败"));
                }
                $this->ajaxReturn(array('error' => self::SUCCESS_NUMBER, 'message' => "修改成功"));
            } else {
                if ($id <= 0) {
                    $this->error("不合法请求", U('Node/index'));
                }

                $this->assign('menu',AuthRuleModel::$MENU_MAP);
                $this->assign('info',$this->model->where(array('id' => $id))->find());
                $list = $this->model->where(array('status' => AuthRuleModel::STATUS_ENABLE))->order(array('sort', 'id' => 'desc'))->select();
                $this->assign('list', node_merges($list));
                $this->display();
            }
        }

        public function del()
        {
            if (($id = I('id', 0, 'intval')) <= 0) {
                $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => "数据格式有误"));
            }
            $result = $this->model->where(array('parent_id' => $id))->select();
            if (!empty($result)) {
                $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => "该分类下面有子类。请先删除子类"));
            }
            $status = intval(I('status', 0, 'intval')) == AuthRuleModel::STATUS_ENABLE ? AuthRuleModel::STATUS_DISABLE : AuthRuleModel::STATUS_ENABLE;
            if (!$this->model->where(array('id' => $id))->save(array('status' => $status))) {
                $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => '操作失败'));
            }
            $this->ajaxReturn(array('error' => self::SUCCESS_NUMBER, 'message' => '操作成功'));
        }
    }