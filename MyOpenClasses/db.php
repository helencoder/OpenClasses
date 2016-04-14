<?php
/**
 * Author: helen
 * CreateTime: 2016/4/12 20:14
 * description: ���ݿ������(���Խ�MySQL���ݿ�,��Ҫ����MySQLi����)
 */
class Database{

    //MySQL������ַ
    private $_host;
    //MySQL�û���
    private $_user;
    //MySQL�û�����
    private $_password;
    //ָ�����ݿ�����
    private $_database;
    //MySQL���ݿ�˿ں�
    private $_port;
    private $_socket;
    //��ǰ���ݿ����
    private $_dbObj;
    //���ݿ��
    private $_table;
    //���ݿ�����
    private $_tableObj;
    // ���������Ϣ
    protected $error            =   '';
    // ������Ϣ
    protected $data             =   array();
    // ��ѯ���ʽ����
    protected $options          =   array();
    protected $_validate        =   array();  // �Զ���֤����
    protected $_auto            =   array();  // �Զ���ɶ���
    protected $_map             =   array();  // �ֶ�ӳ�䶨��
    protected $_scope           =   array();  // ������Χ����
    // �����������б�
    protected $methods          =   array('strict','order','alias','having','group','lock','distinct','auto','filter','validate','result','token','index','force');

    /**
     * Database���ʼ������
     * ȡ��DB���ʵ������ �ֶμ��
     * @access public
     * @param string $host MySQL���ݿ�������
     * @param string $user MySQL���ݿ��û���
     * @param string $password MySQL���ݿ�����
     * @param string $database ָ�����������ݿ�
     * @return mixed  ���ݿ�������Ϣ��������Ϣ
     */
    public function __construct($host,$user,$passowrd,$database,$port=3306){
        $this->_initialize();
        if(!isset($host)||!isset($user)||!isset($passowrd)||!isset($database)){
            return false;
        }else{
            $this->_host     = $host;
            $this->_user     = $user;
            $this->_password = $passowrd;
            $this->_database = $database;
            $this->_port     = $port;
            $_dbObj = new mysqli($host,$user,$passowrd,$database,$port);
            if($_dbObj->connect_errno){
                $this->error = $_dbObj->connect_error;
                return false;
            }else{
                $this->_dbObj = $_dbObj;
                return $this;
            }
        }
    }
    /**
     * ������Ϣ����
     * �������ݿ�������������һ��ִ��ʱ�Ĵ�����Ϣ
     * @access public
     * @return mixed  ���ݿ����Ӵ�����Ϣ(��������'')
     */
    public function error(){
        return $this->error;
    }
    // �ص����� ��ʼ��ģ��
    protected function _initialize() {}
    /**
     * �������ݶ����ֵ
     * @access public
     * @param string $name ����
     * @param mixed $value ֵ
     * @return void
     */
    public function __set($name,$value) {
        // �������ݶ�������
        $this->data[$name] = $value;
    }

    /**
     * ��ȡ���ݶ����ֵ
     * @access public
     * @param string $name ����
     * @return mixed
     */
    public function __get($name) {
        return isset($this->data[$name])?$this->data[$name]:null;
    }

    /**
     * ������ݶ����ֵ
     * @access public
     * @param string $name ����
     * @return boolean
     */
    public function __isset($name) {
        return isset($this->data[$name]);
    }

