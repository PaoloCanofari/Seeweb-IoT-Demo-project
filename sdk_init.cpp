#include "sdk_init.h"
#include "data_sender.h"

sdk_Init::sdk_Init(int argc, char *argv[])
{
    timer->setInterval(60000);

    //connect timer timeout event to SendData() function
    connect(timer, &QTimer::timeout, this, &sdk_Init::sendData);

    //Initialize sdk object
    sdk = new AstarteDeviceSDK(QDir::currentPath() + QStringLiteral("/astarte-device-%1-conf/transport-astarte.conf").arg(device), QDir::currentPath() + QStringLiteral("/interfaces"), device.toLatin1());

    //qDebug() << "INITIALIZATION...";

    //when device is connected without errors, start the timer
    connect(sdk->init(), &Hemera::Operation::finished, this, &sdk_Init::checkInitResult);

    //handle the incoming data from Astarte
    connect(sdk, &AstarteDeviceSDK::dataReceived, this, &sdk_Init::handleIncomingData);
}

void sdk_Init::sendData(){

    //qDebug() << "Ready to send!";

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
