<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style type=css/stylesheet>
  .color
  {
    background-color:'red';
  }
    </style> 
</head>
<body  style="background-image: url('images/Jellyfish.jpg'); background-repeat: no-repeat;background-attachment: fixed;
  background-size: cover; background-size: 100% 100%;">
<div class="modal" tabindex="-1" role="dialog" id='modal_frm'>
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">add details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id='frm' enctype="multipart/form-data">
            <input type='hidden' name='action' id='action' value='Insert'>
            <input type='hidden' name='id' id='uid' value='0'>
            <div class='form-group'>
            <label>Name</label>
            <input type='text' name='name' id='name' required class='form-control'>
            </div>     
            <div class='form-group'>
            <label>Gender</label>
                <select name='gender' id='gender'  required class='form-control'>
                    <option value=''>select</option>
                    <option value='Male'>Male</option>
                    <option value='Female'>Female</option>
                    <option value='Others'>Others</option>
                </select>
            </div>
            <div class='form-group'>
            <label>Email</label>
            <input type='email' name='email' id='email' required class='form-control'>
            </div>     
            <div class='form-group'>
            <label>image</label>
            <input type='file' type='text' name='image' id='image' required class='form-control'>
            
            </div>     
            
            <input type='submit' value='submit' class='btn btn-success'>
        </form>
        
      </div>
      
    </div>
  </div>
</div>
<div class="container mt-5" style="background:#fff" >
        <p class='text-right'><a herf='#' class='btn btn-success' id='add_record'>add record </a></p>
<table class='table table-bordered'>
<thead>
    <th class='color'>Uid</th>  
    <th class='color'>name</th>
    <th style="color:violet">gender</th>
    <th style="color:violet">email</th>
    <th style="color:violet">image</th>
    <th style="color:violet">edit</th>
    <th style="color:violet">delete</th>
    <th style="color:violet">preview</th>
    
</thead>
<tbody id='tbody'>
<?php

    $con=mysqli_connect("localhost","root","","ajax_crud");
    $sql="select * from users";
    $res=$con->query($sql);
    while($row=$res->fetch_assoc()){
        echo " <tr uid='{$row["ID"]}'>     
        <td >{$row["ID"]}</td>
        <td >{$row["NAME"]}</td>
        <td>{$row["GENDER"]}</td>
        <td>{$row["EMAIL"]}</td>
        <td><img src='image1/{$row["image"]}' width='100' height='100'>
                </td>
           
            <td><a href='#' class='btn btn-primary edit'>Edit</a></td>        
                <td><a href='#' class='btn btn-danger delete'>Delete</a></td>
                <td><a href='preview.php?id={$row["ID"]}' class='btn btn-success'>Preview</a></td>               
                </tr>";
    }
?>
</tbody>
</table>

</div>
<script>
    $(document).ready(function(){
        var current_row=null;
        $("#add_record").click(function(){
          clear_input();
              $("#modal_frm").modal('hide');
         
          $("#modal_frm").modal();
          
        });
        
        $("#frm").submit(function(event){
          event.preventDefault();
          
          var formData = new FormData($('#frm')[0]);
          formData.append('submit', 'Insert');
          $.ajax({
            url:"ajax_action.php",
            type:"post",
            data:formData,
            contentType: false,
            processData: false,
            beforeSend:function(){
              $("#formData").find("input[type='submit']").val('Loading...');
            },
            success:function(res){
              if(res){
                if($("#uid").val()=="0"){
                  
                  $("#tbody").append(res);
                }else{
                  $(current_row).html(res);
           
                }
              }else{
                alert("Failed Try Again");
              }
              $("#frm").find("input[type='submit']").val('Submit');
              clear_input();
              $("#modal_frm").modal('hide');
            }
          });
        });
        $("body").on("click",".edit",function(event)
        {
        
          event.preventDefault();
          current_row=$(this).closest("tr");
       
          $("#modal_frm").modal();
          var id=$(this).closest("tr").attr("uid");
          var name=$(this).closest("tr").find("td:eq(1)").text();
          var gender=$(this).closest("tr").find("td:eq(2)").text();
          var email=$(this).closest("tr").find("td:eq(3)").text();
          $('#image').removeAttr('required')
          $("#action").val("Update");
          $("#uid").val(id);
          $("#name").val(name);
          $("#gender").val(gender);
          $("#email").val(email);
           })
         
        $("body").on("click",".delete",function(event){
            event.preventDefault();
            var id=$(this).closest("tr").attr("uid");
            var cls=$(this);
            if(confirm("are you sure"))
            {
            $.ajax({
            url:"ajax_action.php",
            type:"post",
            data:{uid:id,action:'delete'},
            beforeSend:function(){
              $(cls).text("loading....");
            },
            success:function(res){
              if(res){
                $(cls).closest("tr").remove();
              }else{
                alert("fail try again");
                $(cls).text("try again"); 
              }
            }
          });
        }

        });

        function clear_input(){
          $("#frm").find(".form-control").val("");
          $("#action").val("Insert");
          $("#uid").val("0");
        }
      });   
        
</script>

</body>
</html>