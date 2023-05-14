<?php

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

require_once __DIR__ . "/vendor/autoload.php";

if (isset($_FILES["html"]) && isset($_FILES["css"])) {
	$html = file_get_contents($_FILES["html"]["tmp_name"]);
	$css = file_get_contents($_FILES["css"]["tmp_name"]);

	$cssToInlineStyles = new CssToInlineStyles();
	$result = $cssToInlineStyles->convert($html, $css);
} else {
	$result = false;
}

?><!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<title>Inline CSS</title>
</head>

<body>
	<form method="post" enctype="multipart/form-data">
		<h1>Convertir</h1>
		<div class="field">
			<label>HTML</label>
			<input type="file" name="html" required accept="text/html">
		</div>
		<div class="field">
			<label>CSS</label>
			<input type="file" name="css" required accept="text/css">
		</div>
		<footer>
			<button>Convertir</button>
		</footer>
	</form>

	<?php if ($result): ?>
	<section>
		<h1>Resultado</h1>
		<textarea rows="20">
			<?php echo $result ?>
		</textarea>
	</section>
	<?php endif ?>
</body>

</html>