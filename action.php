<?php
   // Include config.php file
   include_once('class/database.php');
   include_once('class/validation.php');

   $data = new Database();

   // Insert Record   
   if (isset($_GET['action']) && $_GET['action'] == "create")
   {
      $validation = new Validation;
      $validation->validate('name', 'Name', 'required|name');
      $validation->validate('email', 'Email', 'required|email');
      $validation->validate('mobile_number', 'Mobile Number', 'required|mobile');
      $validation->validate('bday', 'Date of Birth', 'required|date');
      $validation->validate('age', 'Age', 'required|number');
      $validation->validate('gender', 'Gender', 'required');

      if(!$validation->run()) {
         $return = [
            'code' => 0,
            'error' => $validation->errors
         ];

         echo json_encode($return);
      } else {
         $_POST['bday'] = date("Y-m-d", strtotime($_POST['bday'])); // change bday format
         echo json_encode($data->create($_POST));
      }
   }

?>