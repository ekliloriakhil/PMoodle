<?php
/// Please, do not edit this file manually! It's auto generated from
/// contents stored in your standard lang pack files:
/// (langconfig.php, install.php, moodle.php, admin.php and error.php)
///
/// If you find some missing string in Moodle installation, please,
/// keep us informed using http://moodle.org/bugs Thanks!
///
/// File generated by cvs://contrib/lang2installer/installer_builder
/// using strings defined in stringnames.txt (same dir)

$string['admindirerror']='Valitud administreerimiskataloog on vale';
$string['admindirname']='Administreerimiskataloog';
$string['cannotcreatelangdir']='Ei saa luua lang kataloogi';
$string['cannotcreatetempdir']='Ei saa luua temp kataloogi';
$string['cannotdownloadcomponents']='Ei saa alla tõmmata komponente.';
$string['cannotdownloadzipfile']='Ei saa alla tõmmata ZIP faili.';
$string['cannotfindcomponent']='Ei leia komponenti.';
$string['cannotsavemd5file']='Ei saa salvestada md5 faili.';
$string['cannotsavezipfile']='Ei saa salvestada ZIP faili.';
$string['cannotunzipfile']='Ei saa lahti pakkida faili.';
$string['caution']='Hoiatus';
$string['check']='Kontrolli';
$string['chooselanguagehead']='Keele valik';
$string['chooselanguagesub']='Palun vali keel, mida kasutatakse AINULT installeerimise käigus. Hiljem saab valida õpikeskkonna ja kasutajate keelt.';
$string['closewindow']='Sule aken';
$string['compatibilitysettingshead']='PHP seadete kontrollimine...';
$string['compatibilitysettingssub']='Sinu server peab läbima kõik need testid, et Moodle jookseks korralikult';
$string['configfilenotwritten']='Installeerimisskript ei suutnud automaatselt tekitada config.php faili, mis sisaldaks sinu valitud seadistusi. Põhjus võib olla selles, et sinu Moodle kataloog ei ole kirjutatav. Sa võid käsitsi kopeerida järgneva koodi config.php nimelisse faili, mis asub Moodle juurkataloogis.';
$string['configfilewritten']='config.php on edukalt loodud';
$string['configurationcompletehead']='Konfigureerimine lõpetatud';
$string['continue']='Jätka';
$string['curlrecommended']='Fakultatiivse Curl teegi installeerimine on väga soovitatav, millega võimaldatakse Moodle võrgunduse funktsionaalsus.';
$string['customcheck']='Muud kontrollid';
$string['database']='Andmebaas';
$string['databasecreationsettingssub']='<b>Tüüp:</b> määratud \"mysql\" paigaldaja poolt<br />
       <b>Host:</b> määratud \"localhost\" paigaldaja poolt<br />
       <b>Nimi:</b> andmebaasi nimi, nt. moodle<br />
       <b>User:</b> määratud \"root\" paigaldaja poolt<br />
       <b>Parool:</b> Sinu andmebaasi parool<br />
       <b>Tabelite prefiks:</b> fakultatiivne prefiks kasutamaks tabeli nimetes';
$string['databasesettingshead']='Nüüd on vaja seadistada andmebaas, kus enamus Moodle andmeid hakatakse hoidma. See andmebaas peab olema eelnevalt loodud ning ka konto, millel ligipääs antud andmebaasile.';
$string['databasesettingssub']='<b>Tüüp:</b> mysql või postgres7<br />
	<b>Host:</b> näiteks localhost või db.isp.com<br />
	<b>Nimi:</b> andmebaasi nimi, näiteks moodle<br />
	<b>Kasutaja:</b> Sinu andmebaasi konto kasutajatunnus<br />
	<b>Parool:</b> Sinu andmebaasi konto parool<br />
	<b>Tabelite prefiks:</b> fakultatiivne prefiks kasutamaks tabelite nimedes';
$string['databasesettingssub_mssql']='<b>Tüüp:</b> SQL*Server (mitte UTF-8) <b><font color=\"red\">Eksperimentaalne! (mitte kasutamiseks töökeskkonnas)</font></b><br />
	<b>Host:</b> näiteks localhost või db.isp.com<br />
	<b>Nimi:</b> andmebaasi nimi, näiteks moodle<br />
	<b>Kasutaja:</b> Sinu andmebaasi konto kasutajatunnus<br />
	<b>Parool:</b> Sinu andmebaasi konto parool<br />
	<b>Tabelite prefiks:</b> prefiks kasutamaks tabelite nimedes (kohustuslik)';
