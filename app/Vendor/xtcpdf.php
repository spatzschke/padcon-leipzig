 <?php
App::import('Vendor','tcpdf/tcpdf');

class XTCPDF  extends TCPDF
{

    var $xheadertext  = 'PDF created using CakePHP and TCPDF';
    var $xheadercolor = array(0,0,200);
    var $xfootertext  = 'Copyright Â© %d XXXXXXXXXXX. All rights reserved.';
    var $xfooterfont  = PDF_FONT_NAME_MAIN ;
    var $xfooterfontsize = 8 ;


    /**
    * Overwrites the default header
    * set the text in the view using
    *    $fpdf->xheadertext = 'YOUR ORGANIZATION';
    * set the fill color in the view using
    *    $fpdf->xheadercolor = array(0,0,100); (r, g, b)
    * set the font in the view using
    *    $fpdf->setHeaderFont(array('YourFont','',fontsize));
    */
    function Header()
    {

        list($r, $b, $g) = $this->xheadercolor;
        $this->setY(10); // shouldn't be needed due to page margin, but helas, otherwise it's at the page top

    }

    /**
    * Overwrites the default footer
    * set the text in the view using
    * $fpdf->xfootertext = 'Copyright Â© %d YOUR ORGANIZATION. All rights reserved.';
    */
    function Footer()
    {

    }
}
?> 