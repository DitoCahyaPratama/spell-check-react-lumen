# Cek Kata 
Aplikasi ini dibuat dengan menggunakan lumen dan react js

## Install backend lumen (microframework)
- install        : composer create-project --prefer-dist laravel/lumen backend 

## Install sastrawi : 
- Install vendor : composer require sastrawi/sastrawi:^1
- Docs           : https://github.com/sastrawi/sastrawi

## Install CORS :
- Install CORS   : composer require fruitcake/laravel-cors
- Settings CORS  : 
    - Create config folder
    - Create cors.php inside config folder
    - Add this in bootstrap/app.php

        ```php
        $app->register(Fruitcake\Cors\CorsServiceProvider::class);
        $app->configure('cors');
        $app->middleware([
            Fruitcake\Cors\HandleCors::class,
        ]);
        ```
- Follow this video

## Install front end react js
- install        : npx create-react-app frontend
- install this package:
    - axios
    - bootstrap
    - react-router-dom
    - reactstrap
- Follow this video