<?php

    namespace Common\Model;

    use Think\Model;

    /*****
     *        文章模型
     *        editor    zhangxin
     *        date        2015-5-6 13:34:57
     *****/
    class LoginLogModel extends Model
    {

        /**
         * @param mixed|string $userId   //用户id
         * @param array $ip               //ip
         * @param bool $messages
         * @return mixed
         */
        public function addLog($userId,$ip,$messages) {
            $data=[
                'user_id'=>$userId,
                'logip'=>$ip,
                'message'=>$messages,
                'create_time'=>date('Y-m-d H:i:s')
            ];
            return $this->add($data);
        }


    }

    ?>