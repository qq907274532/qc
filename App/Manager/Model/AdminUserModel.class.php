<?php
namespace Manager\Model;
use Think\Model;
/*****
 *		文章模型
 *		editor	zhangxin
 *		date		2015-5-6 13:34:57
 *****/
class AdminUserModel extends Model {
	

	const STATUS_ENABLE="1";
	const STATUS_DISABLE="2";
	protected $_validate = array(
     array('username','require','管理员名称必须填写'),  // 都有时间都验证
     array('email','require','管理员名称必须填写'),  // 都有时间都验证
     array('username','','管理员名称已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
     array('password','require','密码必须填写'),  // 只在登录时候验证
     array('repassword','password','确认密码和密码不一致',0,'confirm'), // 验证确认密码是否和密码一致
   );
	public static $STATUS_MAP=array(
		self::STATUS_ENABLE=>'启用',
		self::STATUS_DISABLE=>'禁用',
		);

    /**
     * 查询用户是否存在
     * @param $where
     * @return mixed
     */
	public function userInfo($where){
		$userInfo=$this->where($where)->find();
		return $userInfo;
	}

    /**
     * 获取管理员列表
     * @return mixed
     */
	public function getListByStatus(){
        $result=$this->where(['status'=>self::STATUS_ENABLE])->select();
        return $result;
    }

    /**
     * 验证验证码是否正确
     * @param $code
     * @param string $id
     * @return bool
     */
	public function check_verify($code, $id = ''){
      $verify = new \Think\Verify();
      return $verify->check($code, $id);
    }
	
    /**
     * @param $id
     * @return mixed
     */
    public function getAdminUserInfoById($id){
        return $this->where(['id'=>$id])->find();
    }


}
?>