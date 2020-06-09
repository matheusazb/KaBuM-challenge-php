<?php
$rootPath = $_SERVER['DOCUMENT_ROOT'];
define("REQUIRE_AUTH", TRUE);

define("ROOT_PATH", $rootPath);
define("VIEWS_PATH", sprintf('%s/Application/View', $rootPath));
define("ASSETS_PATH", '/assets/static');
define("DB_DRIVER", "mysql");
define("DB_HOST", getenv("DB_HOST"));
define("DB_USER", getenv("MYSQL_USER"));
define("DB_PASS", getenv("MYSQL_PASSWORD"));
define("DB_DATABASE", getenv("MYSQL_DATABASE"));
define("FINISH_REQUEST", false);
define("DB_CHARSET", "utf8");


define("BASEURL_LOGOUT", "/logout");
define("BASEURL_CLIENT_UPDATE", "/clients/update/%s");
define("BASEURL_CLIENT_ADDRESS_LIST", "/clients/address/list/%s");
define("BASEURL_CLIENT_ADDRESS_CREATE", "/clients/address/create/%s");
define("BASEURL_CLIENT_ADDRESS_UPDATE", "/clients/address/update/%s");
define("BASEURL_CLIENT_LIST", "/clients/list");
define("BASEURL_CLIENT_CREATE", "/clients/create");

define("ENDPOINT_CLIENT_DELETE", "/api/clients");
define("ENDPOINT_CLIENT_LIST", "/api/clients");
define("ENDPOINT_CLIENT_CREATE", "/api/clients/insert");
define("ENDPOINT_CLIENT_UPDATE", "/api/clients/update/%s");

define("ENDPOINT_ADDRESS_DELETE", "/api/address");
define("ENDPOINT_ADDRESS_LIST", "/api/address");
define("ENDPOINT_ADDRESS_CREATE", "/api/address/insert");
define("ENDPOINT_ADDRESS_UPDATE", "/api/address/update/%s");
define("ENDPOINT_AUTH", "/api/auth/login");
