<?php

/**
 * Author: helen
 * CreateTime: 2016/4/15 23:12
 * description: PHP--排序函数（数组排序）
 */
class SORT
{
    //属性值：存储传入的数组
    protected $array = array();
    //属性值：数组长度
    protected $length;

    /*
     * SORT类初始化函数
     * @access public
     * @param array $array 传入的需要进行排序的函数
     * @return object $this 对象本身
     * */
    public function __construct(array $array)
    {
        $this->array = $array;
        $this->length = count($array);
        return $this;
    }

    /*
     * 冒泡排序
     * 算法思想：两两比较相邻元素（记录）的关键字，如果反序则交换，直到没有反序的元素（记录）为止
     * 复杂度：时间复杂度：o(n*n)
     * 辅助空间：o(1)
     * 稳定性：稳定
     * @access public
     * @param string $type 排列顺序：升序asc，降序desc;默认升序asc
     * @return array $array 排序完成的数组
     * @return string $exchange_count 排序过程中交换的次数
     * @return string $compare_count 排序过程中比较的次数
     * */
    public function BubbleSort($type = 'asc')
    {
        $array = $this->array;
        $length = $this->length;
        $exchange_count = 0;      //交换次数
        $compare_count = 0;       //比较次数
        $flag = true;             //标记，目的在于减少比较次数
        switch ($type) {
            case 'asc':     //升序排列
                for ($i = 0; $i < $length && $flag; $i++) {      //若flag为true则退出循环
                    $flag = false;
                    for ($j = $length - 2; $j > $i; $j--) {
                        if ($array[$j] > $array[$j + 1]) {
                            $tmp = $array[$j];
                            $array[$j] = $array[$j + 1];
                            $array[$j + 1] = $tmp;
                            $exchange_count++;
                            $flag = true;   //如果有数据交换，则flag为true
                        }
                        $compare_count++;
                    }
                }
                break;
            case 'desc':    //降序排列
                for ($i = 0; $i < $length && $flag; $i++) {          //若flag为true则退出循环
                    $flag = false;
                    for ($j = $length - 2; $j >= $i; $j--) {
                        if ($array[$j] < $array[$j + 1]) {
                            $tmp = $array[$j];
                            $array[$j] = $array[$j + 1];
                            $array[$j + 1] = $tmp;
                            $exchange_count++;
                            $flag = true;   //如果有数据交换，则flag为true
                        }
                        $compare_count++;
                    }
                }
                break;
        }
        return array(
            'array' => $array,
            'exchange_count' => $exchange_count,
            'compare_count' => $compare_count
        );
    }

    /*
     * 简单选择排序
     * 算法思想：通过n-i次关键字间的比较，从n-i+1个记录中选出关键字最小的元素（记录），并和第i（1=<i<=n）个元素（记录）交换之
     * 复杂度：o(n*n)
     * 辅助空间：o(1)
     * 稳定性：稳定
     * @access public
     * @param string $type 排列顺序：升序asc,降序desc;默认升序asc
     * @return array $array 排序完成的数组
     * @return string $exchange_count 排序过程中交换的次数
     * @return string $compare_count 排序过程中比较的次数
     * */
    public function SelectSort($type = 'asc')
    {
        $array = $this->array;
        $length = $this->length;
        $exchange_count = 0;      //交换次数
        $compare_count = 0;       //比较次数
        switch ($type) {
            case 'asc':
                for ($i = 0; $i < $length; $i++) {
                    $min = $i;          //将当前下标定义为最小值下标
                    for ($j = $i + 1; $j < $length; $j++) {   //循环之后的数据
                        if ($array[$min] > $array[$j]) {    //如果有小于当前最小值的关键字
                            $min = $j;                  //将此关键字的下标赋值给min
                        }
                        $compare_count++;
                    }
                    if ($i != $min) {       //若min不等于i，说明找到最小值，交换
                        $tmp = $array[$min];
                        $array[$min] = $array[$i];
                        $array[$i] = $tmp;
                        $exchange_count++;
                    }
                }
                break;
            case 'desc':
                for ($i = 0; $i < $length; $i++) {
                    $max = $i;          //将当前下标定义为最大值下标
                    for ($j = $i + 1; $j < $length; $j++) {   //循环之后的数据
                        if ($array[$max] < $array[$j]) {    //如果有大于当前最da值的关键字
                            $max = $j;                  //将此关键字的下标赋值给max
                        }
                        $compare_count++;
                    }
                    if ($i != $max) {       //若min不等于i，说明找到最大值，交换
                        $tmp = $array[$max];
                        $array[$max] = $array[$i];
                        $array[$i] = $tmp;
                        $exchange_count++;
                    }
                }
                break;
        }
        return array(
            'array' => $array,
            'exchange_count' => $exchange_count,
            'compare_count' => $compare_count
        );
    }

