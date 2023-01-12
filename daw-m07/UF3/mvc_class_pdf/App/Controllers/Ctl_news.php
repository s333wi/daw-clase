<?php

namespace App\Controllers;

require_once 'App/../../../vendor/autoload.php';
defined('MVC_APP') or die('Access denied');
session_start();

use App\Models\Mdl_users;
use app\Models\Mdl_news;
use TCPDF;

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
        var_dump($autor);
        //Instanciem el model de noticies i afegim la noticia
        $usr_news = new Mdl_news();
        $result = $usr_news->addNews(trim($titol), trim($descripcio), $autor, intval($id));

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

    function viewNews(int $id)
    {

        //Instanciem el model de noticies i extreiem la noticia
        $usr_news = new Mdl_news();
        $news = $usr_news->getNews($id);
        $usr_model = new Mdl_users();
        include 'App/views/news/view_news.phtml';
    }

    function pdf_news(int $id)
    {
        //make a pdf with tcdpf that contains all the data of a news article 
        $news_model = new Mdl_news();
        $info_news = $news_model->getNews($id);
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/daw-clase/daw-m07/UF3/mvc_class_pdf/index.php?action=view_news&id=' . $id;
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('s333wi');
        $pdf->SetTitle('News PDF ' . $id);
        $pdf->SetSubject('News');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->AddPage();
        $this->printPdf($pdf, $info_news, $url);
        $pdf->Output('news' . $id . '.pdf', 'I');
    }

    function pdfAllNews()
    {
        //check if user its logged in and has level 10
        if(!isset($_SESSION['username'])){
            header('Location: index.php');
            exit;
        }
        $usr_model = new Mdl_users();
        $level = $usr_model->getUserLevel($_SESSION['username']);

        if($level < 10){
            header('Location: index.php');
            exit;
        }

        $news_model = new Mdl_news();
        $info_news = $news_model->fetchAllNews();
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('s333wi');
        $pdf->SetTitle('ALL News PDF');
        $pdf->SetSubject('News');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('helvetica', '', 12);
        foreach ($info_news as $news) {
            $pdf->AddPage();
            $url = 'http://' . $_SERVER['HTTP_HOST'] . '/daw-clase/daw-m07/UF3/mvc_class_pdf/index.php?action=view_news&id=' . $news['codin'];
            $this->printPdf($pdf, $news, $url);
        }
        $pdf->Output('all_news.pdf', 'D');
    }

    function printPdf($pdf, $info_news, $url)
    {
        $html_title = '<h1>Titol: ' . $info_news['titol'] . '</h1>';
        $html_autor = '<h3>Autor: ' . $info_news['autor'] . '</h3>';
        $html_data = '<h6>Data: ' . $info_news['data'] . '</h6>';
        $html_body = '<p>Contingut: ' . $info_news['descripcio'] . '</p>';
        $html_url = '<p>URL: <a href="' . $url . '">' . $url . '</a></p>';
        $html_generacio_pdf = '<p>Generat : ' . date('d/m/Y h:i:s') . '</p>
        <p>Generat per: ' . ($_SESSION['username'] ?? "Visitant") . '</p>';
        $pdf->writeHTML($html_title, true, false, true, false, '');
        $pdf->writeHTML($html_autor, true, false, true, false, '');
        $pdf->writeHTML($html_data, true, false, true, false, '');
        $pdf->writeHTML($html_body, true, false, true, false, '');
        $pdf->writeHTML($html_url, true, false, true, false, '');
        $pdf->writeHTML($html_generacio_pdf, true, false, true, false, '');
    }
}
