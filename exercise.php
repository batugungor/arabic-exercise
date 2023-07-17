<?php

$amount_of_letters = 7;
$amount_of_rows = 9;
$harakaat_enable = "false";

$types = [
    "alphabet"
];

if (isset($_GET["harakaat"])) {
    if ($_GET["harakaat"] == "true") {
        $harakaat_enable = "true";
    }
}

$shipments = json_decode(file_get_contents("content/alphabet.json"), true);

$letters = [];
$harakaat = [];

$select = [];

foreach ($shipments["alphabet"] as $letter) {
    $letters[$letter["pronunciation"]] = [
        "arabic" => $letter["properties"]["arabic"],
        "answer" => $letter["letter"]
    ];
}

foreach ($shipments["harakaat"] as $letter) {
    $harakaat[$letter["type"]] = [
        "arabic" => $letter["properties"]["arabic"],
        "addition" => $letter["properties"]["addition"]
    ];
}

if(isset($_GET["letters"])) {
    foreach ($_GET["letters"] as $selectedLetter) {
        $select[] = $letters[$selectedLetter];
    }
} else {
    $select = $letters;
}

$questionnaire = [];

for ($i = 0; $i < $amount_of_rows; $i++) {
    $answer = [];
    $questionnaire[$i] = [
        "text" => '',
        "answer" => ''
    ];

    for ($j = 0; $j < $amount_of_letters; $j++) {
        $selected = $select[array_rand($select)];
        $selectHarakaat = $harakaat[array_rand($harakaat)];

        if ($harakaat_enable == "true") {
            $questionnaire[$i]["text"] = $selected["arabic"] . $selectHarakaat["arabic"] . $questionnaire[$i]["text"];
            $answer[$i][] = $selected["answer"] . $selectHarakaat["addition"];
        } else {
            $questionnaire[$i]["text"] = $selected["arabic"] . $questionnaire[$i]["text"];
            $answer[$i][] = $selected["answer"];
        }
    }

    $answer = array_reverse($answer[$i]);
    $questionnaire[$i]["answer"] = implode(' ', $answer);
}
?>

<!DOCTYPE html>
<html lang="nl">
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
<div class="container col-xl-10 col-xxl-8 px-4 py-3">
    <div class="row">
        <div class="col-md-12">
            <h1 class="display-4">Arabisch oefenen</h1>
            <p> Introductie: Het arabisch lezen gaat van rechts naar links, maar wanneer je een antwoord invult is het
                van links naar rechts.</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-10">
            <div class="row">
                <?php foreach ($questionnaire as $quiz) {
                    $quizcounter = 0;
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <span class="quiz-text">
                                </span>
                        <span class="quiz-text">
                            <?php echo $quiz["text"]; ?>
                        </span>
                            </div>
                        </div>
                        <input type="text" class="form-control mt-1 quiz-answer-inputs"
                               id="<?php echo "answer" . $quizcounter; ?>"
                               data-value-answer="<?php echo $quiz['answer'] ?>">
                    </div>
                    <?php
                    $quizcounter++;
                } ?>
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="list-group">
                <a href="/" class="list-group-item list-group-item-action" style="font-size: 15px">Terug naar de
                    hoofdmenu</a>
                <a href="/alphabet.php" class="list-group-item list-group-item-action" style="font-size: 15px">Bekijk alfabet</a>
                <a href="<?php echo $_SERVER['REQUEST_URI'] ?>" class="list-group-item list-group-item-action"
                   style="font-size: 15px">Opnieuw</a>
                <a href="javascript:void(0)" id="checkAnswers"
                   class="list-group-item list-group-item-action list-group-item-primary" style="font-size: 15px">
                    Nakijken
                </a>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-borderless mt-5">
                        <tbody>
                        <tr>
                            <th scope="row">Aantal goed</th>
                            <td id="amountOfGood"></td>
                        </tr>
                        <tr>
                            <th scope="row">Aantal fout</th>
                            <td id="amountOfWrong"></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"
            crossorigin="anonymous"></script>
    <script src="js/external.js"></script>
    <input type="hidden" name="counter" id="counter" value="<?php echo $harakaat_enable == "true" ? '-3' : '-2'; ?>">

    <?php
    if (isset($_GET["color"])) {
        if ($_GET["color"] == "true") {
            ?>
            <script>
                $(document).ready(function () {
                    $('.quiz-text').each(function () {
                        var letters = $(this).text().split('');
                        var counter = -30;
                        $(this).text('');
                        for (var i = 0; i < letters.length; i++) {
                            counter++;
                            if (i % 4 == 0 || counter == 0) {
                                counter = document.getElementById("counter").value;
                                $(this).append('<span class="color_red">' + letters[i] + '</span>');
                            } else {
                                $(this).append('<span class="color_black">' + letters[i] + '</span>');
                            }
                        }
                    });
                });
            </script>
            <?php
        }
    }
    ?>

    <script>
        $(document).ready(function () {
            $("#checkAnswers").click(function () {
                var correct = 0;
                var wrong = 0;

                $('.quiz-answer-inputs').each(function (e, element) {
                    if (element.value.toLowerCase() === $(element).data('value-answer')) {
                        $(element).css("border", "1px solid green");
                        correct++;
                    } else {
                        $(element).css("border", "1px solid red");
                        wrong++;
                    }
                });
                $('#amountOfGood').empty();
                $('#amountOfWrong').empty();
                $('#amountOfGood').append(correct);
                $('#amountOfWrong').append(wrong);
            });
        });
    </script>
</body>
</html>

