/*
 * Copyright (C) 2018 Seeweb Srl
 *
 * This file is part of SeewebIoT.
 * SeewebIoT is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 2.1 of the License, or
 * (at your option) any later version.
 *
 * SeewebIoT is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with SeewebIoT.  If not, see <http://www.gnu.org/licenses/>.
 */

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
