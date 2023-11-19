<?php 

namespace Classes {
   
   class Helper {

      public static function isOverEighteen( string $birthDate ) : bool {
         $eighteenYearsAgo = strtotime('-18 years');
         $userBirthDate = strtotime($birthDate);
         return $userBirthDate <= $eighteenYearsAgo;
      }

      public static function formatSpanishShortDate(string $date) : string {
         return date('d/M/Y', strtotime($date));
      }
   }
}