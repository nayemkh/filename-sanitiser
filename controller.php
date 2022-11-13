<?php

namespace FileSanitiser;

class Controller
{
    public $filenames = [];

    public $options = [
        'r_underscore' => 'Replace underscores with spaces',
        'r_hyphen' => 'Replace hyphens with spaces',
        'capitalise_word' => 'Capitalise first letter of each word',
    ];

    public function processFileNames()
    {
        $submitted = htmlentities($_POST['filenames']);
        $filenames = array_filter(explode(PHP_EOL, $submitted));
        if (is_array($filenames) && !empty($filenames)) {
            foreach ($filenames as $filename) {
                if (isset($_POST['r_underscore']) && $_POST['r_underscore'] === '1') {
                    $filename = str_replace('_', ' ', $filename);
                }

                if (isset($_POST['r_hyphen']) && $_POST['r_hyphen'] === '1') {
                    $filename = str_replace('-', ' ', $filename);
                }

                if (isset($_POST['capitalise_word']) && $_POST['capitalise_word'] === '1') {
                    $words = explode(' ', $filename);
                    $capitalisedWords = [];
                    foreach ($words as $word) {
                        $capitalisedWords[] = ucfirst($word);
                    }
                    $filename = implode(' ', $capitalisedWords);
                }

                $this->filenames[] = $filename;
            }
        }
    }

    public function run()
    {
        if (isset($_POST['filenames']) && trim($_POST['filenames'] !== '')) {
            $this->processFileNames();
        }
    }
}
