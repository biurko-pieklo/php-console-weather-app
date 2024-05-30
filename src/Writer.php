<?php

namespace weather;

use DateTime;
use Fpdf\Fpdf;
use SimpleXMLElement;

class Writer {
    public static function toPDF(array $cities): void {
        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        $i = 0;

        foreach ($cities as $city => $data) {
            if ($i++ >= 4) {
                $pdf->AddPage();
            }

            $pdf->Cell(40, 10, $city);
            $pdf->Ln(10);

            foreach ($data as $key => $value) {
                $pdf->Cell(40, 10, $key . ': ' . $value);
                $pdf->Ln(8);
            }

            $pdf->Ln(10);
        }

        $name = new DateTime();
        $name = $name->format('Hmis') . '.pdf';

        $pdf->Output('F',  './output/pdf/'.$name, true);
    }

    public static function toJSON(array $cities): void {
        $name = new DateTime();
        $name = $name->format('Hmis') . '.json';

        file_put_contents('./output/json/'.$name, json_encode($cities));
    }

    public static function toXML(array $cities): void {
        $xml = new SimpleXMLElement('<xml/>');

        foreach ($cities as $city => $data) {
            $cityEl = $xml->addChild('city');
            $cityEl->addChild('name', $city);

            foreach ($data as $key => $value) {
                $cityEl->addChild(str_replace(' ', '', $key), $value);
            }
        }

        $name = new DateTime();
        $name = $name->format('Hmis') . '.xml';

        Header('Content-type: text/xml');
        $xml->asXML('./output/xml/'.$name);
    }
}
