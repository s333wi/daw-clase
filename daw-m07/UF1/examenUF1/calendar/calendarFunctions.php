<?php
function getFirstDay($dayMonth) // Retorno la abreviacio segons el dia del mes per al header
{
    $daysWeek = [1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat', 7 => 'Sun'];
    foreach ($daysWeek as $key => $value) {
        if ($dayMonth == $value) return $key;
    }
}

$abbrDies = ['Dl', 'Dm', 'Dc', 'Dj', 'Dv', 'Ds', 'Dg'];
$currDay = date("d");
$currMonth = date("m");
$currYear = date("Y");
//Genero el dia actual
$currDate = strtotime($currDay . '-' . $currMonth . '-' . $currYear);

//Genero el dia que ve per $_POST
$monthPost = empty($_POST['months']) ? date("m") : $_POST['months'];
$yearPost = empty($_POST['years']) ? date("Y") : $_POST['years'];
$postDate = strtotime($currDay . '-' . $monthPost . '-' . $yearPost);

//Creo les variables necessaries per generar el mes del $_POST
$firstDayMonth = strtotime('01-' . $monthPost . '-' . $yearPost);
$monthTotalDays = date('t', $firstDayMonth);
$lastDayMonth = strtotime($yearPost . '-' . $monthPost . '-' . $monthTotalDays);
$firstDayMonth = date('D', $firstDayMonth);
$numFirstDay = getFirstDay($firstDayMonth);

//Calculo el numero de setmanes teninc en compte per quin dia comença de la setmana
$weeks = ceil((($monthTotalDays + $numFirstDay - 1) / 7));
$addDay = 1; //Variable que em servira per emplenar els dies del mes
