<?php
    $a = 10;
    $b = 200;
    //加法
    $resultAdd = bcadd($a, $b, 10);
    //减法
    $resultSub=bcsub($a,$b,10);
    //乘法
    $resultMul=bcmul($a,$b,10);
    //除法
    $resultDiv=bcdiv($a,$b,10);  

    print_r($resultDiv);
?>