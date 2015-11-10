<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 8.10.2015 г.
 * Time: 11:27 ч.
 */
declare(strict_types=1);

namespace controllers;


class CustomRouteController
{


   public static function routeChecker(string $currentRoute) : string{

       $filePath = "config\\customRoutes.txt";
       $file = new \SplFileObject($filePath);
       $pattern  = "/#default:\"(\w+)\".*#custom:\"(\w+)\"/";
       $outputRoute = $currentRoute;
       $routes = [];

       foreach($file as $line){

           preg_match($pattern,$line,$match);

          if(count($match)>0) {

              $default = $match[1];
              $customRoute = $match[2];


              if ($currentRoute == $customRoute) {

                  var_dump($default);

                  $outputRoute = $default;
              } elseif ($currentRoute == $default) {

                  throw new \ErrorException('This route not exist!');
              }
          }
       }
       return $outputRoute;
   }
}