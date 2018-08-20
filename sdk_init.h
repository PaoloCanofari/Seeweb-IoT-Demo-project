#ifndef SDK_INIT_H
#define SDK_INIT_H

#include <AstarteDeviceSDK.h>
#include <HemeraCore/Operation>

#include <QtCore/QDebug>
#include <QtCore/QDir>
#include <QObject>
#include <QtCore/QTimer>

namespace Hemera {
class Operation;
}

class QTimer;

class AstarteDeviceSDK;

class sdk_Init : public QObject //set class as public object
{
    Q_OBJECT

public:
    sdk_Init(int argc, char *argv[]);

    //public Astarte SDK object
    AstarteDeviceSDK *sdk;

    //device interface
    QByteArray interface = "INTERFACE_NAME_HERE";
    
    //device ID
    QString device = "DEVICE_ID_HERE";


private slots:
    void sendData();

    void checkInitResult(Hemera::Operation *op);
    void handleIncomingData(const QByteArray &interface, const QByteArray &path, const QVariant &value);
private:
    QTimer *timer = new QTimer();
};

#endif // SDK_INIT_H
