<?php
declare(strict_types=1);

// load config
require_once 'config.php';

const DIR = 'src' ;

// load classes
require_all(DIR);


function require_all($dir, $depth=0, $maxDepth = 5) {
    if ($depth > $maxDepth) {
        return;
    }

    // require all php files
    $scan = glob("$dir/*");
    foreach ($scan as $path) {
        if (preg_match('/\.php$/', $path)) {
            require_once $path;
        } elseif (is_dir($path)) {
            require_all($path, $depth+1);
        }
    }
}


