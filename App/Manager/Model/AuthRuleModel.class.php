<?php
    namespace Manager\Model;

    use Think\Model;

    /*****
     *        节点模型
     *        editor    zhangxin
     *        date        2015-5-6 13:34:57
     *****/
    class AuthRuleModel extends Model
    {
        const STATUS_ENABLE  = "1";
        const STATUS_DISABLE = "2";
        const IS_MENU        = 1;
        const IS_NOT_MENU    = 2;
        public static $MENU_MAP   = [
            self::IS_MENU => '是',
            self::IS_NOT_MENU => '否'
        ];
        public static $STATUS_MAP = [
            self::STATUS_ENABLE => '启用',
            self::STATUS_DISABLE => '禁用'
        ];
        protected     $_validate  = array(
            array('title', 'require', '规则名称必须填写'), //默认情况下用正则进行验证
            array('name', 'require', '规则标识必须填写'), //默认情况下用正则进行验证
            array('name', '', '规则标识已经存在！', 0, 'unique', 1), // 在新增的时候验证name字段是否唯一
            array('url', 'require', 'url必须填写'), //默认情况下用正则进行验证
        );

        /**
         * 获取role列表
         * @param array $order
         * @param array $where
         * @return mixed
         */
        public function getAuthRuleList($order = ['id' => 'desc'], $where = ['status'=>self::STATUS_ENABLE])
        {
            return $this->where($where)->order($order)->select();
        }

        /**
         * @param $id
         * @return mixed
         */
        public function getAuthRuleInfoById($id)
        {
            return $this->where(['id' => $id])->find();
        }

    }

    ?>