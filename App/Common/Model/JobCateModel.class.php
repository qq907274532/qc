<?php

    namespace Common\Model;

    use Think\Model;

    /*****
     *        文章模型
     *        editor    zhangxin
     *        date        2015-5-6 13:34:57
     *****/
    class JobCateModel extends Model
    {


        const STATUS_ENABLE  = 1;
        const STATUS_DISABLE = 2;
        protected     $_validate  = array(
            array('name', 'require', '职位类别名称必须填写'),  // 都有时间都验证
        );
        public static $STATUS_MAP = array(
            self::STATUS_ENABLE => '启用',
            self::STATUS_DISABLE => '禁用',
        );


        /**
         * 获取留言数据
         * @param $id
         * @return mixed
         */
        public function getJobCateInfoById($id){
            return $this->where(['id'=>$id])->find();
        }

        /**
         * 查询职位类别列表
         * @param array $where
         * @param array $order
         * @return mixed
         */
        public function getJobCateList($where=[],$order=['id'=>'desc']){
            return $this->where($where)->order($order)->select();
        }


    }

    ?>