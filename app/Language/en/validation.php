<?php

// override core en language system validation or define your own en language validation message
return [

    // Custom validation messages
    'validateOPCURL' => 'The {field} field must be a valid URL.',
    'uniqueopcdata'  => 'Duplicate {field} Data Not Allowed',
    'bulk_import_ext_in' => 'The {field} field must have a valid extension.',
    'validate_max_rows' => 'The File Only '.EXCEL_IMPORT_ROW_LIMIT_COUNT.' Records Only Allowed.'
];
