<?php
App::import('Vendor','xtcpdf'); 
$tcpdf = new XTCPDF();
$textfont = 'freesans'; // looks better, finer, and more condensed than 'dejavusans'

// add a page (required with recent versions of tcpdf)
$tcpdf->AddPage();

$html = $this->requestAction('Offers/gerneratePdfContent/');


$tcpdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

ob_clean();

echo $tcpdf->Output('filename.pdf', 'I');

?>