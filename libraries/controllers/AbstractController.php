<?php

namespace Controllers;

abstract class AbstractController
{
    protected \Models\User $userModel;
    protected \Models\Article $articleModel;
    protected \Models\Comment $commentModel;

    public function __construct()
    {
        $this->userModel = new \Models\User();
        $this->articleModel = new \Models\Article();
        $this->commentModel = new \Models\Comment;
    }
}
