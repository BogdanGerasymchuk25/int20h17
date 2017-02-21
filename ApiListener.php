<?php
/**
 * Created by PhpStorm.
 * User: Bogdan
 * Date: 21.02.2017
 * Time: 12:11
 */
define('__ROOT__', dirname(dirname(__FILE__)));

class ApiListener
{
    private $data;
    private $date;
    private $programs = array();

    public function __construct($url){
        $dataJson = file_get_contents($url);
        $dataObj = json_decode($dataJson);
        if ($dataObj !== null) {
            $this->setData($dataObj);
            $this->setDate($dataObj->data->date);
            $this->setPrograms($dataObj->data->programs);
        } else {
            $this->setData('unknown');
        }
    }

    public function getData(){
       return $this->data;
    }

    public function setData($data){
        $this->data = $data;
    }

    public function getDate(){
        return $this->date;
    }

    public function setDate($date){
        $this->date = $date;
    }

    public function getPrograms(){
        return $this->programs;
    }

    public function setPrograms($programs){
        foreach ($programs as $program){
            array_push($this->programs,[
                    "image" => $program->image->preview,
                    "title" => $program->title,
                    "sub_title" => $program->subtitle,
                    "realtime_begin" => $program->realtime_begin,
                    "realtime_end" => $program->realtime_end,
                    "is_on_the_air" => $program->is_on_the_air,
                ]
            );
        }
    }

}