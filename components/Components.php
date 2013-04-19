<?php
//componente creadopor juan russi
require_once('Dialog.php');
require_once('Config.php');
require_once('PHPMail.php');
require_once ('Credenciales.php');
//Example for use Dialog
//Dialog::Message('pedrito', 'hola', true);
class Components{
    /*private $mysql_host = "mysql2.000webhost.com";
    private $mysql_database = "a8943238_sei";
    private $mysql_user = "a8943238_sei";
    private $mysql_password = "Temporal2012"; 
    private $dbName="a8943238_sei";
    /**DEvelopment*/
    
    private $mysql_host = "localhost";
    private $mysql_user = "root";
    private $mysql_password = ""; 
    private $dbName="uccmysql";
    private $conect;
    private $error='error';
    private static $date=null;
    /*public function __construct() {
        $this->conect = mysql_connect($this->mysql_host, $this->mysql_user, $this->mysql_password);
        if (!$this->conect){
            return $this->error . " -" . mysql_error();
        }
        mysql_select_db($this->dbName, $this->conect);
    }*/
    public function __executeQuery($query=null,$conect=null){
        $rs = mysql_query($query,@$conect);
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
    public function sendRsForMail($mails=null,$subject=null,$msg=null){
                       
             
            /*GMAIL SENDER MAIL*/
            $mail = new PHPMail();  // Instantiate your new class
            $mail->Host = "mail.btconsultores.com.co"; //Estableix GMAIL com el servidor SMTP.
            $mail->SMTPAuth= true; //Habilita la autenticaciÃ³ SMPT.
            //$mail->SMTPSecure="tls"; //Estableix el prefix del servidor.
            $mail->Port = 25 ; //Estableix el port SMTP.
            /*USuario y contraseña de la clave de el usuario*/        
            $mail->Username = "noreply@btconsultores.com.co";
            $mail->Password = "80200532";
            
            $mail->From = 'noreply@btconsultores.com.co';
            $mail->FromName = "Master Admin";
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
            $message = $msg;
            $mail->IsHTML(true);
            $mail->Body = $message;
            //$send = $mail->Send();
            $send =true;
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
    public static function getFilesofFolder($nameFolder){
        if(is_dir($nameFolder)){
            return scandir($nameFolder);
        }else{
            return $this->error;
        }
    }
}
?>
