<?php

function prep_pdf($orientation = 'portrait')
{
	$CI = & get_instance();
	
	$CI->cezpdf->selectFont(base_url() . '/fonts');	
	
	$all = $CI->cezpdf->openObject();
	$CI->cezpdf->saveState();
	$CI->cezpdf->setStrokeColor(0,0,0,1);
	if($orientation == 'portrait') {
		$CI->cezpdf->ezSetMargins(80,70,120,120);
		
		$img 	= FCPATH.'/public/images/topbolivariano.jpeg';
		#$CI->cezpdf->addJpegFromFile($img,15,770,550,43);
		$CI->cezpdf->addJpegFromFile($img,30,720,550,43);
		
		$CI->cezpdf->ezStartPageNumbers(500,28,8,'','{PAGENUM} de {TOTALPAGENUM}',1);
		$CI->cezpdf->line(20,40,578,40);
		$CI->cezpdf->addText(50,32,8,'Generado el ' . date('d-m-Y h:i:s a'));
		$system_name = utf8_decode($CI->config->item('system_name'));
		$CI->cezpdf->addText(50,22,8,"$system_name - ".base_url());
	}
	else {
		$root	= $_SERVER['DOCUMENT_ROOT'];
		$site 	= explode('/',$_SERVER['REQUEST_URI']);		
		$path 	= substr($root,0,strlen($root)-1) ;
		$img 	= "$path/{$site[1]}/public/images/topbolivariano.jpeg";
		$CI->cezpdf->addJpegFromFile($img,25,785,550,43);		
		
		$CI->cezpdf->ezStartPageNumbers(750,28,8,'','{PAGENUM} de {TOTALPAGENUM}',1);		
		$CI->cezpdf->line(20,40,800,40);
		$CI->cezpdf->addText(50,32,8,'Generado el ' . date('d-m-Y h:i:s a'));
		$CI->cezpdf->addText(50,22,8,'Sistema de Valija Diplomática - '.base_url());
	}
	$CI->cezpdf->restoreState();
	$CI->cezpdf->closeObject();
	$CI->cezpdf->addObject($all,'all');
}

?>