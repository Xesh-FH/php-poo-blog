<?php

/**
 * CE FICHIER A POUR BUT D'AFFICHER LA PAGE D'ACCUEIL !
 * 
 * On va donc se connecter à la base de données, récupérer les articles du plus récent au plus ancien (SELECT * FROM articles ORDER BY created_at DESC)
 * puis on va boucler dessus pour afficher chacun d'entre eux
 */

require_once('libraries/database.php');
require_once('libraries/utils.php');
require_once('libraries/models/Article.php');
require_once('libraries/models/User.php');

$model = new Article();
$userModel = new User();

$articles = $model->findAll("created_at DESC");
$users = $userModel->findAll();

/**
 * 3. Affichage
 */

// compact('pageTitle', 'articles') fait la même chose que créer le tableau associatif suivant :
// [
//    'pageTitle' => $pageTitle,
//    'articles'  => $articles
// ]
//    /!\==  Il faut que les variables avec des noms identiques aux strings passées en param de compact() existent dans le fichier  ==/!\
$pageTitle = "Accueil";
render('articles/index', compact('pageTitle', 'articles'));
