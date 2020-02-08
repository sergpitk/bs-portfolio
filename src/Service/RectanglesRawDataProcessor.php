<?php
/**
 * Created by PhpStorm.
 * User: Sergey Pitkevich <sergpitk@andi.lv>
 * Date: 08/02/2020
 * Time: 15:21
 */

namespace App\Service;

class RectanglesRawDataProcessor
{

    public function convertRaw ($data) {
        function multi_explode ($delimiters,$string) {

            $ready = str_replace($delimiters, $delimiters[0], $string);
            return  explode($delimiters[0], $ready);
        }

        $res = explode("rectangles", $data);



        $res_res = str_replace([",","{","}"], '', $res);

        $input = null;
        foreach ($res_res as $key => $value) {
            $input[] = multi_explode(["id:", "x:", "y:", "height:", "width:", "color:"], $value);
        }

        $headerBody = $input[0];
        array_shift($headerBody);

        foreach ($headerBody as $key=>&$value) {
            $value = preg_replace('/[\s+,\'\]}{]/', '', $value);
        }

        $headerKeys = ['width','height','color'];
        $header = array_combine($headerKeys, $headerBody);

        $bodyBody = $input[1];
        array_shift($bodyBody);
        foreach ($bodyBody as $key=>&$value) {
            $value = preg_replace('/[\s+,\'\]}{]/', '', $value);
        }

        $bodyKeys = ["id", "x", "y", "height", "width", "color"];
        $body = null;

        for ($i = 0; (count($bodyBody) / count($bodyKeys)) ; $i++) {
            foreach ($bodyKeys as  $v) {
                $body[$i][$v] = $bodyBody[0];
                array_splice($bodyBody, 0,1);
            }
        }
        return array_merge(
            $header,
            ['rectangles'=> $body]
        );
    }
}