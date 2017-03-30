<?php

    namespace User\Model;

    use Think\Model;

    /*****
     *        文章模型
     *        editor    zhangxin
     *        date        2015-5-6 13:34:57
     *****/
    class UserModel extends Model
    {


        /**
         * 获取用户
         * @param $id
         * @return mixed
         */
        public function getUserById($id){
            $map['id']=['in',$id];
            return $this->where($map)->select();
        }



    }

    ?>