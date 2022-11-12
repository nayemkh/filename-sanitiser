<?php

namespace FileSanitiser;

class Controller
{
    public $filenames = [];

    public function processFileNames()
    {
        $submitted = $_POST['filenames'] ?? '';

        if ($submitted) {
            $filenames = array_filter(explode(PHP_EOL, $submitted));
            if (is_array($filenames) && !empty($filenames)) {
                foreach ($filenames as $filename) {
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
