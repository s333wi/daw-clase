<?php
function getFirstDay($dayMonth)
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
$currDate = strtotime($currDay . '-' . $currMonth . '-' . $currYear);

$monthPost = empty($_POST['months']) ? date("m") : $_POST['months'];
$yearPost = empty($_POST['years']) ? date("Y") : $_POST['years'];
$postDate = strtotime($currDay . '-' . $monthPost . '-' . $yearPost);

$firstDayMonth = strtotime('01-' . $monthPost . '-' . $yearPost);
$monthTotalDays = date('t', $firstDayMonth);
$lastDayMonth = strtotime($yearPost . '-' . $monthPost . '-' . $monthTotalDays);
$firstDayMonth = date('D', $firstDayMonth);
$numFirstDay = getFirstDay($firstDayMonth);

$weeks = ceil((($monthTotalDays + $numFirstDay - 1) / 7));
$addDay = 1;
