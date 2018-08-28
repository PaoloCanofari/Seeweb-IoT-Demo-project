# Guida all'utilizzo di SeewebIoT
Questa guida ha lo scopo di spiegare come utilizzare il servizio SeewebIoT fornito da Seeweb per realizzare progetti IoT. Nello specifico, verrà utilizzato un progetto dimostrativo per facilitare la comprensione della guida.
Una volta acquistato il servizio, verranno forniti tutte le credenziali necessarie citate nel corso della guida.

## Configurazione della piattaforma

### Introduzione alle interfacce
Le interfacce definiscono il modo in cui i dati vengono scambiati con la piattaforma. Affinché un Dispositivo possa scambiare dati con la piattaforma, è necessario prima installare le interfacce all'interno del Realm.

Le interfacce vengono descritte attraverso un documento in formato JSON. Ognuna di essa è identificata da un nome unico di tipo `Reverse Domain` di massimo 128 caratteri.

```
{
	"interface name" : "com.test.InterfaceName",
	"version_major": 1,
	"version_minor": 0,
	[...]
}
```

Le interfacce possono essere di due tipi diversi: `Datastream` o `Properties`

**Datastream:** Rappresenta un ordinato streaming di dati mutabile, senza alcun concetto di sincronizzazione o dati persistenti.
Questo tipo di interfacce dovrebbe essere usato quando si tratta di valori come campioni di sensori, comandi ed eventi.
I datastreams sono archiviati come serie temporali nel database, rendendoli adatti per il time span filtering e qualsiasi altra operazione di serie temporali comune e non sono idempotenti nella semantica dell'API REST. A causa della loro natura, le interfacce del flusso di dati hanno un numero di proprietà aggiuntive che ottimizzano il loro comportamento.

**Properties:** rappresentano uno stato sincronizzato persistente e statico senza alcun concetto di cronologia e timestamping. Le proprietà sono utili quando si effettua la composizione con impostazioni, stati o norme / regole. Sono memorizzati in modo key-value e raggruppati in base alla loro interfaccia e sono idempotenti nella semantica dell'API REST. Anziché essere in grado di agire su un flusso come nel caso del flusso di dati, è possibile recuperare le proprietà o utilizzarle come trigger ogni volta che cambiano. I valori nell'interfaccia di proprietà possono essere disinseriti (o cancellati in base al gergo http): per consentire una cosa del genere, l'interfaccia deve avere la proprietà allow_unset impostata su true.

Il proprietario di un'interfaccia ha accesso di sola scrittura ad essa, mentre altri attori hanno accesso di sola lettura. La proprietà dell'interfaccia può essere `dispositivo` o` server`.
Ogni interfaccia deve avere una matrice di mapping. Ogni mappatura descrive un endpoint che viene risolto in un percorso, è fortemente digitato e può avere opzioni aggiuntive. Qualsiasi endpoint può supportare qualsiasi numero di parametri.

Di seguito una lista dei tipi di endpoint supportati.

* Double
* Integer
* boolean (true or false)
* longInteger
* string
* binaryblob
* datetime
* doublearray

Di seguito un documento JSON che descrive un' interfaccia di esempio:

```
{
    "data": {
      "version_minor": 2,
      "version_major": 0,
      "type": "properties",
      "ownership": "device",
      "mappings": [
        {
          "type": "integer",
          "path": "/myValue",
          "description": "This is quite an important value."
        },
        {
          "type": "integer",
          "path": "/myBetterValue",
          "description": "A better revision, introduced in minor 2, supported only by some devices"
        },
        {

          "type": "boolean",
          "path": "/awesome",
          "allow_unset": true,
          "description": "Introduced in minor 1, tells you if device is awesome. Optional."
        }
      ],
      "interface_name": "com.my.Interface1"
    }
}
```

