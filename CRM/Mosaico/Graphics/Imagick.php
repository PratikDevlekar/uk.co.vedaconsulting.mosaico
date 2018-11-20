<?php

/**
 * Class CRM_Mosaico_Graphics_Imagick
 *
 * A graphics provider which directly uses the imagick API.
 *
 * This is deprecated because we've had several random reports wherein
 * imagick operations fail and we haven't been able to determine why.
 */
class CRM_Mosaico_Graphics_Imagick implements CRM_Mosaico_Graphics_Interface {

  public function sendPlaceholder($width, $height) {
    $image = new Imagick();

    $image->newImage($width, $height, "#707070");
    $image->setImageFormat("png");

    $x = 0;
    $y = 0;
    $size = 40;

    $draw = new ImagickDraw();

    while ($y < $height) {
      $draw->setFillColor("#808080");

      $points = array(
        array("x" => $x, "y" => $y),
        array("x" => $x + $size, "y" => $y),
        array("x" => $x + $size * 2, "y" => $y + $size),
        array("x" => $x + $size * 2, "y" => $y + $size * 2),
      );

      $draw->polygon($points);

      $points = array(
        array("x" => $x, "y" => $y + $size),
        array("x" => $x + $size, "y" => $y + $size * 2),
        array("x" => $x, "y" => $y + $size * 2),
      );

      $draw->polygon($points);

      $x += $size * 2;

      if ($x > $width) {
        $x = 0;
        $y += $size * 2;
      }
    }

    $draw->setFillColor("#B0B0B0");
    $draw->setFontSize($width / 5);
    $draw->setFontWeight(800);
    $draw->setGravity(Imagick::GRAVITY_CENTER);
    $draw->annotation(0, 0, $width . " x " . $height);

    $image->drawImage($draw);

    header("Content-type: image/png");

    echo $image;
  }

}
