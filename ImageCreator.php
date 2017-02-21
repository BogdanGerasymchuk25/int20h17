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

    public function createImage(){
        $im = imagecreatefromjpeg($this->programs[0]['image']);
        Header("Content-type: image/jpeg");
        imagejpeg($im);
        imageDestroy($im);
    }


    public function Im(){
        /* Создаем новый объект imagick */
        $im = new Imagick();

        /* создаем красное, зеленое и синее изображения */
        $im->newImage(100, 50, "red");
        $im->newImage(100, 50, "green");
        $im->newImage(100, 50, "blue");

        /* Соединяем все изображения в одно */
        $im->resetIterator();
        $combined = $im->appendImages(true);

        /* Выводим изображение */
        $combined->setImageFormat("png");
        header("Content-Type: image/png");
        echo $combined;
    }

}