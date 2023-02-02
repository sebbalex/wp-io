<?php

$DEBUG = true;
return array(
  'debug' => $DEBUG,
  'base_url' => $DEBUG &&
    'http://172.17.0.1:3000/api/v1' ||
    'https://api.io.pagopa.it/api/v1',
);
