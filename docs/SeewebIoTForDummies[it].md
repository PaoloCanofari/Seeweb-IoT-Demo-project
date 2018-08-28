# Guida all'utilizzo di SeewebIoT
Questa guida ha lo scopo di spiegare come utilizzare il servizio SeewebIoT fornito da Seeweb per realizzare progetti IoT. Nello specifico, verrà utilizzato un progetto dimostrativo per facilitare la comprensione della guida.
Una volta acquistato il servizio, verranno forniti tutte le credenziali necessarie citate nel corso della guida.

## Configurazione della piattaforma

### Introduzione alle interfacce
Le interfacce definiscono il modo in cui i dati vengono scambiati con la piattaforma. Affinché un Dispositivo possa scambiare dati con la piattaforma, è necessario prima installare le interfacce all'interno del Realm.

Le interfacce vengono descritte attraverso un documento in formato JSON. Ognuna di essa è identificata da un nome unico di tipo `Reverse Domain` di massimo 128 caratteri.
