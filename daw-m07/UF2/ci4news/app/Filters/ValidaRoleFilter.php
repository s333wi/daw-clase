<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class ValidaRoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
        if (!session()->has('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if (empty($arguments)) {
            return;
        }

        foreach ($arguments as $role) {
            if (session()->get('role') == $role) {
                return;
            }
        }

        return redirect()->to('/login');
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
