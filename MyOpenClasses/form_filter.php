<?php
/**
 * Author: helen
 * CreateTime: 2016/4/11 9:04
 * description: ��������--�û��������룬���䣬�ֻ���
 */
/*
 * ������ PHP��غ���
 *      ������	                           ����	                          ����
 * htmlspecialchars()	        ���롢��˫���š����ں�С�ںŻ���HTML��ʽ	  &ת��&amp; "ת��&quot;' ת��&#039;<ת��&lt;>ת��&gt;
 * htmlentities()	            �����ַ���ת��HTML��ʽ	                  ������htmlspecialchars�ַ��⣬������˫�ֽ��ַ���ʾ�ɱ���ȡ�
 * addslashes()	                ��˫���š���б�߼�NULL���Ϸ�б��ת��	      ���ĵ��ַ����������� (')��˫���� (")����б�� backslash (/) �Լ����ַ�NULL��
 * stripslashes()	            ȥ����б���ַ�	                          ȥ���ַ����еķ�б���ַ�����������������б�ߣ���ȥ��һ��������һ������ֻ��һ����б�ߣ���ֱ��ȥ����
 * quotemeta()	                �������÷���	                          ���ַ����к��� . // + * ? [ ^ ] ( $ ) ���ַ���ǰ����뷴б�� "/" ���š�
 * nl2br()	                    �������ַ�ת��<br>
 * strip_tags()	                ȥ��HTML��PHP���	                      ȥ���ַ������κ� HTML��Ǻ�PHP��ǣ�������Ƿ��֮������ݡ�ע������ַ���HTML��PHP��ǩ���ڴ���Ҳ�᷵�ش���
 * mysql_real_escape_string()	ת��SQL�ַ����е������ַ�	              ת�� /x00  /n  /r  �ո�  /  '  " /x1a����Զ��ֽ��ַ��������Ч��mysql_real_escape_string���ж��ַ�����mysql_escape_string���ÿ��ǡ�
 * trim()                       �����Ƴ��ַ�������Ŀհ��ַ�������Ԥ�����ַ���
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