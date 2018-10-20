import json
with open("dictionary.txt", "r", encoding="utf-8") as f:
	xxx = f.read().replace("\n", ",")
	xxx = "["+xxx[:-1]+"]"
	with open("dictionary.json", "w", encoding="utf-8") as z:
		z.write(xxx)