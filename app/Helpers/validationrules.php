<?php
namespace App\Helpers;

class validationrules
{
    public function validateOPCURL(string $str): bool
    {
        // Modify the following pattern to match the OPC server URL format
        $pattern = '/^(opc\.tcp|http|https):\/\/[a-zA-Z0-9\-._~:/?#[\]@!$&\'()*+,;=]+$/';

        return (bool) preg_match($pattern, $str);
    }
}
?>