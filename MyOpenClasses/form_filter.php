<?php
/**
 * Author: helen
 * CreateTime: 2016/4/11 9:04
 * description: 表单过滤类--用户名，密码，邮箱，手机号
 */
/*
 * 表单过滤 PHP相关函数
 *      函数名	                           释义	                          介绍
 * htmlspecialchars()	        将与、单双引号、大于和小于号化成HTML格式	  &转成&amp; "转成&quot;' 转成&#039;<转成&lt;>转成&gt;
 * htmlentities()	            所有字符都转成HTML格式	                  除上面htmlspecialchars字符外，还包括双字节字符显示成编码等。
 * addslashes()	                单双引号、反斜线及NULL加上反斜线转义	      被改的字符包括单引号 (')、双引号 (")、反斜线 backslash (/) 以及空字符NULL。
 * stripslashes()	            去掉反斜线字符	                          去掉字符串中的反斜线字符。若是连续二个反斜线，则去掉一个，留下一个。若只有一个反斜线，就直接去掉。
 * quotemeta()	                加入引用符号	                          将字符串中含有 . // + * ? [ ^ ] ( $ ) 等字符的前面加入反斜线 "/" 符号。
 * nl2br()	                    将换行字符转成<br>
 * strip_tags()	                去掉HTML及PHP标记	                      去掉字符串中任何 HTML标记和PHP标记，包括标记封堵之间的内容。注意如果字符串HTML及PHP标签存在错误，也会返回错误。
 * mysql_real_escape_string()	转义SQL字符串中的特殊字符	              转义 /x00  /n  /r  空格  /  '  " /x1a，针对多字节字符处理很有效。mysql_real_escape_string会判断字符集，mysql_escape_string则不用考虑。
 * trim()                       函数移除字符串两侧的空白字符或其他预定义字符。
 * */
class FormFliter{
    private $username;
    private $password;
    private $email;
    private $phone;
    function __construct($username=null,$password=null,$email=null,$phone=null){
        $this->username = $username;
        $this->password = $password;
        $this->email    = $email;
        $this->phone    = $phone;
        self::validate();
    }
    function validate(){
        self::username_fliter();
        self::password_fliter();
        self::email_fliter();
        self::phone_fliter();
    }
    function username_fliter(){

    }
    function password_fliter(){

    }
    function email_fliter(){

    }
    function phone_fliter(){

    }
}