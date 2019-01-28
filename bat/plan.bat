@echo off  

start 'C:\Program Files\Internet Explorer\iexplore.exe' 'http://jwzs.ythx123.com/plan'
ping -n 10 127.1>nul
taskkill /im iexplore.exe /f