<?php
namespace Services;
use Smalot\PdfParser\Parser;

class PdfReaderService
{
    public function read($filepath)
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($filepath);
        return $pdf->getText();
    }
}
