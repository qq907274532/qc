<?php

    namespace Common\Model;

    use Think\Model;

    /*****
     *        文章模型
     *        editor    zhangxin
     *        date        2015-5-6 13:34:57
     *****/
    class MessagesModel extends Model
    {


        const STATUS_ENABLE  = "1";
        const STATUS_DISABLE = "2";
        const READ_ENABLE    =2;//已读
        const READ_DISABLE    =1;//未读
        protected     $_validate  = array(
            //array('name', 'require', '物流名称必须填写'),  // 都有时间都验证
        );
        public static $STATUS_MAP = array(
            self::STATUS_ENABLE => '启用',
            self::STATUS_DISABLE => '禁用',
        );
        public static $READ_MAP=[
            self::READ_DISABLE=>'未读',
            self::READ_ENABLE =>'已读'
        ];

        /**
         * 获取留言数据
         * @param $id
         * @return mixed
         */
        public function getMessageInfoById($id){
            return $this->where(['id'=>$id])->find();
        }


    }

    ?>