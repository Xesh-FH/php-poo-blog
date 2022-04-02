<?php

class Renderer
{
    public static function render(string $path, array $variables = [])
    {
        //  extract() => documentation : https://www.php.net/manual/fr/function.extract.php
        extract($variables);
        ob_start();
        require('templates/' . $path . '.html.php');
        $pageContent = ob_get_clean();

        require('templates/layout.html.php');
    }
}