## Gestione delle interfacce
In questa parte della guida viene utilizzato Postman per velocizzare e semplificare l'uso di richieste HTTP.
### Installazione di un'interfaccia
All'interno di Postman selezionare il tipo di richiesta `POST` e scrivere l'URL contenente il percorso alla propria interfaccia. Il formato corretto per l'URL da utilizzare è il seguente:

```
<realm name>.api.<your astarte domain>/v1/<realm name>/interfaces/
```
Dopo aver inserito l'URL corretto, impostare il tipo di autorizzazione su `Baerer Token` e inserire il proprio token per l'accesso al REALM fornito al momento dell' acquisto.

Nella sezione `Body` della richiesta, inserire il documento JSON descrivente la propria interfaccia. A questo punto è possibilie inviare la richiesta. La risposta sarà `201 Created` oppure un errore. Le cause più comuni agli errori possono essere:
* L'interfaccia esiste già nel realm
* Il documento JSON per la descrizione dell'interfaccia non è valido
* Il percorso dell'interfaccia è errato

### Ottenere la lista delle interfacce installate
Per ottenere una lista delle interfacce installate, cambiare il tipo di richiesta in `GET`, utilizzando l'URL e il token inseriti in precedenza. Se l'interfaccia è stata creata con successo, si otterrà una risposta di questo tipo:

```
{
	"data": [
		"com.api.realmName.interfaceName"
	]
}
```
Se all'URL si aggiunge il nome dell'interfaccia, si otterrà una lista delle versioni disponibili. Se al nome dell'interfaccia si aggiunge il numero della versione, si otterrà come risposta un documento JSON che descrive l'interfaccia corrispondente alla versione inserita.

### Aggiornare un'interfaccia

Le interfacce potrebbero cambiare nel tempo e sono dinamiche. In quanto tali, possono essere installate o aggiornate. Per installazione dell'interfaccia si intende aggiungere un'interfaccia completamente nuova. Per aggiornamento dell'interfaccia si intende l'aggiornamento di un'interfaccia esistente attraverso la creazione di una nuova versione primaria (major_version) o di una nuova versione secondaria (minor_version).

Un realm può contenere qualsiasi numero di interfacce e qualsiasi numero di versioni principali di una singola interfaccia. Esso detiene, tuttavia, solo l'ultima versione secondaria installata di ciascuna versione principale, a causa alla compatibilità intrinseca di Versioning semantico.

Per aggiornare un'interfaccia, basta eseguire una richiesta HTTP di tipo PUT con postman nel seguente endpoint del realm `/interfaces/<name>/<major_version>`. Verrà restituita un codice `201 Created` o un errore.

#### Installazione di una nuova interfaccia principale (major version)

Se l'interfaccia di un device viene aggiornata ad una nuova versione maggiore, quella precedente viene archiviata e la ricezione dei dati tramite essa viene sospesa. Ogni chiamata API, trigger o riferimento all'interfaccia sarà sempre indirizzata alla versione principale dichiarata nell'introspezione, indipendentemente dal fatto che una versione più recente potrebbe essere stata installata nel reame.
L'introspezione dell'interfaccia per ogni device deve essere inserita in formato JSON nell cartella `/interfaces`, situata nello stesso percorso del file di esecuzione del client.

## Triggers
I trigger sono il meccanismo per la generazione di eventi push. Essi consentono agli utenti di specificare le condizioni in base alle quali un carico utile personalizzato viene consegnato a un destinatario, utilizzando una specifica `azione`, che di solito si associa a uno specifico protocollo di trasporto, come HTTP.

Ogni trigger viene definito da due principali componenti: **condizione** (`condition`) e **azione** (`action`).

#### Condizione
Una condizione definisce l'evento (o la catena di eventi) per cui viene attivata un'azione. Astarte monitora gli eventi in arrivo e attiva un'azione corrispondente ogni volta che c'è una corrispondenza alla condizione.
#### Azione
Un'azione definisce il modo in cui un evento dovrebbe essere inviato all'esterno (es. una richiesta HTTP POST su un certo URL). Inoltre, molte azioni hanno un payload che contiene il body dell'evento.

