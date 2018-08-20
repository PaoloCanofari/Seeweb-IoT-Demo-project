#include <QCoreApplication>
#include <QDebug>

#include <QObject>

#include "sdk_init.h"

int main(int argc, char *argv[])
{
    QCoreApplication a(argc, argv);

    //call sdk_Init main function
    sdk_Init sdk(argc, argv);

    return a.exec();

}
