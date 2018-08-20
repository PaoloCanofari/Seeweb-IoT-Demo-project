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
