
<?php
 
class Core{
    protected $currentController= 'Pages';
    protected $currentMethod ='index';
    protected $params =[]; 

    public function __construct(){
        // print_r($this->getUrl());
        $url=$this->getUrl();
        // print_r($url);
        // Lok into controller for first value, uc words will capitalize firts letter
        // if(file_exists('../app/controllers/'. ucwords($url[0]).'.php')){
        //     // Set a new controller
        //     $this->currentController=ucwords($url[0]);
        //     unset($url[0]);
        // }
        // require controller
        require_once '../app/controllers/'. $this->currentController .'.php';
        // instantiate 
        $this->currentController= new $this->currentController;
        // second part of url \
        if(isset($url[1])){
            if(Method_exists($this->currentController, $url[1])){
                $this->currentMethod=$url[1];
                unset($url[1]);
            }
        }
        //Get parameters
        $this->params=$url ? array_values($url) : [];
        // call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod],$this->params);
   }
    public function getUrl(){
        if(isset($_GET['url'])){
          $url = rtrim($_GET['url'], '/');
          $url = filter_var($url, FILTER_SANITIZE_URL);
          $url = explode('/', $url);
          return $url;
        }
    }
   
  
 }
