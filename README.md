# WP IO plugin
Forked from: https://github.com/DevinVinson/WordPress-Plugin-Boilerplate

## Cosa?
Un plugin per integrare i servizi di [App IO](https://io.italia.it) all'interno del CMS Wordpress.

## Perché?
Unificare in un unico CMS i servizi essenziali per una pubblica amministrazione.

## Run
### Wordpress
`$ docker compose up -d`

### Mock API server per IO
```
$ git clone git@github.com:pagopa/io-dev-api-server.git
$ cd io-dev-api-server
$ yarn install && yarn generate
$ yarn start
```
