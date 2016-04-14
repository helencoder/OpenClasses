<?php
/**
 * Author: helen
 * CreateTime: 2016/4/11 10:39
 * description: ΢��ҳ����Ȩ--(JS-SDKʹ��Ȩ��ǩ���㷨)
 */
class JSSDK{
    private $appId;
    private $appSecret;

    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }
    /*
     * ��ȡaccess_token
     * (��Ҫ���棬���������ݿ�洢,��ҪƵ��ˢ�»�ȡ)
     * http����ʽ: GET  https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET
     * �ӿ��������
     *  ����	     �Ƿ����	       ˵��
        grant_type	��	��ȡaccess_token��дclient_credential
        appid	    ��	�������û�Ψһƾ֤
        secret	    ��	�������û�Ψһƾ֤��Կ����appsecret
     * �ӿڷ���˵��
     * {"access_token":"ACCESS_TOKEN","expires_in":7200}    access_token	��ȡ����ƾ֤  expires_in	ƾ֤��Чʱ�䣬��λ����
     * �ӿڴ���˵��
     * {"errcode":40013,"errmsg":"invalid appid"}
     * */
    private function getAccessToken(){
        $appId = $this->appId;
        $appSecret = $this->appSecret;
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appId.'&secret='.$appSecret;
        $res = $this->api_request($url);
        if(isset($res->access_token)){
            return array(
                'errcode'       =>0,
                'errmsg'        =>'success',
                'access_token'  =>$res->access_token,
                'expires_in'    =>$res->expires_in
            );
        }else{
            return array(
                'errcode'       =>$res->errcode,
                'errmsg'        =>$res->errmsg,
                'access_token'  =>null,
                'expires_in'    =>null
            );
        }
    }
    /*
     * ��ȡjsapi_ticket
     * ����Ч��7200�룬�����߱������Լ��ķ���ȫ�ֻ���jsapi_ticket��
     * ����ʽ��https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=ACCESS_TOKEN&type=jsapi
     * �ӿڷ���ֵ��JSON
     * {
            "errcode":0,
            "errmsg":"ok",
            "ticket":"bxLdikRXVbTPdHSM05e5u5sUoXNKd8-41ZO3MhKoyN5OfkWITDGgnr2fwJ0m9E8NYzWKVZvdVtaUgWvsdshFKA",
            "expires_in":7200
        }
     * */
    private function getJsApiTicket(){
        $access_token_data = $this->getAccessToken();
        if($access_token_data['errcode']==0){
            $access_token = $access_token_data['access_token'];
            $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$access_token.'&type=jsapi';
            $res = $this->api_request($url);
            if($res->errcode==0){
                return array(
                    'errcode'     =>$res->errcode,
                    'errmsg'      =>$res->errmsg,
                    'ticket'      =>$res->ticket,
                    'expires_in'  =>$res->expires_in
                );
            }else{
                return array(
                    'errcode'     =>$res->errcode,
                    'errmsg'      =>$res->errmsg,
                    'ticket'      =>null,
                    'expires_in'  =>null
                );
            }
        }else{
            return array(
                'errcode'         =>$access_token_data['errcode'],
                'errmsg'          =>$access_token_data['errmsg'],
                'ticket'          =>null,
                'expires_in'      =>null
            );
        }
    }
    /*
     * ǩ���㷨
     * ǩ�����ɹ������£�����ǩ�����ֶΰ���noncestr������ַ�����, ��Ч��jsapi_ticket, timestamp��ʱ�����, url����ǰ��ҳ��URL��������#������沿�֣� ��
     * 1�������д�ǩ�����������ֶ�����ASCII ���С���������ֵ��򣩺�
     * 2��ʹ��URL��ֵ�Եĸ�ʽ����key1=value1&key2=value2����ƴ�ӳ��ַ���string1��
     * ������Ҫע��������в�������ΪСд�ַ�����string1��sha1���ܣ��ֶ������ֶ�ֵ������ԭʼֵ��������URL ת�塣
     * */
    /*
     * ��ȡ����ַ���
     * mt_rand() ʹ�� Mersenne Twister �㷨�������������
     * mt_rand(min,max)���û���ṩ��ѡ���� min �� max��mt_rand() ���� 0 �� RAND_MAX ֮���α�������
     * ��Ҫ 5 �� 15������ 5 �� 15��֮������������ mt_rand(5, 15)��
     * �˺���rand()���ı�
     * */
    /*
     * 1.ǩ���õ�noncestr��timestamp������wx.config�е�nonceStr��timestamp��ͬ��
     * 2.ǩ���õ�url�����ǵ���JS�ӿ�ҳ�������URL��
     * 3.���ڰ�ȫ���ǣ������߱����ڷ�������ʵ��ǩ�����߼���
     * ע�⣺
     * ȷ�����ȡ����ǩ����url�Ƕ�̬��ȡ�ģ���̬ҳ��ɲμ�ʵ��������php��ʵ�ַ�ʽ��
     * �����html�ľ�̬ҳ����ǰ��ͨ��ajax��url������̨ǩ����ǰ����Ҫ��js��ȡ��ǰҳ���ȥ'#'hash���ֵ����ӣ�����location.href.split('#')[0]��ȡ,������ҪencodeURIComponent����
     * ��Ϊҳ��һ������΢�ſͻ��˻����������ĩβ��������������������Ƕ�̬��ȡ��ǰ���ӣ������·�����ҳ��ǩ��ʧ�ܡ�
     * */
    public function getSignPackage()
    {
        $jsapiTicket_data = $this->getJsApiTicket();
        $nonceStr = $this->getNonceStr();
        $timestamp = time();
        $url = $this->getUrl();
        if($jsapiTicket_data['errcode']==0){
            $jsapiTicket = $jsapiTicket_data['ticket'];
            // ���������˳��Ҫ���� key ֵ ASCII ����������
            $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
            $signature = sha1($string);
            return  array(
                "appId"         => $this->appId,
                "nonceStr"      => $nonceStr,
                "timestamp"     => $timestamp,
                "url"           => $url,
                "signature"     => $signature,
                "rawString"     => $string,
                "errcode"       => $jsapiTicket_data['errcode'],
                "errmsg"        => $jsapiTicket_data['errmsg']
            );
        }else{
            return  array(
                "appId"         => $this->appId,
                "nonceStr"      => $nonceStr,
                "timestamp"     => $timestamp,
                "url"           => $url,
                "signature"     => null,
                "rawString"     => null,
                "errcode"       => $jsapiTicket_data['errcode'],
                "errmsg"        => $jsapiTicket_data['errmsg']
            );
        }
    }
    /*
     * ��ȡnonceStr
     * */
    private function getNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $nonceStr = "";
        for ($i = 0; $i < $length; $i++) {
            $nonceStr .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $nonceStr;
    }
    /*
     * ��ȡurl
     * url����ǰ��ҳ��URL��������#������沿�֣�
     * */
    private function getUrl(){
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $url;
    }
    /*
     * ΢��API���÷���
     * */
    private function api_request($url,$data=null){
        //��ʼ��cURL����
        $ch = curl_init();
        //����cURL����������������
        $opts = array(
            //�ھ������ڷ���httpsվ��ʱ��Ҫ������������ر�ssl��֤��
            //��������ʽ����ʱ��Ҫ���ģ���������֤��֤��
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 500,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $url,
        );
        curl_setopt_array($ch, $opts);
        //post�������
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        //ִ��cURL����
        $output = curl_exec($ch);
        if (curl_errno($ch)) {    //cURL��������������
            var_dump(curl_error($ch));
            die;
        }
        //�ر�cURL
        curl_close($ch);
        $res = json_decode($output);
        return ($res);   //����json����
    }

}