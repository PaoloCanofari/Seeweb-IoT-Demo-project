# Seeweb IoT project
## What is it?
SeewebIoT project is an example project with the aim of explain how to use Qt5, raspberry Pi and Astarte platform to build an IoT project. Even if you're not an expert, you'll be able to make your first IoT projet easily.
### Hardware used in this project

	1) Raspberry Pi zero
	2) Arduino NANO
	3) DHT22 humidity and temperature sensor
	4) MQ135 air quality sensor
	5) UV intensity sensor
	6) 5V to 3.3V logic converter circuit

### Software used in this project

	1) Astarte
	2) Astarte SDK for QT5
	3) QT5
	4) Arduino IDE
	5) POSTMAN

## Let's Start

### Introduction to interface

Interfaces define how data is exchanged over Astarte. For a Device to be capable of exchanging data into its Realm, its interfaces have to be registered into the Realm First.
Interfaces are described using JSON document. Each of them is identified by a unique name of maximum 128 characters, which must be a Reverse Domain Name.

```
{
	"interface name" : "com.test.InterfaceName",
	"version_major": 1,
	"version_minor": 0,
	[...]
}
```

Interfaces have a predefined type, which can be either property or datastream. Every Device in Astarte can have any number of interfaces of any different type.

**Datastream:** represents a mutable, ordered stream of data, with no concept of persistent or synchronization. This kind of interfaces should be used when dealing with	values such as a sensor samples, commands and events. Datastreams are stored as time series in the database, making them suitable for time span filtering and any other common time series operation, and they are not idempotent in the REST API semantics. Due to their nature, datastream interfaces have a number of additional properties which fine tune their behavior.

**Properties:** represent a persistent, stateful synchronized state with no concept of history and timestamping. Properties are useful when dialing with settings, states or policies/rules. They are stored in a key-value fashion, and grouped according to their interface, and they are idempotent in the REST API semantics. Rather than being able to act on a stream like in the datastream case, properties can be retrieved, or can be used as a trigger whenever they change. Values in a properties interface can be unset (or deleted according to the http jargon): to allow such a thing, the interface must have its allow_unset property set to true.

The owner of and interface has a write-only access to it, whereas other actors have read-only access. Interface ownership can be either `device` or `server`
Every interface must have an array of mappings. Each mapping describes an endpoint which is resolved to a path, it is strongly typed, and can have additional options. Any endpoint can support any number of parameters.

This is a list of every endpoint type suppported:

	- Double
	- Integer
	- boolean (true or false)
	- longInteger
	- string
	- binaryblob
	- datetime
	- doublearray

The following example is the JSON document which describes the interface used in this project:

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
          "description": "Introduced in minor 1, tells you if the device is awesome. Optional."
        }
      ],
      "interface_name": "com.my.Interface1"
    }
}

```


## Managing Interfaces

To manage interfaces we recommend to use Postman, which will make things easier and fasterd.

### Installing an interface

Once Postman is installed, select the POST protocol and write your path to interfaces. The right format for interfaces path is the following:

```
<realm name>.api.<your astarte domain>/v1/<realm name>/interfaces/
```

After typing the interface url, set the authorization type to `Bearer Token`, and insert your personal token (REALM type), you will get every necessary token after buying astarte service.

Now paste your JSON document which describes your interface in the `Body` section. Now send the call, it should return a 201 Created or an error. Most common failure causes are:

	- The interface alrastarteeady exists in this realm
	- The interface schema fails validation
	- The interfaces path is wrong

### Get a list of installed interfaces

To get a list of installed interfaces, change the Postman protocol to GET, use the same interfaces Path and same authorization parameter. If the interfaces was successfully created, something like this will be returned:

```
{
	"data": [
		"com.api.realmName.interfaceName"
	]
}
```
if you add the interface name to the url you typed before, you'll get a list of all available major version number.
By adding also one of the major version number, you'll get the JSON document which describes the interface corresponding to that version.

### Updating an interface

Interfaces are supposed to change over time, and are dynamic. As such, they can be installed and updated. Interface installation means adding either a whole new interface (as in: an interface with a new name), or a new major version of an already known interface. Interface update means updating a specific, existing interface name/major version with a new minor version.

A Realm can hold any number of interfaces and any number of major versions of a single interface. It holds, however, only the latest installed minor version of each major version, due to the inherent compatibility of Semantic Versioning

To update an interface, issue a PUT protocol, with the same installation parameters in `/interfaces/<name>/<major_version>` endpoint of the realm. The call will return 201 Created or an error.

#### Interface major version change

If a device upgrades one of its interfaces to a new major version, the previous interface is parked and its data remains dangling.
Every API call, trigger or reference to the interface will always target the major version declared in the introspection, regardless of the fact that a more recent version might have been installed in the realm.

In case of updating an interface, it's required to copy the updated JSON and paste it in the `/interfaces` folder in the client path, as `<interface Name>.json`.

## Triggers
Triggers in Astarte are the go-to mechanism for generating push events. In contrast with AppEngine’s REST APIs, Triggers allow users to specify conditions upon which a custom payload is delivered to a recipient, using a specific `action`, which usually maps to a specific transport/protocol, such as HTTP.

Each trigger is defined by two main components: `condition` and `action`.

#### Condition
A condition defines the event (or chain of events) upon which an action is triggered. Astarte monitors incoming events and triggers a corresponding action whenever there is a match.

#### Action
Actions are triggered by a matching condition. An Action defines how the event should be sent to the outer world (e.g. an http POST on a certain URL). In addition, most actions have a Payload, which carries the body of the event.

### Install a trigger
Installing a trigger is easy. Simply make a HTTP POST to your realm url (adding `/triggers`), with JSON document in the request body. Every official documentation about the JSON configuration of a trigger is available at [this link](https://docs.astarte-platform.org/snapshot/api/index.html?urls.primaryName=Realm%20Management%20API). In this configuration example, a POST will be sent to a URL of our choice every time our device connects to astarte.
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

###### NOTICE:
Due to how triggers work, it is fundamental to install the trigger before a device connects. Doing otherwise will cause the trigger to kick in at a later time, and as such no events will be streamed for a while.

## Getting ready to code Astarte client for straming data

### Installing necessary packages

To compile and install the Astarte SDK for QT5 framework, some packages are required: `libqt5serialport5-dev` `libmosquittopp-dev` `qt5-qmake` `qt5-default` `cmake` `build-essential` `libssl-dev` `git`. After installing those packages, download `Astarte Qt5 Device SDK` from GitHub:

```git clone https://github.com/astarte-platform/astarte-device-sdk-qt5 ```

