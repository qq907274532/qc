<?php
    namespace Manager\Controller;

    use Manager\Model\AdminUserModel;
    use Think\Controller;

    class LoginController extends Controller
    {
        private $model;
        const ERROR_NUMBER = 100;
        const SUCCESS_NUMBER = 200;
        public function _initialize()
        {


        }

        public function index()
        {
            if (IS_POST) {

                $this->model = new AdminUserModel();
                if (empty($verify = trim(I('verify')))) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => '验证码不能为空'));
                }
                if (!$this->model->check_verify($verify)) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => '验证码不正确'));
                }
                if (empty($username = trim(I('username')))) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => '用户名不能为空'));
                }
                if (empty($password = trim(I('password')))) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => '密码不能为空'));
                }

                if (empty($userInfoDetail = $this->model->userInfo(array('username' => $username)))) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => '用户名或密码不正确'));
                }
                if (!checkPassword($userInfoDetail['password'], $password)) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => '用户名或密码不正确'));
                }
                if ($userInfoDetail['status'] == AdminUserModel::STATUS_DISABLE) {
                    $this->ajaxReturn(array('error' => self::ERROR_NUMBER, 'message' => '该用户已被禁用'));
                }
                $data = array(
                    'last_time' => date('Y-m-d H:i:s', time()),
                    'last_ip' => $_SERVER['REMOTE_ADDR'],
                );

                $this->model->where(array('id' => $userInfoDetail['id']))->save($data);
                session('id', $userInfoDetail['id']);
                session('name', $userInfoDetail['username']);
                session('email', $userInfoDetail['email']);
                $this->ajaxReturn(array('error' => self::SUCCESS_NUMBER, 'message' => '登录成功'));
            } else {
                $this->display();
            }

        }

        public function verify()
        {
            $config = array(
                'fontSize' => 30,    // 验证码字体大小
                'length' => 4,     // 验证码位数
                'useNoise' => false, // 关闭验证码杂点
            );
            $Verify = new \Think\Verify($config);
            $Verify->entry();
        }

        /**
         * 退出
         */
        public function logout()
        {
            session_unset();
            session_destroy();
            $this->redirect('Login/index');
        }

    }