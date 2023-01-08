<?php

// Include the TCPDF library
require_once('./TCPDF-main/tcpdf.php');

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

// Output the PDF
$pdf->Output('my_pdf.pdf', 'I');

?>
