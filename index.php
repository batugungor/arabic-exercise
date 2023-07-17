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
    <div class="row align-items-center g-lg-5 py-5">
        <div class="col-lg-7 text-center text-lg-start">
            <h1 class="display-4 fw-bold lh-1 mb-3">Arabic Exercise</h1>
            <p class="col-lg-10 fs-4">Selecteer wat je wilt oefenen</p>
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
            <form class="p-4 p-md-5 border rounded-3 bg-light" method="get" action="exercise.php">
                <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelectGrid" name="type"
                            aria-label="Floating label select example">
                        <option value="alphabet">Alfabet</option>
                    </select>
                    <label for="floatingSelectGrid">Wat wil je oefenen?</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="color" name="color" aria-label="Floating label select example">
                        <option value="true">Ja</option>
                        <option value="false">Nee</option>
                    </select>
                    <label for="color">Wil je hulp met kleuren?</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="harakaat" name="harakaat"
                            aria-label="Floating label select example">
                        <option value="true">Ja</option>
                        <option value="false" selected>Nee</option>
                    </select>
                    <label for="color">Wil je oefenen met harakaat?</label>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <label style="opacity: 0.65">Welke letters wil je oefenen?</label>
                                <span class="form-text">(leeg laten voor allemaal)</span>
                            </div>
                            <?php foreach ($alphabet as $letter) { ?>
                                <div class="col-6">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="letters[]"
                                               value="<?php echo $letter['pronunciation'] ?>">
                                        <label class="form-check-label" for="inlineCheckbox1">
                                            <?php echo $letter["pronunciation"] . " (" . $letter["properties"]["arabic"] . ")" ?>
                                        </label>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <a href="/flashcard.php">
                            <button class="w-100 btn btn-lg btn-primary mb-2" type="button">Flashcard!</button>
                        </a>
                    </div>
                    <div class="col-6">
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Oefenen!</button>
                    </div>
                </div>
            </form>
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