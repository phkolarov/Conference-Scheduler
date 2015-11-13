<?php
declare(strict_types=1);

class MainMenuHelper{


    public static $menuitems;

    public static function generate(){

        $authorizedLinks = "";
        $registeredUsersMenu = "";
        if(count(self::$menuitems) > 0){

            foreach(self::$menuitems as $button => $value){


                $authorizedLinks .= "<li><a href=\"#\">$button</a></li>";

            }

        }


        if(count(self::$menuitems) > 0){

            $registeredUsersMenu .= "<li class=\"dropdown\">
                <a href=\"#\" class=\"dropdown-toggle\" data-toggle=\"dropdown\" role=\"button\" aria-haspopup=\"true\" aria-expanded=\"false\">Registered Users <span class=\"caret\"></span></a>
                <ul class=\"dropdown-menu\">
                  ". $authorizedLinks . "

                </ul>
              </li>";
        }

        echo  "<nav class=\"navbar navbar-default\">
        <div class=\"container-fluid\">
          <div class=\"navbar-header\">
            <button type=\"button\" class=\"navbar-toggle collapsed\" data-toggle=\"collapse\" data-target=\"#navbar\" aria-expanded=\"false\" aria-controls=\"navbar\">
              <span class=\"sr-only\">Toggle navigation</span>
              <span class=\"icon-bar\"></span>
              <span class=\"icon-bar\"></span>
              <span class=\"icon-bar\"></span>
            </button>
            <a class=\"navbar-brand\" href=\"#\">Conference Scheduler</a>
          </div>
          <div id=\"navbar\" class=\"navbar-collapse collapse\">
            <ul class=\"nav navbar-nav\">
              <li class=\"active\"><a href=\"#\">Home</a></li>
              <li><a href=\"#\">About</a></li>
              <li><a href=\"#\">Contact</a></li>
            ".$registeredUsersMenu."
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
      <form method='post' action='Test/index'>
      <input type='text' name='inputtest'>
      <input type='submit' value='send'>
      </form>
      ";

    }

}
?>


