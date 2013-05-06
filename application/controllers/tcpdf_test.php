<?php

class Tcpdf_test extends Controller {

	function __construct()
	{
		parent::Controller();
		 $this->load->library('pdf');
	}
	
    function pdf_test()
    {

    }

    function index()    {

        $this->pdf->SetSubject('TCPDF Tutorial');
        $this->pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $this->pdf->SetFont('times', 'BI', 16);
        $this->pdf->AddPage();
        $this->pdf->Output('example_001.pdf', 'I');        
    }
    function barcode ()  {
    	 
        #$this->pdf->setPageFormat(array(85.000,  200.000), 'P');
        $this->pdf->setPageFormat('LETTER', 'P');
        $this->pdf->SetMargins(3,3,3,3);    
        $this->pdf->setPrintHeader(false);
		$this->pdf->setPrintFooter(false);        
        $this->pdf->SetFont('helvetica', 'B', 4);        
        $this->pdf->AddPage();
		$style = array(
		    'position' => '',
		    'align' => '',
		    'stretch' => true,
		    'fitwidth' => true,
		    'cellfitalign' => '',
		    'border' => false,
		    'hpadding' => 'auto',
		    'vpadding' => 'auto',
		    'fgcolor' => array(0,0,0),
		    'bgcolor' => false, //array(255,255,255),
		    'text' => true,
		    'font' => 'helvetica',
		    'fontsize' => 11,
		    'stretchtext' => 0
		);

		$yt = 8;
		$yc = 9;		 
		
		for ($j = 1; $j<=10; $j++) {
			for ($i = 1; $i<= 2; $i++) {			
			 	#$this->pdf->Text(8,  $yt,'MPPRE-BIENES NACIONALES');
				#$this->pdf->Text(44, $yt,'MPPRE-BIENES NACIONALES');
				#$this->pdf->Text(78, $yt,'MPPRE-BIENES NACIONALES');
			 	$this->pdf->write1DBarcode('58073', 'C128',  6, $yc, 26, 15, 0.4, $style, 'N');
				$this->pdf->write1DBarcode('58073', 'C128', 42, $yc, 26, 15, 0.4, $style, 'N');
				$this->pdf->write1DBarcode('58073', 'C128', 76, $yc, 26, 15, 0.4, $style, 'N');			 	
			}
			$yt = $yt + 24;
			$yc = $yc + 24;
		}

		$this->pdf->Output('bar_code.pdf', 'I'); 
    }
    function etiquetas () {    	
    	$style_bar_code = array(
		    'position' => '',
		    'align' => '',
		    'stretch' => true,
		    'fitwidth' => true,
		    'cellfitalign' => '',
		    'border' => false,
		    'hpadding' => 'auto',
		    'vpadding' => 'auto',
		    'fgcolor' => array(0,0,0),
		    'bgcolor' => false, //array(255,255,255),
		    'text' => true,
		    'font' => 'helvetica',
		    'fontsize' => 14,
		    'stretchtext' => 0
		);
		#die('Toño');
		$codes = array();
		#$specific 	= '4001,4002,4005,4010,4011,4016,4017,4018,4019,4020,4030,4040';
		$specific 	= '4001,4002,4005,4010,4011,4016,4017,4018,4019,4020,4030';
		#$specific 	= '4001,4002,4005,4010,4011,4016,4017,4018,4019';
		$rango 		= false; 
		if ($rango) {
			$begin =  5001;
			$end   =  5015;
			### Colocando c/u de los códigos en en arreglo unidimensional $codes 			
			for ($i = $begin; $i<= $end; $i++) {
					$codes [] = $i;				 
			}
			
			$rows = 1;
			$j = 0;
			### Para determinar el N° de Filas
	   		foreach ($codes as $code) {   	    		
	    		$j++;
	    		if ($j==3){    			
	    			$j=0;
	    			$rows++;
	    		}   			  		   		
			}
		}
		else {
			$codes = explode(',',$specific);
		}
		$pdf = new Pdf('P', 'cm','LETTER');
		#$pdf = new Pdf('P', 'cm', 'LETTER', true, 'UTF-8', false);    	
    	#$pdf = new Pdf('P', 'cm', 'LETTER', true, 'UTF-8', false);
    	$pdf->SetFont('helvetica', 'B', 4);
    	$pdf->setPageFormat(array(111.000,  350.000), 'P');    	
    	$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);    	
		#$pdf->AddPage('P',array(108, 108));    	  
		$pdf->AddPage();
    	$pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(200, 200, 200)));
   		
    	#$x = 5; 	$y = 4;
    	$x = 11; 	$y = 4;
		$rows = 1;
				
		foreach ($codes as $code) {			
			#$pdf->RoundedRect($x,  $y, 30.1, 19.9, 2.50, '1111', 'DF', null, array(200, 200, 200));
			$pdf->Text($x+4,  $y+3,'MPPRE-BIENES NACIONALES');
			$pdf->write1DBarcode($code, 'C128',  $x+2, $y+4, 26, 15, 0.4, $style_bar_code, 'N');						     		    		
			$x = $x + 35; #### X1=7	X2=42	X3=77  
			if ($x >= 111){
				$x = 11;
				$y = $y + 23;
			}   			  		   		
		}
    	
    			
		$pdf->Output('bar_code.pdf', 'I'); 
    }
    
	function test_codes () {  	
		$begin =  101;
		$end   =  127;		
		$codes = array();			
		
		for ($i = $begin; $i<= $end; $i++) {
				$codes [] = $i;				 
		}

		$i=0;
		$j=0;
		$rows = 1;
		
    	foreach ($codes as $code) {    		    		
    		echo "$code ";    		
    		$j++;
    		if ($j==3){ 
    			echo "</br>";
    			$j=0;
    			$rows++;
    		}   			  		   		
		}
		echo '<hr/>';	
		echo 'Total de Filas: '.$rows;

    }
}  
?>