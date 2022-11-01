<?php
require_once __DIR__ . "/vendor/autoload.php";

use loophp\collection\Collection;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// require_once __DIR__ . "excel.php";
echo "<pre>";
// var_dump((new Daan\readExcel(__DIR__ . "/Financial_Sample.xlsx"))->readExcelAndGetKeyNames(0));

var_dump((new Daan\readExcel(__DIR__ . "/Financial_Sample.xlsx"))->addKeysAndValuesToDatabase(0));
// (new Daan\readExcel(__DIR__ . "/Financial_Sample.xlsx"))->createTable(0);
