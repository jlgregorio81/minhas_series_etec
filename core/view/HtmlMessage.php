<?php
namespace core\view;

class HtmlMessage extends HtmlPage{

    protected $title;
    protected $msg;

    public function __construct($title = null, $msg = null)
    {
        $this->htmlFile = 'core/view/html_message.phtml';
        $this->title = $title;
        $this->msg = $msg;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function setMsg($msg){
        $this->msg = $msg;
    }

}