    /*
     * 直接插入排序
     * 算法思想：将一个元素（记录）插入到已经排好序的有序表中，从而得到一个新的，元素（记录）数增1的有序表
     * 复杂度：o(n*n)
     * 辅助空间：o(1)
     * 稳定性：稳定
     * @access public
     * @param string $type 排列顺序：升序asc,降序desc;默认升序asc
     * @return array $array 排序完成的数组
     * @return string $exchange_count 排序过程中交换的次数
     * @return string $compare_count 排序过程中比较的次数
     * */
    public function InsertSort($type = 'asc')
    {
        $array = $this->array;
        $length = $this->length;
        $exchange_count = 0;      //交换次数
        $compare_count = 0;       //比较次数
        switch ($type) {
            case 'asc':
                for ($i = 1; $i < $length; $i++) {
                    if ($array[$i] < $array[$i - 1]) {    //须将$array[$i]插入有序子表
                        $flag = $array[$i];     //设置哨兵
                        for ($j = $i - 1; $array[$j] > $flag && $j >= 0; $j--) {
                            $array[$j + 1] = $array[$j];    //记录后移
                            $compare_count++;
                        }
                        $array[$j + 1] = $flag;   //插入到正确位置
                        $exchange_count++;
                    }
                }
                break;
            case 'desc':
                for ($i = 1; $i < $length; $i++) {
                    if ($array[$i] > $array[$i - 1]) {    //须将$array[$i]插入有序子表
                        $flag = $array[$i];     //设置哨兵
                        for ($j = $i - 1; $array[$j] < $flag && $j >= 0; $j--) {
                            $array[$j + 1] = $array[$j];    //记录后移
                            $compare_count++;
                        }
                        $array[$j + 1] = $flag;   //插入到正确位置
                        $exchange_count++;
                    }
                }
                break;
        }
        return array(
            'array' => $array,
            'exchange_count' => $exchange_count,
            'compare_count' => $compare_count
        );
    }

    /*
     * 希尔排序
     * 算法思想：序列分割--基本有序，然后进行直接插入排序。将相距某个增量的元素(记录)组成一个子序列，保证在子序列中分别进行直接插入排序后得到的结果是基本有序(小的关键字基本在前面，大的关键字基本在后面)
     * 复杂度：o(n*logn)~o(n*n)
     * 辅助空间：o(1)
     * 稳定性：不稳定
     * @access public
     * @param string $type 排列顺序：升序asc,降序desc;默认升序asc
     * @return array $array 排序完成的数组
     * @return string $exchange_count 排序过程中交换的次数
     * @return string $compare_count 排序过程中比较的次数
     * */
    public function ShellSort($type = 'asc')
    {
        $array = $this->array;
        $length = $this->length;
        $exchange_count = 0;      //交换次数
        $compare_count = 0;       //比较次数
        switch ($type) {
            case 'asc':
                for ($gap = $length >> 1; $gap > 0; $gap >>= 1) {
                    for ($i = $gap; $i < $length; $i++) {
                        $temp = $array[$i];
                        for ($j = $i - $gap; $j >= 0 && $array[$j] > $temp; $j -= $gap) {
                            $array[$j + $gap] = $array[$j];
                            $compare_count++;
                        }
                        $array[$j + $gap] = $temp;
                        $exchange_count++;
                    }
                }
                break;
            case 'desc':
                for ($gap = $length >> 1; $gap > 0; $gap >>= 1) {
                    for ($i = $gap; $i < $length; $i++) {
                        $temp = $array[$i];
                        for ($j = $i - $gap; $j >= 0 && $array[$j] < $temp; $j -= $gap) {
                            $array[$j + $gap] = $array[$j];
                            $compare_count++;
                        }
                        $array[$j + $gap] = $temp;
                        $exchange_count++;
                    }
                }
                break;
        }
        return array(
            'array' => $array,
            'exchange_count' => $exchange_count,
            'compare_count' => $compare_count
        );
    }

