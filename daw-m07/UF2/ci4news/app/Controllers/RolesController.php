<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class RolesController extends BaseController
{
    private $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        helper('form');
    }

    public function index()
    {
        //
    }

    public function dashboard()
    {
        $order = $this->request->getVar('order');
        $sort = $this->request->getVar('sort');

        $model = model('RolesModel');

        if ($order != null && $sort != null) {
            if (strtolower($sort) == 'asc') {
                $sort = 'desc';
            } else if (strtolower($sort) == 'desc') {
                $sort = 'asc';
            }
            $data['info_roles'] = $model->fetchRoles($order, $sort);
        } else {
            $sort = 'asc';
            $data['info_roles'] = $model->fetchRoles();
        }
        $data['title'] = "Dashboard roles";
        $data['pager'] = $model->pager;
        $data['sort'] = $sort;
        return view("roles/dashboard", $data);
    }

    public function update($roleId = null){
        $rolModel = model('RolesModel');
        $data['role'] = $rolModel->find($roleId);
        if (empty($data['role'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('No s\'ha trobat el rol amb roleId: ' . $roleId);
        }

        $data['title'] = "Update role";

        if ($this->request->getMethod() == 'post') {
            $rolModel->updateRol($roleId, $this->request->getPost());
            return redirect()->to('/roles/dashboard');
        }

        return view('roles/update', $data);
    }

    public function delete($roleId = null)
    {
        $usrModel = model('RolesModel');
        $usrModel->delete($roleId);
        return redirect()->to('/roles/dashboard');
    }
}
