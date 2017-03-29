<?php
    namespace Manager\Controller;

    use Common\Model\LogModel;
    use Think\Controller;

    class AdminBaseController extends Controller
    {
        private $Auth;
        private $name;
        const ERROR_NUMBER = 100;
        const SUCCESS_NUMBER = 200;

        public function __construct()
        {

            parent::__construct();
            if (!isset($_SESSION['id'])) {
                $this->redirect('Login/index');
            }
            $this->Auth = new \Library\Auth();
            $this->name = MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME;
            $this->checkAuth($this->name, $_SESSION['id']);
            //self::addLog($_SESSION['id'],MODULE_NAME,CONTROLLER_NAME,ACTION_NAME,I('post.'),I('get.'));
            /*第三级菜单pid*/
            $openId = $this->Auth->getId($this->name);
            $this->assign('openFirstId', $this->Auth->getFirstId($openId));
            $this->assign('open', $openId);
            $this->assign('menus', $this->Auth->getRuleListById($_SESSION['id'],['sort'=>'asc']));

        }

        /**
         * @param $uid  //用户id
         * @param $module   //模块
         * @param $controller   //控制器
         * @param $action        //方法
         * @param $postValue      //post提交
         * @param $getValue       //get提交
         */
        static public function addLog($uid,$module,$controller,$action,$postValue,$getValue){
            $data=[
                'uid'=>$uid,
                'module'=>$module,
                'controller'=>$controller,
                'action'=>$action,
                'post_value'=>$postValue,
                'get_value'=>$getValue,
            ];
            $logModel= new LogModel();
            $logModel->addLog($data);
        }
        /**
         * @param $auth
         * @param $id
         */
        public function checkAuth($auth, $id)
        {
            if (!in_array(CONTROLLER_NAME, C('NOT_AUTH_CONTROLLER'))) {
                if (!$this->Auth->check($auth, $id)) {
                    $this->error('没有权限访问本页面!', U('Index/index'));
                }
            }
        }


        //公共的分页 只适合单表查询
        /**
         * @param $model
         * @param array $order
         * @param array $where
         * @param string $pageAll
         * @return array
         */
        public function page_com($model, $order = [], $where = [], $pageAll = '20')
        {

            $count = $model->where($where)->count();// 查询满足要求的总记录数
            $Page = new \Library\Page($count, $pageAll);
            //$Page       = new \Think\Page($count,$pageAll);// true实例化分页类 传入总记录数和每页显示的记录数(25)
            $show = $Page->show();// 分页显示输出
            // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
            $list = $model->where($where)->order($order)->limit($Page->firstRow . ',' . $Page->listRows)->select();
            $data = array(
                'list' => $list,
                'page' => $show
            );
            return $data;
        }
    }