<?php

    namespace Common\Model;

    use Think\Model;

    /*****
     *        文章模型
     *        editor    zhangxin
     *        date        2015-5-6 13:34:57
     *****/
    class JobModel extends Model
    {


        const STATUS_ENABLE  = 1;
        const STATUS_DISABLE = 2;

        protected     $_validate  = array(
            array('title', 'require', '职位名称必须填写'),  // 都有时间都验证
            array('num', 'require', '招聘人数必须填写'),  // 都有时间都验证
            array('address', 'require', '工作地点必须填写'),  // 都有时间都验证
            array('description', 'require', '职位描述必须填写'),  // 都有时间都验证
            array('require', 'require', '职位要求必须填写'),  // 都有时间都验证
            array('endtime', 'require', '截止时间必须填写'),  // 截止时间必须填写
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
        public function getJobInfoById($id){
            return $this->where(['id'=>$id])->find();
        }



    }

    ?>