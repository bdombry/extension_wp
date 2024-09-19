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


/// choisir un suffixe random
function random_suffixe($val){
    // Obtenir un index aléatoire
    $random_index = array_rand($val);

    // Sélectionner la chaîne correspondante
    return $val[$random_index];
} 



function replace($texte) {
    // Les suffixes aléatoires
    $suffixes = array('feur ', 'coubeh ');

    // Les mots à rechercher
    $search = array('quoi', 'Quoi');

    // Boucle sur chaque mot à rechercher
    foreach ($search as $mot) {
        // Remplacer chaque occurrence du mot, même s'il fait partie d'un mot plus long
        $texte = preg_replace_callback(
            '/' . preg_quote($mot, '/') . '/',
            function($matches) use ($suffixes) {
                // Ajoute un suffixe aléatoire à chaque correspondance du mot trouvé
                return $matches[0] . random_suffixe($suffixes);
            },
            $texte
        );
    }

    return $texte;
}




// Tableau des options que nous voulons vérifier et appliquer un filtre
$options = [
    'content' => 'the_content',
    'title' => 'the_title',
    'widget' => 'widget_text',
    'trad'=> 'gettext',
    'excerpt' => 'the_excerpt',

];




// Fonction pour ajouter le plugin dans les onglets principaux 
function quoi_plugin_menu() {
    add_menu_page(
        // Titre de l'onglet
        'Réglages du Plugin Quoi',

        // Nom de l'onglet
        'Quoi Plugin',

        // Capacité requise pour voir l'onglet
        'manage_options',

        // Slug unique pour la page
        'quoi-plugin-settings',

        // Fonction de rappel qui affichera le contenu de la page
        'quoi_plugin_settings_page',

        // Icône du menu (WordPress Dashicons)
        'dashicons-admin-generic',

        // Position dans le menu
        30
    );
}
add_action('admin_menu', 'quoi_plugin_menu');


// Interface des options 
function quoi_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h1>Réglages du Plugin Quoi</h1>
        <form method="post" action="options.php">
            <div class="preference">
                <label label for="the_content">Modifie le contenu des articles/pages.s</label>
                <input type="checkbox" name="content" id="content" value="1" <?php checked(1, get_option('content'), true); ?> />
            </div>
            <div class="preference">
                <label label for="title">Modifie le titre des articles/pages.</label>
                <input type="checkbox" name="title" id="title" value="1" <?php checked(1, get_option('title'), true); ?> />
            </div>
            <div class="preference">
                <label label for="widget">Modifie le contenu des widgets de texte.</label>
                <input type="checkbox" name="widget" id="widget" value="1" <?php checked(1, get_option('widget'), true); ?> />
            </div>
            <div class="preference">
                <label label for="mod_gettext">Modifie les chaînes de texte traduites.</label>
                <input type="checkbox" name="gettext" id="gettext" value="1" <?php checked(1, get_option('gettext'), true); ?> />
            </div>
            <div class="preference">
                <label label for="article">Modifie le texte des articles/pages.</label>
                <input type="checkbox" name="article" id="article" value="1" <?php checked(1, get_option('article'), true); ?> />
            </div>
            
            
            <?php
            // Affiche les champs de sécurité pour les options
            settings_fields('quoi_plugin_settings');
            // Affiche toutes les sections et champs de la page
            do_settings_sections('quoi-plugin-settings');
            // Affiche le bouton de soumission
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', 'quoi_plugin_register_settings');


function quoi_plugin_register_settings() {
    // Tableau des options à enregistrer
    $options = [
        'content',
        'title',
        'widget',
        'gettext',
        'article',
    ];

    // Parcours du tableau pour enregistrer chaque option
    foreach ($options as $option_name) {
        register_setting('quoi_plugin_settings', $option_name);
    }
}


// Parcours du tableau des options
foreach ($options as $option_name => $filter_name) {
    // Si l'option est cochée (valeur == 1)
    if (get_option($option_name) == 1) {
        // Ajouter le filtre correspondant à la fonction 'replace'
        add_filter($filter_name, 'replace');
    }
}




// // Vérification de la valeur de l'option 'content'
// if (get_option('content') == 1) {
//     // Si la checkbox est cochée (valeur = 1), appliquer le filtre
//     add_filter('the_content', 'replace');
// } else {
//     // Si la checkbox n'est pas cochée, ne rien faire
//     return null;
// }




// function replace($texte) {
//     $suffixes = array('feur ', 'coubeh ');
//     // Tableau des mots à rechercher
//     $search = array('quoi', 'Quoi');

//     // Tableau vide pour stocker les résultats des remplacements
//     $replace = [];

//     // On parcourt les mots à remplacer
//     foreach ($search as $mot) {
//         // Appeler la fonction random_suffix pour obtenir un suffixe aléatoire
//         $replace[] = sprintf('%s%s', $mot, random_suffixe($suffixes), );
//     }

//     // Remplacement dans le texte
//     $texte_modifie = str_replace($search, $replace, $texte);

//     return $texte_modifie;
// }




// function quoi_plugin_register_settings() {
//     // Enregistrement de l'option 'content' dans la base de données
//     register_setting('quoi_plugin_settings', 'content');
// }




// function replaces($texte) {
//     $search = array('quoi', 'Quoi');
//     $replace = array('quoicoubeh','Quoicoubeh');

//     $texte_modifie = str_replace($search, sprintf('%s', $replace), $texte);
    
//     return $texte_modifie;
// }





// Filtre qui applique la fonction de remplacement à tous les textes de WordPress

// Modifie le contenu des articles/pages.
// add_filter('the_content', 'replace');

// Modifie le titre des articles/pages.
// add_filter('the_title', 'replace');

// Modifie le contenu des widgets de texte.
// add_filter('widget_text', 'replace');

// Modifie les chaînes de texte traduites.
// add_filter('gettext', 'replace');

// Modifie le texte des articles/pages.
// add_filter('the_excerpt', 'replace');
?>