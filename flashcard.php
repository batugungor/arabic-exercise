<?php

$amount_of_letters = 1;
$amount_of_rows = 1;
$amount_of_choices = 4;
$harakaat_enable = "false";

$types = [
    "alphabet"
];

if (isset($_GET["harakaat"])) {
    if ($_GET["harakaat"] == "true") {
        $harakaat_enable = "true";
    }
}

$alphabet = json_decode(file_get_contents("content/alphabet.json"), true);

$letters = [];
$harakaat = [];

$choices = [];
$select = [];

foreach ($alphabet["alphabet"] as $letter) {
    $letters[$letter["pronunciation"]] = [
        "arabic" => $letter["properties"]["arabic"],
        "answer" => $letter["letter"]
    ];
}

foreach ($alphabet["harakaat"] as $letter) {
    $harakaat[$letter["type"]] = [
        "arabic" => $letter["properties"]["arabic"],
        "addition" => $letter["properties"]["addition"]
    ];
}

if (isset($_GET["letters"])) {
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

    $selectHarakaat = $harakaat[array_rand($harakaat)];

    for ($j = 0; $j < $amount_of_letters; $j++) {
        $selected = $select[array_rand($select)];


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

    $choices[] = $questionnaire[$i]["answer"];



    for ($i = 1; $i < $amount_of_choices; $i++) {
        $selected = $alphabet["alphabet"][array_rand($alphabet["alphabet"])];

        while ($selected["letter"] == $choices[0]) {
            $selected = $alphabet["alphabet"][array_rand($alphabet["alphabet"])];
        }


        $choices[] = $selected["letter"];
//        print_r($selected["letter"]);

    }
    shuffle($choices);
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
            <h1 class="display-4">Arabisch flashcards</h1>
            <p> Introductie: Er komt een Arabische letter voor. Kies de juiste transliteratie</p>
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
    </div>
    <div class="row mb-5">
        <div class="col-4">

        </div>
        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-body text-center" id="quiz-text"
                     data-quiz-answer='<?php echo $questionnaire[0]["answer"] ?>'>
                    <span class="quiz-text">
                        <?php echo $questionnaire[0]["text"] ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <?php foreach ($choices as $choice) { ?>
            <div class="col-md-<?php echo (12 / $amount_of_choices) ?> col-12 mb-2 mb-md-1 text-center">
                <div class="card quiz-select" style="cursor: pointer;">
                    <div class="card-body">
                        <span class="quiz-text" data-quiz-selected="<?php echo $choice ?>"><?php echo $choice ?></span>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js"
            crossorigin="anonymous"></script>
    <script src="js/external.js"></script>
    <input type="hidden" name="counter" id="counter" value="<?php echo $harakaat_enable == "true" ? '-3' : '-2'; ?>">

    <script>
        $(document).ready(function () {
            console.log
            $(".quiz-select").click(function (event) {
                var selectedValue = $(event.target).closest('.card-body')
                var dataSelected = selectedValue.children("span").data('quiz-selected');
                var quizText = $('#quiz-text').data('quiz-answer');

                if (quizText === dataSelected) {
                    $(selectedValue).css("border", "1px solid green");
                } else {
                    $(selectedValue).css("border", "1px solid red");
                }

            });
        });
    </script>
</body>
</html>

