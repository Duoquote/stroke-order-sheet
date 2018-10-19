<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="main.css">
	<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
</head>
<body>
	<div class="header">
		<h1 class="header">Stroke Order Exercise Sheet Generator</h1>
		<div class="generate-box">
			<input type="text" name="generate" id="generate-text" class="generate-text" autofocus>
			<input type="button" class="generate" onclick="var chars = document.getElementById('generate-text');serialize(chars.value)" value="Generate">
		</div>
		<h2 class="header">Beta v1.1</h2>
		<input type="range" min="1" max="100" value="50" class="box-width-range" id="box-width">
	</div>

	<div id="page">
		<div id="sheet"></div>
	</div>
	<script type="text/javascript">
		if (!localStorage["svg"]) {
			localStorage.setItem("svg", '<svg version="1.1" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg" class="hanzi-svg"><g stroke="#c1c1c1" stroke-dasharray="3" stroke-width="3" transform="scale(4, 4)"><line x1="0" y1="0" x2="256" y2="256"></line><line x1="256" y1="0" x2="0" y2="256"></line><line x1="128" y1="0" x2="128" y2="256"></line><line x1="0" y1="128" x2="256" y2="128"></line></g><g transform="scale(1, -1) translate(0, -900)"></g></svg>')
		}
		function saveDoc() {
			html2canvas(document.getElementById("page")).then(function(canvas) {
			    document.body.appendChild(canvas);
			});
		}

		function charId(hanzi) {
			return hanzi.charCodeAt(0);
		}
		function createBox(hanzi, ind) {
			var mainG = document.createElement("div");
			var strokes = [];
			mainG.className = "hanzi-box";
			mainG.id = hanzi+"-"+String(ind);
			mainG.innerHTML = localStorage["svg"];
			document.getElementById("sheet-"+hanzi).appendChild(mainG);
		}
		function fetchStrokes(hanzi) {
			const Http = new XMLHttpRequest();
			const url='./paths/'+hanzi+'.path';
			Http.open("GET", url);
			Http.responseType = 'json';
			Http.send();
			Http.onreadystatechange=(e)=>{
				if (Http.readyState == 4 && Http.status == 200) {
					strokeProcessor(hanzi, Http.response)
				}
			}
		}
		function strokeProcessor(hanzi, strokes) {
			var currentBox = "";
			for (var i = 0; i < strokes.length; i++) {
				createBox(hanzi, i);
				if (i < strokes.length) {
					for (var z = 0; z <= i; z++) {
						currentBox = currentBox+strokes[z];
					}
					document.getElementById(hanzi+"-"+i).firstChild.childNodes[1].innerHTML = currentBox;
				}
			}
			var first = document.createElement("div");
			var mainHanzi = document.getElementById(hanzi+"-0");
			first.className = "hanzi-box full-hanzi";
			first.id = hanzi+"-full";
			first.innerHTML = localStorage["svg"];
			first.firstChild.childNodes[1].innerHTML = currentBox;
			var last = first.cloneNode(true);
			last.className = "hanzi-box last-hanzi";
			mainHanzi.parentNode.insertBefore(first, mainHanzi);
			mainHanzi.parentNode.appendChild(last);
		}
		function serialize(inText) {
			console.log(inText.split(""))
			for (var i = 0; i < inText.split("").length; i++) {
				var hanzi = inText.split("")[i];
				var mainElem = document.createElement("div");
				mainElem.id = "sheet-"+charId(hanzi);
				mainElem.className = "boxes";
				document.getElementById("sheet").appendChild(mainElem);
				fetchStrokes(charId(hanzi));
			}
		}
	</script>
	<script type="text/javascript">
		var slider = document.getElementById("box-width")
		slider.oninput = function(){
			var hanziBox = document.getElementsByClassName("hanzi-svg");
			for (var i = 0; i < hanziBox.length; i++) {
				hanziBox[i].style.width = String((this.value/75)+1)+"cm";
			}
		}
	</script>
</body>
</html>
