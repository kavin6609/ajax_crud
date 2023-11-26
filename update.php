<?php


$con=mysqli_connect("localhost","root","","ajax_crud");
    
$action=$_POST["action"];
if($action =="Update"){
    $id=mysqli_real_escape_string($con,$_POST["id"]);
    $name=mysqli_real_escape_string($con,$_POST["name"]);
    $gender=mysqli_real_escape_string($con,$_POST["gender"]);
    $email=mysqli_real_escape_string($con,$_POST["email"]);
    $user_image = $_FILES['image']['name'];
    $temp_user_name = $_FILES['image']['tmp_name'];
        if(empty($user_image))
        {
            $sql="update users SET NAME='{$name}',GENDER='{$gender}',EMAIL='{$email}'where ID='{$id}'";
            $sql="select image from users where ID='$id'";
            $result = mysqli_query($con,$sql);
            $row = mysqli_fetch_assoc($result);  
            $fileName=$row['image'];
            
        }
        else{
        $targetDir = "image1/";
        $fileName = basename($_FILES["image"]["name"]);
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
}
    ?>