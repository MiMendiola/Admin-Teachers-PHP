<?php

    Class View{

        function __construct(){
        }

        /**
         * This function render a full view
         */
        function render($name){
            require  './Views/'. $name .'.php';
        }

        /**
         * This function assembles the view using by default the generic parts of the web
         */
        function view_loader($data){
          
          if(is_array($data)){
            //Create variables with the values that come to the view 
            foreach($data as $key => $value){
                $$key = $value;
            }
          }

            //Page Header        
            require_once ('./Views/config_views/header.php');

            //Check if the view is dashboard
            if(isset($data['view']) || $data != "login"){
                if($data['view'] != "login"){
                    if(!isset($user)){
                        $user = $_SESSION['user'];
                      }
                      $permisions = array(2,3);
                    if(in_array($_SESSION['user']->getUser_type_id(), $permisions) && $_SESSION['user']->getFirstTime() != "0000-00-00 00:00:00"){
                        require_once ('./Views/config_views/admin_panel.php');
                    }
                    if($_SESSION['user']->getFirstTime() != "0000-00-00 00:00:00"){
                        require_once ('./Views/config_views/nav.php');   

                    }
                }
                if($_GET['url'] != "main/dashboard"){
                    echo "<div class='d-flex align-items-baseline'>
                            <div class='p-2 col-md-6'>";
                        echo "<p class='ml-4'>".$breadcrumbs."</p>";
                    echo "</div>
                            <div class='col-md-2 text-center ml-auto' >
                                <a href='".URL."main/dashboard'> Return </a>
                            </div>
                        </div>";
                } else {
                    echo "<p class='ml-4'>".$breadcrumbs."</p>";
                }
            }

            //View 
            if(isset($data['view'])){
                require_once ('./Views/'.$data['view'].'.php');

            } else {
                require_once ('./Views/'.$data.'.php');
            }

            //Footer
            if(isset($data['view']) || $data != "login"){
                require_once ('./Views/config_views/footer.php');
            }
            
            require_once ('./Views/config_views/scripts.php');

        }
    }
?>