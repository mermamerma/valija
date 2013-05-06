<?php

/**
 * 
 * 
 * @author
 * @version 
 */	

class Tuto extends Controller {

	function __construct() {
		parent::Controller();
	}
    public function index() {

    }
    function hola_mundo(){
    	
    	$this->load->library('cezpdf');
		$this->load->helper('pdf');
		#var_dump($_SERVER['DOCUMENT_ROOT']);
		echo SELF.'</br>';
		$path = str_replace(SELF, '', __FILE__);
		echo $path.'</br>';		
		echo __FILE__.'</br>';
		#str_replace()
		die(FCPATH);
		#$this->cezpdf->addJpegFromFile($img, 50, 780, 141, 45);
		
		
		#$this->cezpdf->ezText($img,12);
		#$this->cezpdf->ezText('Este el el programa de GENERAR PDF',20);

		#$this->cezpdf->ezText('Hello World', 12, array('justification' => 'center'));
		$this->cezpdf->ezSetDy(-10);

		#$content = 'The quick, brown fox jumps over a lazy dog. DJs flock by when MTV ax quiz prog.
		#			Junk MTV quiz graced by fox whelps. Bawds jog, flick quartz, vex nymphs.';

		#$this->cezpdf->ezText($content, 10);		
		
		$this->cezpdf->ezStream();
		
    }
    
    function tabla() {
		$this->load->library('cezpdf');
		$this->load->helper('pdf');
		prep_pdf();    
		#$db_data[] = array('name' => 'Jon Doe', 'phone' => '111-222-3333', 'email' => 'jdoe@someplace.com');
		#$db_data[] = array('name' => 'Jane Doe', 'phone' => '222-333-4444', 'email' => 'jane.doe@something.com');
		#$db_data[] = array('name' => 'Jon Smith', 'phone' => '333-444-5555', 'email' => 'jsmith@someplacepsecial.com');
		for ($i=0 ; $i < 150 ; $i++) {
			$db_data[] = array('name' => "Nombre $i", 'phone' => "$i-$i-$i", 'email' => "usuario_$i@someplacepsecial.com");
		}	
		
		
		$col_names = array(
		'name' => 'Name',
		'phone' => 'Phone Number',
		'email' => 'E-mail Address'
		);
		
		$this->cezpdf->ezTable($db_data, $col_names, 'Contact List', array('width'=>500));
		#$this->cezpdf->ezTable($db_data, $col_names, 'Contact List');
		
		$this->cezpdf->ezStream();
	}  
}
