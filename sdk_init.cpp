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
