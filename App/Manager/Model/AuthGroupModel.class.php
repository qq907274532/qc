<?php
    namespace Manager\Model;

    use Think\Model;

    /*****
     *        权限组模型
     *        editor    zhangxin
     *        date        2015-5-6 13:34:57
     *****/
    class AuthGroupModel extends Model
    {
        const STATUS_ENABLE  = "1";
        const STATUS_DISABLE = "2";
        public static $STATUS_MAP = array(
            self::STATUS_ENABLE => '启用',
            self::STATUS_DISABLE => '禁用',
        );
        protected     $_validate  = array(
            array('title', 'require', '角色名称必须填写'), //默认情况下用正则进行验证
            array('remark', 'require', '角色描述必须填写'), //默认情况下用正则进行验证

        );

        /**
         * @param $id
         * @return string
         */
        public function getAuthGroupInfoById($id)
        {
            return $this->where(['id' => $id])->find();
        }

        /**
         * 获取权限组
         * @param array $order
         * @param array $where
         * @return mixed
         */
        public function getAuthGroupList($order = ['id' => 'desc'], $where = [])
        {
            return $this->where($where)->order($order)->select();
        }

    }

    ?>