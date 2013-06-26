<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
* Convert an strind date with format  aaaa-mm-dd to dd/mm/aaaa 
*
* @@author  Author(s): Jesus Rodriguez
* @access   public
* @param    string	date
* @param 	string  separator input
* @param 	string	separator output
* @return   string
*/  

function date_iso_to_latin($date,$input = '-', $output = '/'){
		if ($date != '') 
			return  implode($output, array_reverse(explode($input,$date)));
		else 
			return '00/00/0000';					    
		
}

/**
* 
* Convert an strind date with format dd/mm/aaaa to aaaa-mm-dd 
*
* @@author  Author(s): Jesus Rodriguez
* @access   public
* @param    string	date
* @param    string	separator input
* @param    string	separator output
* @return   string
*/  

function date_latin_to_iso($date,$input = '/', $output = '-'){
	if ($date != '') 
		return  implode($output, array_reverse(explode($input,$date)));
	else 
		return '0000-00-00 00:00:00';					    
		
}

function now_mysql_date(){
	return  date("Y-m-d");		
}

function now_mysql_datetime(){
	return  date("Y-m-d H:i:s"); 		
}

function get_hour($f = 0){
	switch ($f) {
   		case 0:
       		return  date("Y-m-d h:i:s a");
       		break;
       	case 1:
       		return  date("Y-m-d H:i:s");        		
       		break;
       	case 2:
       		return  date("d-m-Y h:i:s a");
       		break;
       	case 3:
       		return  date("d-m-Y H:i:s");
       		break;	
       	case 4:
       		return  date("Y/m/d H:i:s");
       		break;
       	case 5:
       		return  date("Y/m/d");
       		break;
       	case 6:
       		return  date(DATE_RFC1123);
       		break;
	}
return 0;		 		
}

function check_date_latin($date){
	$sep = "[\/\-\.]";  
    $req = "#^(((0?[1-9]|1\d|2[0-8]){$sep}(0?[1-9]|1[012])|(29|30){$sep}(0?[13456789]|1[012])|31{$sep}(0?[13578]|1[02])){$sep}(19|[2-9]\d)\d{2}|29{$sep}0?2{$sep}((19|[2-9]\d)(0[48]|[2468][048]|[13579][26])|(([2468][048]|[3579][26])00)))$#";  
    $filtro1 = preg_match($req, $date);  
	if ($filtro1) {		
		$separator_type= array("/","-",".");
		foreach ($separator_type as $separator) {
          		$find= stripos($date,$separator);
          		if($find<>false){
              		$separator_used = $separator;
          		}
       	}		 
	
		$partes = explode($separator_used,$date);
		#var_dump($partes);				
		$day    = $partes[0];
		$month  = $partes[1];
		$year   = $partes[2];		
		$filtro2 = checkdate($month,$day,$year); 		
	}
	if ($filtro1 && $filtro2)
		return TRUE;
	return FALSE;		
}

function dateDe($fecha){
	if ($fecha !="" ){
	 	$arrFecha = explode("-",$fecha);		 	
	 	$anho=$arrFecha[0];
	 	$mes=$arrFecha[1];
	 	$dia=$arrFecha[2];
	 	$fecha=$dia."-".$mes."-".$anho;
	 	return $fecha;
	}else
		return "";	
}

function datePg($fecha){
	if ($fecha!=""){
	 	$arrFecha=explode("-",$fecha);		 	
	 	$anho=$arrFecha[2];
	 	$mes=$arrFecha[1];
	 	$dia=$arrFecha[0];
	 	$fecha=$anho."-".$mes."-".$dia;
	 	return $fecha;
	}
	else
		return "";	
}

function fecha_legible($fecha) {  
	$week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");  
	$months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

	$arr_espacios = explode(" ",$fecha);	
	$p1 = $arr_espacios[0] ; // Para la fecha
	$p2 = $arr_espacios[1] ; // Para la hora
	$arrFecha = explode('-',$p1);	
	
	$mes  = $arrFecha[1];
	$dia  = $arrFecha[0];
	$anho = $arrFecha[2];	
			 
	$year 		= date ('Y',mktime(0, 0, 0, $mes, $dia, $anho));
	$month 		= date ('n',mktime(0, 0, 0, $mes, $dia, $anho));	  
	$day 		= date ('j',mktime(0, 0, 0, $mes, $dia, $anho));	  
	$week_day 	= date ('w',mktime(0, 0, 0, $mes, $dia, $anho));  
	$date = $week_days[$week_day] . ", " . $day . " de " . $months[$month] . " de " . $year.", $arr_espacios[1] $arr_espacios[2]  " ;   
	return $date;      
	
	/*
	$week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");  
	$months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	$arrFecha=explode("-",$fecha);		 	
	$anho=$arrFecha[2];
	$mes=$arrFecha[1];
	$dia=$arrFecha[0];	  
	$year_now = date ("Y");  
	$month_now = date ("n");  
	$day_now = date ("j");  
	$week_day_now = date ("w");  
	$date = $week_days[$week_day_now] . ", " . $day_now . " de " . $months[$month_now] . " de " . $year_now;   
	return $date;  
	*/
}