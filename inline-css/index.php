<?php

use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

require_once __DIR__ . "/vendor/autoload.php";

header("Content-Type: text/html; charset=utf-8");

function encodeSpanishCharacters($htmlString) {
	return str_replace(['&lt;', '&gt;'], ['<', '>'], htmlentities($htmlString, ENT_NOQUOTES, "UTF-8"));
	$spanishCharacters = array(
		'á' => '&aacute;',
		'é' => '&eacute;',
		'í' => '&iacute;',
		'ó' => '&oacute;',
		'ú' => '&uacute;',
		'ñ' => '&ntilde;',
		'Á' => '&Aacute;',
		'É' => '&Eacute;',
		'Í' => '&Iacute;',
		'Ó' => '&Oacute;',
		'Ú' => '&Uacute;',
		'Ñ' => '&Ntilde;'
	);
	return preg_replace_callback('#([áéíóúñÁÉÍÓÚÑ])#', function ($m) use ($spanishCharacters) {
		return $spanishCharacters[$m[0]] ?? "XXX";
	}, $htmlString);
}

if (isset($_FILES["html"]) && isset($_FILES["css"])) {
	$html = file_get_contents($_FILES["html"]["tmp_name"]);
	$css = file_get_contents($_FILES["css"]["tmp_name"]);

	$cssToInlineStyles = new CssToInlineStyles();
	$result = $cssToInlineStyles->convert($html, $css);
	$result = encodeSpanishCharacters($result);
} else {
	$result = false;
}

?>
<!doctype html>
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

	<?php if ($result) : ?>
		<section>
			<h1>Resultado</h1>
			<p>
				<a download href="data:text/html;base64,<?php echo base64_encode($result) ?>">Descargar</a>
			</p>
		</section>
	<?php endif ?>
</body>

</html>