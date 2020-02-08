<?php

namespace App\Controller;

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
     * @param RectanglesRawDataProcessor $rectanglesRawDataProcessor
     * @param RectanglesCreator $rectanglesCreator
     * @return JsonResponse
     */
    public function RectanglesInput(Request $request, RectanglesRawDataProcessor $rectanglesRawDataProcessor,
            RectanglesCreator $rectanglesCreator)
    {
        $data = $request->getContent();

        $convertedData = $rectanglesRawDataProcessor->convertRaw($data);

        $rectanglesCreator->createRectangleCollection($convertedData);



        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/RectanglesRestController.php',
            'res' => $convertedData
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
