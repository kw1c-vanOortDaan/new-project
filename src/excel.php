<?php

namespace Daan;

use loophp\collection\Collection;

class readExcel extends database
{
    public $path;
    protected $reader;
    public function __construct(string $path = "")
    {
        parent::__construct();
        $this->path = $path;
        $this->reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    }
    private function verifyExistence(): array
    {
        try {
            if (!file_exists($this->path)) {
                throw new \Exception("File does not exist");
            }
            return [
                "status" => "success",
                "message" => "File exists",
            ];
        } catch (\Exception $e) {
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }
    // Deze functie kan maar 1 sheet lezen in een heel excel bestand, meerdere sheets en een error word gedumpt
    public function readExcelAndGetKeyNames($sheetNum)
    {
        $this->verifyExistence();
        $spreadsheet = $this->reader->load($this->path);
        if (empty($spreadsheet->getSheetNames()[$sheetNum])) {
            return [
                "status" => "error",
                "message" => "Sheet does not exist"
            ];
        }
        $sheet = $spreadsheet->getSheet($sheetNum);
        $sheet = $spreadsheet->getActiveSheet()->toArray();
        $keys = $sheet[0];
        return Collection::fromIterable($sheet)->combine($keys)->slice(1)->map(function ($row) use ($keys) {
            return array_combine($keys, $row);
        })
            ->map(function ($row) use ($keys) {
                return array_merge($row, ["keyCount" => count($keys)]);
            })->all();
    }
    // Create a function that generates a random name
    // private function nameRandomizer()
    // {
    //     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //     $charactersLength = strlen($characters);
    //     $randomString = '';
    //     for ($i = 0; $i < 10; $i++) {
    //         $randomString .= $characters[rand(0, $charactersLength - 1)];
    //     }
    //     return $randomString;
    // }
    public function addKeysAndValuesToDatabase(int $sheetNum)
    {
        $spreadsheet = $this->readExcelAndGetKeyNames($sheetNum);
        if (isset($spreadsheet["status"]) && $spreadsheet["status"] === "error") {
            return $spreadsheet;
        }

        //

        $tester = $this->database->table("test");
        foreach ($tester as $test) {
            echo $test->id;
            echo '<br>';
            echo $test->user;
            echo '<br>';
        }
    }
}
