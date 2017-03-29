<?php
    /**
     * @param $node
     * @param string $access
     * @param int $pid
     * @return array
     */
    function node_merges($node,$access='',$pid=0){
        $arr=array();
        foreach ($node as $v) {
            if(is_array($node)){
                $v['access']=in_array($v['id'], $access)?1:0;
            }
            if($v['parent_id']==$pid){
                $v['child']=node_merges($node,$access,$v['id']);
                if (empty($v['child'])) {
                    $v['show'] = 0;
                } else {
                    $v['show'] = 1;
                }
                $arr[]=$v;
            }
        }
        return $arr;
    }

    /**
     * @param $arg
     * @param string $logName
     */
    function logs($arg, $logName = 'debug')
    {

        $logName = $logName ? $logName : 'wanglibao';//日志名称
        if(!is_dir(__APP_LOGS_PATH__)){
            mkdir(__APP_LOGS_PATH__, 0777, true);
        }

        $fp = fopen(__APP_LOGS_PATH__ . '/' . $logName . '.log.' . date('Ymd'), 'a');

        $traces = debug_backtrace();
        $logMsg = 'FILE:' . basename($traces[0]['file']) . PHP_EOL;
        $logMsg .= 'FUNC:' . $traces[1]['function'] . PHP_EOL;
        $logMsg .= 'LINE:' . $traces[0]['line'] . PHP_EOL;

        if (is_string($arg)) {
            $logMsg .= 'ARGS:' . $arg . PHP_EOL;
        } else {
            $logMsg .= 'ARGS:' . var_export($arg, true) . PHP_EOL;
        }
        $logMsg .= 'DATETIME:' . date('Y-m-d H:i:s') . PHP_EOL . PHP_EOL;

        fwrite($fp, $logMsg);
        fclose($fp);
    }

    /**
     * 验证邮箱格式
     * @param $email
     * @return bool
     */
    function checkEmail($email){
        $pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
        if ( preg_match( $pattern, $email ) ){
             return true;
        }else{
            return false;
        }
    }
    /**
     * 生成商户唯一订单id
     *
     * @return string
     */
    function generateOrderId()
    {
        $tmp = str_replace('.', '', microtime(true)); //毫秒

        return str_pad($tmp, 15, '0') . mt_rand(1000, 9999);
    }

    /**
     * 检验django密码
     * @param $storePassword
     * @param $password
     * @return bool
     */
    function checkPassword($storePassword, $password)
    {
        list($algorithm, $iterations, $salt, $hash) = explode('$', $storePassword, 4);
        $newHash = base64_encode(hash_pbkdf2("sha256", $password, $salt, $iterations, 0, true));
        if (strcmp($newHash, $hash) !== 0) {
            return false;
        } else {
            return true;
        }

    }

    /**
     * 创建django密码
     *
     * @param $password 明文密码
     *
     * @return string
     */
    function makePassword($password)
    {
        $salt = randomChar(12);
        $iterations = 12000;
        $hash = base64_encode(hash_pbkdf2("sha256", $password, $salt, $iterations, 0, true));
        return "pbkdf2_sha256\$" . $iterations . "\$" . $salt . "\$" . $hash;
    }
    /**
     * 随机密令
     *
     * @param $length
     *
     * @return null|string
     */
    function randomChar($length)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[rand(0, $max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }
        return $str;
    }