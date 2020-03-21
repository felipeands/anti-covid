<html>

<head>

	<title></title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, minimum-scale=1.0">

	<link rel="stylesheet" type="text/css" href="styles.css" />

</head>

<body>

	<form method="POST" action="" enctype="multipart/form-data">

		<div class="form-group">
			<label>
				<span>Sua foto</span>
				<input type="file" name="avatar" required="required" />
			</label>
		</div>

		<div class="buttons">
			<input type="submit" value="Gerar avatar" />
		</div>

	</form>


	<?php 

	if ($_FILES['avatar']) {

		$mask = new Imagick("./mask.png");
		$avatar = new Imagick($_FILES['avatar']['tmp_name']);

		$width = $avatar->getImageWidth();
		$height = $avatar->getImageHeight();

		// $avatar->resizeImage(640, 640, Imagick::FILTER_LANCZOS, 1);
		$avatar->setCompressionQuality(100);
		$avatar->cropThumbnailImage(640, 640);

		if ($width > $height) {
			$avatar->rotateimage(new ImagickPixel('#00000000'), 90);
		}

		$avatar->setImageVirtualPixelMethod(Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
		$avatar->setImageArtifact('compose:args', "1,0,-0.5,0.5");
		$avatar->compositeImage($mask, Imagick::COMPOSITE_DEFAULT, 0, 0);

		echo "
		<a href='data:image/jpg;base64,".base64_encode($avatar)."' download='avatar.jpg'>
		<img src='data:image/jpg;base64,".base64_encode($avatar)."' style='width: 400px; height: 400px;' />
		</a>
		";


		// loga
		$ipaddress = '';
		if (isset($_SERVER['HTTP_CLIENT_IP']))
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		else if(isset($_SERVER['REMOTE_ADDR']))
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		else
			$ipaddress = 'UNKNOWN';
		
		$data = date('Y-m-d H:i:s');

		$fp = fopen('./data.txt', 'at');
		fwrite($fp, "data: ${data}, ip: ${ipaddress}\n");
		fclose($fp);
	}

	?>

</body>

</html>