<?php

namespace App\Controllers;

use \App\Controllers\BaseController;

use SIENSIS\KpaCrud\Libraries\KpaCrud;

/**
 * KpaCrudSampleController - Is a sample controller, to view how to use KpaCrud Library.
 *                           - Shows a simple table like News
 *                           - Shows a table with two primary keys
 *                           - Shows a table whit two 1=>N relations
 *                           - Shows a table with a 1=>N relation workers=>jobs
 * 
 * @link ../readme.md     To view KpaCrud functions and samples, to customize your expirience
 *  
 * @package App\Controllers
 */
class UserController extends BaseController
{

    public function hashNewPassword($postData)
    {
        $postData['data_password_hash'] = password_hash($postData['data_password_hash'], PASSWORD_DEFAULT);
        return $postData; // if return null, edit process will be cancelled
    }
    public function hashEditPassword($postData)
    {
        if ($postData['data_password_hash'] != $postData['olddata_password_hash']) {
            // field has a new value. You new to generate new password
            $postData['data_password_hash'] = password_hash($postData['data_password_hash'], PASSWORD_DEFAULT);
        } // else field not changed, you can update with the same value
        return $postData;  // if return null, edit process will be cancelled
    }
    public function myCustomPage($obj)
    {
        $this->request->getUri()->stripQuery('customf');
        $this->request->getUri()->addQuery('customf', 'mpost');

        $html = "<div class=\"container-lg p-4\">";
        $html .= "<form method='post' action='" . base_url($this->request->getPath()) . "?" . $this->request->getUri()->getQuery() . "'>";
        $html .= csrf_field()  . "<input type='hidden' name='test' value='ToSend'>";
        $html .= "<div class=\"bg-secondary p-2 text-white\">";
        $html .= "	<h1>View item</h1>";
        $html .= "</div>";
        $html .= "	<div style=\"margin-top:20px\" class=\"border bg-light\">";
        $html .= "		<div class=\"d-grid\" style=\"margin-top:20px\">";
        $html .= "			<div class=\"p-2 \">	";
        $html .= "				<label>Username</label>	";
        $html .= "				<div class=\"form-control bg-light \">";
        $html .= $obj['username'];
        $html .= "				</div>";
        $html .= "			</div>";
        $html .= "";
        $html .= "			<div class=\"p-2 \">	";
        $html .= "				<label>eCorreu</label>	";
        $html .= "				<div class=\"form-control bg-light\">";
        $html .= $obj['email'];
        $html .= "				</div>";
        $html .= "			</div>";
        $html .= "			";
        $html .= "		</div>";
        $html .= "	</div>";
        $html .= "<div class='pt-2'><input type='submit' value='Envia'></div></form>";
        $html .= "</div>";

        // You can load view info from view file and return to KpaCrud library
        // $html = view('view_route/view_name');

        return $html;
    }
    public function myCustomPagePost($obj)
    {
        // $obj contains info about register if you repeat querystring received in MyCustomPage
        $html = '<h1>Operation ok</h1>';

        /*
        Do something with this->request->getPost information
        */
        dd($this->request->getPost());
        return $html;
    }
    public function dashboard()
    {
        $crud = new KpaCrud();
        $crud->setTable('users');
        $crud->setPrimaryKey('id');

        if ($crud->isExportMode()) {
            $crud->setColumns(['username', 'email', 'active']);
            $crud->addWhere('users.active=1');
        } else {
            $crud->setColumns(['id', 'email', 'username', 'active',]);
        }

        $crud->addPostAddCallBack(array($this, 'hashNewPassword'));
        $crud->addPostEditCallBack(array($this, 'hashEditPassword'));

        // Create an invisible named function in KpaCrud to call after
        $crud->addItemFunction('mpost', '', array($this, 'myCustomPagePost'), "", false);

        /**
         * Available options:
         *
         * - name -> Field name to show user in pages
         * - type -> Field type, available types are:
         *         DEFAULT_FIELD_TYPE 
         *         INVISIBLE_FIELD_TYPE
         *         EMAIL_FIELD_TYPE
         *         CHECKBOX_FIELD_TYPE
         *         NUMBER_FIELD_TYPE 
         *         RANGE_FIELD_TYPE 
         *         DATE_FIELD_TYPE 
         *         DATETIME_FIELD_TYPE 
         *         TEXTAREA_FIELD_TYPE 
         * - default -> default value into add page
         * - check_value/uncheck_value -> You can configure check&uncheck values for a checkbox to store correctly into bd, by default are check=1 / uncheck=0
         * - html_atts -> Permits to add html attribs to a input field, like: required, placeholder, pattern, title, min, max, step... 
         * - options -> Options to show in a dropdown field
         */
        $crud->setColumnsInfo([
            'id' => ['name' => 'Codi'],
            'email' => [
                'name' => 'Email',
                'html_atts' => [
                    'required',
                    'placeholder="Introdueix l\'adreça mail de l\'usuari"'
                ],
                'type' => KpaCrud::EMAIL_FIELD_TYPE
            ],
            'username' => [
                'name' => 'Nom usuari',
                'html_atts' => [
                    "required",
                    "placeholder=\"Introdueix el nom d'usuari\""
                ],
            ],
            'active' => [
                'name' => 'Actiu',
                'type' => KpaCrud::DROPDOWN_FIELD_TYPE,
                'options' => ['' => "Tria opcio", 'Usuari desactivat', 'Usuari actiu'],
                'html_atts' => [
                    "required",
                    "multiple",
                    "name=\"active[]\"",
                ],
                'default' => '1'
            ],

            'password_hash' => [
                'type' => KpaCrud::PASSWORD_FIELD_TYPE,
                'name' => 'Password',
                'html_atts' => []
            ],

            'force_pass_reset' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE,],
            'reset_expires' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE,],
            'activate_hash' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
            'reset_hash' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
            'reset_at' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
            'status' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],
            'status_message' => ['type' => KpaCrud::INVISIBLE_FIELD_TYPE],

        ]);

        $data['output'] = $crud->render();

        return view('User/dashboard', $data);
    }
}
