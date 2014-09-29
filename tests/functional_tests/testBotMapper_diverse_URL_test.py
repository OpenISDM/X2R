#-*- coding: utf-8 -*-
import requests
import json

'''
This test tests diverse URL forms that defined in test_fixture/mapping/test.mapping. 
The corresponding rdf File is located in test_fixture/data/sample.rdf

Note: the url should be set according to your X2R's server setting. 

'''

url = 'http://localhost/x2r_php/em/mapper.php'

rc = open('../test_fixture/data/sample.rdf', 'rb').read()

mapping = open('../test_fixture/mapping/test.mapping', 'rb').read()

payload = {'format': 'rdfxml', 'mapping': mapping, 'rdfContent': rc}


r = requests.post(url, data=payload)
result = r.text
print 'the result: \n\n'
print result