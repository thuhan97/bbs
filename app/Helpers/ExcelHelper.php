<?php
/**
 * Created by PhpStorm.
 * User: TrinhNV
 * Date: 4/24/2018
 * Time: 3:55 PM
 */

namespace App\Helpers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelHelper
{
    const ZIP_TEMP = 'app/temp/';

    public static function fillReadmeFileDataFromArray(string $filePath, array $data)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $row = 1;
        foreach ($data as $id => $name) {
            $sheet->setCellValue("A$row", $id);
            $sheet->setCellValue("B$row", $name);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);
    }

    public static function fillDataToSheet(string $filePath, string $sheetName, array $data)
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
        $sheet = $spreadsheet->getSheetByName($sheetName);
        if (!empty($data))
            $sheet->fromArray($data);
        $writer = new Xlsx($spreadsheet);
        $tempFolder = storage_path(self::ZIP_TEMP . date('Y/m/d/'));
        if (!FileHelper::folder_exist($tempFolder)) FileHelper::makePath($tempFolder);

        $tempPath = $tempFolder . str_random(5) . '.xlsx';
        $writer->save($tempPath);

        return $tempPath;
    }

    /**
     * @param Spreadsheet $excelFile
     * @param             $sheetName
     *
     * @return array|null
     */
    public static function readSheetData($excelFile, $sheetName)
    {
        $sheet = $excelFile->getSheetByName($sheetName);

        if ($sheet) {
            return $sheet->toArray();
        }
    }

}
