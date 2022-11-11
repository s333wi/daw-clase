<?php
include_once 'calendarFunctions.php';
include_once 'events.php';

//Control de mesos
if (isset($_POST['mesEnrere'])) {

    if (($monthPost - 1) == 0) {
        $monthPost = 12;
        $yearPost--;
    } else {
        $monthPost--;
    }
} elseif (isset($_POST['mesEndavant'])) {
    if (($monthPost + 1) == 13) {
        $monthPost = 1;
        $yearPost++;
    } else {
        $monthPost++;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link rel="stylesheet" type='text/css' href='./style.css' />

</head>

<body>
    <form method="post" action="index.php">
        <table border=1>
            <thead>
                <tr>
                    <td class="noBorder"><button name="mesEnrere">&lt&lt</button></td>
                    <td colspan=2 class="noBorder">
                        <select name="months" onchange="document.forms[0].submit()">
                            <?
                            //Generacio dels mesos amb abreviacions controlant el mes actual
                            for ($month = 1; $month <= 12; $month++) {
                                $selected = ($month == $monthPost) ? 'selected="selected"' : "";
                                $dia = date("M", strtotime("1-" . $month . "-2000"));
                                echo "<option value='" . $month . "' " . $selected . ">" . $dia . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td class="noBorder"></td>
                    <td colspan=2 class="noBorder">
                        <select name="years" onchange="document.forms[0].submit()">
                            <?php
                            //Generacio dels anys controlant l'any actual
                            for ($year = 1970; $year <= 2077; $year++) {
                                $selected = ($year == $yearPost) ? 'selected="selected"' : "";
                                $dia = date("Y", strtotime("01-01-" . $year));
                                echo "<option value='" . $dia . "' " . $selected . ">" . $dia . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td class="noBorder"><button name="mesEndavant">&gt&gt</button></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    //Primera fila amb les abreviacions en catala
                    foreach ($abbrDies as $dia) {
                        echo '<td>' . $dia . '</td>';
                    }
                    ?>
                </tr>
                <?php
                $firstWeek = true; //Variable per controlar la primera setmana ja que es comporta de manera diferent
                $blank = '<td>&nbsp-&nbsp</td>';
                for ($week = 1; $week <= $weeks; $week++) {
                ?>
                    <tr>
                        <?php
                        for ($dia = 1; $dia <= 7; $dia++) {
                            //Empleno els td en blanc que sobren avans i a final de mes
                            if ($dia < $numFirstDay && $firstWeek) {
                                echo $blank;
                            } elseif ($addDay > $monthTotalDays && $week == $weeks) {
                                echo $blank;
                            } else {
                                //Empleno els dies del mes tenint en compte caps de setmana i dia actual
                                if ($addDay == $currDay && $currDate == $postDate) {
                                    echo '<td id="currDay">' . $addDay;
                                } elseif ($dia == 6) {
                                    echo '<td class="satDay">' . $addDay;
                                } elseif ($dia == 7) {
                                    echo '<td class="sunDay">' . $addDay;
                                } else {
                                    echo '<td>' . $addDay;
                                }
                                //Genero el dia a cada volta per comprovar si te events
                                $loopDate = $addDay . '-' . $monthPost . '-' . $yearPost;
                                //Comprovacio dels events
                                if (!empty($event[$loopDate])) {
                                    echo '<a title="' . $event[$loopDate] . '">*</a>';
                                }
                                echo '</td>';
                                $addDay++;
                            }
                        }
                        $firstWeek = false;
                        ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </form>
</body>

</html>