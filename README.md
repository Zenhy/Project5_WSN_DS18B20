# Project5_WSN_DS18B20
A wireless DS18B20 sensor network, include data post to Database, Web server that display temperature graph, tables, and real time monitoring (Via Asynchronous web server)
The php files belong to the var/www/html directory:
Index = main page with hyperlinks 
Chart = display sensors value in graph (web server)
Tables = display sensors value in tables (web server)
Node = display sensors real time monitoring (linked to an asynchronous web ip)
There are two c codes: 
Sender board code = The reading plus sending sensor value to reciever board
Reciever board code = Recieve senders board data and post it to web server
