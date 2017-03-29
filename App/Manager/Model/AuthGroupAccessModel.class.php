<?php
    namespace Manager\Model;

    use Think\Model;

    /*****
     *        文章模型
     *        editor    zhangxin
     *        date        2015-5-6 13:34:57
     *****/
    class AuthGroupAccessModel extends Model
    {

        /**
         * @return mixed
         */
        public function getList()
        {
            return $this->select();
        }

        /**
         * @param $uid
         * @return mixed
         */
        public function getInfoByUid($uid)
        {
            return $this->where(['uid' => $uid])->find();
        }

    }

    ?>