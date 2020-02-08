<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RectanglesInputController extends AbstractController
{
    /**
     * @Route("/rectangles/input", name="rectangles_input")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RectanglesInputController.php',
        ]);
    }
}
