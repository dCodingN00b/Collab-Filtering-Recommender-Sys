<!DOCTYPE html>
<html>
<head>
	<title>File Upload Form</title>
	<style>

		form {
			background-color: #fff;
			padding: 20px;
			border: 1px solid black;
			/*box-shadow: 2px 2px 3px 0px rgba(0,0,0,0.2);*/
			max-width: 500px;
			margin: 0 auto;
			text-align: center;
		}
		h2 {
			margin-top: 0;
			color: #333;
		}
		::file-selector-button {
		  display: none;
		  
		}
		input[type=file] {
			
		}
		
		label {
			display: inline-block;
			text-decoration: underline;
			color: blue;
		}
		
		label:hover {
			cursor: pointer;
		}
		.filename {
			font-size: 14px;
			color: #777;
			border: 1px dashed #272727;
			padding: 15px;
		}
		.submit-btn {
			margin-top: 20px;
			background-color: #5cb85c;
			color: #fff;
			border: none;
			padding: 10px 20px;
			border-radius: 5px;
			cursor: pointer;
			font-size: 16px;
			transition: background-color 0.3s ease;
		}
		.submit-btn:hover {
			background-color: #4cae4c;
		}
		.dropzone {
			border: 1px dashed #272727;
			padding: 30px;
			text-align: center;
			cursor: pointer;
		}
		.dropzone:hover {
			background-color: #f4f4f4;
		}
		
		.dropzone.dragover {
			background-color: silver;
			
		}
	</style>
</head>
<body>
	<form method="post" action = "uploadlist.php" enctype="multipart/form-data">

			
		<div class="dropzone" id="dropzone">
		<img src = 'images/file3.svg' alt = '' style ='width: 70px; opacity: 0.5'>
		<br/><br/>Drop file here or <label for="file-upload">Choose File</label>
		<p style = "transform:translate(0%, 35%); color: #272727; font-size: 12px;">TXT only</p></div>
		<div style = "transform:translate(23%, 50%); margin-bottom: 10px;">
		</div>
		<div class="filename"><input type="file" name="file-upload" id="file-upload" style ='transform:translate(-15%, 0%);' onchange="validateFile(this);" required></div>
		<input type="submit" name="submit" value="Upload" class="submit-btn">
	</form>

	<script>
	
		var dropzone = document.getElementById('dropzone');
		/*		dropzone.addEventListener('dragenter', function() {
			this.classList.add('dragover');
			this.textContent = 'Drop file';
		});*/
		


		dropzone.ondragover = function() {
			this.className = 'dropzone dragover';
			return false;
		}
		dropzone.ondragleave = function() {
			this.className = 'dropzone';
			return false;
		}
		dropzone.ondrop = function(e) {
			e.preventDefault();
			this.className = 'dropzone';
			document.getElementById('file-upload').files = e.dataTransfer.files;
			
		}
	

	</script>

	

</body>