<?php
namespace core\view;

abstract class HtmlPage{

    protected $htmlFile;
    protected $model;

    protected function drawHeader(){
        require_once('header.phtml');
    }

    protected function drawFooter(){
        require_once('footer.phtml');
    }

    public function show(){
        $this->drawHeader();
        require_once($this->htmlFile);
        $this->drawFooter();
    }

    public function setModel($model){
        $this->model = $model;
    }

    public function getModel(){
        return $this->model;
    }

}
