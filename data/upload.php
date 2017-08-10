<?php
  header("Content-Type:application/json;charset=utf-8");

  $fileName = $_FILES['afile']['name'];
  $fileType = $_FILES['afile']['type'];
  $fileContent = file_get_contents($_FILES['afile']['tmp_name']);
  $dataUrl = 'data:' . $fileType . ';base64,' . base64_encode($fileContent);
  $fileSize = $_FILES['afile']['size'];
  $temp = explode(".", $_FILES["afile"]["name"]);
  $extension = end($temp);        // 获取文件后缀名
  $allowedExts = array("gif", "jpeg", "jpg", "png");// 允许上传的图片后缀


  $json = json_encode(array(
    'name' => $fileName,
    'type' => $fileType,
    'username' => $_REQUEST['username'],
    'accountnum' => $_REQUEST['accountnum'],
    'size' => $fileSize,
    'end' => $extension
  ));

 // echo $json;

 if ((($fileType == "image/gif")
 || ($fileType == "image/jpeg")
 || ($fileType == "image/jpg")
 || ($fileType == "image/pjpeg")
 || ($fileType == "image/x-png")
 || ($fileType == "image/png"))
 && ($fileSize < 204800)    // 小于 200 kb
 && in_array($extension, $allowedExts))
 {
    if (file_exists("../upload/" . $_FILES["afile"]["name"]))
      		{
      			echo '{"msg":"文件已存在"}';
      		}
      		else
      		{
      			// 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
      			move_uploaded_file($_FILES["afile"]["tmp_name"], "../upload/" . $_FILES["afile"]["name"]);
      			echo '{"msg":"储存完毕"}';
      		}

 }else
 {
    echo '{"code":-1,"msg":"非法文件格式"}';
 }
?>