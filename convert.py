import json
with open("dictionary.txt", "r", encoding="utf-8") as f:
	xxx = f.read().replace("\n", ",")
	with open("dictionary.json", "w", encoding="utf-8") as z:
		z.write(xxx)