    /*
     * 堆排序
     * 算法思想：将待排序的序列构造成一个大顶堆。此时，整个序列的最大值就是堆顶的根节点。将它移走，然后将剩余元素重新构造成一个堆，再移走根节点，以此类推。
     * 复杂度：o(n*logn)
     * 辅助空间：o(1)
     * 稳定性：不稳定
     * @access public
     * @param string $type 排列顺序：升序asc,降序desc;默认升序asc
     * @return array $array 排序完成的数组
     * @return string $exchange_count 排序过程中交换的次数
     * @return string $compare_count 排序过程中比较的次数
     * */
    public function HeapSort($type = 'asc')
    {
        $array = $this->array;
        $length = $this->length;
        $exchange_count = 0;      //交换次数
        $compare_count = 0;       //比较次数
        switch ($type) {
            case 'asc':
                $array = self::heap_sort_asc($array);
                break;
            case 'desc':
                $array = self::heap_sort_desc($array);
                break;
        }
        return array(
            'array' => $array,
            'exchange_count' => $exchange_count,
            'compare_count' => $compare_count
        );
    }

    protected function swap(&$x, &$y)
    {
        $t = $x;
        $x = $y;
        $y = $t;
    }

    protected function max_heapify_asc(&$arr, $start, $end)
    {
        //建立父節點指標和子節點指標
        $dad = $start;
        $son = $dad * 2 + 1;
        if ($son >= $end)//若子節點指標超過範圍直接跳出函數
            return;
        if ($son + 1 < $end && $arr[$son] < $arr[$son + 1])//先比較兩個子節點大小，選擇最大的
            $son++;
        if ($arr[$dad] <= $arr[$son]) {//如果父節點小於子節點時，交換父子內容再繼續子節點和孫節點比較
            self::swap($arr[$dad], $arr[$son]);
            self::max_heapify_asc($arr, $son, $end);
        }
    }

    protected function heap_sort_asc($arr)
    {
        $len = count($arr);
        //初始化，i從最後一個父節點開始調整
        for ($i = $len / 2 - 1; $i >= 0; $i--)
            self::max_heapify_asc($arr, $i, $len);
        //先將第一個元素和已排好元素前一位做交換，再從新調整，直到排序完畢
        for ($i = $len - 1; $i > 0; $i--) {
            self::swap($arr[0], $arr[$i]);
            self::max_heapify_asc($arr, 0, $i);
        }
        return $arr;
    }

    protected function max_heapify_desc(&$arr, $start, $end)
    {
        //建立父節點指標和子節點指標
        $dad = $start;
        $son = $dad * 2 + 1;
        if ($son >= $end)//若子節點指標超過範圍直接跳出函數
            return;
        if ($son + 1 < $end && $arr[$son] > $arr[$son + 1])//先比較兩個子節點大小，選擇最大的
            $son++;
        if ($arr[$dad] >= $arr[$son]) {//如果父節點小於子節點時，交換父子內容再繼續子節點和孫節點比較
            self::swap($arr[$dad], $arr[$son]);
            self::max_heapify_desc($arr, $son, $end);
        }
    }

    protected function heap_sort_desc($arr)
    {
        $len = count($arr);
        //初始化，i從最後一個父節點開始調整
        for ($i = $len / 2 - 1; $i >= 0; $i--)
            self::max_heapify_desc($arr, $i, $len);
        //先將第一個元素和已排好元素前一位做交換，再從新調整，直到排序完畢
        for ($i = $len - 1; $i > 0; $i--) {
            self::swap($arr[0], $arr[$i]);
            self::max_heapify_desc($arr, 0, $i);
        }
        return $arr;
    }

    /*
     * 归并排序
     * 算法思想：假设初始具有n个元素，每个子序列的长度为2，然后两两归并，得到下一个子序列，继续两两归并，以此类推。
     * 复杂度：o(n*logn)
     * 辅助空间：o(n)
     * 稳定性：稳定
     * @access public
     * @param string $type 排列顺序：升序asc,降序desc;默认升序asc
     * @return array $array 排序完成的数组
     * @return string $exchange_count 排序过程中交换的次数
     * @return string $compare_count 排序过程中比较的次数
     * */
    public function MergeSort($type = 'asc')
    {
        $array = $this->array;
        $length = $this->length;
        $exchange_count = 0;      //交换次数
        $compare_count = 0;       //比较次数
        switch ($type) {
            case 'asc':
                $array = self::merge_sort_asc($array);
                break;
            case 'desc':
                $array = self::merge_sort_desc($array);
                break;
        }
        return array(
            'array' => $array,
            'exchange_count' => $exchange_count,
            'compare_count' => $compare_count
        );
    }

