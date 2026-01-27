Hieronder vindt u alle benodigde informatie voor het correct opstarten van de Barroc Intens website.

- Download de .ZIP file van de Repository en pak deze uit in de local path naar keuze.
- Open het uigepakte project in je editor.
- .env.example naar .env maken. voer dit commando uit in de terminal "copy [.env.example](http://_vscodecontentref_/3) .env".
- als die klaar is voer "composer install" uit in de terminal.
- wacht tot composer klaar is en voer "npm install" in de terminal.
- wacht tot npm install klaar is en voer "php artisan key:generate" in de terminal.
- als de key generated is voer "php artisan migrate" en daarna "php artisan db:seed".
- daarna kunt u "npm run dev" in de terminal laten draaien.

De website is nu klaar voor gebruik. 
Let op! zorg dat je een manier hebt om de website lokaal te draaien. denk aan laravel herd.
