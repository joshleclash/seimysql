<?php
//componente creadopor juan russi
require_once('Dialog.php');
require_once('Config.php');
require_once('PHPMail.php');
//Example for use Dialog
//Dialog::Message('pedrito', 'hola', true);
class Components{
    public $dbName="uccmysql";
    private $conect;
    protected $error='error';
    private static $date=null;
    private $server='localhost';
    private $user="root";
    private $password="";
    public function __construct() {
        $this->conect = mysql_connect($this->server, $this->user, $this->password);
        mysql_select_db($this->dbName, $this->conect);
    }
    public function __executeQuery($query=null,$conect=null){
        $rs = mysql_query($query,$conect);
        if($rs==false)
            {
                  return $this->error . "-" . mysql_error();
            }
        else
            {
              return $rs;
            }
        return $rs;
    }
    public function __returnDataByRs($rs=null,$data=null){
        $dato='';
        if(is_array($data))
            {
            while($row=  mysql_fetch_array($rs)){
                    foreach($data as $k => $v):
                        $dato[$k] = $row[$v];
                    endforeach;
                }
            return $dato;
            }
        else
            {
            while($row=  mysql_fetch_array($rs))
                $dato = $row[$data];
            return $dato;
            }
        
    }/***
     * Optimizar
     */
    public function __returnJsonArray($rs=null,$idTable=null){
            if($rs==null){return $this->error ." -" ."Por favor envie recorset para retornar json";}
            $js="";
            $i=0;
            $json=array();
            
            while($row = mysql_fetch_array($rs))
                {
                $json['myData'][$i]=array('val'=>$idTable,
                                          'title'=>htmlentities($row['registro']. ' - ('.$row['empresa'].' ).'.$row['cod_datos_productor']),
                                  );
                $i++;
                }
            return json_encode($json);
        }
    /**Peticion ajax send array('url'=>'routeScript.php','type'=>'get o post','data'=>array('nameVar'=>'value'),'update'=>'idResponse')
     */
    public static function ajaxRequest($params){
        $response='$.ajax({';
        // $response='$.ajax({';
        if(array_key_exists('url',$params))
        {
            $response.='url:"' .$params['url'].'",';
        }
        if(array_key_exists('type',$params))
        {
            $response.='method:"' .$params['type'].'",';
        }
         if(array_key_exists('data',$params))
         {
             $val='';
             $i=0;
             foreach($params['data'] as $k=>$v){
                 if($i==0)
                     {
                     $val .= ''.$k.':'.'"'.$v.'"';     
                     }
                 else{
                     $val .=',';
                     $val .= ''.$k.':'.'"'.$v.'"';     
                     }
             $i++;        
             }
            $response.='data:{' .$val.'},';
         }
        $response .='success:function(response){'; 
        if(array_key_exists('update', $params))
        {
            $response .=  '$("#'.$params['update'].'").html(response);';  
              
        }
        else
        {
            $response .=  'console.log(response);';
        }
        $response .='}';
        $response .= '});';
      return  $response;
      
    }
    public static function getDate($timeZone=null,$varDate=null){
        if(is_null($timeZone)){
            date_default_timezone_set('America/Bogota');
            return self::$date=date('Y-m-d H:i:s');
        }else{
            date_default_timezone_set($timeZone);
            if(is_null($varDate))
            return self::$date=date('Y-m-d H:i:s');
            else    
            return self::$date=date($varDate);
        }
        
    }
    public function sendRsForMail($rs=null,$mails=null,$subject=null,$msg=null){
                       
             
            /*GMAIL SENDER MAIL*/
            $mail = new PHPMail();  // Instantiate your new class
            $mail->IsSMTP(); // enable SMTP
            $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true;  // authentication enabled
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
                    
            $mail->Username = "joshleclash@gmail.com";
            $mail->Password = "5k4t3b04rd5";
            
            $mail->From = 'sisfito@ica.gov.co';
            $mail->FromName = "Juan Pablo Russi";
            $mail->Subject = $subject;
           
            if(is_array($mails))
                {
                foreach($mails as $k=>$v):
                    $mail->AddAddress($v);
                endforeach;
                }
            else
                {
                    $mail->AddAddress($mails);
                }
            
            //**************************/
            if(is_null($msg)){    
                $message = $this->createMsgMail($rs);
            }else{//Enviando mensaje desde el el metodo
                $message = $msg;
            }
            $mail->IsHTML(true);
            $mail->Body = $message;
            $send = $mail->Send();
            if($send){
                return true;
            }else{
             return   $mail->ErrorInfo;
            }
            
     }
    public function getConnect(){
        return $this->conect;
    }
    public function __paramSearchByTable($tablaName=null){
        $sql = "SHOW COLUMNS from ". $tablaName;
        $rs = $this->__executeQuery($sql,$this->conect);
        while($row = mysql_fetch_array($rs)){
           $data[$row['Field']] = $row['Field'];
        }
        return $data;
    }
    public static function obtenFilesofFolder($nameFolder){
        if(is_dir($nameFolder)){
            return scandir($nameFolder);
        }else{
            return $this->error;
        }
    }
}
?>
