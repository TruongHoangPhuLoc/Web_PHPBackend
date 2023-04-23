FROM ubuntu:20.04
RUN apt update && apt install tzdata -y
RUN apt-get update -y
RUN apt-get install apache2 -y
RUN apt install libapache2-mod-php php-mysql -y
COPY ./php.conf /etc/apache2/sites-available/
RUN a2enmod rewrite 
RUN a2dissite 000-default 
RUN a2ensite php.conf
RUN ln -sf /proc/self/fd/1 /var/log/apache2/access.log && \
    ln -sf /proc/self/fd/1 /var/log/apache2/error.log 
RUN mkdir /var/www/app/
WORKDIR /var/www/app
COPY ./ ./
RUN chown www-data:www-data -R /var/www/app/
EXPOSE 80
CMD ["/usr/sbin/apache2ctl", "-DFOREGROUND"]