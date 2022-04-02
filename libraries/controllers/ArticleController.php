<?php

namespace Controllers;

class ArticleController extends AbstractController
{
    /**
     * Montrer la liste des articles
     */
    public function index()
    {
        $articles = $this->articleModel->findAll("created_at DESC");
        $users = $this->userModel->findAll();

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
        \Renderer::render('articles/index', compact('pageTitle', 'articles'));
    }

    /**
     * Montrer un Article
     */
    public function show()
    {
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

        $article = $this->articleModel->findById($article_id);
        $commentaires = $this->commentModel->findAllByArticle($article_id);


        /**
         * 5. On affiche 
         */
        $pageTitle = $article['title'];

        \Renderer::render('articles/show', compact('pageTitle', 'article', 'commentaires', 'article_id'));
    }

    /**
     * DANS CETTE FONCTION, ON CHERCHE A SUPPRIMER L'ARTICLE DONT L'ID EST PASSE EN GET
     * Il va donc falloir bien s'assurer qu'un paramètre "id" est bien passé en GET, puis que cet article existe bel et bien
     * Ensuite, on va pouvoir effectivement supprimer l'article et rediriger vers la page d'accueil
     */
    public function delete()
    {
        /**
         * On vérifie que le GET possède bien un paramètre "id" (delete.php?id=202) et que c'est bien un nombre
         */
        if (empty($_GET['id']) || !ctype_digit($_GET['id'])) {
            die("Ho ?! Tu n'as pas précisé l'id de l'article !");
        }

        $id = $_GET['id'];

        /**
         * Vérification que l'article existe bel et bien
         */
        $article = $this->articleModel->findById($id);
        if (!$article) {
            die("L'article $id n'existe pas, vous ne pouvez donc pas le supprimer !");
        }

        $this->articleModel->delete($id);

        /**
         * 5. Redirection vers la page d'accueil
         */
        \Http::redirect('index.php');
    }
}
