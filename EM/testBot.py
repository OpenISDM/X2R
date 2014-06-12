import requests

url = 'http://localhost/x2r_php/em/extractor.php'
rc = open('../../data/alf.rdf', 'rb').read()
en = 'k'
cus = 'False'
payload = {'excludedNameSpace': en, 'checkUrisStatus': cus, 'rdfContent': rc}
r = requests.post(url, data=payload)
print r.text
