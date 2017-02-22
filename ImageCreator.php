<?php

/**
 * Created by PhpStorm.
 * User: Bogdan
 * Date: 21.02.2017
 * Time: 15:06
 */
require ("ApiListener.php");

$i = new ImageCreator();
$i->Im();


class ImageCreator
{
    private $url = "https://api.ovva.tv/v2/ua/tvguide/1plus1/";
    private $programs;

    public function __construct(){
        $this->setUrl($this->url);
        $p = new ApiListener($this->url);
        $this->programs = $p->getPrograms();
        //var_dump($date);exit();
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function Im(){

        /* Создаем новый объект imagick */
        $im = new Imagick();
        $draw = new ImagickDraw();
        $pixel = new ImagickPixel( 'white' );

        foreach ($this->programs as $program) {

            $handle = fopen($program['image'], 'rb');
            $im->readImageFile($handle);
            $im->resizeImage(12, 12);

            /* Новое изображение */
            $im->newImage(800, 175, $pixel);

            /* Черный текст */
            $draw->setFillColor('black');

            /* Настройки шрифта */
            $draw->setFont('Bookman-Demi');
            $draw->setFontSize( 20 );

            /* Создаем текст */
            $im->annotateImage($draw, 10, 45, 0, date('h:m', $program['realtime_begin'])." - ".date('h:m', $program['realtime_end']).", ".$program['title'].", ".$program['sub_title']);

            /* Устанавливаем формат изображения */
            $im->setImageFormat('png');

        }

        /* Соединяем все изображения в одно */
        $im->resetIterator();
        $combined = $im->appendImages(true);

        /* Выводим изображение */
        $combined->setImageFormat("png");
        header("Content-Type: image/png");
        echo $combined;
    }

}