# milanochesuona
Aggregatore di concerti a Milano

Linne generali

***** Database
	- Evento
		+ Id
		+ Data e ora  
		+ IdVenue (nullable)
		+ Nome Venue (fillato automaticamente se uno mette il venue)
		+ Indirizzo (fillato automaticamente se uno mette il venue)
		+ Link Evento
		+ Genere (tag)
		+ Immagine evento (link o dl?)
		+ Descrizione
		+ Costo
	- EventoBand
		+ IdEvento
		+ IdBand
	- Band
		+ Nome
		+ Link
		+ Genere/i
		+ Descrizione
		+ Immagine band (link o dl?)
	- Venue
		+ Nome
		+ Indirizzo
		+ Link
		+ Descrizione
	- Generi
		+ Id

***** Funzionalità (motivare da use cases)
	Ogni concerto deve avere un giorno (1)
	Possibilità di filtrare per giorno (1)
	Possibilità(o obbligo) di accorpare rassegne / festival all'interno dello stesso giorno
	Database venues - solo per funzionalità di background
	Database gruppi - solo per funzionalità di background
	Database eventi - back e front
	L'elenco "calendario" nella pagina principale è generato dinamicamente, così come le pagine dei singoli eventi filtrando dal database
	
***** Casi d'uso
	1. Visualizzazione 
		1.a - voglio semplicemente visualizzare la lista di cosa succede oggi o nei giorni successivi 
	
	2. Inserimento
	voglio inserire un concerto. Apro pagina di form inserimento. Devo mettere il nome dell'evento, il/i gruppo/i, la location, l'orario. Opzionali: link evento, immagine, link gruppo/i, genere.

***** Note
	- Un evento deve essere identificato da un luogo ed un giorno. Se una tal rassgna in un tal giorno avviene in più luoghi bisognerà creare più eventi.
	- Per venue si intende sia un locale. Se un evento non è in un locale metto l'indirizzo e lascio vuoto il campo venue