    /**
     * �������ݶ����ֵ
     * @access public
     * @param string $name ����
     * @return void
     */
    public function __unset($name) {
        unset($this->data[$name]);
    }
    /**
     * ����__call����ʵ��һЩ����ķ���(���ڵ������в����ڷ����Ľ������)
     * @access public
     * @param string $method ��������
     * @param array $args ���ò���
     * @return mixed
     */
    public function __call($method,$args) {
        /*if(in_array(strtolower($method),$this->methods,true)) {
            // ���������ʵ��
            $this->options[strtolower($method)] =   $args[0];
            return $this;
        }elseif(in_array(strtolower($method),array('count','sum','min','max','avg'),true)){
            // ͳ�Ʋ�ѯ��ʵ��
            $field =  isset($args[0])?$args[0]:'*';
            return ;
        }elseif(strtolower(substr($method,0,5))=='getby') {
            // ����ĳ���ֶλ�ȡ��¼
            $field   =   parse_name(substr($method,5));
            $where[$field] =  $args[0];
            return ;
        }elseif(strtolower(substr($method,0,10))=='getfieldby') {
            // ����ĳ���ֶλ�ȡ��¼��ĳ��ֵ
            $name   =   parse_name(substr($method,10));
            $where[$name] =$args[0];
            return ;
        }elseif(isset($this->_scope[$method])){// ������Χ�ĵ�������֧��
            return ;
        }else{

        }*/
    }
    /*
     * ѡ�����ݿ�
     * @access public
     * @param string $database ѡ������ݿ�����
     * @return mixed ���ݿ�������Ϣ
     * */
    public function select_db($database){
        $select_db = mysqli_select_db($this->_dbObj,$database);
        if($select_db){
            $this->_database = $database;
            $_dbObj = new mysqli($this->_host,$this->_user,$this->_password,$database,$this->_port);
            $this->_dbObj = $_dbObj;
            return $this;
        }else{
            $this->error = mysqli_error($this->_dbObj);
            return false;
        }
    }
    /*
     * ���ݿ��û�����
     * @access public
     * @param string $user ���ݿ��û�����
     * @param string $password ���ݿ��û�����
     * @return mixed ���ݿ�������Ϣ
     * */
    public function change_user($user,$password){
        $change_user = mysqli_change_user($this->_dbObj,$user,$password,$this->_database);
        if($change_user){
            $this->_user = $user;
            $this->_password = $password;
            $_dbObj = new mysqli($this->_host,$this->_user,$this->_password,$this->_database,$this->_port);
            $this->_dbObj = $_dbObj;
            return $this;
        }else{
            $this->error = mysqli_error($this->_dbObj);
            return false;
        }
    }
    /*
     * ��ѯ���ݿ������еı���
     * @access public
     * @return array ���ݱ�������ͱ���
     * */
    public function tables(){
        $sql = 'show tables';
        $search_res = mysqli_query($this->_dbObj,$sql);
        if($search_res){
            $num_rows = $search_res->num_rows;
            $tables_msg = array(
                'count'=>$num_rows,
                'tables'=>array()
            );
            for($i=0;$i<$num_rows;$i++){
                $row = $search_res->fetch_assoc();
                $key = 'Tables_in_'.$this->_database;
                array_push($tables_msg['tables'],$row[$key]);
            }
            mysqli_free_result($search_res);
            return $tables_msg;
        }else{
            mysqli_free_result($search_res);
            return false;
        }
    }
    /*
     * ��ȡָ������������Ϣ
     * @access public
     * @param string $table ���ݱ�����
     * @return array ���ݱ����ϸ��Ϣ
     * */
    public function select_table($table){
        $sql = 'select * from '.$table;
        $search_res = mysqli_query($this->_dbObj,$sql);
        if($search_res){
            $this->_table = $table;
            $table_msg = self::query_handle($search_res);
            $this->_tableObj = $table_msg;
            mysqli_free_result($search_res);
            return $table_msg;
        }else{
            mysqli_free_result($search_res);
            return false;
        }
    }
    /*
     * ��ȡָ������ֶ���ϸ��Ϣ
     * @access public
     * @param string $table ���ݱ�����
     * @return array ���ݱ���ֶ���ϸ��Ϣ
     * */
    public function select_table_fields($table){
        $sql = 'show fields from '.$table;
        $search_res = mysqli_query($this->_dbObj,$sql);
        if($search_res){
            $this->_table = $table;
            $fields_msg = self::query_handle($search_res);
            mysqli_free_result($search_res);
            return $fields_msg;
        }else{
            mysqli_free_result($search_res);
            return false;
        }
    }
    /*
     * ��ȡ���ݱ���ָ���ֶ���Ϣ��������ֶ�ͬʱ��ѯ��
     * @access public
     * @param mixed $field ָ���ֶΣ��ַ�������ʹ�ã������
     * @return array ���ݱ���ָ���ֶ���Ϣ
     * */
    public function getField($field){
        $fields = self::param_handle($field);
        $count = count($fields);
        for($i=0;$i<$count;$i++){
            $index = $fields[$i];
            $sql = 'select '.$index.' from '.$this->_table;
            $res = mysqli_query($this->_dbObj,$sql);
            $field_msg[$index] = self::query_handle($res);
        }
        return $field_msg;
    }
    /*
     * mysqli_query�������������
     * @access protected
     * @param object $obj mysqli_query�������
     * @return array ���ݱ���ָ���ֶ���Ϣ
     * */
    protected function query_handle($obj){
        $res = array();
        for($i=0;$i<$obj->num_rows;$i++){
            $row = $obj->fetch_assoc();
            array_push($res,$row);
        }
        return $res;
    }
    /*
     * �������������
     * @access protected
     * @param mixed $param �������
     * @return array �������������
     * */
    public function param_handle($param){
        if(is_string($param)&&!empty($param)){
            $params = explode(',',$param);
        }elseif(is_array($param)&&!empty($param)){
            $params = $param;
        }else{
            return false;
        }
        return $params;
    }
    /*
     * ��ѯ���ʽ����������
     * @access protected
     * @param mixed $param �������(where limit order)
     * @return string ������ַ�������
     * */
    public function options_handle($param){
        if(is_numeric($param)){
            $option = $param;
        }elseif(is_string($param)&&!empty($param)&&!is_numeric($param)){
            $params = explode(',',$param);
            $count = count($params);
            $option = implode(' and ',$params);
        }elseif(is_array($param)&&!empty($param)){
            $params = $param;
            $count = count($params);
            $arr = array();
            foreach($param as $key=>$value){
                $tip = "$key=$value ";
                array_push($arr,$tip);
            }
            $option = implode(' and ',$arr);
        }else{
            return false;
        }
        return $option;
    }
    /*
     * ��ѯ���ʽ$options������
     * @access protected
     * @return string ������ַ�������
     * */
    protected function option(){
        $options = $this->options;
        $option = '';
        if(isset($options['where'])){
            $option .= 'where '.$options['where'].' ';
        }
        if(isset($options['order'])){
            $option .= 'order by '.$options['order'].' '.$options['order_type'].' ';
        }
        if(isset($options['limit'])){
            $option .= 'limit '.$options['limit'];
        }
        return $option;
    }
    /*
     * ���ݲ�ѯ���ʽ��ѯ����(�������������м�¼)
     * @access public
     * @return array �����ѯ���ʽ���ض�����
     * */
    public function find(){
        $option = self::option();
        $sql = 'select * from '.$this->_table.' '.$option;
        $search_res = mysqli_query($this->_dbObj,$sql);
        $msg = self::query_handle($search_res);
        return $msg;
    }
    /*
     * ��ѯ���ʽ where������
     * @access public
     * @param mixed $where where��ѯ����
     * @return object $this
     * */
    public function where($where){
        $this->options['where'] = self::options_handle($where);
        return $this;
    }
    /*
     * ��ѯ���ʽ limit������
     * @access public
     * @param mixed $limit limit��ѯ����(����)
     * @return object $this
     * */
    public function limit($limit){
        $this->options['limit'] = self::options_handle($limit);
        return $this;
    }
    /*
     * ��ѯ���ʽ order������
     * @access public
     * @param string $order order��ѯ����
     * @param string $type order��ѯ������˳��Ĭ�Ͻ���
     * @return object $this
     * */
    public function order($order,$type='desc'){
        $this->options['order'] = $order;
        $this->options['order_type'] = $type;
        return $this;
    }
    /*
     * ���ݴ�����(��ദ���ά����)
     * @access public
     * @param array $data ��Ҫ���������
     * @return object $this
     * */
    public function data(array $data){
        $values = array();
        $fields = array();
        if(is_array($data)){
            foreach($data as $key=>$value){
                if(is_array($value)){       //��ά����
                    $tip = 1;
                    array_push($values,'('.implode(',',array_values($value)).')');
                    array_push($fields,'('.implode(',',array_keys($value)).')');
                }else{      //һά����
                    $tip = 0;
                }
            }
        }else{
            return false;
        }
        if(!$tip){
            array_push($values,'('.implode(',',array_values($data)).')');
            array_push($fields,'('.implode(',',array_keys($data)).')');
        }
        $this->data['fields'] = $fields[0];
        $this->data['values'] = implode(',',$values);
        return $this;
    }
    /*
     * ������������
     * @access public
     * @return mixed ���ݿ�������Ϣ
     * */
    public function add(){
        $fields = $this->data['fields'];
        $values = $this->data['values'];
        $sql = 'INSERT INTO '.$this->_table.$fields.'VALUES'.$values;
        $res = mysqli_query($this->_dbObj,$sql);
        return $res;
    }
    /*
     * ���ݸ��º�����һά���飩
     * @access public
     * @param array $data ��Ҫ���µ�����
     * @return mixed ���ݿ�������Ϣ
     * */
    function save(array $data){
        $tip = array();
        if(is_array($data)){
            foreach($data as $key=>$value){
                array_push($tip,"$key=$value");
            }
        }else{
            return false;
        }
        $set_msg = implode(',',$tip);
        $sql = 'UPDATE '.$this->_table.' SET '.$set_msg.' WHERE '.$this->options['where'];
        $res = mysqli_query($this->_dbObj,$sql);
        return $res;
    }
    /*
     * ����ɾ������
     * @access public
     * @return mixed ���ݿ�ɾ����Ϣ
     * */
    public function delete(){
        $sql = 'DELETE FROM '.$this->_table.' WHERE '.$this->options['where'];
        $res = mysqli_query($this->_dbObj,$sql);
        return $res;
    }
    /*
     * SQL����ѯ
     * */
    public function query($sql){
        $search_res = mysqli_query($this->_dbObj,$sql);
        return $search_res;
    }
    /*
     * mysql�в�ѯ���
     * */
    protected function sql(){
        /*
         * ����SQL���
         * �������ݣ�INSERT INTO tb_name(id,name,score)VALUES(NULL,'����',140),(NULL,'����',178),(NULL,'����',134);
         * ������䣺UPDATE tb_name SET score=189 WHERE id=2;
         * ɾ�����ݣ�DELETE FROM tb_name WHERE id=3;
         * WHERE��䣺SELECT * FROM tb_name WHERE id=3;
         * HAVING ��䣺SELECT * FROM tb_name GROUP BY score HAVING count(*)>2
         * ����������Ʒ���=��>��<��<>��IN(1,2,3......)��BETWEEN a AND b��NOT AND ��OR Linke()�÷���      %  Ϊƥ�����⡢  _  ƥ��һ���ַ��������Ǻ��֣�IS NULL ��ֵ���
         * MySQL��������ʽ��SELECT * FROM tb_name WHERE name REGEXP '^[A-D]'   //�ҳ���A-D Ϊ��ͷ��name
         * */
    }
    /*
     * �ر�����
     * */
    public function close(){
        $close = mysqli_close($this->_dbObj);
        if($close){
            return true;
        }else{
            return false;
        }
    }
    function __destruct(){
        mysqli_close($this->_dbObj);
    }
}