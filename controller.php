<?php

namespace FileSanitiser;

class Controller
{
    public $filenames = [];

    public $options = [
        'r_underscore' => 'Replace underscores with spaces',
        'r_hyphen' => 'Replace hyphens with spaces',
    ];

    public function processFileNames()
    {
        $submitted = $_POST['filenames'] ?? '';

        if ($submitted) {
            $submitted = htmlentities($submitted);
            $filenames = array_filter(explode(PHP_EOL, $submitted));
            if (is_array($filenames) && !empty($filenames)) {
                foreach ($filenames as $filename) {
                    if (isset($_POST['r_underscore']) && $_POST['r_underscore'] === '1') {
                        $filename = str_replace('_', ' ', $filename);
                    }

                    if (isset($_POST['r_hyphen']) && $_POST['r_hyphen'] === '1') {
                        $filename = str_replace('-', ' ', $filename);
                    }

                    $this->filenames[] = $filename;
                }
            }
        }
    }

    public function run()
    {
        $this->processFileNames();
    }
}
