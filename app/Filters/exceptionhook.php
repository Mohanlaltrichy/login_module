<?php
namespace App\Filters;

use App\Libraries\ExceptionLogger;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class exceptionhook implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Set up exception handling
        set_exception_handler([$this, 'handleException']);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No need for after filter in this case
    }

    public function handleException(\Throwable $exception)
    {
        $logger = new ExceptionLogger();
        $logger->logException($exception);
        
        // You can also customize how the exception is displayed here if needed
    }
}

?>