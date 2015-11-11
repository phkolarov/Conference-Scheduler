<?php
declare(strict_types=1);

class MainMenuHelper{


    public static function generate(array $publicButtons, array $AuthorizedButtons) : string{



        $publicLinks = "";
        $authorizedLinks = "";

        if(count($publicButtons) > 0){

            foreach($publicButtons as $button){

                    $publicButtons += "<li><a href=\"#\">Something else here</a></li>";

            }

        }






        return "";

    }

}
?>


