<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'third_party/mpdf/vendor/autoload.php'; // Sesuaikan path autoload.php

use Mpdf\Mpdf;

class Pdf_generator
{
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function generate($html, $filename = '', $stream = TRUE)
    {
        $mpdf = new Mpdf();

        $mpdf->WriteHTML($html);

        if ($stream) {
            $mpdf->Output($filename . '.pdf', 'D'); // Download file PDF
        } else {
            $mpdf->Output($filename . '.pdf', 'I'); // Tampilkan file PDF di browser
        }
        exit;
    }
}
