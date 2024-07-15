#First stage
FROM ubuntu:latest as first

#Create content
RUN mkdir /web/
COPY index.php /web/index.php

#Second stage
FROM php:8.2-apache

#Copy content
COPY --from=first /web/index.html /var/www/html/

EXPOSE 80

USER www-data 
