#ifndef MAINWINDOW_H
#define MAINWINDOW_H

#include <QMainWindow>
#include <QTimer>
#include <QDateTime>
#include <QProcess>
#include <QPixmap>
#include <QStringList>
#include <QJsonDocument>
#include <QJsonArray>
#include <QJsonObject>
#include <QFile>
#include <QNetworkInterface>
#include <QHostAddress>
#include <QLabel>
#include <QHBoxLayout>

namespace Ui {
class MainWindow;
}

class MainWindow : public QMainWindow
{
    Q_OBJECT

public:
    explicit MainWindow(QWidget *parent = nullptr);
    ~MainWindow();
private slots:
    void UpdateTime();
    void getWifiStrength();
    void getlocalIP();
    void getData();
private:

    Ui::MainWindow *ui;
    QTimer *timer = new QTimer(this);

};

#endif // MAINWINDOW_H
