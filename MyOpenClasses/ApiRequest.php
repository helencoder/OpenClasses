<?php
/**
 * Author: helen
 * CreateTime: 2016/4/11 11:08
 * description: API���÷���--GET��POST������װ
 */
class ApiRequest{
    private $url;
    private $data;
    function __construct($url,$data=null){
        $this->url  = $url;
        $this->data = $data;
    }
}