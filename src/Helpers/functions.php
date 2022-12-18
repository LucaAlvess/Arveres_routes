<?php

function redirect(string $path, int $httpCode = 301): never
{
    header('Location: ' . $path, true, $httpCode);
    exit();
}

