FROM tunet/php:8.0.6-fpm

RUN apk update \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        zlib-dev \
        libzip-dev \
        freetype-dev \
        libjpeg-turbo-dev \
        libpng-dev \
    && apk --no-cache add \
        git \
        zsh \
		zlib \
		freetype \
        libjpeg-turbo \
        libpng \
        libzip-dev \
        postgresql-client \
    && pecl install xdebug-3.0.4 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-enable gd \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && apk del .build-deps

#RUN apk --no-cache add wkhtmltopdf
COPY --from=madnight/alpine-wkhtmltopdf-builder:0.12.5-alpine3.10 /bin/wkhtmltopdf /bin/wkhtmltopdf

RUN apk add --no-cache \
        libgcc \
        libstdc++ \
        libx11 \
        glib \
        libxrender \
        libxext \
        libintl \
        ttf-dejavu \
        ttf-droid \
        ttf-freefont \
        ttf-liberation \
        ttf-ubuntu-font-family \
        libreoffice-common \
        xvfb \
        xvfb-run \
        openjdk8-jre

RUN set -xe \
    && apk add --no-cache --purge -uU \
        libreoffice \
        curl icu-libs unzip zlib-dev musl \
        mesa-gl mesa-dri-swrast \
        libreoffice libreoffice-base libreoffice-lang-uk \
        ttf-freefont ttf-opensans ttf-ubuntu-font-family ttf-inconsolata \
        ttf-liberation ttf-dejavu \
        libstdc++ dbus-x11 \
    && echo "http://dl-cdn.alpinelinux.org/alpine/edge/main" >> /etc/apk/repositories \
    && echo "http://dl-cdn.alpinelinux.org/alpine/edge/community" >> /etc/apk/repositories \
    && echo "http://dl-cdn.alpinelinux.org/alpine/edge/testing" >> /etc/apk/repositories \
    && apk add --no-cache -U \
        ttf-font-awesome ttf-mononoki ttf-hack \
    && rm -rf /var/cache/apk/* /tmp/*



ARG LINUX_USER_ID

RUN addgroup --gid $LINUX_USER_ID docker \
    && adduser --uid $LINUX_USER_ID --ingroup docker --home /home/docker --shell /bin/zsh --disabled-password --gecos "" docker

USER $LINUX_USER_ID

RUN wget https://github.com/robbyrussell/oh-my-zsh/raw/master/tools/install.sh -O - | zsh || true
RUN echo 'export ZSH=/home/docker/.oh-my-zsh' > ~/.zshrc \
    && echo 'ZSH_THEME="simple"' >> ~/.zshrc \
    && echo 'plugins=(npm)' >> ~/.zshrc \
    && echo 'source $ZSH/oh-my-zsh.sh' >> ~/.zshrc \
    && echo 'PROMPT="%{$fg_bold[yellow]%}php_cli@docker_monitor %{$fg_bold[blue]%}%(!.%1~.%~)%{$reset_color%} "' > ~/.oh-my-zsh/themes/simple.zsh-theme

WORKDIR /srv/app
