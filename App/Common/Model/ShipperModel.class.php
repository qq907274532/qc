<?php

    namespace Common\Model;

    use Think\Model;

    /*****
     *        文章模型
     *        editor    zhangxin
     *        date        2015-5-6 13:34:57
     *****/
    class ShipperModel extends Model
    {


        const STATUS_ENABLE  = "1";
        const STATUS_DISABLE = "2";
        protected     $_validate  = array(
            array('name', 'require', '物流名称必须填写'),  // 都有时间都验证
        );
        public static $STATUS_MAP = array(
            self::STATUS_ENABLE => '启用',
            self::STATUS_DISABLE => '禁用',
        );

        /**
         * 获取物流数据
         * @param $id
         * @return mixed
         */
        public function getShipperInfoById($id){
            return $this->where(['id'=>$id])->find();
        }


    }

    ?>