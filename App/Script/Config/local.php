<?php
return array (
  'script' => 
  array (
    'driver' => 'Pdo',
    'key' => 'scrip',
    'dsn' => 'mysql:dbname=mili;host=101.201.113.171:3306',
    'username' => 'mili',
    'password' => 'Mili_123',
    'driver_options' => 
    array (
      1002 => 'SET NAMES \'UTF8\'',
    ),
  ),
  'testScript' => 
  array (
    'driver' => 'Pdo',
    'key' => 'scrip',
    'dsn' => 'mysql:dbname=mili;host=101.200.83.75:3306',
    'username' => 'mili',
    'password' => 'Mili_123',
    'driver_options' => 
    array (
      1002 => 'SET NAMES \'UTF8\'',
    ),
  ),
  'localhost' => 
  array (
    'driver' => 'Pdo',
    'key' => 'scrip',
    'dsn' => 'mysql:dbname=script;host=localhost:3306',
    'username' => 'root',
    'password' => 'password',
    'driver_options' => 
    array (
      1002 => 'SET NAMES \'UTF8\'',
    ),
  ),
);