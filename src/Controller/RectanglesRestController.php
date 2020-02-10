<?php

namespace App\Controller;

use App\Entity\Rectangle;
use App\Service\RectanglesCreator;
use App\Service\RectanglesOverlapValidator;
use App\Service\RectanglesRawDataProcessor;
use App\Service\RectanglesPngSaver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RectanglesRestController extends AbstractController
{
    /** @param  */
    private $faults;

    public function __construct($faults)
    {
        $this->faults = $faults;
    }


    /**
     * @Route("/generate-rectangles/", name="generate_rectangles", methods={"POST"})
     * @param Request $request
     * @param Rectangle $rectangle
     * @param RectanglesRawDataProcessor $rectanglesRawDataProcessor
     * @param RectanglesCreator $rectanglesCreator
     * @param RectanglesOverlapValidator $rectanglesOverlapValidator
     * @param RectanglesPngSaver $rectanglesPngSaver
     * @return JsonResponse
     */
    public function RectanglesInput(
                        Request $request,
                        Rectangle $rectangle,
                        RectanglesRawDataProcessor $rectanglesRawDataProcessor,
                        RectanglesCreator $rectanglesCreator,
                        RectanglesOverlapValidator $rectanglesOverlapValidator,
                        RectanglesPngSaver $rectanglesPngSaver
    )
    {
        $data = $request->getContent();

        $convertedData = $rectanglesRawDataProcessor->convertRaw($data);

        $rectanglesCollection = $rectanglesCreator->createRectangleCollection($rectangle, $convertedData);



        if (NULL === $rectanglesCollection->getErrors()) {
            $rectangleOverlapChecked = $rectanglesOverlapValidator->validateOverlapCollection($rectanglesCollection);
            /*echo '<pre>';
            var_dump($rectangleOverlapChecked->getRectangles());
            echo '</pre>';*/
        }
        else {
            return $this->json([
                'success' => false,
                'errors' => [
                    $this->faults[0] => ['rectangle_id'],
                    $this->faults[1] => ['rectangle_id'],
                    $this->faults[2] => ['width'],
                    $this->faults[3] => []
                ]
            ]);
        }

        $rectanglesPngSaver->saveFile($rectangleOverlapChecked);



        return $this->json([
            'success' => true,
            'id' => auto-generated-identifier
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
