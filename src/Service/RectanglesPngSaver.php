<?php
/**
 * Created by PhpStorm.
 * User: Sergey Pitkevich <sergpitk@andi.lv>
 * Date: 09/02/2020
 * Time: 15:51
 */

namespace App\Service;


use App\Entity\Rectangle;
use App\Entity\RectanglesUnit;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RectanglesPngSaver
{

    private $validator;
    /** @param $status */
    private $status;
    
    private $prefixPath;
    private $pngDirectory;

    public function __construct(ValidatorInterface $validator, $prefixPath, $pngDirectory, $status)
    {
        $this->validator = $validator;
        $this->prefixPath = $prefixPath;
        $this->pngDirectory = $pngDirectory;
        $this->status = $status;
    }


    public function saveFile(Rectangle $rectangle)
    {
        $rectanglesUnits = $rectangle->getRectangles();

        /**
         * @var  RectanglesUnit $rectanglesUnit
         */
        foreach ($rectanglesUnits as $key => $rectanglesUnit) {
            if ($rectanglesUnit->getStatus() ==  $this->status[2]) {
                $this->prepareGD($rectanglesUnit, $rectangle);
            }
        }
    }
    
    private function prepareGD (RectanglesUnit $rectanglesUnit, Rectangle $rectangle)
    {
        $im = @imagecreatetruecolor(($rectanglesUnit->getX() + $rectanglesUnit->getHeight()),
            ($rectanglesUnit->getY() + $rectanglesUnit->getHeight()));
        $hex = $rectanglesUnit->getColor();

        $color = (function() use ($im, $hex) {
            $hex = ltrim($hex,'#');
            $red = hexdec(substr($hex,0,2));
            $green = hexdec(substr($hex,2,2));
            $blue = hexdec(substr($hex,4,2));
            return imagecolorallocate($im, $red, $green, $blue);
        })();


        imagefill($im, $rectanglesUnit->getX(), $rectanglesUnit->getY(), $color);

        header('Content-type: image/png');

        $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',
            $rectanglesUnit->getIdentity());
        $fileName = $safeFilename.'-'.uniqid().'.'.'png';


        imagepng($im,$this->prefixPath.$this->pngDirectory.$fileName);
        imagedestroy($im);
    }
}