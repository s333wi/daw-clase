<?php

namespace App\Controllers;

session_start();
defined('MVC_APP') or die('Access denied');

use App\Models\Mdl_messenger;
use App\Models\Mdl_users;
use TCPDF;

class Ctl_messenger
{

    //Carrego les vistes de la taula de missatges
    function loadView()
    {
        if (!isset($_SESSION['username'])) {
            header('Location: index.php');
            exit;
        }
        $usr_model = new Mdl_users();
        $level = $usr_model->getUserLevel($_SESSION['username']);
        $messenger = new Mdl_messenger();
        //Agafo els missatges enviats i els que he rebut
        $info_messenger_sent = $messenger->fetchAllMessagesSent($_SESSION['username']);
        $info_messenger_received = $messenger->fetchAllMessages($_SESSION['username']);
       
        include 'App/views/messenger/messenger.phtml';
    }

    function viewSave(int $id)
    {   
        //Si no esta loguejat no pot entrar
        if (!isset($_SESSION['username'])) {
            header('Location: index.php');
            exit;
        }
        //Si no te id es un missatge nou
        if (!empty($id)) {
            $messenger = new Mdl_messenger();
            $info_messenger = $messenger->getMessage($id);
        }
        //Agafo tots els usuaris per fer el select dels receptors
        $usr_model = new Mdl_users();
        $level = $usr_model->getUserLevel($_SESSION['username']);
        $users = $usr_model->getAllUsers();
        include 'App/views/messenger/addMessage.phtml';
    }


    //Funcio per guardar el missatge 
    function saveMessage()
    {
        //Si no esta loguejat no pot entrar
        if (!isset($_SESSION['username'])) {
            header('Location: index.php');
            exit;
        }

        //Agafo el nivell de l'usuari per saber si es admin o no
        $usr_model = new Mdl_users();
        $level = $usr_model->getUserLevel($_SESSION['username']);


        $post = filter_input_array(INPUT_POST);
        extract($post);

        $messenger = new Mdl_messenger();

        //Si el receptor es tots els usuaris i no es admin no pot enviar el missatge a tot el mon
        if ($receptor == "all" && $level < 10) {
            header('Location: dashboard.php?action=view_messenger');
            exit;
        //Si el receptor es tots els usuaris i es admin envia el missatge a tots els usuaris
        } else if ($receptor == "all" && $level == 10) {
            $messenger->sendMessageAll(trim($assumpte), trim($missatge), $_SESSION['username']);
        } else {
            $messenger->saveMessage(trim($assumpte), trim($missatge), trim($receptor), trim($_SESSION['username']));
        }

        header('Location: index.php?action=view_messenger');
        exit;
    }

    //Funcio per eliminar el missatge
    function deleteMessage(int $id)
    {
        //Si no esta loguejat no pot entrar
        if (!isset($_SESSION['username'])) {
            header('Location: index.php');
            exit;
        }
        
        //Agafo el missatge per veure si existeix i el seu receptor
        $messenger = new Mdl_messenger();
        $message = $messenger->getMessage($id);


        //Si el missatge no existeix o el receptor no es el usuari loguejat no pot eliminar el missatge
        if ($message == null || $message['receptor'] != $_SESSION['username']) {
            header('Location: index.php?action=view_messenger');
            exit;
        }

        $messenger->deleteMessage($id);
        header('Location: index.php?action=view_messenger');
        exit;
    }

    //Funcio per veure un missatge en concret
    function viewMessage(int $id)
    {
        if (!isset($_SESSION['username'])) {
            header('Location: index.php');
            exit;
        }

        $messenger = new Mdl_messenger();
        $message = $messenger->getMessage($id);

        //Si el missatge no existeix o el receptor no es el usuari loguejat no pot veure el missatge
        if ($message == null || $message['receptor'] != $_SESSION['username']) {
            header('Location: index.php?action=view_messenger');
            exit;
        }

        //Si el missatge no esta vist el marco com a vist
        if ($message['data_apertura'] == null) {
            $messenger->setSeenMessage($id);
        }
        include 'App/views/messenger/view_message.phtml';
    }

    //Funcio per creaer el pdf del missatge
    function pdfMessage(int $id)
    {
        if (!isset($_SESSION['username'])) {
            header('Location: index.php');
            exit;
        }

        $messenger = new Mdl_messenger();
        $message = $messenger->getMessage($id);
        if ($message) {
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator($_SESSION['username']);
            $pdf->SetAuthor($message['emissor']);
            $pdf->SetTitle('Missatge');
            $pdf->SetSubject('Missatge');
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->AddPage();
            $html = '<h1>Missatge en PDF</h1>';
            $html .= '<p><b>Assumpte: </b>' . $message['assumpte'] . '</p>';
            $html .= '<p><b>Missatge: </b>' . $message['text'] . '</p>';
            $html .= '<p><b>Emisor: </b>' . $message['emissor'] . '</p>';
            $html .= '<p><b>Receptor: </b>' . $message['receptor'] . '</p>';
            $html .= '<p><b>Data d\'enviament: </b>' . date('d/m/Y', strtotime($message['data_env'])) . '</p>';
            $html .= '<p><b>Data d\'apertura: </b>' . date('d/m/Y', strtotime($message['data_apertura'])) . '</p>';
            $html .= '<p><b>PDF Generat en: </b>' . date('d/m/Y h:i:s') . '</p>';
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('missatge'.random_int(500,10000).'.pdf', 'D');
        }
        header('Location: index.php?action=view_messenger');
        exit;
    }
}
