<?php namespace components\cms; if(!defined('TX')) die('No direct access.'); tx('Account')->page_authorisation(2); ?>

<h1>Handleiding</h1>

<section class="section">

  <h2>Introductie</h2>

  <p>
    <span class="text-info tuxion-cms">tuxion.cms</span> is een in 2008 voor het eerst gepubliceerd open source cms (<i>content management system</i> of beheersysteem) voor kleine en middelgrote websites. Door middel van dit cms kunt u de content op uw website op eenvoudige wijze wijzigen en/of aanvullen zonder dat daar technische kennis voor vereist is. Er wordt dagelijks gewerkt aan een nog betere gebruikerservaring. Heeft u suggesties ter verbetering van <span class="tuxion_cms">tuxion.cms</span>, laat het de ontwikkelaars dan weten via het <i>feedback</i>-formulier. Zie hiervoor sectie x.x in de handleiding.
  </p>

</section>

<section class="section">

  <h2>Gebruikersbeheer</h2>
  
  <p>
    Op dit moment bent u reeds ingelogd met uw e-mailadres: <?php echo tx('Data')->session->user->email; ?>. Omdat uw account een beheerdersaccount is heeft u toegang tot dit beheersysteem, te vinden op <a href="#" title="U bevindt zich al in het beheersysteem, dus deze link is inactief."><?php echo URL_BASE; ?>admin</a>.
  </p>
  
  <p>
    Om gebruikers te beheren klikt u linksonder op <a href="#" class="text-link account-accounts">Gebruikersbeheer</a>. U ziet een lijst met alle gebruikers op de website.
  </p>
  
  <h3>Een gebruiker toevoegen</h3>
  
  <ol>
    <li>Klik op het tabblad <span class="text-link">Nieuwe gebruiker</span>.</li>
    <li>
      Voer de gebruikersgegevens in.
      <ul>
        <li>
          <span class="form-key">E-mailadres</span>
          <span class="form-key-explanation">Het e-mailadres van de gebruiker. Hiermee logt de gebruiker straks in.</span>
        </li>
        <li>
          <span class="form-key">Wachtwoord</span>
          <span class="form-key-explanation">Het wachtwoord van de gebruiker. Hiermee logt de gebruiker straks in.</span>
        </li>
        <li>
          <span class="form-key">Voornaam (optioneel)</span>
          <span class="form-key-explanation">De voornaam van de gebruiker.</span>
        </li>
        <li>
          <span class="form-key">Tussenvoegsel (optioneel)</span>
          <span class="form-key-explanation">De voornaam van de gebruiker.</span>
        </li>
        <li>
          <span class="form-key">Achternaam (optioneel)</span>
          <span class="form-key-explanation">De voornaam van de gebruiker.</span>
        </li>
      </ul>
    </li>
    <li>
      Kies eventueel extra opties.
      <ul>
        <li>
          <span class="form-key">Laat gebruiker wachtwoord kiezen</span>
          <span class="form-key-explanation">Als deze optie is aangevinkt, wordt er een activatie-mail verzonden, waardoor de gebruiker zelf zijn wachtwoord kan kiezen. Als deze optie is aangevinkt, hoeft er geen wachtwoord bij <span class="text-reference">Wachtwoord</span> ingevuld te worden.</span>
        </li>
        <li>
          <span class="form-key">Beheerder</span>
          <span class="form-key-explanation">Als deze optie is aangevinkt, krijgt de gebruiker beheerdersrechten. Hierdoor heeft de gebruiker alle rechten op de website en kan hij de website beheren op dezelfde manier als u dat nu doet.</span>
        </li>
      </ul>
    </li>
  </ol>

</section>

<section class="section">
  
  <h2>Menubeheer</h2>

  <p>
    In de menubalk aan de linkerkant van het beheersysteem ziet u een overzicht van de menu-items op de website. Het is hier mogelijk om menu-items toe te voegen, te bewerken, te verwijderen of te rearrangeren.
  </p>
  
  <h3>Een menu-item toevoegen</h3>
  
  <ol>
    <li>Klik op <span class="text-info add-menu-item">Voeg een menu-item toe</span>. Er verschijnt een nieuw scherm.</li>
    <li>
      Voer de gegevens voor dit menu-item in.
      <ul>
        <li>
          <span class="form-key">Titel</span>
          <span class="form-key-explanation">De titel van het menu-item.</span>
        </li>
        <li>
          <span class="form-key">Menu</span>
          <span class="form-key-explanation">Het menu waarbinnen dit menu-item zich bevindt. Meestal is er &eacute;&eacute;n menu: het hoofdmenu.</span>
        </li>
      </ul>
    </li>
    <li>Klik op <span class="text-info submit button">Opslaan</span></li>
  </ol>
  
  <p>
    In de menubalk links is het menu-item bovenaan toegevoegd. U kunt nu een pagina aan het menu-item koppelen, of het menu-item op een andere plek in het menu plaatsen.
  </p>
  
  <h3>Menu-items van volgorde of niveau veranderen</h3>
  
  <ol>
    <li>Versleep een menu-item verticaal om de volgorde van de menu-items te veranderen. Op deze manier kunt u de volgorde van uw pagina's aanpassen.</li>
    <li>Versleep een menu-item horizontaal om de diepte van de menu-items te veranderen. Op deze manier kunt u sub-pagina's aanmaken.</li>
    <li>Klik op <span class="text-info button">Wijzigingen opslaan</span> om de wijzigingen op te slaan.</li>
  </ol>

