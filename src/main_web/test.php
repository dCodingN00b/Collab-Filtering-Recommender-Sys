<!DOCTYPE html>
<!-- Created By CodingNepal - www.codingnepalweb.com -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drag & Drop or Browse: File Upload | CodingNepal</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
	<style>
#drop-area {
  border: 2px dashed #bbb;
  width: 300px;
  height: 200px;
  margin: 20px auto;
  text-align: center;
  padding-top: 80px;
  font-size: 20px;
}

.drop-text {
  color: #bbb;
  cursor: pointer;
}

.highlight {
  background-color: #f1f1f1;
}

	</style>
	
<script>
var dropArea = document.getElementById('drop-area');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
  dropArea.addEventListener(eventName, preventDefaults, false);
  document.body.addEventListener(eventName, preventDefaults, false);
});

['dragenter', 'dragover'].forEach(eventName => {
  dropArea.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
  dropArea.addEventListener(eventName, unhighlight, false);
});

dropArea.addEventListener('drop', handleDrop, false);

function preventDefaults(e) {
  e.preventDefault();
  e.stopPropagation();
}

function highlight(e) {
  dropArea.classList.add('highlight');
}

function unhighlight(e) {
  dropArea.classList.remove('highlight');
}

function handleDrop(e) {
  var dt = e.dataTransfer;
  var files = dt.files;

  handleFiles(files);
}

function handleFiles(files) {
  files = [...files];
  files.forEach(uploadFile);
}

function uploadFile(file) {
  var url = 'upload.php';
  var xhr = new XMLHttpRequest();
  var formData = new FormData();

  xhr.open('POST', url, true);
  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

  xhr.addEventListener('readystatechange', function(e) {
    if (xhr.readyState == 4 && xhr.status == 200) {
      console.log(xhr.responseText);
    } else if (xhr.readyState == 4 && xhr.status != 200) {
      console.log(xhr.responseText);
    }
  });

  formData.append('file', file);

  xhr.send(formData);
}


</script>
</head>
<body>
  <div id="drop-area">
  <div class="drop-text">Drag and drop file here</div>
</div>
<?php
if (isset($_FILES['file'])) {
  $file = $_FILES['file'];
  $fileName = $file['name'];
  $fileTmpName = $file['tmp_name'];
  $fileSize = $file['size'];
  $fileError = $file['error'];
  $fileType = $file['type'];

  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowed = array('jpg', 'jpeg', 'png', 'pdf');

  if (in_array($fileActualExt, $allowed)) {
    if ($fileError === 0) {
      $fileNameNew = uniqid('', true) . "." . $fileActualExt;
      $fileDestination = 'uploads/' . $fileNameNew;
      move_uploaded_file($fileTmpName, $fileDestination);
      echo "File uploaded successfully";
    } else {
      echo "Error uploading file";
    }
  } else {
    echo "Invalid file type";
  }
}
?>

</body>
</html>