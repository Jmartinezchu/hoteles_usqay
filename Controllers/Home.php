<?php

 
  class Home extends Controllers {

    public function __construct()
    {
       parent::__construct();
    }

    public function home($parems)
    { 
      $data['page_id'] = 1;
      $data['page_tag'] = NAME_PROYECT;
      $data['page_title'] = "Página principal";
      $this->views->getView($this,"home",$data);
    }

  }

?>