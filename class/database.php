<?php
   
   class Database 
   {
      private $servername = "localhost";
      private $username   = "root";
      private $password   = "root";
      private $dbname = "exam";
      public $db;
      public $table = "profile";

      public function __construct()
      {
         try {
            $this->db = new mysqli($this->servername, $this->username, $this->password, $this->dbname);   
         } catch (Exception $e) {
            echo $e->getMessage();
         }
      }

      // Insert book data into book table
      public function create($data)  
      {  
         foreach ($data as $key=>$value)
         {
            if(is_array($value)) {
               foreach ($value as $k => $v)
                  $data[$key][$k] = mysqli_real_escape_string($this->db, $v); 
            } else
               $data[$key] = mysqli_real_escape_string($this->db, $value); 
         }
         
         $sql = "INSERT INTO `".$this->table."` (";            
         $sql .= implode(",", array_keys($data)) . ') VALUES (';            
         $sql .= "'" . implode("','", array_values($data)) . "')";
         
         if($this->db->query($sql))  
            return true;  
         else  
            return false; 
      }
   }

?>