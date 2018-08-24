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

#include "data_sender.h"

#include <QJsonDocument>
#include <QJsonObject>
#include <QJsonArray>
#include <QIODevice>

data_sender::data_sender(sdk_Init *s)
{
    //new QFile object
    QFile file;
    file.setFileName(QDir::currentPath() + "/data/data.json");  //Set the data.json path
    file.open(QIODevice::ReadOnly | QIODevice::Text);   //Open the file streaming in read only mode
    QString json_data = file.readAll();     //read the file and store it in a variable
    file.close(); //close the file streaming

//    qDebug() << json_data.toLatin1().data();

    QJsonDocument json_doc = QJsonDocument::fromJson(json_data.toUtf8()); //Encode to json_document using QJsonDocument object
    QJsonObject json_obj = json_doc.object(); //create a Json object from the encoded document

    //for every key in json_object, grab the value
    foreach (const QString& key, json_obj.keys()) {

        QJsonValue value = json_obj.value(key);

        //print the key name and its value
        qDebug() << "Key = " << key << ", Value = " << value.toString();

        //send the data to Astarte using the sdk_init object (declared in the header file)
        s->sdk->sendData(s->interface, QByteArray("/").append(key), value, QDateTime::currentDateTime());
    }

}

