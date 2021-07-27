FROM ubuntu:18.04
#set timezone to NZ
ENV TZ=Pacific/Auckland

#set debian install interface to none
ENV DEBIAN_FRONTEND=noninteractive

#set laravel project dir
ARG PROJECT_HOME

# run bash script to install dependency software
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
    && apt-get update \
    && apt-get install -y sudo nginx git vim zip unzip php-fpm php-cli php-curl php-xml php-mysql php-redis php-mbstring php-gd \
     php-zip php-pear php-dev php-xdebug supervisor\
    && apt-get remove -y nano \
    && apt-get autoremove -y \
    && pecl channel-update pecl.php.net \
    && sed -i 's/memory_limit = 128M/memory_limit = 1024M/g' /etc/php/7.2/fpm/php.ini \
    && sed -i 's/max_execution_time = 30/max_execution_time = 1200/g' /etc/php/7.2/fpm/php.ini \
    && sed -i 's/post_max_size = 8M/post_max_size = 1024M/g' /etc/php/7.2/fpm/php.ini \
    && sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 512M/g' /etc/php/7.2/fpm/php.ini \
    && sed -i 's/session.cache_limiter = nocache/session.cache_limiter = public/g' /etc/php/7.2/fpm/php.ini \
    && service php7.2-fpm restart\
    && sed -i 's/max_execution_time = 30/max_execution_time = 0/g' /etc/php/7.2/cli/php.ini \
    && sed -i 's/post_max_size = 8M/post_max_size = 512M/g' /etc/php/7.2/cli/php.ini \
    && sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 512M/g' /etc/php/7.2/cli/php.ini \
    && cd /tmp \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/bin/composer \
    && apt-get clean \
    && echo "PS1='\${debian_chroot:+(\$debian_chroot)}\[\033[01;32m\]\u\[\e[0m\]@\[\e[1;35m\]\h\[\e[0m\]:\W\$ '" >> /root/.bashrc \
    && echo "alias cdp='cd $PROJECT_HOME/'" >> /root/.bashrc \
    && echo "server {\n\
    listen 80 default_server;\n\
    root $PROJECT_HOME/public;\n\
    index index.php;\n\
    client_max_body_size 100m;\n\
    server_name _;\n\
    location / {\n\
        try_files \$uri \$uri/ /index.php?\$query_string;\n\
    }\n\
    location ~ \.php$ {\n\
        include snippets/fastcgi-php.conf;\n\
        fastcgi_pass unix:/run/php/php7.2-fpm.sock;\n\
        fastcgi_connect_timeout 1200;\n\
        fastcgi_read_timeout 1200;\n\
        fastcgi_send_timeout 1200;\n\
    }\n\
}" > /etc/nginx/sites-available/default \
    &&  echo "[program:laravel-worker]\n\
process_name=%(program_name)s_%(process_num)02d\n\
command=php $PROJECT_HOME/artisan queue:work --sleep=3 --tries=3\n\
autorestart=true\nuser=www-data\n\
numprocs=1\n\
redirect_stderr=true\n\
stdout_logfile=$PROJECT_HOME/storage/logs/queue-worker.log" \
     > /etc/supervisor/conf.d/laravel-worker.conf \
    && echo "#!/bin/bash\nservice php7.2-fpm start\n\
service supervisor start\nservice nginx start\ntail -f /var/log/nginx/error.log" > /root/start.sh \
    && chmod +x /root/start.sh
ENTRYPOINT ["/root/start.sh"]
