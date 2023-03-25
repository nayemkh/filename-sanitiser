<?php

namespace FileSanitiser;

class Controller
{
    public $filenames = [];

    public $options = [
        'r_underscore' => 'Replace underscores with spaces',
        'r_hyphen' => 'Replace hyphens with spaces',
        'r_ext' => 'Remove file extension (detects the <strong>last</strong> full stop and gets rid of it along with any subsequent text)',
        'capitalise_first_letter' => 'Capitalise first letter',
        'capitalise_word' => 'Capitalise first letter of each word',
    ];

    public $messages = [];

    public function processFilenames()
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

                if (isset($_POST['r-ext']) && $_POST['r-ext'] === '1') {
                    $fullStop = strrpos($filename, '.');
                    if ($fullStop) {
                        $filename = substr($filename, 0, $fullStop);
                    }
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

                if (isset($_POST['capitalise-first-letter']) && $_POST['capitalise-first-letter'] === '1') {
                    $capitalise = true;

                    // Don't capitalise word if specified to be ignored
                    $firstWord = strtok($filename, ' ');
                    if ((isset($ignoredWords)) && is_array($ignoredWords) && !empty($ignoredWords)) {
                        if (in_array(strtolower($firstWord), $ignoredWords)) {
                            $capitalise = false;
                        }
                    }

                    if ($capitalise) {
                        $filename = ucfirst($filename);
                    }
                }

                $this->filenames[] = $filename;
            }
        }
    }

    public function run()
    {
        if (isset($_POST['filenames']) && trim($_POST['filenames'] !== '')) {
            // Don't run sanitiser unless an option is selected
            if (is_array($this->options) && !empty($this->options)) {
                foreach ($this->options as $key => $option) {
                    $optionName = str_replace('_', '-', $key);
                    if (isset($_POST[$optionName]) && $_POST[$optionName] === '1') {
                        $optionSelected = true;
                        continue;
                    }
                }
            }
            if (isset($optionSelected)) {
                $this->processFilenames();
            } else {
                $this->messages[] = 'You must select an option';
            }
        }
    }
}