### Installazione di un trigger
installare un trigger è semplice: basta effettuare una richiesta HTTP POST con Postman all' endpoint `/triggers` del percorso del realm, con un documento JSON nel body della richiesta. Tutta la documentazione ufficiale sulla configurazione dei trigger è disponibile a questo [link](https://docs.astarte-platform.org/snapshot/api/index.html?urls.primaryName=Realm%20Management%20API). Nella seguente configurazione di esempio, viene effettuata una richiesta POST ogni volta che il device si connette alla piattaforma.

```
{
    "data": {
        "simple_triggers": [
            {
                "type": "device_trigger",
                "on": "device_connected",
                "device_id": "YOUR_ID_HERE"
            }
        ],
        "name": "mytrigger_seewebIoT",
        "action": {
            "http_post_url": "http://example.com"
        }
    }
}
```

###### NOTA:
Perché i trigger funzionino, è fondamentale installarli prima che il device si connetta. In caso contrario l'attivazione del trigger verrà ritardata.

### Ottenere i dati dal proprio Realm

Per ottenere i dati dal proprio Realm, eseguire una richiesta HTTP GET al seguente url, utilizzado il token per l'autenticazione di `AppEngine`:

`<realm name>.api.<your astarte domain>/v1/<realm name>/devices/<your deviceid>/interfaces/<interfaceName>/<DataPath>`

Si otterrà una risposta contenente un documento in formato JSON contenente tutti i dati inviati correttamente dal device attraverso l'interfacicia dichiarata.

## Scrivere il client

### Installazione dei pacchetti necessari su Raspberry

Per compilare il client di invio dati ad Astarte, sono necessari i seguenti pacchetti: `pip` `libqt5serialport5-dev` `libmosquittopp-dev` `qt5-qmake` `qt5-default` `cmake` `build-essential` `libssl-dev` `git` `pyserial (sudo pip install pyserial)`. Una volta installati tutti i pacchetti necessari, bisogna scaricare e compilare l'SDK per QT5 di Astarte.

```
$ git clone https://github.com/astarte-platform/astarte-device-sdk-qt5
$ cd astarte-device-sdk-qt5/
$ mkdir build
$ cd build
$ cmake -DCMAKE_INSTALL_PREFIX=/usr ..
$ make
$ make install
```

### Generare il device ID e creare il file di configurazione
Ogni device deve essere provvisto di un ID che può essere generato eseguendo `./generate-astarte-device-id`. Copiare l'ID generato e creare una nuova cartella per il file di configurazione:
```
$ mkdir astarte-device-DEVICE_ID_HERE-conf
 ```
Ora è necessario creare il file di configurazione `transport-astarte.conf`, contenente il testo seguente:

```
[AstarteTransport]
agentKey=AGENT_KEY_HERE
endpoint=https://PAIRING_HOST_HERE/v1/REALM_HERE
persistencyDir=PERSISTENCY_DIR_HERE
```
Inserire il proprio token per l'accesso al realm in `agentKey=`.
Scrivere l'url del realm in `endpoint=`.
Scrivere il percorso a una cartella persistente in `persistencyDir=`, questa dovrà sempre esistere dato che i file di configurazione del device verranno salvati qui. Se la cartella verrà eliminata o né verrà cambiato il percorso, il device non sarà più in grado di autenticarsi ad astarte tramite l'ID corrente.

A questo punto, bisogna creare l'introspezione dell'interfaccia nella cartella `/interfaces` inserendo il documento JSON che la descrive come `<InterfaceName>.json`.

###### NOTA:
La seguente parte della guida richiede conoscenze di C++ in ambiente QT5, in caso di difficoltà è stato reso open source il codice per un client pronto all'uso. Per la guida al suo utilizzo, saltare alla sezione `B`.

