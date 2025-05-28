<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Libraries\fatalerrorlogger;

class fatalerrorfilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Instantiate logger to auto-register shutdown handler
        //file_put_contents(WRITEPATH.'logs/fatallogger_hook.txt', "Filter hit\n", FILE_APPEND);
        new fatalerrorlogger();
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing needed after response
    }
}
?>