<?php

    namespace Common\Model;

    use Think\Model;

    /*****
     *        文章模型
     *        editor    zhangxin
     *        date        2015-5-6 13:34:57
     *****/
    class JobApplyModel extends Model
    {


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