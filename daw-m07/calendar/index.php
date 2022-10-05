<?php
$abbrDies = ['Dl', 'Dm', 'Dc', 'Dj', 'Dv', 'Ds', 'Dg'];
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
    <table border=1>
        <thead>
            <tr>
                <td>
                    << </td>
                <td colspan=2 class="noBorder">
                    <select name="months">
                        <?php
                        for ($month = 1; $month <= 12; $month++) {
                            $dia = date("M", strtotime("1-" . $month . "-2000"));
                            echo "<option value='" . $dia . "'>" . $dia . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td class="noBorder"></td>
                <td colspan=2 class="noBorder">
                <select name=" years">
                    <?php
                    for ($year = 1970; $year <= 2077; $year++) {
                        $dia = date("Y", strtotime("01-01-" . $year));
                        echo "<option value='" . $dia . "'>" . $dia . "</option>";
                    }
                    ?>
                    </select>
                </td>
                <td> >> </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                foreach ($abbrDies as $dia) {
                    echo '<td>' . $dia . '</td>';
                }
                ?>
            </tr>
        </tbody>
    </table>
</body>

</html>