## RestCountriesApi Example Console Command Application


This example is about creating a command-line utility for determining the countries which speaks the same language or
checks if given two countries speak the same language by using open rest api.


## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

## Prerequisities

Docker has to be preinstalled before set up this project.

## Installing

After Docker installed , please run 

```
docker-compose up 
```

For testing please open a new terminal window and run 
```
docker-compose exec restlanguageapi php artisan
```

## Commands
The command is at app/Console/Commands/CountryDetector.php. You can run that command like this after open a new terminal for that project.


```
docker-compose exec restlanguageapi php artisan country:detect
```

For unit tests please run 

```
docker-compose exec restlanguageapi  php vendor/bin/phpunit 
```
