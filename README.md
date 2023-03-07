# PrestaShop Test Module
 
 <b> Apie modulį: </b>
<li> Modulio valdymo dalyje galima užkrauti API ir išsaugoti <b>produktus</b>, bei <b>kategorijas</b> į duombazę (panaudotas https://fakestoreapi.com/products).
<li> Įvedus netinkamą API nuoruodą valdymo lange išmetamas klaidos pranešimas.
<li> Validuoja duomenis ar yra įvestas produkto pavadinimas.
<li> Modulis sukuria dirbtinius <b>klientų</b> duomenis patvirtinimus formą.
<li> Panaudotas composer.

<b> Prestashop versija: </b>
<li> Modulis kurtas ant Prestashop 1.7.8.8 versijos.

<b> Reikalavimai: </b>
<li> Diegimui reikia panaudoti <a href="https://getcomposer.org/">Composer</a>.

<b> Diegimas: </b>
<li> Parsisiųsti .zip failą <b>(Code -> Download ZIP)</b>.
<li> Pervadinkite direktorijos pavadinimą į <b>testmodule</b>, nes direktorijos ir modulio pavadinimai turi sutapti.
<li> Išarchyvuoti failą ir įkeltį į Prestashop modules direktoriją. <b>(pvz. C:\xampp\htdocs\prestashop\modules)</b>.
<li> Modulio direktorijoje reikia įrašyti komandinę eilutę <b>composer install</b>, kad būtų atsiųsti visi reikiami failai i vendor katalogą.
<li> Prisijungti prie Prestashop administracijos puslapio, paspausti <b>Modules->Marketplace</b>, paieškoje įvesti <b>testmodule</b> ir paspausti <b>Install</b>.

<b> Trynimas: </b>
<li>  Prisijungti prie Prestashop administracijos puslapio, paspausti <b>Modules->Module Manager</b>, paieškoje įvesti <b>testmodule</b> ir paspausti <b>Unistall</b>.
