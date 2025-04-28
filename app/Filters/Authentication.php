<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Authentication implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if(!session('rol') == 'admin' || session('rol') == 'maestro') {
            return redirect()->to(base_url('/'))->with('msg', 'Por favor, inicia sesión para acceder al sistema');
        }
        
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}