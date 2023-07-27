<?php require_once("config.php");?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="style.css">
	<title>Uplaod image and download in PHP and MYSQL database </title>
</head>
<body>
	<?php
		if(isset($_POST['form_submit']))
		{	
			$title=$_POST['title'];
			$folder = "uploads/";
			$image_file=$_FILES['image']['name'];
			$file = $_FILES['image']['tmp_name'];
			$path = $folder . $image_file;  
			$target_file=$folder.basename($image_file);
			$imageFileType=pathinfo($target_file,PATHINFO_EXTENSION);
//Allow only JPG, JPEG, PNG & GIF etc formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
 $error[] = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed';   
}
//Set image upload size 
    if ($_FILES["image"]["size"] > 500000) {
   $error[] = 'Sorry, your image is too large. Upload less than 500 KB in size.';
}
if(!isset($error))
{
move_uploaded_file($file,$target_file); 
$result=mysqli_query($db,"INSERT INTO items(image,title) VALUES('$image_file','$title')"); 
if($result)
{
	$image_success=1;  
}
else 
{
	echo 'Something went wrong'; 
}
}
		}


if(isset($error)){ 

foreach ($error as $error) { 
	echo '<div class="message">'.$error.'</div><br>'; 	
}

}
	?> 
	<div class="container">
	<?php if(isset($image_success))
		{
		echo '<div class="success">Image Uploaded successfully</div>'; 
		} ?>
<form action="" method="POST" enctype="multipart/form-data">
	<label>Image </label>
	<input type="file" name="image" class="form-control" required >
	<label>Title</label>
	<input type="text" name="title" class="form-control">
	<br><br>
	<button name="form_submit" class="btn-primary"> Upload</button>
</form>
</div>
<div class="container_display">
	<table cellpadding="10">
		<tr>
			<th> Image</th>
			<th>Title</th>
		</tr>
		<?php $res=mysqli_query($db,"SELECT* from items ORDER by id DESC");
			while($row=mysqli_fetch_array($res)) 
			{
				echo '<tr> 
                  <td><img src="uploads/'.$row['image'].'" height="200"></td> 
                  <td>'.$row['title'].'</td> 
                  <td><a href="download.php?id='.$row['id'].'"><button class="btn-primary download_btn">Download</button></a>
               
                  </td> 


				</tr>';

} ?>
		
	</table>
	</div>

</body>
</html>