<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 8.10.2015 г.
 * Time: 11:27 ч.
 */
declare(strict_types=1);

namespace controllers\defaultControllers;


class CustomRouteController
{


   public static function routeChecker($controller,$action){

       $controller = strtolower($controller);
       $action = strtolower($action);


       $filePath = "config\\customRoutes.txt";
       $file = new \SplFileObject($filePath);
       $pattern  = '/#default controller\/action: ([A-Za-z]*)\/([A-Za-z]*); #custom controller\/action: ([A-Za-z]*)\/([A-Za-z]*);/';

       $returnCorrectParameters = [];

       foreach($file as $line){


           preg_match($pattern,$line,$match);


          if(!empty($match[0])) {


              $defaultController = strtolower($match[1]);
              $defaultAction = strtolower($match[2]);
              $customController = strtolower($match[3]);
              $customAction = strtolower($match[4]);

              if ($customController == $controller && $customAction == $action && $defaultController != "" && $defaultAction != "") {

                  var_dump('1');
                  $returnCorrectParameters["controller"] = $defaultController;
                  $returnCorrectParameters["action"] = $defaultAction;

              } elseif ($controller == $defaultController && $action == $defaultAction) {

                  throw new \ErrorException('This route not exist!');
              }
          }
       }

       return $returnCorrectParameters;

   }
}