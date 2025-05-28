<?php namespace App\Libraries;

use Config\Database;

class FatalErrorLogger
{
    protected $db;
    protected $prevExceptionHandler;

    public function __construct()
    {
        //Connect to DB
        $this->db = Database::connect('mysqldb');

        //Register shutdown handler
        register_shutdown_function([$this, 'handleShutdown']);

        //Capture & replace the exception handler
        $this->prevExceptionHandler = set_exception_handler([$this, 'handleException']);
    }

    public function handleShutdown(): void
    {
        $error = error_get_last();

        if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
            $this->safeLog([
                'module_name'   => 'shutdown_fatal',
                'current_url'   => $_SERVER['REQUEST_URI'] ?? 'unknown',
                'function_name' => "{$error['file']} on line {$error['line']}",
                'error_msg'     => $error['message'],
                'error_source'  => 'shutdown',
            ]);
        }
    }

    public function handleException(\Throwable $e): void
    {
        // 1. Log the throwable
        $this->safeLog([
            'module_name'   => 'uncaught_throwable',
            'current_url'   => $_SERVER['REQUEST_URI'] ?? 'unknown',
            'function_name' => $e->getFile() . ' on line ' . $e->getLine(),
            'error_msg'     => $e->getMessage(),
            'error_source'  => get_class($e),
        ]);

        // 2. Delegate to the previous handler exactly once
        if (is_callable($this->prevExceptionHandler)) {
            call_user_func($this->prevExceptionHandler, $e);
        } else {
            // Fallback: let CI’s default handling take over
            exit(1);
        }
    }

    /**
     * Inserts into the DB but never lets an exception bubble out.
     */
    protected function safeLog(array $data): void
    {
        try {
            $this->db->table('error_exception_log')->insert($data);
        } catch (\Throwable $dbErr) {
            // Silent fallback: write to file, but don’t throw
            @file_put_contents(
                WRITEPATH . 'logs/fatal_db_fail_' . date('Ymd_His') . '.log',
                json_encode([
                    'db_error'      => $dbErr->getMessage(),
                    'original_data' => $data,
                ])
            );
        }
    }
}
