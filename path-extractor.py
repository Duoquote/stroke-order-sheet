from css_html_js_minify import html_minify
import os
import time
import json
if not os.path.exists("./paths"):
	os.makedirs("./paths")
files = os.listdir("./svgs")
def convert(inName):
	with open("./svgs/"+inName, "r") as f:
		contents = f.read()
		contents = contents.split("<style type=\"text/css\">")
		l = contents[0]
		r = contents[1].split("</style>")[1]
		contents = (l+r).split("<clipPath")[0]+"</g></svg>"
		contents = contents.replace("lightgray", "black")
		contents = contents.split("<g transform=\"scale(1, -1) translate(0, -900)\">")[1].split("</g>")[0]
		contents = html_minify(contents)
		al = contents.split("<path")
		al = al[1:]
		contents = []
		for i in al:
			contents.append("<path"+i)
		contents = json.dumps(contents)
		with open("./paths/"+inName.split(".")[0]+".path", "w") as z:
			z.write(contents)
for i in files:
	try:
		i.split(".svg")
		convert(i)
	except Exception as e:
		print(e)
		pass