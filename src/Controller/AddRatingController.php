<?php


namespace App\Controller;
use App\Entity\Poster;

class AddRatingController
{
    private $addRatingHandler;

    public function __construct()
    {
        $this->addRatingHandler = 1;
    }

    public function __invoke(Poster $data):Poster
    {
        $this->addRatingHandler->handle($data);

        return $data;
    }

}