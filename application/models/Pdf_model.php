<?php
if (! defined ( 'BASEPATH' ))	exit ( 'No direct script access allowed' );

/**
 * 
 * @author jackw
 *
 */
	
class Pdf_model extends CI_Model {
	function output($template, $data) {
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->setAutoTopMargin = 'stretch';
		$mpdf->setAutoBottomMargin = 'stretch';
		// {PAGENO}/{nbpg}
		// $data['title'] = 'My test title';
		$head = $this->parser->parse('pdf/head', $data, TRUE);
		$foot = $this->parser->parse('pdf/foot', $data, TRUE);
		$html = $this->parser->parse('pdf/'.$template, $data, TRUE);
		$mpdf->SetHTMLHeader($head);
		$mpdf->SetHTMLFooter($foot);
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		exit;
	}

	function htmloutput($html, $data, $head='pdf/head', $foot='pdf/foot') {
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->setAutoTopMargin = 'stretch';
		$mpdf->setAutoBottomMargin = 'stretch';
		// {PAGENO}/{nbpg}
		// $data['title'] = 'My test title';
		$head = $this->parser->parse('pdf/head', $data, TRUE);
		$foot = $this->parser->parse('pdf/foot', $data, TRUE);

		$mpdf->SetHTMLHeader($head);
		$mpdf->SetHTMLFooter($foot);
		$mpdf->WriteHTML($html);
		$mpdf->Output();
		exit;
	}
}