    protected function merge_sort_asc($arr)
    {
        $len = count($arr);
        if ($len <= 1) {
            return $arr;
        } else {
            $half = ($len >> 1) + ($len & 1);
            $arr2d = array_chunk($arr, $half);
            $left = self::merge_sort_asc($arr2d[0]);
            $right = self::merge_sort_asc($arr2d[1]);
            while (count($left) && count($right)) {
                if ($left[0] < $right[0]) {
                    $reg[] = array_shift($left);
                } else {
                    $reg[] = array_shift($right);
                }
            }
        }
        return array_merge($reg, $left, $right);
    }

    protected function merge_sort_desc($arr)
    {
        $len = count($arr);
        if ($len <= 1) {
            return $arr;
        } else {
            $half = ($len >> 1) + ($len & 1);
            $arr2d = array_chunk($arr, $half);
            $left = self::merge_sort_desc($arr2d[0]);
            $right = self::merge_sort_desc($arr2d[1]);
            while (count($left) && count($right)) {
                if ($left[0] > $right[0]) {
                    $reg[] = array_shift($left);
                } else {
                    $reg[] = array_shift($right);
                }
            }
        }
        return array_merge($reg, $left, $right);
    }

    /*
     * 快速排序
     * 算法思想：通过一趟排序将待排记录分割成独立的两部分，其中一部分记录的关键字均比另一部分的关键字小，则可对这两部分记录继续进行排序，以达到整个序列有序的目的。
     * 复杂度：o(n*logn)
     * 辅助空间：o(logn)~o(n)
     * 稳定性：不稳定
     * @access public
     * @param string $type 排列顺序：升序asc,降序desc;默认升序asc
     * @return array $array 排序完成的数组
     * @return string $exchange_count 排序过程中交换的次数
     * @return string $compare_count 排序过程中比较的次数
     * */
    public function QuickSort($type = 'asc')
    {
        $array = $this->array;
        $length = $this->length;
        static $exchange_count = 0;      //交换次数
        static $compare_count = 0;       //比较次数
        switch ($type) {
            case 'asc':
                $array = self::quick_sort_asc($array);
                break;
            case 'desc':
                $array = self::quick_sort_desc($array);
                break;
        }
        return array(
            'array' => $array,
            'exchange_count' => $exchange_count,
            'compare_count' => $compare_count
        );
    }

    protected function quick_sort_asc($arr)
    {
        $len = count($arr);
        static $compare_count = 0;       //比较次数
        if ($len <= 1) {
            return $arr;
        } else {
            $left = $right = array();
            $mid_value = $arr[0];
            for ($i = 1; $i < $len; $i++) {
                if ($arr[$i] < $mid_value) {
                    $left[] = $arr[$i];
                } else {
                    $right[] = $arr[$i];
                }
                $compare_count++;
            }
        }
        return array_merge(self::quick_sort_asc($left), (array)$mid_value, self::quick_sort_asc($right));
    }

    protected function quick_sort_desc($arr)
    {
        $len = count($arr);
        static $compare_count = 0;       //比较次数
        if ($len <= 1) {
            return $arr;
        } else {
            $left = $right = array();
            $mid_value = $arr[0];
            for ($i = 1; $i < $len; $i++) {
                if ($arr[$i] > $mid_value) {
                    $left[] = $arr[$i];
                } else {
                    $right[] = $arr[$i];
                }
                $compare_count++;
            }
        }
        return array_merge(self::quick_sort_desc($left), (array)$mid_value, self::quick_sort_desc($right));
    }
    /*
     * 排序算法中数组元素交换函数
     * @access protected
     * @param array $array 需要元素交换的数组
     * @param interger $i 需要元素交换的数组下标
     * @param interger $j 需要元素交换的数组下标
     * @return void
     * */
    /*protected function swap(array $array, $i, $j)
    {
        $tmp = $array[$i];
        $array[$i] = $array[$j];
        $array[$j] = $tmp;
    }*/
}