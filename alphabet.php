<?php
$alphabet = json_decode(file_get_contents("content/alphabet.json"), true)["alphabet"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Oefenen met Arabisch!</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1"/>
    <meta name="description" content=""/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/external.css"/>

</head>
<body>
<div id="fadein"></div>
<div id="loader-wrapper">
    <div class="loader"></div>
</div>

<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row">
        <div class="col-12 col-md-2">
            <div class="list-group">
                <a href="/" class="list-group-item list-group-item-action" style="font-size: 15px">Terug naar de
                    hoofdmenu</a>
            </div>
        </div>
    </div>
    <div class="row align-items-center g-lg-5 py-5">
        <div class="col-12 col-md-8">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" class="text-center">Letter</th>
                    <th scope="col" class="text-center">Uitspraak</th>
                    <th scope="col" class="text-center">Transliteratie</th>
                    <th scope="col" class="text-center">Eind - Midden - Begin</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($alphabet as $letter) { ?>
                    <tr>
                        <th class="text-center" scope="row"><span><?php echo $letter["properties"]["arabic"] ?></span></th>
                        <td class="text-center"><?php echo $letter["pronunciation"] ?></td>
                        <td class="text-center" ><?php echo $letter["letter"] ?></td>
                        <td class="text-center">
                        <span>
                            <?php echo $letter["properties"]["arabic"] .  "\u{200D}" ?>
                            <?php echo "\u{200D}" . $letter["properties"]["arabic"] . "\u{200D}" ?>
                            <?php echo "\u{200D}" . $letter["properties"]["arabic"] ?>
                        </span>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="js/external.js"></script>

</body>
</html>