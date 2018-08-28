/*
 * Author: Paolo Canofari
 *
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

#ifndef DATA_SENDER_H
#define DATA_SENDER_H
#include "sdk_init.h"

#include <QObject>
#include <QDebug>
#include <QFile>

class data_sender : public QObject //set class as public object
{
    Q_OBJECT
public:
    data_sender(sdk_Init *s);
private:

    //create sdk_init object to use the Astarte's sdk object declared in that class
    sdk_Init *s;
};

#endif // DATA_SENDER_H
