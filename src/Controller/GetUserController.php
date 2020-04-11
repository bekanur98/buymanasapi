<?php
// api/src/Controller/GetUserController.php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;

class GetUserController
{
    private $getUserHandler;

    public function __construct(GetUserHandler $getUserHandler)
    {
        $this->getUserHandler = $getUserHandler;
    }
    
    
    public function __invoke(User $data): User
    {
        $this->getUserHandler->handle($data);

        return $data;
    }
}