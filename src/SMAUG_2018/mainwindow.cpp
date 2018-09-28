#include "mainwindow.h"
#include "ui_mainwindow.h"

MainWindow::MainWindow(QWidget *parent) :
    QMainWindow(parent),
    ui(new Ui::MainWindow)
{
    ui->setupUi(this);

    UpdateTime();
    ui->frame->resize(this->width(), 40);
    ui->frame->setStyleSheet("background: #6ba3ff");

    //insert date and time inside the appropriate label
    ui->date->setText(QDateTime::currentDateTime().toString("dd:MM:yyyy"));
    ui->time->setText(QDateTime::currentDateTime().toString("hh:mm:ss"));

    //set logo

    QPixmap logo(":/icons/logo.png");
    ui->label->setPixmap(logo);

    connect(timer, SIGNAL(timeout()), this, SLOT(UpdateTime()));
    timer->start(50);
}

MainWindow::~MainWindow()
{
    delete ui;
}

void MainWindow::UpdateTime(){

    ui->time->setText(QDateTime::currentDateTime().toString("hh:mm:ss"));
    ui->date->setText(QDateTime::currentDateTime().toString("dd:MM:yyyy"));

    getlocalIP();
    getWifiStrength();
    getData();

}

void MainWindow::getWifiStrength(){

    //Uses iwconfig output to get signal strenght and chooses a correct image for wifi label

    QProcess proc;
    QString cmd = "iwconfig wlan0 | grep Signal | cut -d \"=\" -f3 | cut -d\" \" -f1";
    proc.start("bash", QStringList()<< "-c" << cmd);
    proc.waitForFinished(-1);

    QString out = proc.readAllStandardOutput();
    int level = out.toInt();
    QPixmap max(":/icons/wifi1.png");
    QPixmap medium(":/icons/wifi2.png");
    QPixmap low(":/icons/wifi3.png");
    QPixmap ultraLow(":/icons/wifi4.png");

    if(level > -50 && level < 0){
        ui->wifiImg->setPixmap(max);
    }
    else if(level <= -50 && level > -60){
        ui->wifiImg->setPixmap(medium);
    }
    else if(level <= -60 && level > -70){
        ui->wifiImg->setPixmap(low);
    }
    else if(level <= -70){
        ui->wifiImg->setPixmap(ultraLow);
    }
    else{
        ui->wifiImg->setStyleSheet("color:red; font-weight: bold");
        ui->wifiImg->setText("No SIGNAL!");

    }

}

void MainWindow::getlocalIP(){
    //get local ip address
    foreach (const QHostAddress &address, QNetworkInterface::allAddresses()) {

        if (address.protocol() == QAbstractSocket::IPv4Protocol && address != QHostAddress(QHostAddress::LocalHost)){
            ui->Ip->setText(address.toString());
        }
    }
}

void MainWindow::getData(){
    //get data from data/data.json file
    QStringList propertyNames;
    QStringList propertyKeys;

    QFile data("data/data.json");
    data.open(QFile::ReadOnly);

    QString read = QString(data.readAll());
    // qDebug() << read;

    QJsonDocument json = QJsonDocument::fromJson(read.toUtf8());
    QJsonObject jsonObject = json.object();

    QStringList array = jsonObject.keys();

    foreach(const QString &key, array){

        //get value for each key and put
        QJsonValue val = jsonObject.value(key);
        QString textVal = QString::number(val.toDouble());

        //insert value inside appropriate label
        if(key == "humidity"){
            ui->humlbl->setText(textVal + " %");
        }
        else if(key == "temperature"){
            ui->templbl->setText(textVal + " °C");
        }
        else if(key == "pm2"){
            ui->pm2lbl->setText(textVal + " mg/m³");
        }
        else if(key == "pm10"){
            ui->pm10lbl->setText(textVal + " mg/m³");
        }
        else if(key == "aqi"){
            ui->aqilbl->setText(textVal + " PPM");
        }
        else if(key == "lightInt"){
            ui->lightlbl->setText(textVal + " %");
        }
        else if(key == "noise"){
            ui->noiselbl->setText(textVal + " Db");
        }
    }

}
