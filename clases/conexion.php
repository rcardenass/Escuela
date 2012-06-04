<?php
class Conexion {
    //put your code here
     #Region"Campos"
    private $Servidor="localhost";
    //private $BaseDatos="escuela_prueba";
	private $BaseDatos="escuela_real";
    private $Usuario="root";
    private $Password="";
    private $cn;
	/*private $Servidor="localhost";
    private $BaseDatos="cepsanrt_colegio";
    private $Usuario="cepsanrt_ruben";
    private $Password="abc123ABC";
    private $cn;*/
    
    #Region"Constructor"
    public function Conexion(){
        $this->cn=mysql_connect($this->Servidor, $this->Usuario, $this->Password) or trigger_error(mysql_error());
        mysql_select_db($this->BaseDatos, $this->cn);
        return $this->cn;
    }
}

?>
