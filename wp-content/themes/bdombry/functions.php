<?php

namespace Bdombry;
// add_action('wp_head', function () {

//     die("Salut");

// });

function customThemeSupport()
{
    add_theme_support('title-tag');

}

function addStyles()
{
    wp_register_style('bdombry', '/wp-content/themes/bdombry/styles/bdombry.css', [], 0.5);
    wp_register_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', ["jin"], 0.1);
    wp_register_script('bootstrap_script', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js');
    wp_enqueue_style('bdombry');
    wp_enqueue_style('bootstrap');
    wp_enqueue_script('bootstrap_script');
}


add_filter("wp_title");


add_action('after_setup_theme', 'bdombry\customThemeSupport');
add_action('wp_enqueue_scripts', 'bdombry\addStyles');