$string['databasesettingssub_mssql_n']='<b>Tüüp:</b> SQL*Server (UTF-8 toetatav)<br />
	<b>Host:</b> näiteks localhost või db.isp.com<br />
	<b>Nimi:</b> andmebaasi nimi, näiteks moodle<br />
	<b>Kasutaja:</b> Sinu andmebaasi konto kasutajatunnus<br />
	<b>Parool:</b> Sinu andmebaasi konto parool<br />
	<b>Tabelite prefiks:</b> prefiks kasutamaks tabelite nimedes (kohustuslik)';
$string['databasesettingssub_mysql']='<b>Tüüp:</b> MySQL<br />
	<b>Host:</b> näiteks localhost või db.isp.com<br />
	<b>Nimi:</b> andmebaasi nimi, näiteks moodle<br />
	<b>Kasutaja:</b> Sinu andmebaasi konto kasutajatunnus<br />
	<b>Parool:</b> Sinu andmebaasi konto parool<br />
	<b>Tabelite prefiks:</b> fakultatiivne prefiks kasutamaks tabelite nimedes';
$string['databasesettingssub_oci8po']='<b>Tüüp:</b> Oracle<br />
	<b>Host:</b> ei kasutata, peab olema tühjaks jäetud<br />
	<b>Name:</b> given name of the tnsnames.ora connection<br />
	<b>User:</b> your database username<br />
	<b>Password:</b> your database password<br />
	<b>Tabelite prefiks:</b> prefiks kasutamaks tabelite nimedes (kohustuslik, 2cc. max)';
$string['databasesettingssub_odbc_mssql']='<b>Tüüp:</b> SQL*Server (üler ODBC) <b><font color=\"red\">Eksperimentaalne! (mitte kasutamiseks töökeskkonnas)</font></b><br />
	<b>Host:</b> DSN antud nimi ODBC kontroll paneelis<br />
	<b>Nimi:</b> andmebaasi nimi, näiteks moodle<br />
	<b>Kasutaja:</b> Sinu andmebaasi konto kasutajatunnus<br />
	<b>Parool:</b> Sinu andmebaasi konto parool<br />
	<b>Tabelite prefiks:</b> prefiks kasutamaks tabelite nimedes (kohustuslik)';
$string['databasesettingssub_postgres7']='<b>Tüüp:</b> PostgreSQL<br />
	<b>Host:</b> näiteks localhost või db.isp.com<br />
	<b>Nimi:</b> andmebaasi nimi, näiteks moodle<br />
	<b>Kasutaja:</b> Sinu andmebaasi konto kasutajatunnus<br />
	<b>Tabelite prefiks:</b> prefiks kasutamaks tabelite nimedes (kohustuslik)';
