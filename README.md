# SiMonas

Sistem Informasi Monitoring Absensi

## Description

This is a web development and API part of SiMonas. This application is for monitoring the student absences.

## Getting Started

### Dependencies

* PHP v8.1.10
* node v20.11.0
* npm v10.2.4
* Laravel v10.46.0
* Composer v2.4.3

### Installing

* ```git clone https://github.com/RifqyYR/absensi.git```
* ```composer Install```
* ```npm install```
* ```cp .env.example .env```
* insert field DEFAULT_PASSWORD=`your password` on .env file in the last line
* ```php artisan key:generate```
* ```php artisan migrate```
* ```php artisan db:seed```
* ```php artisan storage:link```

### Executing program

* Run the server
* Run vite
```
php artisan serve
npm run dev
```

## Authors

RifqyYR:
* [@GitHub](https://github.com/RifqyYR)
* [@LinkedIn](https://www.linkedin.com/in/rifqyyr/)
