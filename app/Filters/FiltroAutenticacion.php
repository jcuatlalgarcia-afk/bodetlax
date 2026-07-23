<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class FiltroAutenticacion implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('errors', ['auth' => 'Debes iniciar sesión.']);
        }

        if ($arguments && ! in_array(session()->get('rol'), $arguments)) {
            return redirect()->to('/')->with('errors', ['auth' => 'No tienes permiso para acceder a esta sección.']);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
