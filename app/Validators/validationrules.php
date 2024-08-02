<?php
namespace App\Validators;

use Config\Services;

class validationrules
{
    //OPC URL Validation
  
    public function validate_email_domain(string $email): bool
    {
        $domain = substr(strrchr($email, "@"), 1);
        return checkdnsrr($domain, 'MX');
    }
   
    //Bulk File Import .ods File Format Check
    public function bulk_import_ext_in($str, string $fields, array $data): bool
    {
       $allowedExtensions = ['xlsx', 'ods'];

        if (empty($fields)) {
            // No file provided
            return true;
        }

        $ext = pathinfo($fields, PATHINFO_EXTENSION);
        return in_array($ext, $allowedExtensions);
    }

    //Bulk Import Excel Row Validation
    public function validate_max_rows($str, $file, array $data): bool
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();

        // Remove the first row
        $worksheet->removeRow(1);

        // Find the last non-empty row
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        
        for ($row = $highestRow; $row >= 1; $row--) {
            $rowData = $worksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);

            // Check if the row is not entirely empty
            if (!empty(array_filter($rowData[0]))) {
                // Found the last non-empty row
                $highestRow = $row;
                break;
            }
        }

        if ($highestRow > EXCEL_IMPORT_ROW_LIMIT_COUNT) {
            return false; // Validation fails if more than 1000 rows
        }

        return true; // Validation passes
    }

}
?>