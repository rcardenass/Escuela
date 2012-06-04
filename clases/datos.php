<?php
include ("conexion.php");

class datos {
    private $Rs;
    private $Sql;
    private $Row;
    
    function datos() {
    }
        
	//REGION TIPO DOCUMENTO
	public function ObtenerTipoDocumentoSelAll(){
		$ObjConexion=new Conexion();
                $this->Sql="select CodTipoDocumento, NombreTipoDocumento from tipodocumento where Estado=1 ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarTipoDocumentoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION TIPO DOCUMENTO
	
	//REGION PROGRAMAACADEMICO
	public function ObtenerProgramaSelAll(){
		$ObjConexion=new Conexion();
                $this->Sql="SELECT CodProgramaAcademico, Programa FROM programaacademico WHERE Estado = 1 ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarProgramaSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION PROGRAMAACADEMICO
	
	//REGION A�O	
    public function ObtenerAnioSelAll(){
		$ObjConexion=new Conexion();
                $this->Sql="Select CodAnio, NombreAnio from anio where Estado=1 order by NombreAnio desc ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarAnioSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	public function ObtenerAnioTodosSelAll(){
		$ObjConexion=new Conexion();
                $this->Sql="Select CodAnio, NombreAnio from anio order by NombreAnio desc ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarAnioTodosSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION A�O
	
	//REGION AREA
    public function ObtenerAreaSelAll(){
		$ObjConexion=new Conexion();
                $this->Sql="SELECT CodArea, NombreArea FROM area WHERE Estado = 1 ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarAreaSelAll($rs){
        return mysql_fetch_assoc($rs);
    }

    public function ObtenerGradoAreaSelAll(){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT b.CodArea, b.CodGrado, c.NombreArea ";
                $this->Sql.="FROM grado a ";
                $this->Sql.="INNER JOIN cursogrado b ON b.CodGrado=a.CodGrado ";
                $this->Sql.="INNER JOIN area c ON c.CodArea=b.CodArea ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarGradoAreaSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION AREA	
	
	//REGION GRADO
	public function ObtenerNivelGradoSelAll(){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT a.CodGrado, b.CodNivel, a.NombreGrado ";
				$this->Sql.="FROM grado a ";
				$this->Sql.="INNER JOIN nivel b ON b.CodNivel=a.CodNivel ";
				$this->Sql.="WHERE a.Estado=1 and b.Estado=1 ORDER BY a.Orden, a.CodNivel ASC ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarNivelGradoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerGradoSelAll(){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT a.CodGrado, concat(b.NombreNivel,' ',a.NombreGrado) AS NombreGrado ";
				$this->Sql.="FROM grado a ";
				$this->Sql.="INNER JOIN nivel b ON b.CodNivel=a.CodNivel ";
				$this->Sql.="WHERE a.Estado=1 and b.Estado=1 ORDER BY a.Orden, a.CodNivel ASC ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarGradoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerGradoSelId($CodGrado){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT a.CodGrado, concat(b.NombreNivel,' ',a.NombreGrado) AS NombreGrado ";
				$this->Sql.="FROM grado a ";
				$this->Sql.="INNER JOIN nivel b ON b.CodNivel=a.CodNivel ";
				$this->Sql.="WHERE a.Estado=1 and a.CodGrado=".$CodGrado." ";
				$this->Sql.="ORDER BY a.Orden, a.CodNivel ASC ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarGradoSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerNivelGradoSelId($CodGrado){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT CodNivel FROM grado where CodGrado=".$CodGrado." ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarNivelGradoSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	//END REGION GRADO
	
	//REGION SECCION
	public function ObtenerSeccionSelAll(){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT CodSeccion, NombreSeccion ";
				$this->Sql.="FROM seccion ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarSeccionSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerSeccionGradoSelAll(){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT  a.CodSeccion, b.CodGrado, a.NombreSeccion ";
				$this->Sql.="FROM seccion a ";
				$this->Sql.="INNER JOIN gradoseccion b ON b.CodSeccion=a.CodSeccion ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarSeccionGradoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerSeccionGradoSelAll2($CodGrado){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT  a.CodSeccion, b.CodGrado, a.NombreSeccion ";
				$this->Sql.="FROM seccion a ";
				$this->Sql.="INNER JOIN gradoseccion b ON b.CodSeccion=a.CodSeccion ";
				$this->Sql.="where b.CodGrado=".$CodGrado." ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarSeccionGradoSelAll2($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION SECCION
	
	//REGION BIMESTRE
	public function ObtenerBimestreSelAll(){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT CodBimestre, NombreBimestre FROM bimestre ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarBimestreSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION BIMESTRE
	
	//REGION CURSO
	public function ObtenerCursoSelAll(){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT CodCurso, NombreCurso FROM curso WHERE Estado = 1 ORDER BY NombreCurso ASC ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarCursoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerCursoGradoSelAll(){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT a.CodCurGra, b.NombreCurso, a.CodGrado ";
				$this->Sql.="FROM cursogrado a ";
				$this->Sql.="INNER JOIN curso b ON b.CodCurso=a.CodCurso ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarCursoGradoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }

    public function ObtenerCursoGradoListaSelAll($CodGrado){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT b.CodCurGra, d.Programa, e.NombreArea, ";
				$this->Sql.="concat(left(f.NombreNivel,3),' ',left(a.NombreGrado,10)) as NombreGrado, c.NombreCurso, b.Estado ";
				$this->Sql.="FROM grado a ";
				$this->Sql.="INNER JOIN cursogrado b ON b.CodGrado=a.CodGrado ";
				$this->Sql.="INNER JOIN curso c ON c.CodCurso=b.CodCurso ";
				$this->Sql.="INNER JOIN programaacademico d ON d.CodProgramaAcademico=b.CodProgramaAcademico ";
				$this->Sql.="inner join area e on e.CodArea=b.CodArea ";
				$this->Sql.="inner join nivel f on f.CodNivel=a.CodNivel ";
				$this->Sql.="WHERE a.CodGrado='".$CodGrado."' ";
				$this->Sql.="ORDER BY a.CodNivel, a.CodGrado ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarCursoGradoListaSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION CURSO
	
	//REGION CRITERIO
	public function ObtenerCriterioSelAll($CodAnio,$CodArea,$CodGrado){
		$ObjConexion=new Conexion();
                 $this->Sql = "SELECT a.CodCriterio, b.NombreAnio, c.NombreArea, "; 
				 $this->Sql.= "concat(e.NombreNivel,' - ',d.NombreGrado) AS NombreGrado, a.NombreCriterio, a.Porcentaje ";
				 $this->Sql.= "FROM criterio a ";
				 $this->Sql.= "INNER JOIN anio b ON b.CodAnio=a.CodAnio ";
				 $this->Sql.= "INNER JOIN area c ON c.CodArea=a.CodArea ";
				 $this->Sql.= "INNER JOIN grado d ON d.CodGrado=a.CodGrado ";
				 $this->Sql.= "INNER JOIN nivel e ON e.CodNivel=d.CodNivel ";
				 $this->Sql.= "where (b.CodAnio='".$CodAnio."' or ''='".$CodAnio."') ";
				 $this->Sql.= "and (c.CodArea='".$CodArea."' or ''='".$CodArea."') ";
				 $this->Sql.= "and (d.CodGrado='".$CodGrado."' or ''='".$CodGrado."') limit 20 ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarCriterioSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	public function ObtenerCriterioDependienteSelAll($CodAnio,$CodGrado,$CodCurGra){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT a.CodCriterio, b.CodCriterioCurso, a.NombreCriterio ";
				$this->Sql.="FROM criterio a ";
				$this->Sql.="INNER JOIN criteriocurso b ON b.CodCriterio=a.CodCriterio ";
				$this->Sql.="WHERE a.CodAnio=".$CodAnio." ";
				if($CodCurGra!=0){
					$this->Sql.="AND a.CodArea=(SELECT x.CodArea FROM cursogrado x WHERE x.CodCurGra=".$CodCurGra.") ";
				}
				$this->Sql.="AND a.CodGrado=".$CodGrado." ";
				$this->Sql.="AND b.CodCurGra=".$CodCurGra." ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarCriterioDependienteSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	public function ObtenerNotaCriterioPrimariaSelAll($CodAnio,$CodGrado,$CodSeccion,$CodCurGra,$CodProfesorCurso,$CodMatricula,$CodBimestre,$CodCriterio){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT a.CodAnio, a.codGrado, a.CodSeccion, b.CodCurGra, c.CodProfesorCurso, c.Nota ";
				$this->Sql.="FROM matricula a ";
				$this->Sql.="INNER JOIN matriculacurso b ON b.CodMatricula=a.CodMatricula ";
				$this->Sql.="INNER JOIN criterionotaprimaria c ON c.CodMatricula=a.CodMatricula ";
				$this->Sql.="WHERE a.CodAnio=".$CodAnio." ";
				$this->Sql.="AND a.Codgrado=".$CodGrado." ";
				$this->Sql.="AND a.CodSeccion=".$CodSeccion." ";
				$this->Sql.="AND b.CodCurGra=".$CodCurGra." ";
				$this->Sql.="AND c.CodProfesorCurso=".$CodProfesorCurso." ";
				$this->Sql.="AND a.CodMatricula=".$CodMatricula." ";
				$this->Sql.="AND c.CodBimestre=".$CodBimestre." ";
				$this->Sql.="AND c.CodCriterio=".$CodCriterio." ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarNotaCriterioPrimariaSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	public function ObtenerNotaCriterioSecundariaSelAll($CodAnio,$CodGrado,$CodSeccion,$CodCurGra,$CodProfesorCurso,$CodMatricula,$CodBimestre,$CodCriterio){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT a.CodAnio, a.codGrado, a.CodSeccion, b.CodCurGra, c.CodProfesorCurso, c.Nota ";
				$this->Sql.="FROM matricula a ";
				$this->Sql.="INNER JOIN matriculacurso b ON b.CodMatricula=a.CodMatricula ";
				$this->Sql.="INNER JOIN criterionota c ON c.CodMatricula=a.CodMatricula ";
				$this->Sql.="WHERE a.CodAnio=".$CodAnio." ";
				$this->Sql.="AND a.Codgrado=".$CodGrado." ";
				$this->Sql.="AND a.CodSeccion=".$CodSeccion." ";
				$this->Sql.="AND b.CodCurGra=".$CodCurGra." ";
				$this->Sql.="AND c.CodProfesorCurso=".$CodProfesorCurso." ";
				$this->Sql.="AND a.CodMatricula=".$CodMatricula." ";
				$this->Sql.="AND c.CodBimestre=".$CodBimestre." ";
				$this->Sql.="AND c.CodCriterio=".$CodCriterio." ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarNotaCriterioSecundariaSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerValidaCriterioSelId($CodAnio,$CodArea,$CodGrado,$NombreCriterio){
		$ObjConexion=new Conexion();
                 $this->Sql = "SELECT COUNT(CodCriterio) AS Cantidad "; 
				 $this->Sql.= "FROM criterio ";
				 $this->Sql.= "WHERE CodAnio=".$CodAnio." ";
				 $this->Sql.= "AND CodArea=".$CodArea." ";
				 $this->Sql.= "AND CodGrado=".$CodGrado." ";
				 $this->Sql.= "AND NombreCriterio='".$NombreCriterio."' ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarValidaCriterioSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerValidaPorcentajeCriterioSelId($CodAnio,$CodArea,$CodGrado){
		$ObjConexion=new Conexion();
                 $this->Sql = "SELECT SUM(Porcentaje) AS Porcentaje "; 
				 $this->Sql.= "FROM criterio ";
				 $this->Sql.= "WHERE CodAnio=".$CodAnio." ";
				 $this->Sql.= "AND CodArea=".$CodArea." ";
				 $this->Sql.= "AND CodGrado=".$CodGrado." ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarValidaPorcentajeCriterioSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function InsertCriterio($CodAnio,$CodArea,$CodGrado,$NombreCriterio,$Porcentaje,$UsuarioCreacion){
		$ObjConexion=new Conexion();
		$this->Sql ="INSERT INTO criterio (CodCriterio,CodAnio,CodArea,CodGrado,NombreCriterio,Porcentaje,UsuarioCreacion,FechaCreacion) ";
		$this->Sql.="values ('null', ".$CodAnio.", ".$CodArea.", ".$CodGrado.",'".$NombreCriterio."',".$Porcentaje.",'".$UsuarioCreacion."', now()) ";
		$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		$Retorna=1;
		return $Retorna;
    }
	
	public function ObtenerCodigoCriterioSelId(){
		$ObjConexion=new Conexion();
         $this->Sql = "SELECT MAX(CodCriterio) AS CodCriterio FROM criterio "; 
         $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarCodigoCriterioSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function InsertCriterioCurso($CodCriterio,$NroNota,$CodGrado,$CodArea,$UsuarioCreacion){
		$ObjConexion=new Conexion();
		$this->Sql ="INSERT INTO criteriocurso (CodCriterio, CodCurGra, NroNotas, UsuarioCreacion, FechaCreacion) ";
		$this->Sql.="SELECT ".$CodCriterio.", CodCurGra, ".$NroNota.", '".$UsuarioCreacion."', now() ";
		$this->Sql.="FROM cursogrado ";
		$this->Sql.="WHERE CodGrado=".CodGrado." ";
		$this->Sql.="and CodArea=".CodArea." ";
		$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		$Retorna=1;
		return $Retorna;
    }
	//END REGION CRITERIO
	
	//REGION MATRICULA
	public function ObtenerMatriculadoGradoSeccionSelAll($CodAnio,$CodGrado,$CodSeccion){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT b.CodMatricula, concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Alumno ";
				$this->Sql.="FROM alumno a ";
				$this->Sql.="INNER JOIN matricula b ON b.CodAlumno=a.CodAlumno ";
				$this->Sql.="WHERE b.CodAnio=".$CodAnio." ";
				$this->Sql.="AND b.CodGrado=".$CodGrado." ";
				$this->Sql.="AND b.CodSeccion=".$CodSeccion." ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarMatriculadoGradoSeccionSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	public function ObtenerMatriculaSelAll($CodAnio,$CodGrado,$CodSeccion,$Buscar){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT a.CodMatricula, c.NombreAnio, ";
				$this->Sql.="concat(b.ApellidoPaterno,' ',b.ApellidoMaterno,' ',b.Nombres) AS Alumno, ";
				$this->Sql.="concat(f.NombreNivel,' - ',d.NombreGrado) as NombreGrado, e.NombreSeccion, ";
				$this->Sql.="CASE a.Turno WHEN 'M' THEN 'Ma&ntilde;ana' WHEN 'T' THEN 'Tarde' WHEN 'N' THEN 'Noche' END AS Turno, ";
				$this->Sql.="a.EstadoRetirado ";
				$this->Sql.="FROM matricula a ";
				$this->Sql.="INNER JOIN alumno b ON b.CodAlumno=a.CodAlumno ";
				$this->Sql.="INNER JOIN anio c ON c.CodAnio=a.CodAnio ";
				$this->Sql.="INNER JOIN grado d ON d.CodGrado=a.CodGrado ";
				$this->Sql.="INNER JOIN seccion e ON e.CodSeccion=a.CodSeccion ";
				$this->Sql.="INNER JOIN nivel f ON f.CodNivel=d.CodNivel ";
				$this->Sql.="where (c.CodAnio='".$CodAnio."' or ''='".$CodAnio."') ";
				$this->Sql.="and (d.CodGrado='".$CodGrado."' or ''='".$CodGrado."') ";
				$this->Sql.="and (e.CodSeccion='".$CodSeccion."' or ''='".$CodSeccion."') ";
				$this->Sql.="and concat(b.ApellidoPaterno,' ',b.ApellidoMaterno,' ',b.Nombres) like '%".$Buscar."%' limit 30";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarMatriculaSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerMatriculaSelId($CodMatricula){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT a.CodMatricula, a.CodAlumno, a.CodAnio, a.CodGrado, a.CodSeccion, a.Turno, ";
				$this->Sql.="concat(b.ApellidoPaterno,' ',b.ApellidoMaterno,' ',b.Nombres) AS Alumno ";
				$this->Sql.="FROM matricula a ";
				$this->Sql.="INNER JOIN alumno b ON b.CodAlumno=a.CodAlumno ";
				$this->Sql.="WHERE a.CodMatricula=".$CodMatricula." ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarMatriculaSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerUltimaMatriculaSelId($CodAlumno){
        $ObjConexion=new Conexion();
        $this->Sql ="SELECT a.CodMatricula, a.CodAlumno, a.CodAnio, a.CodGrado, a.CodSeccion, a.Turno, a.EstadoRetirado,  ";
		$this->Sql.="concat(b.ApellidoPaterno,' ',b.ApellidoMaterno,' ',b.Nombres) AS Alumno ";
		$this->Sql.="FROM matricula a ";
		$this->Sql.="INNER JOIN alumno b ON b.CodAlumno=a.CodAlumno ";
		$this->Sql.="WHERE b.CodAlumno=".$CodAlumno." ";
        $this->Sql.="ORDER BY a.CodMatricula DESC limit 1 ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarUltimaMatriculaSelId($rs){
        return mysql_fetch_assoc($rs);
    }

	//END REGION MATRICULA
	
	//REGION PROFESOR
	public function ObtenerProfesorDeAlumnoSelAll($CodAnio,$CodGrado,$CodSeccion){
        $ObjConexion=new Conexion();
        $this->Sql ="SELECT b.CodPersonal, upper(concat(b.ApellidoPaterno,' ',b.ApellidoMaterno,' ',b.Nombres)) AS Profesor ";
		$this->Sql.="FROM profesorcurso a ";
		$this->Sql.="INNER JOIN personal b ON b.CodPersonal=a.CodPersonal ";
		$this->Sql.="WHERE a.CodAnio='".$CodAnio."' ";
        $this->Sql.="AND a.CodGrado='".$CodGrado."' ";
        $this->Sql.="AND a.CodSeccion='".$CodSeccion."' ";
        $this->Sql.="GROUP by b.ApellidoPaterno,' ',b.ApellidoMaterno,' ',b.Nombres ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarProfesorDeAlumnoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }

	public function ObtenerProfesorSelId($CodProfesor){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT CodPersonal,  ";
				$this->Sql.="concat(upper(ApellidoPaterno),' ',upper(ApellidoMaterno),' ',upper(Nombres)) as Profesor ";
				$this->Sql.="FROM personal ";
				$this->Sql.="WHERE CodTipoPersonal=2 and CodPersonal='".$CodProfesor."' ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarProfesorSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerProfesorCursoSelId($CodAnio,$CodGrado,$CodSeccion,$CodCurGra){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT a.CodProfesorCurso, concat(b.ApellidoPaterno,' ',b.ApellidoMaterno,' ',b.Nombres) AS Personal ";
				$this->Sql.="FROM profesorcurso a ";
				$this->Sql.="INNER JOIN personal b ON b.CodPersonal=a.CodPersonal ";
				$this->Sql.="WHERE a.CodAnio=".$CodAnio." AND a.CodGrado=".$CodGrado." ";
				$this->Sql.="AND a.CodSeccion=".$CodSeccion." AND a.CodCurGra=".$CodCurGra." ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarProfesorCursoSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerProfesorCursoSelId2($CodProfesorCurso){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT a.CodProfesorCurso, a.CodPersonal, ";
				$this->Sql.="concat(upper(b.ApellidoPaterno),' ',upper(b.ApellidoMaterno),' ',upper(b.Nombres)) AS Profesor, ";
				$this->Sql.="a.CodCurGra, a.CodAnio, a.CodNivel, a.CodGrado, a.CodSeccion ";
				$this->Sql.="FROM profesorcurso a ";
				$this->Sql.="INNER JOIN personal b ON b.CodPersonal=a.CodPersonal ";
				$this->Sql.="where b.CodTipoPersonal=2 ";
				$this->Sql.="and a.CodProfesorCurso='".$CodProfesorCurso."' ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarProfesorCursoSelId2($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerProfesorCursoSeAll($CodAnio,$CodGrado,$CodSeccion,$Profesor){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT b.CodProfesorCurso, f.NombreAnio, ";
				$this->Sql.="concat(left(h.NombreNivel,3),' ',left(d.NombreGrado,10)) as NombreGrado, g.NombreSeccion, ";
				$this->Sql.="concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Profesor, ";
				$this->Sql.="e.NombreCurso ";
				$this->Sql.="FROM personal a ";
				$this->Sql.="INNER JOIN profesorcurso b ON b.CodPersonal=a.CodPersonal ";
				$this->Sql.="INNER JOIN cursogrado c ON  c.CodCurGra=b.CodCurGra ";
				$this->Sql.="INNER JOIN grado d ON d.CodGrado=c.CodGrado ";
				$this->Sql.="INNER JOIN curso e ON e.CodCurso=c.CodCurso ";
				$this->Sql.="INNER JOIN anio f ON f.CodAnio=b.CodAnio ";
				$this->Sql.="INNER JOIN seccion g ON g.CodSeccion=b.CodSeccion ";
				$this->Sql.="inner join nivel h on h.CodNivel=d.CodNivel ";
				$this->Sql.="where (f.CodAnio='".$CodAnio."' or ''='".$CodAnio."') ";
				$this->Sql.="and (d.CodGrado='".$CodGrado."' or ''='".$CodGrado."') ";
				$this->Sql.="and (g.CodSeccion='".$CodSeccion."' or ''='".$CodSeccion."') ";
				$this->Sql.="and concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) like '%".$Profesor."%' ";
				$this->Sql.="order by h.CodNivel, d.CodGrado limit 20";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarProfesorCursoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION PROFESOR
	
	//REGION ALUMNO
	public function ObtenerAlumnoSelAll($Buscar){
		$ObjConexion=new Conexion();
				$this->Sql ="SELECT a.CodAlumno, Concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Alumno, ";
				$this->Sql.="DATE_FORMAT(a.FechaNacimiento,'%d/%m/%Y') AS FechaNacimiento, a.Telefono, ";
					$this->Sql.="(SELECT y.NombreAnio ";
					$this->Sql.="FROM matricula x ";
					$this->Sql.="INNER JOIN anio y ON y.CodAnio=x.CodAnio ";
					$this->Sql.="WHERE x.CodAlumno=a.CodAlumno ";
					$this->Sql.="ORDER BY x.CodMatricula DESC limit 1) AS Anio, ";
					$this->Sql.="(SELECT concat(w.NombreNivel,' - ',y.NombreGrado,' - ',z.NombreSeccion) ";
					$this->Sql.="FROM matricula x ";
					$this->Sql.="INNER JOIN grado y ON y.CodGrado=x.CodGrado ";
					$this->Sql.="INNER JOIN seccion z ON z.CodSeccion=x.CodSeccion ";
					$this->Sql.="INNER JOIN nivel w ON w.CodNivel=y.CodNivel ";
					$this->Sql.="WHERE x.CodAlumno=a.CodAlumno ORDER BY x.CodMatricula DESC limit 1) AS GradoSeccion, ";
					$this->Sql.="(SELECT max(x.CodMatricula) FROM matricula x WHERE x.CodAlumno=a.CodAlumno) AS CodMatricula ";
				$this->Sql.="FROM alumno a ";
				$this->Sql.="where Concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,'',a.Nombres) LIKE '%".$Buscar."%' ";
				$this->Sql.="order by CodAlumno desc ";
				$this->Sql.="limit 15";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarAlumnoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerAlumnoSelId($CodAlumno){
		$ObjConexion=new Conexion();
				$this->Sql ="SELECT a.CodAlumno, Concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Alumno, ";
				$this->Sql.="DATE_FORMAT(a.FechaNacimiento,'%d/%m/%Y') AS FechaNacimiento, a.Telefono ";
				$this->Sql.="FROM alumno a WHERE a.CodAlumno=".$CodAlumno." ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarAlumnoSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function InsertAlumno($ApellidoPaterno,$ApellidoMaterno,$Nombres,$FechaNacimiento,$Sexo,$CodTipoDocumento,$NumeroDocumento,$Ubigeo,$Direccion,$Referencia,$Telefono,$EmailPersonal,$EmailInstitucional,$CodColegio,$CodigoUgel,$UsuarioCreacion){
		$ObjConexion=new Conexion();
		$Qry ="SELECT count(CodAlumno) as Cantidad FROM alumno ";
		$Qry.="where ApellidoPaterno='".$ApellidoPaterno."' ";
		$Qry.="and ApellidoMaterno='".ApellidoMaterno."' ";
		$Qry.="and Nombres='".Nombres."' ";
		$rs=mysql_query($Qry, $ObjConexion->Conexion()) or die(mysql_error());
		$row=mysql_fetch_assoc($rs);
		if($row['Cantidad']==1){
			$Retorna=0;
		}else{
			$this->Sql ="INSERT INTO alumno (CodAlumno,ApellidoPaterno,ApellidoMaterno,Nombres,FechaNacimiento, ";
			$this->Sql.="Sexo,CodTipoDocumento,NumeroDocumento,Ubigeo,Direccion,Referencia, ";
			$this->Sql.="Telefono,EmailPersonal,EmailInstitucional,CodColegio,CodigoUgel,UsuarioCreacion,FechaCreacion) ";
			$this->Sql.="values ('null', '".$ApellidoPaterno."','".$ApellidoMaterno."','".$Nombres."','".$FechaNacimiento."', ";
			$this->Sql.="'".$Sexo."', ".$CodTipoDocumento.",'".$NumeroDocumento."','".$Ubigeo."','".$Direccion."', ";
			$this->Sql.="'".$Referencia."','".$Telefono."','".$EmailPersonal."','".$EmailInstitucional."',".$CodColegio.", ";
			$this->Sql.="'".$CodigoUgel."','".$UsuarioCreacion."', now()) ";
			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
			$Retorna=1;
		}
        return $Retorna;
	}
	
	public function UpdateAlumno($CodAlumno,$ApellidoPaterno,$ApellidoMaterno,$Nombres,$FechaNacimiento,$Sexo,$CodTipoDocumento,$NumeroDocumento,$Ubigeo,$Direccion,$Referencia,$Telefono,$EmailPersonal,$EmailInstitucional,$CodColegio,$CodigoUgel,$UsuarioModificacion){
		$ObjConexion=new Conexion();
		if($CodAlumno>0){
			$log=true;			
			$this->Sql ="update alumno set ";
			$this->Sql.="ApellidoPaterno='".$ApellidoPaterno."', ";
			$this->Sql.="ApellidoMaterno='".$ApellidoMaterno."', ";
			$this->Sql.="Nombres='".$Nombres."', ";
			$this->Sql.="FechaNacimiento='".$FechaNacimiento."', ";
			$this->Sql.="Sexo='".$Sexo."', ";
			$this->Sql.="CodTipoDocumento=".$CodTipoDocumento.", ";
			$this->Sql.="NumeroDocumento='".$NumeroDocumento."', ";
			$this->Sql.="Ubigeo='".$Ubigeo."', ";
			$this->Sql.="Direccion='".$Direccion."', ";
			$this->Sql.="Referencia='".$Referencia."', ";
			$this->Sql.="Telefono='".$Telefono."', ";
			$this->Sql.="EmailPersonal='".$EmailPersonal."', ";
			$this->Sql.="EmailInstitucional='".$EmailInstitucional."', ";
			$this->Sql.="CodColegio=".$CodColegio.", ";
			$this->Sql.="UsuarioModificacion='".$UsuarioModificacion."', ";
			$this->Sql.="FechaModificacion=now(), ";
			$this->Sql.="CodigoUgel='".$CodigoUgel."' ";
			$this->Sql.="where CodAlumno=".$CodAlumno." ";
			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		}else{
			$log=false;
		}
		return $log;
	}
	//END REGION ALUMNO
	
	//REGION DIA	
    public function ObtenerDiaSelAll($Desde,$Hasta){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT a.CodDia, DATE_FORMAT(a.FechaApertura,'%d/%m/%Y') as FechaApertura, ";
				$this->Sql.="TIME(a.FechaCreacion) as HoraApertura, ";
				$this->Sql.="case DATE_FORMAT(a.FechaCierre,'%d/%m/%Y') ";
				$this->Sql.="when '00/00/0000' then '' else DATE_FORMAT(a.FechaCierre,'%d/%m/%Y') end as FechaCierre, ";
				$this->Sql.="TIME(a.FechaCierre) as HoraCierre, ";
				$this->Sql.="case a.Estado when 1 then 'Abierto' when 0 then 'Cerrado' end as Estado, a.UsuarioCreacion, ";
				$this->Sql.="(select count(CodCaja) from caja b where b.CodDia=a.CodDia) as Situacion ";
				$this->Sql.="FROM dia a ";
				if($Desde!='' and $Hasta!=''){
					$this->Sql.="where DATE_FORMAT(a.FechaApertura,'%d/%m/%Y') BETWEEN  '".$Desde."' and '".$Hasta."' ";
				}
				$this->Sql.="ORDER BY a.CodDia DESC ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarDiaSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION DIA
	
	//REGION CAJA
    public function ObtenerCajaSelAll($Usuario,$Dia){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT CodCaja, CodDia, DATE_FORMAT(Fecha,'%d/%m/%Y') as Fecha, ";
				$this->Sql.="case Estado when 1 then 'Abierto' when 0 then 'Cerrado' end as Estado, ";
				$this->Sql.="CajaChica, MontoCierre, UsuarioCreacion ";
				$this->Sql.="FROM caja ";
				$this->Sql.="where UsuarioCreacion='".$Usuario."' ";
				$this->Sql.="and (DATE_FORMAT(Fecha,'%d/%m/%Y')='".$Dia."' or ''='".$Dia."') ";
				$this->Sql.="ORDER BY CodDia DESC ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarCajaSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION CAJA
	
	//REGION PRODUCTO
    public function ObtenerProductoSelAll($Buscar){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT CodProducto, NombreProducto, Precio, Descuento, ";
				$this->Sql.="case Estado when 0 then 'Desactivado' else '' end as Estado, ";
				$this->Sql.="case FlagStock when 1 then 'Si' else '' end FlagStock ";
				$this->Sql.="FROM productos where NombreProducto like '%".$Buscar."%' ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarProductoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerProductoSelId($CodProducto){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT CodProducto, NombreProducto, Precio, Descuento, Estado ";
				$this->Sql.="FROM productos where CodProducto = ".$CodProducto." ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarProductoSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerMaximoProductoSelId($Usuario){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT max(CodProducto) as Maximo ";
				$this->Sql.="FROM productos where UsuarioCreacion = '".$Usuario."' ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarMaximoProductoSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function InsertProducto($TipoProducto,$TipoComprobante,$Nombre,$Precio,$Usuario,$Stock){
		$ObjConexion=new Conexion();
		$Qry="SELECT count(*) as Cantidad FROM productos where Nombreproducto='".$Nombre."' ";
		$rs=mysql_query($Qry, $ObjConexion->Conexion()) or die(mysql_error());
		$row=mysql_fetch_assoc($rs);
		if($row['Cantidad']==1){
			$Retorna=0;
		}else{
			$this->Sql ="insert into productos (CodProducto, CodTipoProducto, CodTipoComprobante, NombreProducto, Precio, UsuarioCreacion, FechaCreacion, FlagStock) ";
			$this->Sql.="values ('null', ".$TipoProducto.", ".$TipoComprobante.", '".$Nombre."', '".$Precio."', '".$Usuario."', now(), ".$Stock.") ";
			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
			$Retorna=1;
		}
        return $Retorna;
    }
	
	public function UpdateProducto($CodProducto,$Precio,$Descuento,$Estado,$Usuario){
		$ObjConexion=new Conexion();
		if(trim($Precio)!='' and trim($Descuento)!='' and $Precio>=$Descuento){
			$log=true;
			$this->Sql ="UPDATE productos SET ";
			$this->Sql.="Precio=".$Precio.", ";
			$this->Sql.="Descuento=".$Descuento.", ";
			$this->Sql.="Estado=".$Estado.", ";
			$this->Sql.="UsuarioModificacion='".$Usuario."', ";
			$this->Sql.="FechaModificacion=now() ";
			$this->Sql.="WHERE CodProducto=".$CodProducto." ";
			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		}else{
			$log=false;
		}
		return $log;
	}
	//END REGION PRODUCTO
	
	//REGION STOCK
	public function InsertStock($CodProducto,$Stock,$UsuarioCreacion){
		$ObjConexion=new Conexion();
		$this->Sql ="insert into stock (CodStock, CodProducto, Stock, UsuarioCreacion, FechaCreacion) ";
		$this->Sql.="values ('null', ".$CodProducto.", ".$Stock.", '".$UsuarioCreacion."', now()) ";
		$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		$Retorna=1;
		return $Retorna;
    }
	//END REGION STOCK

        //REGION MOVIMIENTO
        public function ObtenerMovimientoSelAll($Anio,$Grado,$Seccion,$Usuario,$Fecha){
		$ObjConexion=new Conexion();
            $this->Sql ="SELECT a.CodComprobante, ";
			$this->Sql.="(SELECT concat(y.NombreGrado,' - ',z.NombreSeccion) ";
            $this->Sql.="FROM matricula x ";
            $this->Sql.="INNER JOIN grado y ON y.CodGrado=x.CodGrado ";
            $this->Sql.="INNER JOIN seccion z ON z.CodSeccion=x.CodSeccion ";
            $this->Sql.="WHERE x.CodAlumno=b.CodAlumno ORDER BY x.CodMatricula DESC limit 1) AS Grado, ";
            $this->Sql.="CASE a.TipoModulo WHEN 0 THEN concat(b.ApellidoPaterno,' ',b.ApellidoMaterno,' ',b.Nombres) ";
			$this->Sql.="WHEN 1 THEN concat('*',rtrim(c.Nombres)) END AS Alumno, ";
            $this->Sql.="(SELECT SUM(x.SubTotal) FROM detallecomprobante x WHERE x.CodComprobante=a.CodComprobante) AS Monto, ";
            $this->Sql.="a.UsuarioCreacion, ";
            $this->Sql.="Date_format(a.FechaCreacion,'%d/%m/%Y') AS FechaCreacion,  ";
            $this->Sql.="Date_format(a.FechaCreacion,'%h:%i:%s %p') AS Hora ";
            $this->Sql.="FROM comprobante a ";
            $this->Sql.="LEFT JOIN alumno b ON a.CodAlumno=b.CodAlumno AND TipoModulo=0 ";
			$this->Sql.="LEFT JOIN cliente c ON c.CodCliente=a.CodAlumno AND TipoModulo=1 ";
            $this->Sql.="where Date_format(a.FechaCreacion,'%d/%m/%Y')='".$Fecha."' ";
			$this->Sql.="and (a.UsuarioCreacion='".$Usuario."' or ''='".$Usuario."') ";
            $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarMovimientoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
    //END REGION MOVIMIENTO
	
	//REGION PERFIL
	public function ObtenerPerfilSelAll(){
		$ObjConexion=new Conexion();
                $this->Sql="SELECT CodPerfil, NombrePerfil FROM perfil WHERE Estado = 1 ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarPerfilSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION PERFIL
	
	//REGION PERFIL
	public function ObtenerUsuarioAlumnoEmailSelAll($Perfil,$Grado,$Seccion){
		$ObjConexion=new Conexion();
			switch ($Perfil) {
				case 1:
					$this->Sql ="SELECT a.CodAlumno as Codigo, a.UsuarioId AS Usuario,  ";
					$this->Sql.="concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Nombres ";
					$this->Sql.="FROM alumno a ";
					$this->Sql.="INNER JOIN matricula b ON b.CodAlumno=a.CodAlumno ";
					$this->Sql.="WHERE a.Estado=1 ";
					$this->Sql.="AND b.EstadoRetirado=0 ";
					$this->Sql.="AND b.CodGrado='".$Grado."' ";
					$this->Sql.="AND b.CodSeccion='".$Seccion."' ";
					break;
				case 2:
					$this->Sql ="SELECT a.CodPersonal as Codigo, a.UsuarioId AS Usuario,  ";
					$this->Sql.="concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Nombres ";
					$this->Sql.="FROM personal a ";
					$this->Sql.="WHERE a.CodTipoPersonal=2 AND a.Estado=1 ";
					break;
				case 3:
					$this->Sql ="SELECT a.CodPersonal as Codigo, a.UsuarioId AS Usuario,  ";
					$this->Sql.="concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Nombres ";
					$this->Sql.="FROM personal a ";
					$this->Sql.="WHERE a.CodTipoPersonal IN (1000) AND a.Estado=1 ";
					break;
				case 4:
					$this->Sql ="SELECT a.CodPersonal as Codigo, a.UsuarioId AS Usuario,  ";
					$this->Sql.="concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Nombres ";
					$this->Sql.="FROM personal a ";
					$this->Sql.="WHERE a.CodTipoPersonal IN (1,3) AND a.Estado=1 ";
					break;
			}
            $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarUsuarioAlumnoEmailSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION PERFIL
	
	//REGION NIVEL
	public function ObtenerNivelSelAll(){
		$ObjConexion=new Conexion();
                $this->Sql="SELECT CodNivel, NombreNivel FROM nivel WHERE Estado = 1 ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarNivelSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION NIVEL
	
	//REGION CONSULTA MATRICULA
	public function ObtenerConsultaMatriculaSelAll($Anio,$Nivel,$Grado,$Seccion,$Estado){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT a.CodAlumno, concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Alumno, ";
				$this->Sql.="concat(e.NombreNivel,' ',c.NombreGrado,' ',d.NombreSeccion) AS GradoSeccion, ";
				$this->Sql.="CASE b.EstadoRetirado WHEN 0 THEN 'Activo' WHEN 1 THEN 'Retirado' END AS Estado ";
				$this->Sql.="FROM alumno a ";
				$this->Sql.="INNER JOIN matricula b ON b.CodAlumno=a.CodAlumno ";
				$this->Sql.="INNER JOIN grado c ON c.CodGrado=b.CodGrado ";
				$this->Sql.="INNER JOIN seccion d ON d.CodSeccion=b.CodSeccion ";
				$this->Sql.="INNER JOIN nivel e ON e.CodNivel=c.CodNivel ";
				$this->Sql.="WHERE b.CodAnio='".$Anio."' ";
				$this->Sql.="AND e.CodNivel='".$Nivel."' ";
				$this->Sql.="AND (b.CodGrado='".$Grado."' or ''='".$Grado."') ";
				$this->Sql.="AND (b.CodSeccion='".$Seccion."' or ''='".$Seccion."') ";
				$this->Sql.="AND (b.EstadoRetirado='".$Estado."' or 2='".$Estado."') ";
				$this->Sql.="order by e.CodNivel, c.CodGrado, concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarConsultaMatriculaSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION CONSULTA MATRICULA
	
	//REGION CONSULTA PROFESOR CURSO
	public function ObtenerConsultaProfesorCursoSelAll($Anio,$Nivel,$Grado,$Seccion){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT b.CodProfesorCurso, f.NombreAnio, ";
				$this->Sql.="concat(h.NombreNivel,' ',d.NombreGrado,' ',g.NombreSeccion) AS GradoSeccion, ";
				$this->Sql.="concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Profesor, ";
				$this->Sql.="e.NombreCurso ";
				$this->Sql.="FROM personal a ";
				$this->Sql.="INNER JOIN profesorcurso b ON b.CodPersonal=a.CodPersonal ";
				$this->Sql.="INNER JOIN cursogrado c ON c.CodCurGra=b.CodCurGra ";
				$this->Sql.="INNER JOIN grado d ON d.CodGrado=c.CodGrado ";
				$this->Sql.="INNER JOIN curso e ON e.CodCurso=c.CodCurso ";
				$this->Sql.="INNER JOIN anio f ON f.CodAnio=b.CodAnio ";
				$this->Sql.="INNER JOIN seccion g ON g.CodSeccion=b.CodSeccion ";
				$this->Sql.="INNER JOIN nivel h ON h.CodNivel=d.CodNivel ";
				$this->Sql.="WHERE b.CodAnio='".$Anio."' ";
				$this->Sql.="AND h.CodNivel='".$Nivel."' ";
				$this->Sql.="AND (b.CodGrado='".$Grado."' or ''='".$Grado."') ";
				$this->Sql.="AND (b.CodSeccion='".$Seccion."' or ''='".$Seccion."') ";
				$this->Sql.="order by h.CodNivel, d.CodGrado ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarConsultaProfesorCursoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION CONSULTA PROFESOR CURSO

    //REGION CONSULTA CRITERIOS DE EVALUACION
	public function ObtenerConsultaCriterioSelAll($Anio,$Nivel,$Grado,$Area){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT a.CodCriterio, concat(d.NombreNivel,' ',b.NombreGrado) AS Grado, ";
				$this->Sql.="c.NombreArea, a.NombreCriterio, a.Porcentaje, ";
                $this->Sql.="(SELECT x.NroNotas FROM criteriocurso x WHERE x.CodCriterio=a.CodCriterio) AS Nro ";
                $this->Sql.="FROM criterio a ";
                $this->Sql.="INNER JOIN grado b ON b.CodGrado=a.CodGrado ";
                $this->Sql.="INNER JOIN area c ON c.CodArea=a.CodArea ";
                $this->Sql.="INNER JOIN nivel d ON d.CodNivel=b.CodNivel ";
                $this->Sql.="WHERE a.CodAnio='".$Anio."' ";
                $this->Sql.="AND d.CodNivel='".$Nivel."' ";
                $this->Sql.="AND (a.CodGrado='".$Grado."' or ''='".$Grado."') ";
                $this->Sql.="AND (a.CodArea='".$Area."' or ''='".$Area."') ";
                $this->Sql.="order by d.CodNivel, a.CodGrado, c.NombreArea ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarConsultaCriterioSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION CONSULTA CRITERIOS DE EVALUACION

    //REGION CONSULTA CAJA
	public function ObtenerConsultaCajaSelAll($Dia){
		$ObjConexion=new Conexion();
                $this->Sql ="SELECT CodCaja, CodDia, DATE_FORMAT(Fecha,'%d/%m/%Y') AS Fecha, ";
		$this->Sql.="CASE Estado WHEN 1 THEN 'Abierto' WHEN 0 THEN 'Cerrado' END AS Estado, ";
                $this->Sql.="CajaChica, MontoCierre, UsuarioCreacion ";
                $this->Sql.="FROM caja ";
                $this->Sql.="WHERE (DATE_FORMAT(Fecha,'%d/%m/%Y')='".$Dia."' OR ''='".$Dia."') ";
                $this->Sql.="ORDER BY CodCaja DESC ";
                $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarConsultaCajaSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION CONSULTA CAJA
	
	//REGION MENU ADMINISTRATIVO
	public function ObtenerMenuAdministrativoSelAll($Usuario){
		$ObjConexion=new Conexion();
            $this->Sql ="SELECT a.Id, a.NombrePrograma AS Nombre, a.IdPadre, a.Url ";
			$this->Sql.="FROM programa a ";
            $this->Sql.="RIGHT OUTER JOIN permiso b ON b.CodPrograma=a.Id ";
            $this->Sql.="WHERE a.CodPerfil=4 ";
            $this->Sql.="AND b.Usuario='".$Usuario."' ";
            $this->Sql.="GROUP by a.Peso, a.Id ";
            $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarMenuAdministrativoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION MENU ADMINISTRATIVO
	
	//REGION DETALLE BOLETA
	public function ObtenerDetalleBoletaSelAll($Comprobante){
		$ObjConexion=new Conexion();
            $this->Sql ="SELECT CASE b.Tipo WHEN 'Pension' THEN concat('Mensualidad',' ',c.NroPension)  ";
            $this->Sql.="WHEN 'Concepto' THEN d.NombreProducto ";
            $this->Sql.="WHEN 'Credito' THEN (SELECT x.NombreProducto FROM productos x WHERE x.CodProducto=e.CodProducto) END AS Concepto, ";
            $this->Sql.="b.SubTotal, b.PrecioUnit-b.SubTotal-b.Dscto AS Saldo ";
            $this->Sql.="FROM comprobante a ";
            $this->Sql.="INNER JOIN detallecomprobante b ON b.CodComprobante=a.CodComprobante ";
            $this->Sql.="LEFT JOIN programacionalumno c ON c.CodProgramacionAlumno=b.Codigo AND b.Tipo='Pension' ";
            $this->Sql.="LEFT JOIN productos d ON d.CodProducto=b.Codigo AND b.Tipo='Concepto' ";
            $this->Sql.="LEFT JOIN detallecuentacorriente e ON e.CodDetalleCuentaCorriente=b.Codigo AND b.Tipo='Credito' ";
            $this->Sql.="WHERE a.codcomprobante='".$Comprobante."' ";
            $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarDetalleBoletaSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION DETALLE BOLETA
	
	//REGION EGRESO CAJA
	public function ObtenerEgresoCajaSelAll($Usuario,$Fecha){
            $ObjConexion=new Conexion();
            $this->Sql ="SELECT b.UsuarioCreacion, a.CodCaja, b.Para, b.Entrega, b.Descripcion, ";
            $this->Sql.="DATE_FORMAT(b.FechaCreacion,'%d/%m/%Y') AS FechaCreacion, TIME(b.FechaCreacion) AS HoraCreacion ";
            $this->Sql.="FROM caja a ";
            $this->Sql.="INNER JOIN egresocaja b ON b.CodCaja=a.CodCaja ";
            $this->Sql.="WHERE b.UsuarioCreacion='".$Usuario."' ";
            $this->Sql.="AND (DATE_FORMAT(b.FechaCreacion,'%d/%m/%Y')='".$Fecha."' or ''='".$Fecha."') ";
            $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarEgresoCajaSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function InsertEgresoCaja($CodCaja, $Autorizado, $Para, $Disponible, $Entrega, $Descripcion, $Usuario){
		$ObjConexion=new Conexion();
		/*$Qry="SELECT count(*) as Cantidad FROM EgresoCaja where CodCaja='".$Nombre."' ";
		$rs=mysql_query($Qry, $ObjConexion->Conexion()) or die(mysql_error());
		$row=mysql_fetch_assoc($rs);
		if($row['Cantidad']==1){
			$Retorna=0;
		}else{*/
			$this->Sql ="INSERT INTO egresocaja (CodEgresoCaja, CodCaja, Autorizado, Para, Disponible, Entrega, Descripcion, UsuarioCreacion, FechaCreacion) ";
			$this->Sql.="values ('null', '".$CodCaja."', '".$Autorizado."', '".$Para."', '".$Disponible."', '".$Entrega."', '".$Descripcion."', '".$Usuario."', now()) ";
			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
			$Retorna=1;
		//}
        //return $Retorna;
		return 1;
    }

    public function ObtenerCodigoCajaSelId($Usuario){
        $ObjConexion=new Conexion();
        $this->Sql ="SELECT CodCaja ";
	$this->Sql.="FROM caja ";
	$this->Sql.="WHERE UsuarioCreacion='".$Usuario."' ";
        $this->Sql.="AND Estado=1 ";
        $this->Sql.="AND DATE_FORMAT(Fecha,'%d/%m/%Y')=DATE_FORMAT(now(),'%d/%m/%Y') ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarCodigoCajaSelId($rs){
        return mysql_fetch_assoc($rs);
    }

    public function ObtenerExisteEgresoSelId($CodCaja,$Usuario){
        $ObjConexion=new Conexion();
        $this->Sql ="SELECT COUNT(CodEgresoCaja) AS Cantidad ";
	$this->Sql.="FROM egresocaja ";
	$this->Sql.="WHERE CodCaja='".$CodCaja."' ";
        $this->Sql.="AND UsuarioCreacion='".$Usuario."' ";
        $this->Sql.="AND DATE_FORMAT(FechaCreacion,'%d/%m/%Y')=DATE_FORMAT(now(),'%d/%m/%Y') ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarExisteEgresoSelId($rs){
        return mysql_fetch_assoc($rs);
    }

    public function ObtenerMontoDisponibleSelId($Usuario){
        $ObjConexion=new Conexion();
        /*$this->Sql ="SELECT ifnull(SUM(Subtotal),0) AS Monto ";
	$this->Sql.="FROM detallecomprobante ";
        $this->Sql.="where UsuarioCreacion='".$Usuario."' ";
        $this->Sql.="AND DATE_FORMAT(FechaCreacion,'%d/%m/%Y')=DATE_FORMAT(now(),'%d/%m/%Y') ";*/
        $this->Sql ="SELECT ifnull(SUM(b.Subtotal),0) AS Monto ";
	$this->Sql.="FROM comprobante a ";
        $this->Sql.="INNER JOIN detallecomprobante b ON b.CodComprobante=a.CodComprobante ";
        $this->Sql.="INNER JOIN caja c ON c.CodCaja=a.CodCaja ";
        $this->Sql.="where b.UsuarioCreacion='".$Usuario."' ";
        $this->Sql.="AND DATE_FORMAT(b.FechaCreacion,'%d/%m/%Y')=DATE_FORMAT(now(),'%d/%m/%Y') ";
        $this->Sql.="AND c.Estado=1 ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarMontoDisponibleSelId($rs){
        return mysql_fetch_assoc($rs);
    }

    public function ObtenerMontoEgresoSelId($CodCaja,$Usuario){
        $ObjConexion=new Conexion();
        $this->Sql ="select SUM(Entrega) AS Monto ";
	$this->Sql.="FROM egresocaja ";
	$this->Sql.="WHERE CodCaja='".$CodCaja."' ";
        $this->Sql.="AND UsuarioCreacion='".$Usuario."' ";
        $this->Sql.="AND DATE_FORMAT(FechaCreacion,'%d/%m/%Y')=DATE_FORMAT(now(),'%d/%m/%Y') ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarMontoEgresoSelId($rs){
        return mysql_fetch_assoc($rs);
    }
    //END REGION EGRESO CAJA
	
	//REGION MENU UBIGEO
	public function ObtenerDepartamentoSelAll(){
		$ObjConexion=new Conexion();
            $this->Sql ="SELECT CodDepartamento, Nombre FROM ubigeo ";
			$this->Sql.="WHERE CodDepartamento<>'00' ";
			$this->Sql.="AND CodProvincia='00' ";
			$this->Sql.="AND CodDistrito='00' ";
            $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarDepartamentoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerProvinciaSelAll(){
		$ObjConexion=new Conexion();
            $this->Sql ="SELECT CodDepartamento, CodProvincia, concat(CodDepartamento,'',CodProvincia) AS Suma, Nombre FROM ubigeo ";
			$this->Sql.="WHERE CodDepartamento<>'00' ";
			$this->Sql.="AND CodProvincia<>'00' ";
			$this->Sql.="AND CodDistrito='00' ";
            $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarProvinciaSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerDistritoSelAll(){
		$ObjConexion=new Conexion();
            $this->Sql ="SELECT CodDepartamento, CodProvincia, CodDistrito, concat(CodDepartamento,'',CodProvincia) AS Suma, concat(CodDepartamento,'',CodProvincia,'',CodDistrito) AS Suma3, Nombre FROM ubigeo ";
			$this->Sql.="WHERE CodDepartamento<>'00' ";
			$this->Sql.="AND CodProvincia<>'00' ";
			$this->Sql.="AND CodDistrito<>'00' ";
            $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarDistritoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION UBIGEO
	
	
	
	//REGION ALUMNO RETIRADO
	public function ObtenerRetiradoSelAll($CodAnio,$Buscar){
		$ObjConexion=new Conexion();
        $this->Sql ="SELECT a.CodAlumno, ";
		$this->Sql.="concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Alumno, ";
		$this->Sql.="concat(d.NombreGrado,' ',e.NombreSeccion) AS GradoSeccion, f.NombreAnio, ";
		$this->Sql.="DATE_FORMAT(c.FechaCreacion,'%d/%m/%Y') as FechaCreacion ";
		$this->Sql.="FROM alumno a ";
		$this->Sql.="INNER JOIN matricula b ON b.CodAlumno=a.CodAlumno ";
		$this->Sql.="INNER JOIN retirado c ON c.CodMatricula=b.CodMatricula ";
		$this->Sql.="INNER JOIN grado d ON d.CodGrado=b.CodGrado ";
		$this->Sql.="INNER JOIN seccion e ON e.CodSeccion=b.CodSeccion ";
		$this->Sql.="INNER JOIN anio f ON f.CodAnio=b.CodAnio ";
		$this->Sql.="WHERE b.CodAnio=".$CodAnio." ";
		$this->Sql.="AND concat(a.ApellidoPaterno,' ',a.ApellidoPaterno,' ',a.Nombres) LIKE '%".$Buscar."%' ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarRetiradoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerMatriculaAlumnoSelId($CodMatricula){
		$ObjConexion=new Conexion();
        $this->Sql ="SELECT a.CodAlumno, b.CodMatricula, ";
		$this->Sql.="concat(a.ApellidoPaterno,' ',a.ApellidoPaterno,' ',a.Nombres) AS Alumno ";
		$this->Sql.="FROM alumno a ";
		$this->Sql.="INNER JOIN matricula b ON b.CodAlumno=a.CodAlumno ";
		$this->Sql.="WHERE b.CodMatricula=".$CodMatricula." ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarMatriculaAlumnoSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function InsertRetiro($CodAlumno, $CodMatricula, $CodColegio, $MotivoRetiro, $Descripcion, $Usuario){
		$ObjConexion=new Conexion();
		$Qry="SELECT count(*) as Cantidad FROM retirado where CodAlumno='".$CodAlumno."' and CodMatricula='".$CodMatricula."' ";
		$rs=mysql_query($Qry, $ObjConexion->Conexion()) or die(mysql_error());
		$row=mysql_fetch_assoc($rs);
		if($row['Cantidad']==1){
			$Retorna=0;
		}else{
			$this->Sql ="INSERT INTO retirado (CodRetirado,CodAlumno,CodMatricula, ";
			$this->Sql.="CodColegio,MotivoRetiro,Descripcion, UsuarioCreacion,FechaCreacion) ";
			$this->Sql.="values ('null','".$CodAlumno."','".$CodMatricula."','".$CodColegio."', ";
			$this->Sql.="'".$MotivoRetiro."','".$Descripcion."','".$Usuario."',now()) ";
			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
			$Retorna=1;
		}
        return $Retorna;
    }
	
	public function UpdateRetiroMatricula($CodMatricula,$UsuarioModificacion){
		$ObjConexion=new Conexion();
		if($CodMatricula>0){
			$log=true;
			$this->Sql ="UPDATE matricula SET ";
			$this->Sql.="EstadoRetirado=1, ";
            $this->Sql.="UsuarioModificacion='".$UsuarioModificacion."', ";
            $this->Sql.="FechaModificacion=now() ";
			$this->Sql.="WHERE CodMatricula=".$CodMatricula." ";
			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		}else{
			$log=false;
		}
		return $log;
	}
	
	
	//END REGION ALUMNO RETIRADO
	
	
	
	
	//REGION MENU PADRE DE FAMILIA
	public function ObtenerMenuPadreSelAll(){
		$ObjConexion=new Conexion();
            $this->Sql="SELECT Id, NombrePrograma as Nombre, IdPadre, Url FROM programa WHERE CodPerfil=3 ";
            $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarMenuPadreSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerPadreFamiliaSelAll($Buscar){
		$ObjConexion=new Conexion();
            $this->Sql ="SELECT a.CodPadreFamilia, a.Tipo, concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Padre, ";
			$this->Sql.="concat(a.Telefono,' - ',a.Celular,' - ',a.Nextel) AS Telefonos, a.Email, ";
                        $this->Sql.="CASE a.Tipo ";
                        $this->Sql.="WHEN 'P' THEN (SELECT COUNT(*) FROM alumno x WHERE x.CodPadre=a.CodPadreFamilia) ";
                        $this->Sql.="WHEN 'M' THEN (SELECT COUNT(*) FROM alumno x WHERE x.CodMadre=a.CodPadreFamilia) ";
                        $this->Sql.="END Nro ";
			$this->Sql.="FROM padrefamilia a ";
			$this->Sql.="WHERE concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) LIKE '%".$Buscar."%' ";
			$this->Sql.="order by concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) ";
            $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarPadreFamiliaSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function InsertPadreFamilia($Tipo,$ApellidoPaterno,$ApellidoMaterno,$Nombres,$FechaNacimiento,$CodTipoDocumento,$Dni,$Ubigeo,$Direccion,$Referencia,$Telefono,$Celular,$Nextel,$Email,$UsuarioCreacion){
		$ObjConexion=new Conexion();
		$Qry="SELECT count(CodPadreFamilia) as Cantidad FROM padrefamilia where dni='".$Dni."' ";
		$rs=mysql_query($Qry, $ObjConexion->Conexion()) or die(mysql_error());
		$row=mysql_fetch_assoc($rs);
		if($row['Cantidad']==1){
			$Retorna=0;
		}else{
			$this->Sql ="INSERT INTO padrefamilia (CodPadreFamilia,Tipo,ApellidoPaterno,ApellidoMaterno,Nombres,FechaNacimiento,CodTipoDocumento,Dni,Ubigeo,Direccion,Referencia,Telefono,Celular,Nextel,Email,UsuarioCreacion,FechaCreacion) ";
			$this->Sql.="values ('null', '".$Tipo."','".$ApellidoPaterno."','".$ApellidoMaterno."','".$Nombres."','".$FechaNacimiento."', '".$CodTipoDocumento."','".$Dni."','".$Ubigeo."','".$Direccion."','".$Referencia."','".$Telefono."','".$Celular."','".$Nextel."','".$Email."','".$UsuarioCreacion."', now()) ";
			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
			$Retorna=1;
		}
        return $Retorna;
	}

        public function ObtenerPadreFamiliaSelId($CodPadreFamilia){
		$ObjConexion=new Conexion();
            $this->Sql ="SELECT CodPadreFamilia,Tipo,ApellidoPaterno,ApellidoMaterno, ";
			$this->Sql.="Nombres,FechaNacimiento,CodTipoDocumento,Dni,Ubigeo, ";
			$this->Sql.="Direccion,Referencia,Telefono,Celular,Nextel,Email, ";
			$this->Sql.="UsuarioCreacion,FechaCreacion ";
			$this->Sql.="FROM padrefamilia ";
                        $this->Sql.="where CodPadreFamilia='".$CodPadreFamilia."' ";
            $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarPadreFamiliaSelId($rs){
        return mysql_fetch_assoc($rs);
    }

    public function ObtenerPadreFamiliaSelId2($Usuario){
		$ObjConexion=new Conexion();
            $this->Sql ="SELECT CodPadreFamilia,Tipo,ApellidoPaterno,ApellidoMaterno, ";
			$this->Sql.="Nombres,FechaNacimiento,CodTipoDocumento,Dni,Ubigeo, ";
			$this->Sql.="Direccion,Referencia,Telefono,Celular,Nextel,Email, ";
			$this->Sql.="UsuarioCreacion,FechaCreacion ";
			$this->Sql.="FROM padrefamilia ";
                        $this->Sql.="where UsuarioId='".$Usuario."' ";
            $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarPadreFamiliaSelId2($rs){
        return mysql_fetch_assoc($rs);
    }

    public function UpdatePadreFamilia($CodPadreFamilia,$ApellidoPaterno,$ApellidoMaterno,$Nombres,$FechaNacimiento,$CodTipoDocumento,$Dni,$Ubigeo,$Direccion,$Referencia,$Telefono,$Celular,$Nextel,$Email,$UsuarioModificacion){
		$ObjConexion=new Conexion();
		if(trim($ApellidoPaterno)!='' and trim($ApellidoMaterno)!='' and $Nombres!='' and $Dni!=''){
			$log=true;
			$this->Sql ="UPDATE padrefamilia SET ";
			$this->Sql.="ApellidoPaterno='".$ApellidoPaterno."', ";
			$this->Sql.="ApellidoMaterno='".$ApellidoMaterno."', ";
			$this->Sql.="Nombres='".$Nombres."', ";
			$this->Sql.="FechaNacimiento='".$FechaNacimiento."', ";
			$this->Sql.="CodTipoDocumento='".$CodTipoDocumento."', ";
                        $this->Sql.="Dni='".$Dni."', ";
                        $this->Sql.="Ubigeo='".$Ubigeo."', ";
                        $this->Sql.="Direccion='".$Direccion."', ";
                        $this->Sql.="Referencia='".$Referencia."', ";
                        $this->Sql.="Telefono='".$Telefono."', ";
                        $this->Sql.="Celular='".$Celular."', ";
                        $this->Sql.="Nextel='".$Nextel."', ";
                        $this->Sql.="Email='".$Email."', ";
                        $this->Sql.="UsuarioModificacion='".$UsuarioModificacion."', ";
                        $this->Sql.="FechaModificacion=now() ";
			$this->Sql.="WHERE CodPadreFamilia=".$CodPadreFamilia." ";
			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		}else{
			$log=false;
		}
		return $log;
	}
        public function UpdateAlumnoPadreFamilia($CodPadreFamilia,$CodAlumno,$Tipo,$UsuarioModificacion){
		$ObjConexion=new Conexion();
		if(trim($CodPadreFamilia)>=0 and trim($CodAlumno)>=0 and $Tipo!=''){
			$log=true;
			$this->Sql ="UPDATE alumno SET ";
                        if($Tipo=='P'){
                            $this->Sql.="CodPadre='".$CodPadreFamilia."', ";
                        }else{
                            $this->Sql.="CodMadre='".$CodPadreFamilia."', ";
                        }
                        $this->Sql.="UsuarioModificacion='".$UsuarioModificacion."', ";
                        $this->Sql.="FechaModificacion=now() ";
			$this->Sql.="WHERE CodAlumno=".$CodAlumno." ";
			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		}else{
			$log=false;
		}
		return $log;
	}

        public function ObtenerHijosDePadreSelAll($CodigoPadreFamilia,$Tipo){
		$ObjConexion=new Conexion();
            $this->Sql ="SELECT a.CodAlumno, concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres) AS Alumno, ";
            $this->Sql.="(SELECT MAX(y.NombreAnio) ";
            $this->Sql.="FROM matricula x ";
            $this->Sql.="INNER JOIN anio y ON y.CodAnio=x.CodAnio ";
            $this->Sql.="WHERE x.CodAlumno=a.CodAlumno) AS Anio, ";
            $this->Sql.="'Estado' ";
            $this->Sql.="FROM alumno a ";
            if($Tipo=='P'){
                $this->Sql.="WHERE a.CodPadre='".$CodigoPadreFamilia."' ";
            }else{
                $this->Sql.="WHERE a.CodMadre='".$CodigoPadreFamilia."' ";
            }
            $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarHijosDePadreSelAll($rs){
        return mysql_fetch_assoc($rs);
    }

    public function ObtenerInformacionDelPadreSelId($CodigoPadreFamilia){
		$ObjConexion=new Conexion();
            $this->Sql ="SELECT a.CodPadreFamilia, ";
            $this->Sql.="CASE a.Tipo WHEN 'P' THEN 'Padre de Familia' ELSE 'Madre de Familia' END AS Tipo, ";
            $this->Sql.="a.ApellidoPaterno, a.ApellidoMaterno, a.Nombres, ";
            $this->Sql.="DATE_FORMAT(a.FechaNacimiento,'%d/%m/%Y') AS FechaNacimiento, b.NombreTipoDocumento, a.Dni, ";
            $this->Sql.="concat( ";
            $this->Sql.="(SELECT x.Nombre FROM ubigeo x WHERE x.CodDepartamento<>'00' AND x.CodProvincia='00' AND x.CodDistrito='00' AND x.CodDepartamento=LEFT(a.Ubigeo,2)),' - ', ";
            $this->Sql.="(SELECT x.Nombre FROM ubigeo x WHERE x.CodDepartamento<>'00' AND x.CodProvincia<>'00' AND x.CodDistrito='00' AND x.CodDepartamento=LEFT(a.Ubigeo,2) AND x.CodProvincia=RIGHT(LEFT(a.Ubigeo,4),2)),' - ', ";
            $this->Sql.="(SELECT x.Nombre FROM ubigeo x WHERE x.CodDepartamento<>'00' AND x.CodProvincia<>'00' AND x.CodDistrito<>'00' AND x.CodDepartamento=LEFT(a.Ubigeo,2) AND x.CodProvincia=RIGHT(LEFT(a.Ubigeo,4),2) AND x.CodDistrito=RIGHT(a.Ubigeo,2)) ";
            $this->Sql.=") AS Ubigeo, ";
            $this->Sql.="a.Direccion, a.Referencia, a.Telefono, a.Celular, a.Nextel, a.Email, a.UsuarioCreacion, DATE_FORMAT(a.FechaCreacion,'%d/%m/%Y') AS FechaCreacion ";
            $this->Sql.="FROM padrefamilia a ";
            $this->Sql.="LEFT JOIN tipodocumento b ON b.CodTipoDocumento=a.CodTipoDocumento ";
            $this->Sql.="WHERE CodPadreFamilia='".$CodigoPadreFamilia."' ";
            $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarInformacionDelPadreSelId($rs){
        return mysql_fetch_assoc($rs);
    }

    public function ObtenerCronogramaPagoHijoSelAll($CodAlumno){
        $ObjConexion=new Conexion();
        $this->Sql ="SELECT a.CodProgramacionAlumno AS Id, b.NombreAnio AS Anio, c.NombreGrado AS Grado, ";
        $this->Sql.="CASE a.NroPension ";
        $this->Sql.="WHEN 1 THEN 'Marzo' WHEN 2 THEN 'Abril' ";
        $this->Sql.="WHEN 3 THEN 'Mayo' WHEN 4 THEN 'Junio' ";
        $this->Sql.="WHEN 5 THEN 'Julio' WHEN 6 THEN 'Agosto' ";
        $this->Sql.="WHEN 7 THEN 'Setiembre' WHEN 8 THEN 'Octubre' ";
        $this->Sql.="WHEN 9 THEN 'Noviembre' WHEN 10 THEN 'Diciembre' ";
        $this->Sql.="END AS NroPension, ";
        $this->Sql.="a.Monto, a.Mora, a.Pagado, DATE_FORMAT(a.FechaInicio,'%d/%m/%Y') AS FechaInicio, ";
        $this->Sql.="DATE_FORMAT(a.FechaTermino,'%d/%m/%Y') AS FechaTermino, ";
        $this->Sql.="DATE_FORMAT(a.FechaModificacion,'%d/%m/%Y') AS FechaModificacion ";
        $this->Sql.="FROM programacionalumno a ";
        $this->Sql.="INNER JOIN anio b ON b.CodAnio=a.CodAnio ";
        $this->Sql.="INNER JOIN grado c ON c.CodGrado=a.CodGrado ";
        $this->Sql.="WHERE a.CodAlumno='".$CodAlumno."' ";
        $this->Sql.="AND a.Estado=1 ";
        $this->Sql.="AND a.Monto+a.Mora>a.Pagado ";
        $this->Sql.="ORDER BY a.NroPension ";
            $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarCronogramaPagoHijoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }

    public function ObtenerDeudaCreditoHijoSelAll($CodAlumno){
        $ObjConexion=new Conexion();
        $this->Sql ="SELECT a.CodCuentaCorriente, b.CodDetalleCuentaCorriente, c.CodProducto AS Id, c.NombreProducto AS Producto, ";
        $this->Sql.="b.MontoPagar AS Pagar, b.MontoPagado AS Pagado, b.Descuento AS Dscto, ";
        $this->Sql.="DATE_FORMAT(b.FechaCreacion,'%d/%m/%Y') AS FechaCreacion ";
        $this->Sql.="FROM cuentacorriente a ";
        $this->Sql.="INNER JOIN detallecuentacorriente b ON b.CodCuentaCorriente=a.CodCuentaCorriente ";
        $this->Sql.="INNER JOIN productos c ON c.CodProducto=b.CodProducto ";
        $this->Sql.="WHERE a.Estado=1 AND b.Estado=1 ";
        $this->Sql.="AND b.MontoPagar>b.MontoPagado+b.Descuento ";
        $this->Sql.="AND a.CodAlumno='".$CodAlumno."' ";
            $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarDeudaCreditoHijoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerAreaPorAlumnoSelAll($CodAlumno,$CodAnio,$CodGrado,$CodSeccion){
        $ObjConexion=new Conexion();
        $this->Sql ="SELECT d.CodArea, d.NombreArea ";
        $this->Sql.="FROM matricula a ";
        $this->Sql.="INNER JOIN matriculacurso b ON b.CodMatricula=a.CodMatricula ";
        $this->Sql.="INNER JOIN cursogrado c ON c.CodCurGra=b.CodCurGra ";
        $this->Sql.="INNER JOIN area d ON d.CodArea=c.CodArea ";
        $this->Sql.="WHERE a.CodAlumno<>".$CodAlumno." ";
        $this->Sql.="AND a.CodAnio=".$CodAnio." ";
        $this->Sql.="AND a.CodGrado=".$CodGrado." ";
        $this->Sql.="AND a.CodSeccion=".$CodSeccion." ";
        $this->Sql.="group by d.CodArea, d.NombreArea ";
        $this->Sql.="ORDER BY d.NombreArea ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarAreaPorAlumnoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }

	public function ObtenerCursoDocentePorAlumnoSelAll($CodPersonal,$CodAnio,$CodGrado,$CodSeccion){
        $ObjConexion=new Conexion();
        $this->Sql ="SELECT d.NombreArea AS Area, c.NombreCurso AS Curso ";
        $this->Sql.="FROM profesorcurso a ";
        $this->Sql.="INNER JOIN cursogrado b ON b.CodCurGra=a.CodCurGra ";
        $this->Sql.="INNER JOIN curso c ON c.CodCurso=b.CodCurso ";
        $this->Sql.="INNER JOIN area d ON d.CodArea=b.CodArea ";
        $this->Sql.="WHERE a.CodPersonal='".$CodPersonal."' ";
        $this->Sql.="AND a.CodAnio='".$CodAnio."' ";
        $this->Sql.="AND a.CodGrado='".$CodGrado."' ";
        $this->Sql.="AND a.CodSeccion='".$CodSeccion."' ";
        $this->Sql.="ORDER BY d.NombreArea, c.NombreCurso ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarCursoDocentePorAlumnoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerCompanierosAlumnoSelAll($CodAlumno,$CodAnio,$CodGrado,$CodSeccion){
        $ObjConexion=new Conexion();
        $this->Sql ="SELECT a.CodAlumno, upper(concat(a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres)) AS Alumno ";
        $this->Sql.="FROM alumno a ";
        $this->Sql.="INNER JOIN matricula b ON b.Codalumno=a.Codalumno ";
        $this->Sql.="WHERE a.CodAlumno<>".$CodAlumno." ";
        $this->Sql.="AND b.CodAnio=".$CodAnio." ";
        $this->Sql.="AND b.CodGrado=".$CodGrado." ";
        $this->Sql.="AND b.CodSeccion=".$CodSeccion." ";
        $this->Sql.="ORDER BY a.ApellidoPaterno,' ',a.ApellidoMaterno,' ',a.Nombres ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarCompanierosAlumnoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerNroNotaCriterioSelAll($CodArea,$CodAnio,$CodGrado){
        $ObjConexion=new Conexion();
        $this->Sql ="SELECT a.CodCriterio, a.NombreCriterio, ";
        $this->Sql.="(SELECT NroNotas FROM criteriocurso x WHERE x.CodCriterio=a.CodCriterio) AS NroNota ";
        $this->Sql.="FROM criterio a ";
        $this->Sql.="WHERE a.CodAnio=".$CodAnio." ";
        $this->Sql.="AND a.CodArea=".$CodArea." ";
        $this->Sql.="AND a.CodGrado=".$CodGrado." ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarNroNotaCriterioSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerSumaNotaCriterioSelAll($CodArea,$CodAnio,$CodGrado){
        $ObjConexion=new Conexion();
        $this->Sql ="SELECT ";
        $this->Sql.="sum((SELECT NroNotas FROM criteriocurso x WHERE x.CodCriterio=a.CodCriterio)) AS NroNota ";
        $this->Sql.="FROM criterio a ";
        $this->Sql.="WHERE a.CodAnio=".$CodAnio." ";
        $this->Sql.="AND a.CodArea=".$CodArea." ";
        $this->Sql.="AND a.CodGrado=".$CodGrado." ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarSumaNotaCriterioSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerCursoPorAreaAlumnoSelAll($CodAlumno,$CodAnio,$CodGrado,$CodSeccion,$CodArea){
        $ObjConexion=new Conexion();
        $this->Sql ="SELECT c.CodCurGra, d.CodCurso, d.NombreCurso ";
        $this->Sql.="FROM matricula a ";
        $this->Sql.="INNER JOIN matriculacurso b ON b.CodMatricula=a.CodMatricula ";
        $this->Sql.="INNER JOIN cursogrado c ON c.CodCurGra=b.CodCurGra ";
        $this->Sql.="INNER JOIN curso d ON d.CodCurso=c.CodCurso ";
        $this->Sql.="WHERE a.CodAlumno=".$CodAlumno." ";
        $this->Sql.="AND a.CodAnio=".$CodAnio." ";
        $this->Sql.="AND a.CodGrado=".$CodGrado." ";
        $this->Sql.="AND a.CodSeccion=".$CodSeccion." ";
        $this->Sql.="AND c.CodArea=".$CodArea." ";
        $this->Sql.="ORDER BY d.NombreCurso ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarCursoPorAreaAlumnoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	 public function ObtenerNroNotaPorCriterioSelAll($CodCriterio){
        $ObjConexion=new Conexion();
        $this->Sql ="SELECT a.CodCriterioCurso, a.CodCriterio, b.CodCriterioNroNota, b.NroEvaluacion ";
        $this->Sql.="FROM criteriocurso a ";
        $this->Sql.="INNER JOIN criterionronota b ON b.CodCriterioCurso=a.CodCriterioCurso ";
        $this->Sql.="WHERE a.CodCriterio=".$CodCriterio." ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarNroNotaPorCriterioSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	 public function ObtenerEvaluacionCriterioSelId($CodMatricula,$CodBimestre,$CodArea,$CodCriterio){
        $ObjConexion=new Conexion();
        $this->Sql ="SELECT d.Nota ";
        $this->Sql.="FROM criterio a ";
        $this->Sql.="INNER JOIN criteriocurso b ON b.CodCriterio=a.CodCriterio ";
        $this->Sql.="INNER JOIN criterionronota c ON c.CodCriterioCurso=b.CodCriterioCurso ";
        $this->Sql.="INNER JOIN criterionotaprimaria d ON d.CodCriterioNroNota=c.CodCriterioNroNota ";
        $this->Sql.="WHERE d.CodMatricula=".$CodMatricula." ";
        $this->Sql.="AND d.CodBimestre=".$CodBimestre." ";
        $this->Sql.="AND a.CodArea=".$CodArea." ";
        $this->Sql.="AND a.CodCriterio=".$CodCriterio." ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarEvaluacionCriterioSelId($rs){
        return mysql_fetch_assoc($rs);
    }
    //END REGION MENU PADRE DE FAMILIA
	
	
	
	
	//REGION CONCEPTO PARA FACTURAR
	public function ObtenerPensionSelAll($CodAlumno){
        $ObjConexion=new Conexion();	
		$this->Sql ="SELECT a.CodProgramacionAlumno as Id, b.NombreAnio, c.NombreGrado, ";
		$this->Sql.="a.NroPension as Item, a.Monto, a.Mora, a.Pagado, a.Monto+a.Mora-a.Pagado as Total ";
		$this->Sql.="FROM programacionalumno a ";
		$this->Sql.="INNER JOIN anio b ON b.CodAnio=a.CodAnio ";
		$this->Sql.="INNER JOIN grado c ON c.CodGrado=a.CodGrado "; 
		$this->Sql.="WHERE a.CodAlumno=".$CodAlumno." ";
		$this->Sql.="AND a.Estado=1 ";
		$this->Sql.="AND a.Monto+a.Mora>a.Pagado ";
		$this->Sql.="order by a.FechaTermino ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarPensionSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerCreditoSelAll($CodAlumno){
        $ObjConexion=new Conexion();			
		$this->Sql ="SELECT a.CodCuentaCorriente, b.CodDetalleCuentaCorriente as Id, c.CodProducto, ";
		$this->Sql.="c.NombreProducto as Producto, b.MontoPagar-b.MontoPagado-b.Descuento as Pagar, ";
		$this->Sql.="b.Descuento as Dscto ";
		$this->Sql.="FROM cuentacorriente a ";
		$this->Sql.="INNER JOIN detallecuentacorriente b ON b.CodCuentaCorriente=a.CodCuentaCorriente ";
		$this->Sql.="INNER JOIN productos c ON c.CodProducto=b.CodProducto ";
		$this->Sql.="WHERE a.Estado=1 ";
		$this->Sql.="AND b.Estado=1 and b.MontoPagar>b.MontoPagado+b.Descuento ";
		$this->Sql.="AND a.CodAlumno=".$CodAlumno." ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarCreditoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerConceptoSelAll(){
        $ObjConexion=new Conexion();					
		$this->Sql ="SELECT CodProducto as Id, CodTipoProducto, NombreProducto as Producto, ";
		$this->Sql.="Precio-Descuento AS Precio, Descuento as Dscto ";
		$this->Sql.="FROM productos where Estado=1 ";
		$this->Sql.="ORDER BY NombreProducto ASC ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarConceptoSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function InsertConceptoaTemporal($CodAlumno,$CodProducto,$Tipo,$UsuarioCreacion,$Modulo){
		$ObjConexion=new Conexion();
		/*$Qry="SELECT count(*) as Cantidad FROM temporal where UsuarioCreacion='".$UsuarioCreacion."' and CodAlumno=".$CodAlumno." ";
		$rs=mysql_query($Qry, $ObjConexion->Conexion()) or die(mysql_error());
		$row=mysql_fetch_assoc($rs);
		if($row['Cantidad']==1){
			$Retorna=0;
		}else{*/
			$this->Sql ="INSERT INTO temporal (CodAlumno,CodTipoComprobante,Tipo,Codigo,Concepto,";
			$this->Sql.="Cantidad,PrecioUnit,Monto,Dscto,Mora,Total,UsuarioCreacion,FechaCreacion,TipoModulo) ";
			$this->Sql.="SELECT ".$CodAlumno.", CodTipoComprobante,'".$Tipo."', CodProducto, NombreProducto, ";
			$this->Sql.="1, Precio, Precio, Descuento, 0.00, Precio-Descuento, '".$UsuarioCreacion."', now(), ".$Modulo." ";
			$this->Sql.="FROM productos ";
			$this->Sql.="WHERE Estado = 1  ";
			$this->Sql.="AND CodProducto=".$CodProducto." ";
			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
			$Retorna=1;
		/*}*/
        return $Retorna;
		
    }
	
	public function InsertCreditoaTemporal($CodAlumno,$CodProducto,$Tipo,$UsuarioCreacion){
		$ObjConexion=new Conexion();
		$Qry ="SELECT count(*) as Cantidad ";
		$Qry.="from temporal WHERE Tipo='Credito' ";
		$Qry.="AND UsuarioCreacion='".$UsuarioCreacion."' ";
		$Qry.="and CodAlumno=".$CodAlumno." ";
		$Qry.="and Codigo=".$CodProducto." ";
		$rs=mysql_query($Qry, $ObjConexion->Conexion()) or die(mysql_error());
		$row=mysql_fetch_assoc($rs);
		if($row['Cantidad']==1){
			$Retorna=0;
		}else{
			$this->Sql ="INSERT INTO temporal (CodAlumno,CodTipoComprobante,Tipo,Codigo,Concepto,Cantidad,PrecioUnit, ";
			$this->Sql.="Monto,Dscto,Mora,Total,UsuarioCreacion,FechaCreacion) ";
			$this->Sql.="SELECT ".$CodAlumno.",c.CodTipoComprobante,'".$Tipo."',b.CodDetalleCuentaCorriente,c.NombreProducto, ";
			$this->Sql.="1,b.MontoPagar-b.MontoPagado,b.MontoPagar-b.MontoPagado, b.Descuento,0.00, ";
			$this->Sql.="b.MontoPagar-b.MontoPagado-b.Descuento,'".$UsuarioCreacion."',now() ";
			$this->Sql.="FROM cuentacorriente a ";
			$this->Sql.="INNER JOIN detallecuentacorriente b ON b.CodCuentaCorriente=a.CodCuentaCorriente ";
			$this->Sql.="INNER JOIN productos c ON c.CodProducto=b.CodProducto ";
			$this->Sql.="WHERE CodAlumno=".$CodAlumno." ";
			$this->Sql.="AND b.CodDetalleCuentaCorriente=".$CodProducto." ";

			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
			$Retorna=1;
		}
        return $Retorna;
    }
	
	public function InsertPensionaTemporal($CodAlumno,$CodProducto,$Tipo,$UsuarioCreacion){
		$ObjConexion=new Conexion();
		$Qry ="SELECT count(*) as Cantidad ";
		$Qry.="from temporal WHERE Tipo='Pension' ";
		$Qry.="AND UsuarioCreacion='".$UsuarioCreacion."' ";
		$Qry.="and CodAlumno=".$CodAlumno." ";
		$Qry.="and Codigo=".$CodProducto." ";
		$rs=mysql_query($Qry, $ObjConexion->Conexion()) or die(mysql_error());
		$row=mysql_fetch_assoc($rs);
		if($row['Cantidad']==1){
			$Retorna=0;
		}else{
			$this->Sql ="INSERT INTO temporal (CodAlumno,CodTipoComprobante,Tipo,Codigo,Concepto,Cantidad,PrecioUnit, ";
			$this->Sql.="Monto,Dscto,Mora,Total,UsuarioCreacion,FechaCreacion) ";
			$this->Sql.="SELECT ".$CodAlumno.",1,'".$Tipo."',a.CodProgramacionAlumno,concat('Pensión',' - ',a.NroPension),1, ";
			$this->Sql.="a.Monto,a.Monto-a.Pagado,0.00,   a.Mora, a.Monto+a.Mora-a.Pagado,'".$UsuarioCreacion."',now() ";
			$this->Sql.="FROM programacionalumno a ";
			$this->Sql.="INNER JOIN anio b ON b.CodAnio=a.CodAnio ";
			$this->Sql.="INNER JOIN grado c ON c.CodGrado=a.CodGrado ";
			$this->Sql.="WHERE a.CodAlumno=".$CodAlumno." ";
			$this->Sql.="AND a.Estado=1 AND a.Monto+a.Mora>a.Pagado ";
			$this->Sql.="AND a.CodProgramacionAlumno=".$CodProducto." ";

			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
			$Retorna=1;
		}
        return $Retorna;
    }
	
	public function ObtenerTipoReciboSelAll($UsuarioCreacion){
        $ObjConexion=new Conexion();					
		$this->Sql ="SELECT CodTipoComprobante ";
		$this->Sql.="FROM temporal ";
		$this->Sql.="WHERE UsuarioCreacion='".$UsuarioCreacion."' ";
		$this->Sql.="GROUP by CodTipoComprobante ";
		$this->Sql.="ORDER BY CodTipoComprobante ASC ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarTipoReciboSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function InsertComprobante($CodAlumno,$CodTipoComprobante,$UsuarioCreacion,$CodCaja,$CodOperacion,$TipoModulo){
		$ObjConexion=new Conexion();
		$this->Sql ="insert into comprobante (CodComprobante, CodAlumno, CodTipoComprobante, ";
		$this->Sql.="UsuarioCreacion, FechaCreacion, CodCaja, CodOperacion, TipoModulo) ";
		$this->Sql.="values ('null', ".$CodAlumno.", ".$CodTipoComprobante.", '".$UsuarioCreacion."', ";
		$this->Sql.="now(), ".$CodCaja.", ".$CodOperacion.", ".$TipoModulo.") ";
		$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		$Retorna=1;
		return $Retorna;
    }
	
	public function InsertDetalleComprobante($CodComprobante,$UsuarioCreacion,$CodAlumno,$CodTipoComprobante){
		$ObjConexion=new Conexion();
		$this->Sql ="insert into detallecomprobante (CodComprobante,Tipo,Codigo,Cantidad,PrecioUnit,Dscto,Mora,SubTotal,UsuarioCreacion,FechaCreacion) ";
		$this->Sql.="SELECT ".$CodComprobante.",Tipo,Codigo,Cantidad,PrecioUnit,Dscto,Mora,Total,'".$UsuarioCreacion."',now() ";
		$this->Sql.="FROM temporal ";
		$this->Sql.="WHERE UsuarioCreacion='".$UsuarioCreacion."' AND CodAlumno=".$CodAlumno." AND CodTipoComprobante=".$CodTipoComprobante." ";
		$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		$Retorna=1;
		return $Retorna;
    }
	
	public function EliminarTemporal($UsuarioCreacion,$CodAlumno,$CodTipoComprobante){
		$ObjConexion=new Conexion();
		$this->Sql ="delete from temporal where UsuarioCreacion='".$UsuarioCreacion."' ";
		$this->Sql.="and CodAlumno=".$CodAlumno." and CodTipoComprobante=".$CodTipoComprobante." ";
		$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		$Retorna=true;
    }
	
	public function ObtenerCodigoComprobanteSelId($CodAlumno,$UsuarioCreacion){
        $ObjConexion=new Conexion();					
		$this->Sql ="SELECT MAX(CodComprobante) AS CodComprobante ";
		$this->Sql.="FROM comprobante ";
		$this->Sql.="where CodAlumno=".$CodAlumno." ";
		$this->Sql.="and UsuarioCreacion='".$UsuarioCreacion."' ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarCodigoComprobanteSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerDetalleComprobantePorTipoComprobanteSelAll($CodTipoComprobante,$CodAlumno,$CodComprobante){
        $ObjConexion=new Conexion();					
		$this->Sql ="SELECT b.CodDetalleComprobante, a.CodTipoComprobante, b.CodComprobante, b.Tipo, b.Codigo, ";
		$this->Sql.="b.Cantidad, b.PrecioUnit, b.Dscto, b.Mora, (b.Cantidad*b.PrecioUnit)-b.Dscto+b.Mora AS Suma, ";
		$this->Sql.="b.SubTotal, b.UsuarioCreacion, b.FechaCreacion ";
		$this->Sql.="FROM comprobante a ";
		$this->Sql.="INNER JOIN detallecomprobante b ON b.CodComprobante=a.CodComprobante ";
		$this->Sql.="WHERE a.CodTipoComprobante=".$CodTipoComprobante." ";
		$this->Sql.="AND a.CodAlumno=".$CodAlumno." ";
		$this->Sql.="AND a.CodComprobante=".$CodComprobante." ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarDetalleComprobantePorTipoComprobanteSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION CONCEPTO PARA FACTURAR
	
	
	//REGION CUENTA CORRIENTE
	public function ObtenerCuentaCorrienteSelId($CodAlumno){
        $ObjConexion=new Conexion();					
		$this->Sql ="SELECT CodCuentaCorriente, CodAlumno, Estado ";
		$this->Sql.="FROM cuentacorriente ";
		$this->Sql.="where CodAlumno=".$CodAlumno." ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
    public function PoblarCuentaCorrienteSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function UpdateMontoPagadoDetalleCuentaCorriente($CodDetalleCuentaCorriente,$MontoPagado,$UsuarioModificacion){
		$ObjConexion=new Conexion();
		if($CodDetalleCuentaCorriente>0){
			$log=true;
			$this->Sql ="UPDATE detallecuentacorriente SET ";
            $this->Sql.="MontoPagado=MontoPagado+".$MontoPagado.", ";
            $this->Sql.="UsuarioModificacion='".$UsuarioModificacion."', ";
            $this->Sql.="FechaModificacion=now() ";
			$this->Sql.="WHERE CodDetalleCuentaCorriente=".$CodDetalleCuentaCorriente." ";
			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		}else{
			$log=false;
		}
		return $log;
	}
	//END REGION CUENTA CORRIENTE
	
	//REGION CUENTA DETALLE CORRIENTE
	public function InsertDetalleCuentaCorriente($CuentaCorriente,$CodProducto,$MontoPagar,$MontoPagado,$Descuento,$Estado,$UsuarioCreacion){
		$ObjConexion=new Conexion();
		$this->Sql ="insert into detallecuentacorriente (CodDetalleCuentaCorriente,CodCuentaCorriente, ";
		$this->Sql.="CodProducto,MontoPagar,MontoPagado,Descuento,Estado,UsuarioCreacion,FechaCreacion) ";
		$this->Sql.="values ('null',".$CuentaCorriente.",".$CodProducto.",".$MontoPagar.",".$MontoPagado.", ";
		$this->Sql.="".$Descuento.",".$Estado.",'".$UsuarioCreacion."',now()) ";
		$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		$Retorna=1;
		return $Retorna;
    }
	//END REGION CUENTA DETALLE CORRIENTE
	
	//REGION PROGRAMACIONALUMNO
	public function UpdateMontoPagadoProgramacionAlumno($CodProgramacionAlumno,$Pagado,$UsuarioModificacion){
		$ObjConexion=new Conexion();
		if($CodProgramacionAlumno>0){
			$log=true;
			$this->Sql ="UPDATE programacionalumno SET ";
            $this->Sql.="Pagado=Pagado+".$Pagado.", ";
            $this->Sql.="UsuarioModificacion='".$UsuarioModificacion."', ";
            $this->Sql.="FechaModificacion=now() ";
			$this->Sql.="WHERE CodProgramacionAlumno=".$CodProgramacionAlumno." ";
			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		}else{
			$log=false;
		}
		return $log;
	}
	//END REGION PROGRAMACIONALUMNO
	
	
	//REGION OPERACION
	public function InsertOperacion($UsuarioCreacion){
		$ObjConexion=new Conexion();
		$this->Sql ="insert into operacion (CodOperacion,UsuarioCreacion,FechaCreacion) ";
		$this->Sql.="values ('null','".$UsuarioCreacion."',now()) ";
		$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		
		/*$objDatos=new datos();
		$rsOperacion=$objDatos->ObtenerCodigoOperacionSelId();
		$rowOperacion=$objDatos->PoblarCodigoOperacionSelId(rsOperacion);*/
		
		/*$Qry ="SELECT max(CodOperacion) as CodOperacion ";
		$Qry.="FROM operacion ";
		$rsOperacion=mysql_query($Qry, $ObjConexion->Conexion()) or die(mysql_error());
		$rowOperacion=mysql_fetch_assoc($rsOperacion);*/
		
		$Retorna=1;	//$rowOperacion['CodOperacion'];
		return $Retorna;
    }
	
	public function ObtenerCodigoOperacionSelId(){
        $ObjConexion=new Conexion();					
		$this->Sql ="SELECT max(CodOperacion) as CodOperacion ";
		$this->Sql.="FROM operacion ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
	public function PoblarCodigoOperacionSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	//END REGION OPERACION
	
	
	//REGION COMPROBANTE
	public function ObtenerComprobanteOperacionSelAll($CodOperacion){
        $ObjConexion=new Conexion();							
		$this->Sql ="SELECT CodComprobante,CodAlumno,CodTipoComprobante,Estado, ";
		$this->Sql.="UsuarioCreacion,DATE_FORMAT(FechaCreacion,'%d/%m/%Y') AS FechaCreacion, ";
		$this->Sql.="UsuarioModificacion,DATE_FORMAT(FechaCreacion,'%d/%m/%Y') AS FechaModificacion, ";
		$this->Sql.="CodCaja,CodOperacion ";
		$this->Sql.="FROM comprobante ";
		$this->Sql.="WHERE CodOperacion=".$CodOperacion." order by CodTipoComprobante ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
	public function PoblarComprobanteOperacionSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerComprobantePrintSelAll($CodAlumno,$CodComprobante){
        $ObjConexion=new Conexion();							
		$this->Sql ="SELECT a.CodComprobante, b.CodDetalleComprobante, ";
		$this->Sql.="CASE b.Tipo ";
		$this->Sql.="WHEN 'Pension' THEN (SELECT concat('Pension - ',x.NroPension) FROM programacionalumno x "; 	
		$this->Sql.="WHERE x.CodProgramacionAlumno=b.Codigo) ";
		$this->Sql.="WHEN 'Concepto' THEN (SELECT y.NombreProducto FROM productos y WHERE y.CodProducto=b.Codigo) ";
		
		$this->Sql.="WHEN 'Credito' THEN (SELECT x.NombreProducto ";
		$this->Sql.="FROM productos x ";
		$this->Sql.="INNER JOIN detallecuentacorriente y ON y.CodProducto=x.CodProducto ";
		$this->Sql.="INNER JOIN cuentacorriente z ON z.CodCuentaCorriente=y.CodCuentaCorriente ";
		$this->Sql.="WHERE z.CodAlumno=a.CodAlumno ";
		$this->Sql.="AND y.CodDetalleCuentaCorriente=b.Codigo ";
		$this->Sql.="AND y.MontoPagar>MontoPagado) ";
		$this->Sql.="END AS Concepto, ";
		
		$this->Sql.="b.Cantidad, b.PrecioUnit, b.Cantidad*b.PrecioUnit AS Monto, b.Dscto, b.Mora, b.SubTotal, ";
		$this->Sql.="b.FechaCreacion ";
		$this->Sql.="FROM comprobante a ";
		$this->Sql.="INNER JOIN detallecomprobante b ON b.CodComprobante=a.CodComprobante ";
		$this->Sql.="WHERE a.CodAlumno=".$CodAlumno." ";
		$this->Sql.="AND a.CodComprobante=".$CodComprobante." ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
	public function PoblarComprobantePrintSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerComprobanteTotalSelId($CodAlumno,$CodComprobante){
        $ObjConexion=new Conexion();									
		$this->Sql ="SELECT SUM(b.SubTotal) AS Total ";
		$this->Sql.="FROM comprobante a ";
		$this->Sql.="INNER JOIN detallecomprobante b ON b.CodComprobante=a.CodComprobante ";
		$this->Sql.="WHERE a.CodAlumno=".$CodAlumno." ";
		$this->Sql.="AND a.CodComprobante=".$CodComprobante." ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
	public function PoblarComprobanteTotalSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function ObtenerDetalleGeneralPagosSelAll($CodAlumno){
        $ObjConexion=new Conexion();									
		$this->Sql ="SELECT a.CodComprobante, a.CodTipoComprobante, SUM(b.SubTotal) AS SubTotal, ";
		$this->Sql.="DATE_FORMAT(a.FechaCreacion,'%d/%m/%Y') as FechaCreacion, ";
		$this->Sql.="Date_format(a.FechaCreacion,'%h:%i:%s %p') AS Hora, ";
		$this->Sql.="a.UsuarioCreacion, a.CodCaja, a.CodOperacion ";
		$this->Sql.="FROM comprobante a ";
		$this->Sql.="INNER JOIN detallecomprobante b ON b.CodComprobante=a.CodComprobante ";
		$this->Sql.="WHERE a.CodAlumno=".$CodAlumno." ";
		$this->Sql.="GROUP by b.CodComprobante ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
	public function PoblarDetalleGeneralPagosSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	//END REGION COMPROBANTE
	
	public function ObtenerUsuarioCajaSelAll(){
        $ObjConexion=new Conexion();									
		$this->Sql ="SELECT a.UsuarioCreacion, concat(b.Apellidos,' ',b.Nombres) AS Usuario ";
		$this->Sql.="FROM comprobante a ";
		$this->Sql.="INNER JOIN usuario b ON b.Login=a.UsuarioCreacion ";
		$this->Sql.="GROUP by a.UsuarioCreacion ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
	public function PoblarUsuarioCajaSelAll($rs){
        return mysql_fetch_assoc($rs);
    }
	
	//REGION CLIENTE
	public function InsertCliente($Nombres,$Direccion,$Telefono,$UsuarioCreacion){
		$ObjConexion=new Conexion();
		$this->Sql ="INSERT INTO cliente (Nombres,Direccion,Telefono,UsuarioCreacion,FechaCreacion) ";
		$this->Sql.="VALUES ('".$Nombres."','".$Direccion."','".$Telefono."','".$UsuarioCreacion."',now()) ";
		$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());		
		return 1;
    }
	
	public function ObtenerClienteSelId(){
        $ObjConexion=new Conexion();									
		$this->Sql ="SELECT max(CodCliente) as CodCliente ";
		$this->Sql.="FROM cliente ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
	public function PoblarClienteSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	//END REGION CLIENTE
	
	
	//REGION USUARIO
	public function ObtenerClaveSelId($Usuario,$Password){
        $ObjConexion=new Conexion();									
		$this->Sql ="SELECT COUNT(CodUsuario) AS Cantidad ";
		$this->Sql.="FROM usuario ";
		$this->Sql.="WHERE Login='".$Usuario."' AND Password='".$Password."' ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
	public function PoblarClaveSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function UpdateClaveUsuario($Login,$Password,$UsuarioModificacion){
		$ObjConexion=new Conexion();
		if(strlen($Login)>0){
			$log=true;
			$this->Sql ="UPDATE usuario SET ";
            $this->Sql.="Password='".$Password."', ";
            $this->Sql.="UsuarioModificacion='".$UsuarioModificacion."', ";
            $this->Sql.="FechaModificacion=now() ";
			$this->Sql.="WHERE Login='".$Login."' ";
			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		}else{
			$log=false;
		}
		return $log;
	}
	
	public function UpdateUsuarioPersonal($CodPersonal,$UsuarioId,$UsuarioModificacion){
		$ObjConexion=new Conexion();
		if(strlen($UsuarioId)>0){
			$log=true;
			$this->Sql ="UPDATE personal SET ";
            $this->Sql.="UsuarioId='".$UsuarioId."', ";
            $this->Sql.="UsuarioModificacion='".$UsuarioModificacion."', ";
            $this->Sql.="FechaModificacion=now() ";
			$this->Sql.="WHERE CodPersonal=".$CodPersonal." ";
			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		}else{
			$log=false;
		}
		return $log;
	}
	
	public function UpdateUsuarioAlumno($CodAlumno,$UsuarioId,$UsuarioModificacion){
		$ObjConexion=new Conexion();
		if(strlen($UsuarioId)>0){
			$log=true;
			$this->Sql ="UPDATE alumno SET ";
            $this->Sql.="UsuarioId='".$UsuarioId."', ";
            $this->Sql.="UsuarioModificacion='".$UsuarioModificacion."', ";
            $this->Sql.="FechaModificacion=now() ";
			$this->Sql.="WHERE CodAlumno=".$CodAlumno." ";
			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		}else{
			$log=false;
		}
		return $log;
	}
	
	public function UpdateUsuarioPadre($CodPadreFamilia,$UsuarioId,$UsuarioModificacion){
		$ObjConexion=new Conexion();
		if(strlen($UsuarioId)>0){
			$log=true;
			$this->Sql ="UPDATE padrefamilia SET ";
            $this->Sql.="UsuarioId='".$UsuarioId."', ";
            $this->Sql.="UsuarioModificacion='".$UsuarioModificacion."', ";
            $this->Sql.="FechaModificacion=now() ";
			$this->Sql.="WHERE CodPadreFamilia=".$CodPadreFamilia." ";
			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		}else{
			$log=false;
		}
		return $log;
	}
	
	//END REGION USUARIO
	
	
	//REGION STOCK
	public function ObtenerStockCabeceraDetalleSelId($CodProducto){
        $ObjConexion=new Conexion();									
		$this->Sql ="SELECT a.CodProducto, a.NombreProducto, b.NombreTipoProducto, ";
		$this->Sql.="c.NombreTipoComprobante, d.Stock, d.StockOriginal ";
		$this->Sql.="FROM productos a ";
		$this->Sql.="INNER JOIN tipoproducto b ON b.CodtipoProducto=a.CodtipoProducto ";
		$this->Sql.="INNER JOIN tipocomprobante c ON c.CodTipoComprobante=a.CodTipoComprobante ";
		$this->Sql.="INNER JOIN stock d ON d.CodProducto=a.CodProducto ";
		$this->Sql.="WHERE a.CodProducto=".$CodProducto." ";
        $this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
        return $this->Rs;
    }
	public function PoblarStockCabeceraDetalleSelId($rs){
        return mysql_fetch_assoc($rs);
    }
	
	public function UpdateStock($CodProducto,$Stock,$StockOriginal,$NroAgregado,$Usuario){
		$ObjConexion=new Conexion();
		if(strlen($Usuario)>0){
			$log=true;
			$this->Sql ="UPDATE stock SET ";
            $this->Sql.="StockOriginal=Stock, ";
			$this->Sql.="Stock=Stock+".$NroAgregado.", ";
			$this->Sql.="NroAgregado=".$NroAgregado.", ";
            $this->Sql.="UsuarioModificacion='".$Usuario."', ";
            $this->Sql.="FechaModificacion=now() ";
			$this->Sql.="WHERE CodProducto=".$CodProducto." ";
			$this->Rs = mysql_query($this->Sql, $ObjConexion->Conexion()) or die(mysql_error());
		}else{
			$log=false;
		}
		return $log;
	}
	// END REGION STOCK
	

	
	  
}

?>