FROM locthp/php-web:v1.0.0
COPY ./ ./
EXPOSE 80
CMD ["/usr/sbin/apache2ctl", "-DFOREGROUND"]