<?php

/**
 * CE FICHIER DOIT AFFICHER UN ARTICLE ET SES COMMENTAIRES !
 * 
 * On doit d'abord récupérer le paramètre "id" qui sera présent en GET et vérifier son existence
 * Si on n'a pas de param "id", alors on affiche un message d'erreur !
 * 
 * Sinon, on va se connecter à la base de données, récupérer les commentaires du plus ancien au plus récent (SELECT * FROM comments WHERE article_id = ?)
 * 
 * On va ensuite afficher l'article puis ses commentaires
 */

require_once('libraries/database.php');
require_once('libraries/utils.php');
require_once('libraries/models/Article.php');
require_once('libraries/models/Comment.php');

$articleModel = new Article;
$commentModel = new Comment;

/**
 * 1. Récupération du param "id" et vérification de celui-ci
 */
// On part du principe qu'on ne possède pas de param "id"
$article_id = null;

// Mais si il y'en a un et que c'est un nombre entier, alors c'est cool
if (!empty($_GET['id']) && ctype_digit($_GET['id'])) {
    $article_id = $_GET['id'];
}

// On peut désormais décider : erreur ou pas ?!
if (!$article_id) {
    die("Vous devez préciser un paramètre `id` dans l'URL !");
}

$article = $articleModel->findById($article_id);
$commentaires = $commentModel->findAllByArticle($article_id);


/**
 * 5. On affiche 
 */
$pageTitle = $article['title'];

render('articles/show', compact('pageTitle', 'article', 'commentaires', 'article_id'));