</section>

<section class="section">

  <h2>Paginabeheer</h2>

  <p>
    In de menubalk aan de linkerkant van het beheersysteem is het mogelijk om onder menu-items pagina's aan te maken. Deze pagina's kunnen op diverse manieren werken, door middel van het kiezen van een systeemcomponent. Het is ook mogelijk om menu-items toe te voegen, te bewerken, te verwijderen, los te koppelen en te rearrangeren.
  </p>

  <h3>Een pagina toevoegen</h3>

  <ol>
    <li>Klik op een willekeurig menu-item in de menubalk aan de linkerkant van het beheersysteem.</li>
    <li>Klik onder het menu Pagina toevoegen op het type pagina dat u onder het menu item wilt toevoegen.</li>
    <li>Voer de paginagegevens in. Dit hangt af van het type pagina dat u toevoegt.</li>
  </ol>

  <h3>Een pagina bewerken</h3>

  <p>
    Er zijn 2 verschillende manieren om pagina's aan te passen.
  </p>

  <h4>Via het pagina-overzicht</h4>

  <ol>
    <li>Klik linksonderin in de menubalk aan de linkerkant van het beheersysteem op de knop Paginaoverzicht.</li>
    <li>Klik in het paginaoverzicht op de knop wijzig bij de pagina waar u bewerkingen op wilt uitvoeren.</li>
    <li>Voer uw bewerkingen uit.</li>
    <ul>
      <li>Met de knop <span class="text-info button">Annuleren</span> verwijdert u uw bewerkingen en gaat u terug naar het hoofdmenu.</li>
      <li>Met de knop <span class="text-info button">Opslaan en teruggaan</span> slaat u uw bewerkingen op een keert u terug naar het hoofdmenu.</li>
      <li>Met de knop <span class="text-info button">Opslaan</span> slaat u uw bewerkingen op maar blijft u op de huidige pagina.</li>
    </ul>
  </ol>

  <h4>Direct onder een menu-item</h4>

  <ol>
    <li>Klik op een willekeurig menu-item in de menubalk aan de linkerkant van het beheersysteem.</li>
    <li>In de 2e sectie van de pagina vind u de pagina's die zich onder het gekozen menu-item bevinden.</li>
    <li>Voer uw bewerkingen uit.</li>
    <ul>
      <li>Met de knop <span class="text-info button">Annuleren</span> verwijdert u uw bewerkingen en gaat u terug naar het hoofdmenu.</li>
      <li>Met de knop <span class="text-info button">Opslaan en teruggaan</span> slaat u uw bewerkingen op een keert u terug naar het hoofdmenu.</li>
      <li>Met de knop <span class="text-info button">Opslaan</span> slaat u uw bewerkingen op maar blijft u op de huidige pagina.</li>
    </ul>
  </ol>

  <h3>Een pagina verwijderen</h3>

  <ol>
    <li>Klik linksonderin in de menubalk aan de linkerkant van het beheersysteem op de knop Paginaoverzicht.</li>
    <li>Klik in het paginaoverzicht op de knop verwijder bij de pagina die u wilt verwijderen.</li>
    <li>Maak uw keuze in het dialoogvenster dat verschijnt.</li>
    <ul>
      <li>Met de knop <span class="text-info button">OK</span> verwijdert u de pagina en keert u terug naar het paginaoverzicht.</li>
      <li>Met de knop <span class="text-info button">Annuleren</span> behoudt u de pagina en keert u terug naar het paginaoverzicht.</li>
    </ul>
  </ol>
  <!--
  Op het startscherm van tuxion.cms: klik op Tekstpagina. Hiermee maak je een nieuwe pagina aan op de site, die straks te koppelen is aan een menu-item.
  Pas de titel van de pagina aan, achter Titel (slechts voor opzoeken in het beheer)
  Typ een titel voor dit bericht in het invulveld zonder naam (deze verschijnt boven het bericht)
  Typ een tekst. Door in dropdown Ã¯Â¿Â½OpmaakÃ¯Â¿Â½ Ã¯Â¿Â½Kop 2Ã¯Â¿Â½ te selecteren kun je een subkopje aanmaken.
  Het opslaan van de pagina inclusief tekst is eenvoudig:
  Klik op Save om de pagina op te slaan en op dezelfde pagina te blijven
  Klik op Save & Return om de pagina op te slaan en terug te gaan naar het overzicht
  Klik op Cancel om de pagina niet op te slaan en terug te gaan naar het overzicht
  -->

</section>