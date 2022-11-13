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
            if (isset($_POST['ignore-words']) && trim($_POST['ignore-words']) !== '') {
                $ignoredWords = array_map('strtolower', explode(',', $_POST['ignore-words']));
                $ignoredWords = array_map('trim', $ignoredWords);
            }

            foreach ($filenames as $filename) {
                if (isset($_POST['r-underscore']) && $_POST['r-underscore'] === '1') {
                    $filename = str_replace('_', ' ', $filename);
                }

                if (isset($_POST['r-hyphen']) && $_POST['r-hyphen'] === '1') {
                    $filename = str_replace('-', ' ', $filename);
                }

                if (isset($_POST['capitalise-word']) && $_POST['capitalise-word'] === '1') {
                    $words = explode(' ', $filename);
                    $capitalisedWords = [];
                    foreach ($words as $word) {
                        // Don't capitalise word if specified to be ignored
                        if ((isset($ignoredWords)) && is_array($ignoredWords) && !empty($ignoredWords)) {
                            if (in_array(strtolower($word), $ignoredWords)) {
                                $capitalisedWords[] = $word;
                                continue;
                            }
                        }
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
