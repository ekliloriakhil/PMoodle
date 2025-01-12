@echo off
cls
COLOR B0
:mode con:cols=65 lines=20
TITLE UNIFORM SERVER - Certificate details

rem ###################################################
rem # Name: view_cert_details.bat
rem # Created By: The Uniform Server Development Team
rem # Edited Last By: Mike Gleaves (ric)
rem # V 1.0 27-6-2011
rem ##################################################

rem ### working directory current folder 
pushd %~dp0
echo.

set OPENSSL_CONF=.\openssl.cnf

Rem --- Other display option
:openssl x509 -in server.crt -noout -text
:openssl x509 -in csr.txt -noout -text
:openssl req -in csr.txt -noout -text
:openssl rsa -in server.key -noout -text
:openssl version

openssl x509 -in ..\usr\local\apache2\server_certs\server.crt -noout -subject -issuer -startdate -enddate

set OPENSSL_CONF=

echo.
pause

rem ### restore original working directory
popd


