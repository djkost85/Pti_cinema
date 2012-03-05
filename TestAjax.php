<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Techniques AJAX - XMLHttpRequest</title>
<script type="text/javascript" src="../Pti_Cinema/script/oXHR.js"></script>
<script type="text/javascript">
<!-- 
function request(callback) {
	var xhr = getXMLHttpRequest();
	
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			callback(xhr.responseText);
		}
	};

	var nick = encodeURIComponent(document.getElementById("nick").value);
	var name = encodeURIComponent(document.getElementById("name").value);
	
	xhr.open("GET", "testAjax.php?Nick=" + nick + "&Name=" + name, true);
	xhr.send(null);
}

function readData(sData) {
	alert(sData);
}
//-->
</script>
</head>
<body>
<?php 


$nick = (isset($_GET["Nick"])) ? $_GET["Nick"] : NULL;
$name = (isset($_GET["Name"])) ? $_GET["Name"] : NULL;

if ($nick && $name) {
	echo "Bonjour " . $name . " ! Je vois que votre pseudo est " . $nick;
} else {
	echo "FAIL";
}

?>

<form>
	<p>
		<label for="nick">Pseudo :</label>
		<input type="text" id="nick" /><br />
		<label for="name">Prénom :</label>
		<input type="text" id="name" />
	</p>
	<p>
		<input type="button" onclick="request(readData);" value="Exécuter" />
	</p>
</form>
</body>
</html>