After downloading the sdk, move inside its folder and run the following commands to build and install it:
```
$ mkdir build
$ cd build
$ cmake -DCMAKE_INSTALL_PREFIX=/usr ..
$ make
# make install
```
### Generate the device ID and  create config file
Each device must be provided with an ID that can be generated by running `./generate-astarte-device-id`. Copy it and create a new folder for config file.
```
$ mkdir astarte-device-DEVICE_ID_HERE-conf
```
Now is necessary to create a new config file for astarte, named `transport-astarte.conf`, containing the following text:
```
[AstarteTransport]
agentKey=AGENT_KEY_HERE
endpoint=https://PAIRING_HOST_HERE/v1/REALM_HERE
persistencyDir=PERSISTENCY_DIR_HERE
```
Write the realm token in `agentKey=`.
Write your realm endpoint in `endpoint=`.
Write your persistencyDir in `persistencyDir=`, it must always exist because when the client will be registered to astarte by the SDK, every authentication file will be stored there. If `persistencyDir` folder will be deleted, the device won't be able to authenticate, and a QNetwork error will be returned by the client.

### Writing a client for Astarte
#### First initialize your device:
When a Device connects successfully, it must subscribe to its server Interfaces. The SDK takes care of this detail and exposes a higher level interface.
Create a new Qt5 project and add the Astarte's libraries in the .pro file:
```
//Astarte Device SDK path
INCLUDEPATH += /usr/include/AstarteDeviceSDKQt5

//Add astarte necessary libraries
LIBS += -lmosquitto
LIBS += -lmosquittopp
LIBS += -lAstarteDeviceSDKQt5
```
Now add the header file in your main class:
```
#include <AstarteDeviceSDK.h>
#include <HemeraCore/Operation>
```

At this point, everything is ready to start writing the code! Here's a little example from our code:

```
sdk_Init::sdk_Init(){			//main function

    m_sdk = new AstarteDeviceSDK(QStringLiteral("/path/to/transport-astarte.conf"), QStringLiteral("/path/to/interfaces"), deviceId);
    connect(m_sdk->init(), &Hemera::Operation::finished, this, &AstarteStreamQt5Test::checkInitResult);
    connect(m_sdk, &AstarteDeviceSDK::dataReceived, this, &AstarteStreamQt5Test::handleIncomingData);
}

void sdk_Init::sendData(){
    qDebug() << "Ready to send!";
		m_sdk->sendData(interface, path, value);
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

It's also possibile to call `sendData(interface, path, value)` function in another class by passing the `m_sdk `object. This method has been used in our code, which first reads the json file in `data/data.json` (created by `data_collector.py`).

### Collecting data from arduino through serial

After assembling the circuit (available in `circuit/`) and uploading code to arduino, launch the script `data_collector.py` using python3 interpreter. If the script reads arduino data without errors, you can start your astarte client.
