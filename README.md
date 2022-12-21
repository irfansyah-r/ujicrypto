# Project Title

Ujicrypto

![Home Page](https://github.com/irfansyah-r/ujicrypto/blob/main/preview/Home.png?raw=true)

## Description

* Ujicrypto merupakan project pemantauan harga mata uang crypto sekaligus dengan 3 indikator nya yang dibuat custom dengan perhitungan manual yaitu :
    * Moving Average
    * Stochastic
    * Parabolic SAR

![Indicator Page](https://github.com/irfansyah-r/ujicrypto/blob/main/preview/Indicator.png?raw=true)

* Menggunakan Laravek versi 9.17.0
* Data harga diambil dari API Binance Exchange

## Getting Started

### Dependencies

* PHP 8
* MySQL

### Installing

* Buka Command Prompt pada folder Project dan jalankan perintah :
```
composer install
```
* Copy file .env.example dan rename menjadi .env
* Sesuaikan config database dengan database yang digunakan
* Buka Command Prompt pada folder Project dan generate key baru dengan menjalankan perintah :
```
php artisan key:generate
```
* Migrasi dan seed database dengan menjalankan perintah :
```
php artisan migrate --seed
```


### Executing program

* Run project dengan menjalankan perintah :
```
php artisan serve
```
* Buka link yang berupa ip dan port seperti http://localhost:8000/ pada browser
* Masuk dengan user :
    * Email     : admin@gmail.com
    * Password  : admin123

## Help

Any advise for common problems or issues.
```
command to run if program contains helper info
```

## Authors

Contributors names and contact info

ex. Irfansyah Rizal  
ex. [@Email](mailto:irfansyah.rizal.20@gmail.com)

## Version History

* 0.2
    * Various bug fixes and optimizations
    * See [commit change]() or See [release history]()
* 0.1
    * Initial Release

## License

This project is licensed under the [NAME HERE] License - see the LICENSE.md file for details
