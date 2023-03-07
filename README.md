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

<b> Ekranvaizdžiai: </b>
# ![screencapture-localhost-PrestaShop-admin-index-php-2023-03-07-15_23_16](https://user-images.githubusercontent.com/107037107/223435217-a64f160d-6dc0-4b0d-9207-754b79d20215.png)
# ![screencapture-localhost-PrestaShop-admin-index-php-2023-03-07-15_24_26](https://user-images.githubusercontent.com/107037107/223435301-76f8a497-a0b3-407b-96d4-4f9f41492fcc.png)
# ![screencapture-localhost-PrestaShop-admin-index-php-sell-catalog-products-0-20-id-product-desc-2023-03-07-15_27_32](https://user-images.githubusercontent.com/107037107/223435755-5d17955f-e183-4143-8f1a-034f115ed2d6.png)
# ![screencapture-localhost-PrestaShop-admin-index-php-sell-catalog-categories-2-2023-03-07-15_28_57](https://user-images.githubusercontent.com/107037107/223436063-8defd4f5-aa17-4ca5-9512-4d24b44709b4.png)
# ![screencapture-localhost-PrestaShop-admin-index-php-sell-customers-2023-03-07-15_30_04](https://user-images.githubusercontent.com/107037107/223436363-e1f2f134-173e-459b-8dc3-96c9f12819b0.png)
