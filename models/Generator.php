<?php

class Generator
{
    private $alphabet;
    private $alphabet_link = "../content/alphabet.json";

    private $_harakaat = false;
    private $_colors = false;

    private $letters;
    private $harakaat;

    private $quiz;
    private $_amount_of_rows;
    private $_amount_of_letters;

    public function __construct()
    {
        $this->initalize();
    }

    public function initalize()
    {
        $this->alphabet = json_decode(file_get_contents($this->alphabet_link), true);
    }

    public function setConfiguration($rows, $letters)
    {
        $this->_amount_of_rows = $rows;
        $this->_amount_of_letters = $letters;
    }

    public function setData()
    {
        foreach ($this->alphabet as $letter) {
            $this->letters[$letter["letter"]] = [
                "arabic" => $letter["properties"]["arabic"],
                "answer" => $letter["letter"]
            ];
        }

        foreach ($this->alphabet as $letter) {
            $this->harakaat[$letter["type"]] = [
                "arabic" => $letter["properties"]["arabic"],
                "addition" => $letter["properties"]["addition"]
            ];
        }
    }

    public function generateQuiz()
    {
        $questionnaire = [];
        for ($i = 0; $i < $this->_amount_of_rows; $i++) {
            $answer = [];
            $questionnaire[$i] = [
                "text" => '',
                "answer" => ''
            ];

            for ($j = 0; $j < $this->_amount_of_letters; $j++) {
                $selected = $this->alphabet[array_rand($this->alphabet)];
                $selectHarakaat = $this->harakaat[array_rand($this->harakaat)];

                if ($this->_harakaat) {
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

        $this->quiz = $questionnaire;
    }

    public function getAlphabet()
    {
        return $this->alphabet;
    }

    public function getQuiz() {
        return $this->quiz;
    }
}