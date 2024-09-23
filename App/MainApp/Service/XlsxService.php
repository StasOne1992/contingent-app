<?php

namespace App\MainApp\Service;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class XlsxService extends AbstractController
{
    public function getRandomName()
    {
        return uniqid() . '.xlsx';
    }

    public function generate($data = array(['Не было передано ни одной строки']), $fileName = 'my.xlsx')
    {
        if ($fileName == 'my.xlsx') {
            $fileName = $this->getRandomName();
        }
        /** @var Spreadsheet $spreadsheet */
        $spreadsheet = new Spreadsheet();
        /** @var Worksheet $sheet */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->fromArray($data, null, 'A1');
        $sheet->setTitle("Sheet1");
        // Create Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);
        // Create a Temporary file in the system
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);
        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }
}