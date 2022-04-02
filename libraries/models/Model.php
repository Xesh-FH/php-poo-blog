<?php

namespace Models;

abstract class Model
{
    protected $pdo;
    protected string $table;

    public function __construct()
    {
        $this->pdo = \Database::getPdo();
    }

    /**
     * Retourne la liste de tous les items du type qui hérite de Model
     * 
     * @return array
     */
    public function findAll(?string $order = ""): array
    {
        // On utilisera ici la méthode query (pas besoin de préparation car aucune variable n'entre en jeu)
        $sql = "SELECT * FROM {$this->table}";

        if ($order) {
            $sql .= " ORDER BY " . $order;
        }

        $resultats = $this->pdo->query($sql);
        // On fouille le résultat pour en extraire les données réelles
        $items = $resultats->fetchAll();
        return $items;
    }

    /**
     * Récupération de l'item en question
     * On va ici utiliser une requête préparée car elle inclue une variable qui provient de l'utilisateur :
     * Ne faites jamais confiance à ce connard d'utilisateur ! :D
     * 
     * @param integer $id
     * Retourne un array ou false
     */
    public function findById(int $id)
    {

        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");

        // On exécute la requête en précisant le paramètre :id 
        $query->execute(['id' => $id]);

        // On fouille le résultat pour en extraire les données réelles de l'article
        $item = $query->fetch();
        return $item;
    }

    /**
     * Réelle suppression de l'item
     * @param integer $id
     * @return void
     */
    public function delete(int $id): void
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $query->execute(['id' => $id]);
    }
}
