<?php 


namespace Classes {

   class RegExp {

      /** YYYY-MM-DD */
      static $birthDate = '/^\d{4}-\d{2}-\d{2}$/';
      
      /** 10 Numbers */
      static $phoneNumber = '/^[0-9]{10}$/';

   }

}