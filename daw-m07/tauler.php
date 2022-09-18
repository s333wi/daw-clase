<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    body {
      padding: 5px;
    }

    table {
      padding:5px;
      border: 1px solid black;
    }

    td {
      border: 1px solid black;
      margin: 1px 1px;
      width: 20px;
      height: 20px;
    }

    td.black {
      background-color: black;
    }

    td.white {
      background-color: lightgrey;
    }

  </style>
</head>

<body>
  <h1>Tauler escacs 8x8</h2>
    <table>
      <?php
      for ($row = 0; $row < 8; $row++) {
      ?>
        <tr>
          <?php for ($col = 0; $col < 8; $col++) {
            $color = ($row % 2 === 0 && $col % 2 != 0) ? ('black') : (($row % 2 != 0 && $col % 2 === 0) ? ('black') : ('white'));
          ?>
            <td class="<?= $color ?>">&nbsp;</td>
          <?php } ?>
        </tr>
      <?php } ?>
    </table>
</body>

</html>