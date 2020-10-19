<?php
/**
 * MIT License
 * @license https://github.com/joaomfrebelo/at_qrcode/blob/master/LICENSE
 * Copyright (c) 2020 João Rebelo
 */

require_once __DIR__
    .DIRECTORY_SEPARATOR.".."
    .DIRECTORY_SEPARATOR."vendor"
    .DIRECTORY_SEPARATOR."autoload.php";

spl_autoload_register(function ($class) {
    if (\strpos("\\", $class) === 0) {
        /** @var string Class name Striped of the first blackslash */
        $class = \substr($class, 1, \strlen($class) - 1);
    }

    $pathBase = __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR;
    $pathSrc  = $pathBase."src".DIRECTORY_SEPARATOR.$class.".php";
    if (is_file($pathSrc)) {
        require_once $pathSrc;
        return;
    }

    $pathTests = $pathBase."test".DIRECTORY_SEPARATOR.$class.".php";
    if (is_file($pathTests)) {
        require_once $pathTests;
        return;
    }
});

define("IS_UNIT_TEST", true);
