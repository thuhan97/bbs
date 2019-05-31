<?php


namespace App\Helpers;


class ExcelHelper
{
    public static function getExcelCols($length = EXCEL_COLUMN_LENGTH)
    {
        if ($length > EXCEL_COLUMN_LENGTH) {
            $num = floor($length / EXCEL_COLUMN_LENGTH);
            $more = $length % EXCEL_COLUMN_LENGTH;
            $results = EXCEL_COLUMNS;
            $firstKey = 'A';
            for ($i = 1; $i < $num; $i++) {
                $firstKey = EXCEL_COLUMNS[$i];
                foreach (EXCEL_COLUMNS as $secondKey) {
                    $results[] = $firstKey . $secondKey;
                }
            }

            for ($j = 0; $j < $more; $j++) {
                $secondKey = EXCEL_COLUMNS[$j];
                $results[] = $firstKey . $secondKey;
            }

            return $results;
        } else if ($length < EXCEL_COLUMN_LENGTH) {
            return array_slice(EXCEL_COLUMNS, 0, $length);
        } else {
            return EXCEL_COLUMNS;
        }
    }
}
