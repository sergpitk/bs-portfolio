<?php

namespace App\Controller;

use App\Entity\Rectangle;
use App\Service\RectanglesCreator;
use App\Service\RectanglesRawDataProcessor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RectanglesRestController extends AbstractController
{
    /**
     * @Route("/generate-rectangles/", name="generate_rectangles", methods={"POST"})
     * @param Request $request
     * @param Rectangle $rectangle
     * @param RectanglesRawDataProcessor $rectanglesRawDataProcessor
     * @param RectanglesCreator $rectanglesCreator
     * @return JsonResponse
     */
    public function RectanglesInput(Request $request, Rectangle $rectangle,
                        RectanglesRawDataProcessor $rectanglesRawDataProcessor, RectanglesCreator $rectanglesCreator)
    {
        $data = $request->getContent();

        $convertedData = $rectanglesRawDataProcessor->convertRaw($data);

        $rectanglesCollection = $rectanglesCreator->createRectangleCollection($rectangle, $convertedData);

        echo '<pre>';
        var_dump($rectanglesCollection->getRectangles());
        echo '</pre>';

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RectanglesRestController.php',
            'res' => $rectanglesCollection->getRectangles()
        ]);
    }

    /**
     * @Route("/generation-status", name="generation_status", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function RectanglesOutput(Request $request)
    {
        $id = $request->get('id');

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RectanglesRestController.php',
            'id'    => $id
        ]);
    }
}
