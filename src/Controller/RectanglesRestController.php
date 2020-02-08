<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RectanglesRestController extends AbstractController
{
    /**
     * @Route("/generate-rectangles/", name="generate_rectangles", methods={"POST"})
     */
    public function RectanglesInput()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RectanglesRestController.php',
        ]);
    }
}
