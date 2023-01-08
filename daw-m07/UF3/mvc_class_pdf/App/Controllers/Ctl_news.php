<?php

namespace App\Controllers;

require_once 'App/../../../vendor/autoload.php';
defined('MVC_APP') or die('Access denied');
session_start();

use TCPDF;
use App\Models\Mdl_users;
use app\Models\Mdl_news;

class Ctl_news
{
    //Funcio que comprova la sessio i el nivell de l'usuari
    public function checkSessionLevel()
    {
        if (!isset($_SESSION['username'])) {
            header('Location: index.php');
            exit;
        }

        $usr_model = new Mdl_users();
        $level = $usr_model->getUserLevel($_SESSION['username']);
        if ($level < 5) {
            header('Location: index.php?action=dashboard');
            exit;
        }
    }

    //Mostra la pagina principal de noticies
    function loadView()
    {
        //Comprovem la sessio i el nivell de l'usuari
        $this->checkSessionLevel();

        //Instanciem el model de noticies i extreiem les noticies
        $news_model = new Mdl_news();
        $info_news = $news_model->fetchAllNews();
        $usr_model = new Mdl_users();
        $level = $usr_model->getUserLevel($_SESSION['username']);
        include 'App/views/news/news.phtml';
    }


    //Funcio que afegeix una noticia
    function addNews()
    {
        $this->checkSessionLevel();

        //Extreiem el post amb el metode habitual
        $data = filter_input_array(INPUT_POST);
        extract($data);

        //Instanciem el model de noticies i afegim la noticia
        $usr_news = new Mdl_news();
        $result = $usr_news->addNews(trim($titol), trim($descripcio), intval($id));

        //Redirigim a la pagina de gestio de noticies
        header('Location: index.php?action=manage_news');
    }

    function deleteNews(int $id)
    {
        //Comprovem la sessio i el nivell de l'usuari
        $this->checkSessionLevel();

        //Instanciem el model de noticies i eliminem la noticia
        $usr_news = new Mdl_news();
        $result = $usr_news->deleteNews($id);

        //Redirigim a la pagina de gestio de noticies
        header('Location: index.php?action=manage_news');
    }

    function pdf_news(int $id)
    {
        ob_start();
        error_reporting(E_ALL & ~E_NOTICE);
        ini_set('display_errors', 0);
        ini_set('log_errors', 1);
        // Create a new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set the document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('My PDF');
        $pdf->SetSubject('My PDF Subject');
        $pdf->SetKeywords('PDF, TCPDF, example');

        // Add a page
        $pdf->AddPage();

        // Set the font
        $pdf->SetFont('helvetica', 'B', 20);

        // Add the title
        $pdf->Cell(0, 0, 'Title', 0, 1, 'C');

        // Set the font
        $pdf->SetFont('helvetica', '', 12);

        // Add the author
        $pdf->Cell(0, 20, 'Author: Your Name', 0, 1, 'L');

        // Add the description
        $pdf->MultiCell(0, 20, 'Description: This is my PDF document. It contains a title, author, description, and date.', 0, 'L');

        // Add the date
        $pdf->Cell(0, 20, 'Date: ' . date('F j, Y'), 0, 1, 'R');


        ob_end_clean();
        // Output the PDF
        $pdf->Output('efe.pdf', 'I');
    }
}
