<?php
/*
Plugin Name: Quoi
Description:  Remplace tout les quoi 
Version: 1
Requires PHP: 7.4
Author: bdombry
License: GPLv2 or later
Text Domain: bdombry
*/

// function replaces($texte) {
//     $search = array('quoi', 'Quoi');
//     $replace = array('quoicoubeh','Quoicoubeh');

//     $texte_modifie = str_replace($search, sprintf('%s', $replace), $texte);
    
//     return $texte_modifie;
// }


// Tableau des suffixes
$suffixes = array('feur', 'coubeh', 'd', 'drilater');


/// choisir un suffix random
function random_suffix($val){
    // Obtenir un index aléatoire
    $random_index = array_rand($val);

    // Sélectionner la chaîne correspondante
    return $val[$random_index];
} 





function replace($texte) {
    // Tableau des mots à rechercher
    $search = array('quoi', 'Quoi');

    // Tableau vide pour stocker les résultats des remplacements
    $replace = [];

    // On parcourt les mots à remplacer
    foreach ($search as $mot) {
        // Appeler la fonction random_suffix pour obtenir un suffixe aléatoire
        $replace[] = sprintf('%s%s', $mot, random_suffix());
    }

    // Remplacement dans le texte
    $texte_modifie = str_replace($search, $replace, $texte);

    return $texte_modifie;
}


// Filtre qui applique la fonction de remplacement à tous les textes de WordPress
add_filter('the_content', 'replace');
add_filter('the_title', 'replace');
add_filter('widget_text', 'replace');
add_filter('gettext', 'replace');
add_filter('ngettext', 'replace');
add_filter('the_excerpt', 'replace');

?>