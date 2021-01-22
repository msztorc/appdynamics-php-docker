#### Appdynamics php-fpm docker example

Example php-agent instrumentation (nginx + php-fpm)

##### Requirements
- docker
- docker-compose

##### Configuration

Create .env file and add the following environment variables

```ini

;APPD_USER=
;APPD_PASS=
AGENT_PATH=/opt/appdynamics/php-agent
AGENT_VERSION=20.12.0.4303

APPDYNAMICS_AGENT_APPLICATION_NAME=app-name
APPDYNAMICS_AGENT_TIER_NAME=tier-name
APPDYNAMICS_AGENT_NODE_NAME=node-name

APPDYNAMICS_AGENT_ACCOUNT_NAME=
APPDYNAMICS_AGENT_ACCOUNT_ACCESS_KEY=
APPDYNAMICS_CONTROLLER_HOST_NAME=
APPDYNAMICS_CONTROLLER_PORT=
APPDYNAMICS_CONTROLLER_SSL_ENABLED=false

APPDYNAMICS_HTTP_PROXY_HOST=
APPDYNAMICS_HTTP_PROXY_PORT=
APPDYNAMICS_HTTP_PROXY_USER=
APPDYNAMICS_HTTP_PROXY_PASSWORD_FILE=

APPDYNAMICS_AGENT_LOG_DIR=

```

##### Build

```bash
$ docker-compose build --no-cache --build-arg APPD_USER=YOUR_APPDYNAMICS_LOGIN --build-arg APPD_PASS=YOUR_APPDYNAMICS_PASSWORD
```

This build will use the official php docker image (`php:7.4-fpm` by default) to build a custom image with preinstalled Appdynamics PHP agent.
Appdynamics PHP agent will be downloaded and installed automatically in the specified version during building the image.
##### Run
```bash
$ docker-compose up -d
```

```text
Creating network "appdynamics-php-docker_app-network" with driver "bridge"
Creating volume "appdynamics-php-docker_web-vol-1" with default driver
Creating appd-example-app       ... done
Creating appd-example-webserver ... done
```

Now, you can open: http://127.0.0.1:8181/index.php


##### Troubleshooting
```bash
$ docker-compose logs
```

Enabling trace-level loggin for php agent

1. Open [docker/php-fpm/appdynamics_agent_log4cxx.xml](docker/php-fpm/appdynamics_agent_log4cxx.xml)

Make sure the `priority` value is set to `trace`

```text
<root>
  <priority value="trace" />
  <appender-ref ref="main"/>
</root>
```

2. Open [docker/php-fpm/Dockerfile](docker/php-fpm/Dockerfile)
Uncomment line:

```text
# COPY ./appdynamics_agent_log4cxx.xml ${PHP_AGENT_DIR}/appdynamics-php-agent-linux_x64/php/conf/appdynamics_agent_log4cxx.xml
```

3. Rebuild image


