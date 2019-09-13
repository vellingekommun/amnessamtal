# Ämnessamtalsbokning

En applikation för att hantera bokningar av ämnessamtal.

Version 0.9 - 2019-09-13
Projektet är utvecklat i Laravel 5.7 (https://laravel.com/), VueJS 2 och Sass.

Utvecklat av [On A Wednesday Afternoon](https://oawa.se) för [Vellinge Kommun](https://vellinge.se/).

För att kunna köra applikationen lokalt används Laravels egna Vagrant-box (https://www.vagrantup.com) Homestead (https://laravel.com/docs/5.7/homestead/), för att kunna starta en Vagrant-miljö behöver du en virtuell maskin som till exempel VirtualBox.

###Så här sätter du upp en lokal utvecklingsmiljö.

1. Klona eller ladda ner repot till din dator.
2. Kopiera Homestead.yaml.example till Homestead.yaml och fyll i din lokala sökväg till projektets root-katalog.
3. Kopiera .env.example till .env och fyll i de olika miljövariablerna.
4. Kör kommandot 'vagrant up' för att starta den lokala utvecklingsmiljön
5. Anslut till den lokala miljön med kommandot 'vagrant ssh'
6. Kör kommandot 'composer install' för att installera alla paket och laravel
7. Kör kommandot 'yarn install' för att installa alla JS-paket
8. Kör kommandot 'php artisan migrate' för att skapa databastabellerna
9. Kör kommandot 'yarn run dev' för att skapa alla javascript och css-filer.

##Kontakt
####Vellinge Kommun
Jimmie Wester
Teknisk projektledare
jimmie.wester@vellinge.se

####On A Wednesday Afternoon
Magnus Jönsson
On A Wednesday Afternoon
magnus@oawa.se