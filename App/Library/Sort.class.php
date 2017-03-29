<?php
    namespace Library;
    class Sort
    {

        /**
         * 冒泡
         * @param $arr
         * @return bool
         */
        static public function getBubbleSort($arr)
        {
            $count = count($arr);
            if ($count <= 0) return false;

            for ($i = 1; $i < $count; $i++) {
                for ($j = 0; $j < $count - $i; $j++) {
                    if ($arr[$j] > $arr[$j + 1]) {
                        $temp = $arr[$j + 1];
                        $arr[$j + 1] = $arr[$j];
                        $arr[$j] = $temp;
                    }
                }
            }
            return $arr;
        }

        /**
         * 插入
         * @param $arr
         * @return mixed
         */
        static public function getInsertSort($arr)
        {
            $count = count($arr);
            for ($i = 1; $i < $count; $i++) {
                $tempValue = $arr[$i];
                for ($j = $i - 1; $j >= 0; $j--) {
                    if ($tempValue < $arr[$j]) {
                        $arr[$j + 1] = $arr[$j];
                        $arr[$j] = $tempValue;
                    } else {
                        break;
                    }
                }
            }
            return $arr;
        }

        /**
         * 选择
         * @param $arr
         * @return mixed
         */
        static public function getSelectSort($arr)
        {
            $count = count($arr);
            for ($i = 0; $i < $count; $i++) {
                $minVal = $arr[$i];
                $minIndex = $i;
                for ($j = $i + 1; $j < $count; $j++) {
                    if ($minVal > $arr[$j]) {
                        $minVal = $arr[$j];
                        $minIndex = $j;
                    }
                }
                $tempValue = $arr[$i];
                $arr[$i] = $arr[$minIndex];
                $arr[$minIndex] = $tempValue;

            }

            return $arr;
        }

        /**
         * 快速
         * @param $arr
         * @return array
         */
        static public function getQuickSort($arr)
        {
            $count = count($arr);
            if ($count <= 1) {
                return $arr;
            }
            $baseNum = $arr[0];
            $leftArray = [];   //小于标尺
            $rightArray = [];   //大于标尺
            for ($i = 1; $i < $count; $i++) {
                if ($baseNum > $arr[$i]) {
                    $leftArray[] = $arr[$i];
                } else {
                    $rightArray[] = $arr[$i];
                }
            }
            $leftArray = self::getQuickSort($leftArray);
            $rightArray = self::getQuickSort($rightArray);
            return array_merge($leftArray, array($baseNum), $rightArray);
        }

        /**
         * 二分查找
         * @param $arr //数组
         * @param $target //要查找的值
         * @return bool|float
         */
        static public function getBinSearch($arr, $target)
        {
            $low = 0;
            $high = count($arr) - 1;
            while ($low <= $high) {
                $mid = floor(($low + $high) / 2);
                #找到元素
                if ($arr[$mid] == $target) return $mid;
                #中元素比目标大,查找左部
                if ($arr[$mid] > $target) $high = $mid - 1;
                #重元素比目标小,查找右部
                if ($arr[$mid] < $target) $low = $mid + 1;
            }
            #查找失败
            return -1;
        }

    }



    ?>