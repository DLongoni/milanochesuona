## milanochesuona
##### Aggregatore di concerti a Milano

#### Database
* Event
  * Id
  * FbId
  * Title
  * StartTime
  * EndTime
  * IdVenue (not nullable)
  * Link 
  * Picture (link)
  * Descr
  * HtmlDescr
  * Status
  * Cost
* EventBand
  * EventId
  * BandId
* Band
  * Id
  * FbId
  * Name
  * FbPage
  * Website
  * Logo Link
  * Picture Link
  * Descr
  * Email
* Venue
  * Id
  * FbId
  * Name
  * Location
  * Website
  * FbPage
  * Logo Link
  * Picture Link
  * Descr
  * Phone
  * Email
* Genre
  * Id
  * Descr
* EventStatus
  * Id
  * Descr
* Location
  *  Id
  *  City
  *  Country
  *  Latitude
  *  Longitude
  *  Street
  *  Zip
* BandGenre
  * BandId
  * GenreId

#### Funzionalita  
##### motivare da use cases
Ogni concerto deve avere un giorno (1)
Possibilita  di filtrare per giorno (1)
Possibilita (o obbligo) di accorpare rassegne / festival all'interno dello stesso giorno
Tab venues - solo per funzionalita  di background
Tab gruppi - solo per funzionalita  di background
Tab eventi - back e front
L'elenco "calendario" nella pagina principale e' generato dinamicamente, cosi' come le pagine dei singoli eventi filtrando dal database
	
### Casi d'uso
1. Visualizzazione 
		1.a - voglio semplicemente visualizzare la lista di cosa succede oggi o nei giorni successivi 

### Note
	- Un evento deve essere identificato da un luogo ed un giorno. Se una tal rassgna in un tal giorno avviene in piu' luoghi bisognera'  creare piu' eventi.
	- Per venue si intende sia un locale. Se un evento non e' in un locale metto l'indirizzo e lascio vuoto il campo venue
### TODO
  * voglio veramente lasciare venue e location separati?
  * linko selettore date a php