$string['dataroot']='Andmete kataloog';
$string['datarooterror']='Sinu määratud andmete kataloogi ei suudetud leida ega luua. Paranda tee või loo ise käsitsi see kataloog.';
$string['dbconnectionerror']='Me ei suutnud sinu määratud andmebaasi ühendada. Palun kontrolli oma andmebaasi seadistust.';
$string['dbcreationerror']='Andmebaasi loomise viga. Ei suudetud luua andmebaasi nime olemasolevate seadistustega.';
$string['dbhost']='Hosti server';
$string['dbprefix']='Tabeli eesliide';
$string['dbtype']='Tüüp';
$string['directorysettingshead']='Palun kinnita Moodle installatsiooni asukohta';
$string['dirroot']='Moodle kataloog';
$string['dirrooterror']='Moodle kataloogi seadistus näib olevat vigane -  me ei suuda sealt leida Moodle installatsiooni. Allpool olev väärtus on nullitud.';
$string['download']='Lae alla';
$string['downloadedfilecheckfailed']='Alla laetud faili kontroll ebaõnnestus.';
$string['downloadlanguagebutton']='Tõmba alla &quot;$a&quot; keelepakett';
$string['downloadlanguagehead']='Tõmba alla keelepakett';
$string['downloadlanguagesub']='Sul on praegu võimalus tõmmata alla keelepakk ja jätkata installeerimist vastavas keeles.<br /><br />Kui Sa oled mitte võimeline alla tõmbama keelepakki, siis installeerimine jätkub inglise keeles. (Niipea, kui installeerimine on lõppenud, on Sul võimalus alla tõmmata täiendavaid keelepakke.)';
$string['environmenterrortodo']='Sa pead lahendama kõik keskkonna probleemid (vead), mis leiti ülal, et hakata installeerima vastavat Moodle versiooni!';
$string['environmenthead']='Keskkonna kontrollimine...';
$string['environmentrecommendcustomcheck']='kui see test ebaõnnestub, siis see võib saada potentsiaalseks probleemiks';
$string['environmentrecommendinstall']='on soovitatav, et oleks installeeritud ja võimaldatud';
$string['environmentrequirecustomcheck']='see test peab olema edukalt läbitud';
$string['environmentrequireinstall']='on nõutud, et oleks installeeritud ja võimaldatud';
$string['environmentrequireversion']='versioon $a->needed on nõutud, Sinul on jooksmas versioon $a->current';
$string['environmentsub']='Me kontrollime, kas mitmesugused süsteemi komponendid vastavad nõudmistele.';
$string['error']='Viga';
$string['fail']='Fail';
$string['fileuploads']='Failide üleslaadimine';
$string['fileuploadserror']='See peaks olema sisse lülitatud';
$string['fileuploadshelp']='<p>Failide üleslaadimine näib sinu serveris olevat välja lülitatud.</p>
<p>Moodle\'it saab ikka installeerida, kui selle võimaluseta ei saa sa kursuse faile või uute kasutajate andmeid üles laadida</p>
<p>Failide üleslaadimise sisse lülitamiseks pead sa (või sinusüsteemiadministraator) muutma main php.ini faili oma süsteemis ja seadma <b>file_uploads</b> väärtuseks \'1\'.</p>';
$string['gdversion']='GD versioon';
$string['gdversionerror']='GD teek peaks olema võimeline töötlema ja looma pilte.';
$string['gdversionhelp']='<p>Sinu serveril ei paista GD installeeritud olevat.</p>
<p>GD on andmeteek, mis on vajalik PHP jaoks, et Moodle\'il oleks võimalik pilte (kasutajate ikoonid, logide graafikud) töödelda ja luua. Moodle töötab ikka ka GD puudumisel, aga need võimalused ei ole siis sinu jaoks kättesaadavad.</p>
<p>GD lisamiseks PHP\'le Unixi operatsioonisüsteemis tuleb kompileerida PHP-d, kasutates --with-gd parameetrit.</p>
<p>Windowsis saad sa tavaliselt muuta php.ini faili ja kommenteerida sisse libdg.dll\'le vastava rea.</p>';
$string['globalsquotes']='Ebaturvaline globaalmuutujate häsitlemine';
$string['globalsquoteserror']='Paranda oma PHP seadeid: mitte võimalda \"register_globals\" ja/või võimalda \"magic_quotes_gpc\".';
$string['globalsquoteshelp']='<p>Kombinatsioon mitte lubatud Magic Quotes GPC ja võimaldatud Register Globals samaaegsest seadistusest ei ole soovitatav.</p><p>Soovituslik seadistus on <b>magic_quotes_gpc = On</b> and <b>register_globals = Off</b> Sinu php.ini failis</p><p>Kui Sul ei ole ligipääsu php.ini failile, siis peaksid paneme alljärgnevad read Moodle kataloogis olevasse faili .htaccess:<blockquote>php_value magic_quotes_gpc On</blockquote><blockquote>php_value register_globals Off</blockquote></p>';
$string['help']='Abi';
$string['iconvrecommended']='Fakultatiivse ICONV teegi installeerimine on tungivalt soovitatav tõstmaks õpikeskkonna jõudlust, eriti kui õpikeskkond toetab mitte ladinatähistikuga keeli (näiteks eesti keelt).';
$string['info']='Informatsioon';
$string['installation']='Installeerimine';
$string['invalidmd5']='Vigane md5'; // ORPHANED
$string['langdownloaderror']='Kahjuks keelt \"$a\" ei paigaldatud. Paigaldamine jätkub inglise keeles.';
$string['langdownloadok']='Keel \"$a\" paigaldati edukalt. Paigaldamisprotsess jätkub selles keeles.';
$string['language']='Keel';
$string['magicquotesruntime']='Magic Quotes talitlusaeg';
$string['magicquotesruntimeerror']='See peaks olema välja lülitatud';
$string['magicquotesruntimehelp']='<p>Magic quotes talitlusaeg peaks olema välja lülitatud, et Moodle saaks korralikult funktsioneerida.</p>
<p>Tavalielt on see vaikimisi välja lülitatud. Vaata <b>magic_quotes_runtime</b> seadistust  sinu php.ini failis.</p>
<p>Kui sul ei ole ligipääsu oma php.ini failile, siis peaksid lisama järgmise koodi .htaccess nimelisse faili, mis asub sinu Moodle kataloogis:
<blockquote>php_value magic_quotes_runtime Off</blockquote>
</p>';
$string['memorylimit']='Mälu limiit';
$string['memorylimiterror']='PHP mälu limiit on seatud päris madalale...sul võib hiljem sellega seoses probleeme tekkida.';
$string['memorylimithelp']='<p>PHP mälu limiit sinu serveri jaoks on hetkel $a.</p>
<p>See võib hiljem tekitada Moodle\'il mäluprobleeme, eriti kui sul on palju mooduleid ja/või kasutajaid.
</p>
<p>Me soovitame, et sa konfigureeriksid PHP kõrgema limiidi peale, näiteks 16M. Selle tostamiseks on mitu viisi:</p>
<ol>
<li>Kui võimalik, siis kompileeri PHP uuesti parameetriga <i>--enable-memory-limit</i>.
See lubab Moodle\'il ise mälu limiiti määrata.</li>
<li>Kui sul on juurdepääs oma php.ini failile, siis saad muuta seal <b>memory_limit</b> väärtuseks midagi 16M lähedast. Kui sul ei ole juurdepääsu, siis võiksid paluda administraatoril seda teha.</li>
<li>Mõnedes PHP serverites saad luua Moodle kataloogi .htaccess faili, mis sisaldab seda rida:<p><blockquote>php_value memory_limit 16M</blockquote></p>
<p>Kuigi mõnedes serverites tõkestab see <b>kõigi</b> PHP lehekülgede tööd (sa näed veateateid, kui vaatad lehti), nii et pead eemaldama .htaccess faili.</p></li>
</ol>';
$string['missingrequiredfield']='Mõned nõutud väljad on puudu';
$string['moodledocslink']='Moodle manuaalid käesoleva lehe kohta';
$string['mssql']='SQL*Server (mssql)';
$string['mssql_n']='SQL*Server UTF-8 toetusega (mssql_n)';
$string['mssqlextensionisnotpresentinphp']='PHP laiendus MSSQL ei ole korralikult seadistatud, mistõttu ei saa ühenduda SQL*Server\'iga. Palun kontrolli oma php.ini faili või kompileeri PHP uuesti.';
$string['mysql']='MySQL (mysql)';
$string['mysqlextensionisnotpresentinphp']='PHP ei ole MySQL laiendiga õigesti konfigureeritud, seega ei saa ta MySQL\'ga suhelda. Palun kontrolli oma php.ini faili või kompileeri PHP uuesti.';
$string['name']='Nimi';
$string['next']='Järgmine';
$string['oci8po']='Oracle (oci8po)';
$string['ociextensionisnotpresentinphp']='PHP laiendus OCI8 ei ole korralikult seadistatud, mistõttu ei saa ühenduda Oracle\'ga. Palun kontrolli oma php.ini faili või kompileeri PHP uuesti.';
$string['odbc_mssql']='SQL*Server üle ODBC (odbc_mssql)';
$string['odbcextensionisnotpresentinphp']='PHP laiendus ODBC ei ole korralikult seadistatud, mistõttu ei saa ühenduda SQL*Server\'iga. Palun kontrolli oma php.ini faili või kompileeri PHP uuesti.';
$string['ok']='OK';
$string['opensslrecommended']='Fakultatiivse OpenSSL teegi installeerimine on väga soovitatav, millega võimaldatakse Moodle võrgunduse funktsionaalsus.';
$string['pass']='Korras';
$string['password']='Salasõna';
$string['pgsqlextensionisnotpresentinphp']='PHP laiendus PGSQL ei ole korralikult seadistatud, mistõttu ei saa ühenduda PostgreSQL\'iga. Palun kontrolli oma php.ini faili või kompileeri PHP uuesti.';
$string['php50restricted']='PHP 5.0.x omab mitmeid probleeme. Palun uuenda 5.1.x või lase tagasi 4.3.x or 4.4.x PHP versioonile';
$string['phpversion']='PHP versioon';
$string['phpversionerror']='PHP versioon peab olema vähemalt 4.1.0';
$string['phpversionhelp']='<p>Moodle vajab vähemalt PHP versiooni 4.1.0</p>
<p>Sinu jooksev versioon on $a</p>
<p>Sa pead oma PHP-d uuendama või kolima hosti, kus on uuem PHP versioon!</p>';
$string['postgres7']='PostgreSQL (postgres7)';
$string['previous']='Eelmine';
$string['remotedownloadnotallowed']='Komponentide alla tõmbamine ei ole Sinu serverisse lubatud (sest allow_url_fopen keelatud).<br /><br />Sa pead tõmbama alla faili <a href=\"$a->url\">$a->url</a> käsitsti, kopeerima \"$a->dest\" oma serveris ja sinna lahti pakkima.';
$string['report']='Ülevaade';
$string['restricted']='Piiratud';
$string['safemode']='Ohutu režiim';
$string['safemodeerror']='Moodle\'il võib ohutus režiimis komplikatsioone tekkida';
$string['safemodehelp']='<p>Moodle võib tekkida mitmesuguseid probleeme, kui ohutu režiim on sisse lülitatud, näiteks ei luba ta tõenäoliselt luua uusi faile.</p>
<p>Ohutu režiim on tavaliselt sisse lülitatud ainult paranoilistel avalikel veebihostidel, seega pead leidma oma Moodle õpikeskkonnale uue serveriteenust pakkuva firma. </p>
<p>Sa võid proovida installeerimist jätkata, kui soovid, aga arvatavasti tekib sul ka hiljem probleeme.</p>';
$string['serverchecks']='Serveri kontrollid';
$string['sessionautostart']='Sessioonide automaatne algatamine';
$string['sessionautostarterror']='See peaks olema välja lülitatud';
$string['sessionautostarthelp']='<p>Moodle vajab sessiooni tuge ja ei tööta ilma selleta.</p>
<p>Sessioone saab sisse lülitada php.ini failist, otsi sealt session.auto_start parameetrit.</p>';
$string['skipdbencodingtest']='Jäta vahele andmebaasi kodeeringu test';
$string['status']='Staatus';
$string['thischarset']='UTF-8';
$string['thisdirection']='ltr';
$string['thislanguage']='Eesti';
$string['unicoderecommended']='Soovitatav on kõikide andmete salvestamine UTF-8\'s (unicode). Uued paigaldamised peaksid olema tehtud andmebaasi, mille vaikimisi kodeering on Unicode. Kui uuendada, siis peaksid teostama UTF-8\'sse üleviimise protsessi (vaata Admin lehte).';
$string['user']='Kasutaja';
$string['welcomep10']='$a->installername ($a->installerversion)';
$string['welcomep20']='Sa näed seda lehte, sest oled edukalt installeerinud ja käivitanud <strong>$a->packname $a->packversion</strong> paketi Sinu arvutis. Õnnitleme!';
$string['welcomep40']='Pakett sisaldab ka <strong>Moodle $a->moodlerelease ($a->moodleversion)</strong>.';
$string['welcomep70']='Vajuta \"Järgmine\" nuppu all jätkamaks <strong>Moodle</strong> paigaldamisega.';
$string['wrongdestpath']='Vale sihtkoha rada.'; // ORPHANED
$string['wrongsourcebase']='Vale allika URL\'i baas.';
$string['wrongzipfilename']='Vale ZIP failinimi.'; // ORPHANED
$string['wwwroot']='Veebiaadress';
$string['wwwrooterror']='Veebiaadress näib vigane - Moodle installatsiooni ei paista seal olevat.';
?>
