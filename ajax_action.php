<?php

require 'PHPMailer/PHPMailerAutoload.php';
require 'PHPMailer/class.smtp.php';

    $con=mysqli_connect("localhost","root","","ajax_crud");
    
    $action=$_POST["action"];
    if($action=="Insert"){    	
    	   
        $name=mysqli_real_escape_string($con,$_POST["name"]);
        $gender=mysqli_real_escape_string($con,$_POST["gender"]);
        $email=mysqli_real_escape_string($con,$_POST["email"]);
		$temp_user_name = $_FILES['image']['tmp_name'];       
        $targetDir = "image1/";
        $fileName = basename($_FILES["image"]["name"]);  
        $random = rand();
        $name_new=$random.$fileName;
        $targetFilePath = $targetDir . $name_new;
        move_uploaded_file($temp_user_name, $targetFilePath);		
        
          $imagepath = $name_new;
          $save = "image1/" . $imagepath; //This is the new file you saving
          $file = "image1/" . $imagepath; //This is the original file

          list($width, $height) = getimagesize($file); 

          $tn = imagecreatetruecolor($width, $height);

          $image = imagecreatefromjpeg($file);
          $info = getimagesize($targetFilePath);
          imagecopyresampled($tn, $image, 0, 0, 0, 0, $width, $height, $width, $height);
          imagejpeg($tn, $save, 40);
            $sql="insert into users(NAME,GENDER,EMAIL,image) values ('{$name}','{$gender}','{$email}','{$name_new}')";
            $email=$_POST['email'];
            $gender=$_POST['gender'];
            $name=$_POST['name'];
            $html= "<tr>
        
                name:{$name}<br><br>
                gender:{$gender}<br><br>
                email:{$email}<br><br>
            </tr>";
            $user_image = $_FILES['image']['name'];
			$temp_user_name = $_FILES['image']['tmp_name'];
			
			$targetDir = "image1/";
			$fileName = $_FILES["image"]["name"];
			$targetFilePath = $targetDir . $name_new;
			
			move_uploaded_file($temp_user_name, $targetFilePath);	
			
        $mail = new PHPMailer(true);
        try{
        
            // $mail->SMTPDebug = 1;
            $mail->isSMTP();                                           
            $mail->Host       = 'smtp.gmail.com';                     
            $mail->SMTPAuth   = true;                                   
            $mail->Username = 'kavin0856@gmail.com';
            $mail->Password = 'qsjr aacz blvy dazn';   
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
        
        $mail->setFrom('kavin0856@gmail.com','kavin');
        
        $mail->addAddress($email);
        // $image=$fileName;
        $mail->addAttachment($targetFilePath);
        $mail->isHTML(true);
        $mail->Body =$html;
        
        $mail->Subject = "this is your detail";
        
        
        $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
         if($con->query($sql))
        {
            $id=$con->insert_id;
            echo "<tr uid='{$id}'>
            <td>{$id}</td>
            
            <td >{$name}</td>
            <td>{$gender}</td>
            <td>{$email}</td>
            <td><img src='image1/{$name_new}' width='100' height='100'></td> 
            
            <td><a href='#' class='btn btn-primary edit'>Edit</a></td>        
            <td><a href='#' class='btn btn-danger delete'>Delete</a></td>
            <td><a href='preview.php?id={$id}' class='btn btn-success'>Preview</a></td>               
            </tr>";
            echo "<script>alert('inserted success')</script>"; 
       
        }
          else
        {
            echo "false";
        }
    }else if($action =="Update"){
        $id=mysqli_real_escape_string($con,$_POST["id"]);
        $name=mysqli_real_escape_string($con,$_POST["name"]);
        $gender=mysqli_real_escape_string($con,$_POST["gender"]);
        $email=mysqli_real_escape_string($con,$_POST["email"]);
        $user_image = $_FILES['image']['name'];
		$temp_user_name = $_FILES['image']['tmp_name'];
			if(empty($user_image))
            {

                $sql="update users SET NAME='{$name}',GENDER='{$gender}',EMAIL='{$email}'where ID='{$id}'";
                $sql1="select image from users where ID='$id'";
                $result = mysqli_query($con,$sql1);
                 $row = mysqli_fetch_assoc($result);  
                 $fileName=$row['image'];
                  
            }
            else{
            $targetDir = "image1/";
			$fileName = basename(rand().$_FILES["image"]["name"]);
            $targetFilePath = $targetDir . $fileName;
			
			move_uploaded_file($temp_user_name, $targetFilePath);	
            

                $sql="update users SET NAME='{$name}',GENDER='{$gender}',EMAIL='{$email}',image='{$fileName}'where ID='{$id}'";
                
            }
            
            
        if($con->query($sql)){
          echo "
            <td>{$id}</td>
            <td>{$name}</td>
            <td>{$gender}</td>
            <td>{$email}</td>
            <td><img src='image1/{$fileName}' width='100' height='100'></td> 
            <td><a href='#' class='btn btn-primary edit'>Edit</a></td>
            <td><a href='#' class='btn btn-danger delete'>Delete</a></td>     
            <td><a href='preview.php?id={$id}' class='btn btn-success'>Preview</a></td>  ";             
  
        }else{
          echo false;
        }
      }else if($action=="delete"){
            $id=$_POST['uid'];
            $sql="delete from users where ID='{$id}'";
            if($con->query($sql))
            {
                echo true;
            }else{
                echo false;
            }
      }
    
?>