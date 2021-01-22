FROM ubuntu:18.04 AS appd-downloader

ARG APPD_USER
ARG APPD_PASS
ARG AGENT_PATH
ARG AGENT_VERSION

RUN apt-get update -y && \
    apt-get install -y bash curl bzip2 tar

# download agent
ADD ./agent-download.sh .

RUN echo "sh ./agent-download.sh ${AGENT_VERSION} ${APPD_USER} ${APPD_PASS} ${AGENT_PATH}"

RUN mkdir -p ${AGENT_PATH}

RUN sh ./agent-download.sh \ 
    ${AGENT_VERSION}\
    ${APPD_USER}\
    ${APPD_PASS}\
    ${AGENT_PATH}

FROM php:7.4-fpm as php-fpm-appd

# RUN apt-get update -y && \ 
#     apt-get install -y curl procps less

ARG APPD_USER
ARG APPD_PASS
ARG AGENT_PATH
ARG AGENT_VERSION

ARG APPDYNAMICS_AGENT_ACCOUNT_NAME
ARG APPDYNAMICS_AGENT_ACCOUNT_ACCESS_KEY
ARG APPDYNAMICS_CONTROLLER_HOST_NAME
ARG APPDYNAMICS_CONTROLLER_PORT
ARG APPDYNAMICS_CONTROLLER_SSL_ENABLED
ARG APPDYNAMICS_AGENT_APPLICATION_NAME
ARG APPDYNAMICS_AGENT_TIER_NAME
ARG APPDYNAMICS_AGENT_NODE_NAME

ARG APPDYNAMICS_HTTP_PROXY_HOST
ARG APPDYNAMICS_HTTP_PROXY_PORT
ARG APPDYNAMICS_HTTP_PROXY_USER
ARG APPDYNAMICS_HTTP_PROXY_PASSWORD_FILE
ARG APPDYNAMICS_AGENT_LOG_DIR

ENV PHP_AGENT_DIR=${AGENT_PATH}
ENV PHP_AGENT_VERSION=${AGENT_VERSION}

# PHP Agent installation (https://docs.appdynamics.com/display/PRO45/Install+the+PHP+Agent+by+Shell+Script)
RUN mkdir -p ${PHP_AGENT_DIR}
COPY --from=0 ${AGENT_PATH}/ ${PHP_AGENT_DIR}/

WORKDIR ${PHP_AGENT_DIR}

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

ADD ./agent-install.sh /agent-install.sh

# Install & instrument AppDynamics PHP Agent
RUN sh /agent-install.sh

# copy logger config file (trace logs enabled)
# COPY ./appdynamics_agent_log4cxx.xml ${PHP_AGENT_DIR}/appdynamics-php-agent-linux_x64/php/conf/appdynamics_agent_log4cxx.xml

CMD ["php-fpm"]