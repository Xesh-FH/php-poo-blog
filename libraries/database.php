<?php

/**
 * Retourne une connexion à la Base de Données
 * 
 * /**
 * 1. Connexion à la base de données avec PDO
 * Attention, on précise ici deux options :
 * - Le mode d'erreur : le mode exception permet à PDO de nous prévenir violament quand on fait une connerie ;-)
 * - Le mode d'exploitation : FETCH_ASSOC veut dire qu'on exploitera les données sous la forme de tableaux associatifs
 * 
 * @return PDO
 */
function getPdo(): PDO
{
    $pdo = new PDO('mysql:host=localhost;dbname=blogpoo;charset=utf8', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    return $pdo;
}


/**
 * Retourne la liste de tous les articles
 * 
 * @return array
 */
function findAllArticles(): array
{
    $pdo = getPdo();
    // On utilisera ici la méthode query (pas besoin de préparation car aucune variable n'entre en jeu)
    $resultats = $pdo->query('SELECT * FROM articles ORDER BY created_at DESC');
    // On fouille le résultat pour en extraire les données réelles
    $articles = $resultats->fetchAll();
    return $articles;
}

/**
 * Récupération de l'article en question
 * On va ici utiliser une requête préparée car elle inclue une variable qui provient de l'utilisateur :
 * Ne faites jamais confiance à ce connard d'utilisateur ! :D
 * 
 * @param integer $id
 * Retourne un array ou false
 */
function findArticle(int $id)
{

    $pdo = getPdo();
    $query = $pdo->prepare("SELECT * FROM articles WHERE id = :article_id");

    // On exécute la requête en précisant le paramètre :article_id 
    $query->execute(['article_id' => $id]);

    // On fouille le résultat pour en extraire les données réelles de l'article
    $article = $query->fetch();
    return $article;
}

/**
 * Récupération des commentaires de l'article en question
 * Pareil, toujours une requête préparée pour sécuriser la donnée filée par l'utilisateur (cet enfoiré en puissance !)
 * @param integer $article_id
 * @return array
 */
function findAllComments(int $article_id): array
{
    $pdo = getPdo();
    $query = $pdo->prepare("SELECT * FROM comments WHERE article_id = :article_id");
    $query->execute(['article_id' => $article_id]);
    $commentaires = $query->fetchAll();
    return $commentaires;
}

/**
 * Trouver un commentaire par son id
 * @param integer $id
 * Retourne un tableau ou false
 */
function findComment(int $id)
{
    $pdo = getPdo();
    $query = $pdo->prepare('SELECT * FROM comments WHERE id = :id');
    $query->execute(['id' => $id]);
    $comment = $query->fetch();
    return $comment;
}

/**
 * Suppréssion d'un commentaire
 * @param integer $id
 * @return void
 */
function deleteComment(int $id): void
{
    $pdo = getPdo();
    $query = $pdo->prepare('DELETE FROM comments WHERE id = :id');
    $query->execute(['id' => $id]);
}

/**
 * Insertion du commentaire
 * @param string $author
 * @param string $content
 * @param integer $article_id
 * @return void
 */
function insertComment(string $author, string $content, int $article_id): void
{
    $pdo = getPdo();
    $query = $pdo->prepare('INSERT INTO comments SET author = :author, content = :content, article_id = :article_id, created_at = NOW()');
    $query->execute(compact('author', 'content', 'article_id'));
}

/**
 * Réelle suppression de l'article
 * @param integer $id
 * @return void
 */
function deleteArticle(int $id): void
{
    $pdo = getPdo();
    $query = $pdo->prepare('DELETE FROM articles WHERE id = :id');
    $query->execute(['id' => $id]);
}