### A) Scrivere un client per astarte
#### Inizializzare l'interfaccia del server
Quando un device si connette correttamente, deve registrarsi all'interfaccia creata sul server. L'SDK si occupa di questo dettaglio e permette di velocizzare e semplificare il processo di scrittura del codice tramite disponendo di un'interfaccia di livello più alto.
Creare un nuovo progetto in QT5 e aggiungere i percorsi alle librerie necessarie nel file .pro:

```
//Astarte Device SDK path
INCLUDEPATH += /usr/include/AstarteDeviceSDKQt5

//Add astarte necessary libraries
LIBS += -lmosquitto
LIBS += -lmosquittopp
LIBS += -lAstarteDeviceSDKQt5
```
A questo punto aggiungiamo l'header della libreria:
```
#include <AstarteDeviceSDK.h>
#include <HemeraCore/Operation>
```
A questo punto, è tutto pronto per iniziare a scrivere il codice del client! Di seguito vi è un esempio tratto dal nostro repository:
```
#include "sdk_init.h"
#include "data_sender.h"

sdk_Init::sdk_Init(int argc, char *argv[])
{
    timer->setInterval(60000);

    //connect timer timeout event to SendData() function
    connect(timer, &QTimer::timeout, this, &sdk_Init::sendData);

    //Initialize sdk object
    sdk = new AstarteDeviceSDK(QDir::currentPath() + QStringLiteral("/astarte-device-%1-conf/transport-astarte.conf").arg(device), QDir::currentPath() + QStringLiteral("/interfaces"), device.toLatin1());

    //when device is connected without errors, start the timer
    connect(sdk->init(), &Hemera::Operation::finished, this, &sdk_Init::checkInitResult);

    //handle the incoming data from Astarte
    connect(sdk, &AstarteDeviceSDK::dataReceived, this, &sdk_Init::handleIncomingData);
}

void sdk_Init::sendData(){

    //call datasender class object
    data_sender *datasender = new data_sender(this);
}

void sdk_Init::checkInitResult(Hemera::Operation *op){
    if(op->isError())
    {
        qWarning() << "AstarteStreamQt5Test init error: " << op->errorName() << op->errorMessage();
    }else {
	sendData();
        timer->start();
    }
}

void sdk_Init::handleIncomingData(const QByteArray &interface, const QByteArray &path, const QVariant &value){
    qDebug() << "Received data, interface: " << interface << "path: " << path << ", value: " << value << ", Qt type name: " << value.typeName();

}
```
E' possibile chiamare la funzione `sendData(interface, path, value)` in un'altra classe, utilizzando un puntatore all'oggetto `m_sdk`.

### B) Utilizzare il client open source pronto all'uso

Utilizzare il codice fornito nel repository è il modo più semplice per iniziare a interagire con il proprio realm, dopo aver seguito copiato il contenuto del percorso `/src/client/` su Raspberry PI. Questo software leggerà ad intervalli di 60 secondi il contenuto del file `/data/data.json` che dovrà contenere i dati dei sensori inviati da arduino in formato JSON via seriale, invierà ogni dato letto all'interfaccia dichiarata, nel percorso corrispondente al nome dell'indice di ogni valore.
Per impostare l' ID del device e il nome dell'interfaccia, modificare il file `sdk_init.h`.
Una volta finito, compilare il codice con i seguenti comandi:

```
$ qmake
$ make
```
## Realizzare il progetto di esempio

### Assemblare il circuito
Lo schema del circuito e il codice per arduino sono disponibili in `/src/arduino_code`. Il dispositivo monitorerà i valori di temperatura, umidità, intensità dei raggi UV e presenza di gas dannosi nell'aria, inviandoli via seriale a Raspberry Pi, quest'ultimo eseguendo lo script `data_collector.py` leggerà i valori restituiti da Arduino e dal sensore SDS011, salvandoli nel file `/data/data.json`.
