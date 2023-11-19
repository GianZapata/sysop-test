<?php

namespace Model;

class User extends ActiveRecord { 
   
   protected static $table = 'users'; 
   protected static $primaryKey = 'id'; 
   protected static $dbColumns = [ 
      'id',
      'admin',
      'birthDate',
      'email',
      'name',
      'password',
      'phoneNumber'
   ]; 

   public $id; 

   public $name;

   public $email;

   public $password;

   public $admin;
   
   public $birthDate;

   public $phoneNumber;

   public function __construct( $args = [] ) { } 

   public function hashPassword() : void {
      $this->password = password_hash($this->password, PASSWORD_BCRYPT);
   }

   public function sanitizeEmail() : void {
      $this->email = filter_var(strtolower($this->email), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   }

   public function validateEmail( string $email ) : bool {
      return filter_var(strtolower( $email ), FILTER_VALIDATE_EMAIL, FILTER_FLAG_NO_ENCODE_QUOTES);
   }

}