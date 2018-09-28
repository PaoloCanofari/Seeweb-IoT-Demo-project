/********************************************************************************
** Form generated from reading UI file 'mainwindow.ui'
**
** Created by: Qt User Interface Compiler version 5.11.1
**
** WARNING! All changes made in this file will be lost when recompiling UI file!
********************************************************************************/

#ifndef UI_MAINWINDOW_H
#define UI_MAINWINDOW_H

#include <QtCore/QVariant>
#include <QtWidgets/QApplication>
#include <QtWidgets/QFrame>
#include <QtWidgets/QGridLayout>
#include <QtWidgets/QHBoxLayout>
#include <QtWidgets/QLabel>
#include <QtWidgets/QMainWindow>
#include <QtWidgets/QSpacerItem>
#include <QtWidgets/QWidget>

QT_BEGIN_NAMESPACE

class Ui_MainWindow
{
public:
    QWidget *centralWidget;
    QFrame *frame;
    QHBoxLayout *horizontalLayout;
    QLabel *date;
    QSpacerItem *horizontalSpacer_3;
    QLabel *time;
    QSpacerItem *horizontalSpacer_2;
    QLabel *Ip;
    QSpacerItem *horizontalSpacer;
    QLabel *wifiImg;
    QWidget *gridLayoutWidget;
    QGridLayout *gridLayout;
    QLabel *noiselbl;
    QLabel *label_10;
    QLabel *label_8;
    QLabel *label_5;
    QSpacerItem *horizontalSpacer_5;
    QSpacerItem *horizontalSpacer_6;
    QLabel *lightlbl;
    QLabel *label_12;
    QLabel *pm2lbl;
    QLabel *aqilbl;
    QLabel *label_14;
    QLabel *pm10lbl;
    QSpacerItem *horizontalSpacer_4;
    QSpacerItem *horizontalSpacer_7;
    QLabel *label;
    QLabel *label_3;
    QLabel *humlbl;
    QLabel *templbl;
    QLabel *label_7;

    void setupUi(QMainWindow *MainWindow)
    {
        if (MainWindow->objectName().isEmpty())
            MainWindow->setObjectName(QStringLiteral("MainWindow"));
        MainWindow->resize(480, 320);
        MainWindow->setMinimumSize(QSize(480, 320));
        MainWindow->setMaximumSize(QSize(480, 320));
        centralWidget = new QWidget(MainWindow);
        centralWidget->setObjectName(QStringLiteral("centralWidget"));
        frame = new QFrame(centralWidget);
        frame->setObjectName(QStringLiteral("frame"));
        frame->setGeometry(QRect(0, 0, 480, 35));
        QSizePolicy sizePolicy(QSizePolicy::Expanding, QSizePolicy::Preferred);
        sizePolicy.setHorizontalStretch(0);
        sizePolicy.setVerticalStretch(0);
        sizePolicy.setHeightForWidth(frame->sizePolicy().hasHeightForWidth());
        frame->setSizePolicy(sizePolicy);
        frame->setMinimumSize(QSize(0, 0));
        frame->setFrameShape(QFrame::StyledPanel);
        frame->setFrameShadow(QFrame::Raised);
        horizontalLayout = new QHBoxLayout(frame);
        horizontalLayout->setSpacing(6);
        horizontalLayout->setContentsMargins(11, 11, 11, 11);
        horizontalLayout->setObjectName(QStringLiteral("horizontalLayout"));
        date = new QLabel(frame);
        date->setObjectName(QStringLiteral("date"));
        QFont font;
        font.setPointSize(12);
        date->setFont(font);

        horizontalLayout->addWidget(date);

        horizontalSpacer_3 = new QSpacerItem(40, 20, QSizePolicy::Expanding, QSizePolicy::Minimum);

        horizontalLayout->addItem(horizontalSpacer_3);

        time = new QLabel(frame);
        time->setObjectName(QStringLiteral("time"));
        time->setFont(font);

        horizontalLayout->addWidget(time);

        horizontalSpacer_2 = new QSpacerItem(40, 20, QSizePolicy::Expanding, QSizePolicy::Minimum);

        horizontalLayout->addItem(horizontalSpacer_2);

        Ip = new QLabel(frame);
        Ip->setObjectName(QStringLiteral("Ip"));
        Ip->setFont(font);

        horizontalLayout->addWidget(Ip);

        horizontalSpacer = new QSpacerItem(40, 20, QSizePolicy::Expanding, QSizePolicy::Minimum);

        horizontalLayout->addItem(horizontalSpacer);

        wifiImg = new QLabel(frame);
        wifiImg->setObjectName(QStringLiteral("wifiImg"));
        wifiImg->setFont(font);

        horizontalLayout->addWidget(wifiImg);

        gridLayoutWidget = new QWidget(centralWidget);
        gridLayoutWidget->setObjectName(QStringLiteral("gridLayoutWidget"));
        gridLayoutWidget->setGeometry(QRect(0, 30, 481, 291));
        gridLayoutWidget->setFont(font);
        gridLayout = new QGridLayout(gridLayoutWidget);
        gridLayout->setSpacing(6);
        gridLayout->setContentsMargins(11, 11, 11, 11);
        gridLayout->setObjectName(QStringLiteral("gridLayout"));
        gridLayout->setContentsMargins(0, 0, 0, 0);
        noiselbl = new QLabel(gridLayoutWidget);
        noiselbl->setObjectName(QStringLiteral("noiselbl"));
        QFont font1;
        font1.setBold(true);
        font1.setWeight(75);
        noiselbl->setFont(font1);
        noiselbl->setStyleSheet(QStringLiteral("font-weight: bold"));

        gridLayout->addWidget(noiselbl, 3, 5, 1, 1);

        label_10 = new QLabel(gridLayoutWidget);
        label_10->setObjectName(QStringLiteral("label_10"));
        label_10->setFont(font);

        gridLayout->addWidget(label_10, 4, 1, 1, 1);

        label_8 = new QLabel(gridLayoutWidget);
        label_8->setObjectName(QStringLiteral("label_8"));
        label_8->setFont(font);

        gridLayout->addWidget(label_8, 3, 4, 1, 1);

        label_5 = new QLabel(gridLayoutWidget);
        label_5->setObjectName(QStringLiteral("label_5"));
        label_5->setFont(font);

        gridLayout->addWidget(label_5, 2, 4, 1, 1);

        horizontalSpacer_5 = new QSpacerItem(40, 20, QSizePolicy::Expanding, QSizePolicy::Minimum);

        gridLayout->addItem(horizontalSpacer_5, 4, 0, 1, 1);

        horizontalSpacer_6 = new QSpacerItem(40, 20, QSizePolicy::Expanding, QSizePolicy::Minimum);

        gridLayout->addItem(horizontalSpacer_6, 4, 6, 1, 1);

        lightlbl = new QLabel(gridLayoutWidget);
        lightlbl->setObjectName(QStringLiteral("lightlbl"));
        lightlbl->setFont(font1);
        lightlbl->setStyleSheet(QStringLiteral("font-weight: bold"));

        gridLayout->addWidget(lightlbl, 2, 5, 1, 1);

        label_12 = new QLabel(gridLayoutWidget);
        label_12->setObjectName(QStringLiteral("label_12"));
        label_12->setFont(font);

        gridLayout->addWidget(label_12, 4, 4, 1, 1);

        pm2lbl = new QLabel(gridLayoutWidget);
        pm2lbl->setObjectName(QStringLiteral("pm2lbl"));
        pm2lbl->setFont(font1);
        pm2lbl->setStyleSheet(QStringLiteral("font-weight: bold"));

        gridLayout->addWidget(pm2lbl, 4, 2, 1, 1);

        aqilbl = new QLabel(gridLayoutWidget);
        aqilbl->setObjectName(QStringLiteral("aqilbl"));
        aqilbl->setFont(font1);
        aqilbl->setStyleSheet(QStringLiteral("font-weight: bold"));

        gridLayout->addWidget(aqilbl, 4, 5, 1, 1);

        label_14 = new QLabel(gridLayoutWidget);
        label_14->setObjectName(QStringLiteral("label_14"));
        label_14->setFont(font);

        gridLayout->addWidget(label_14, 5, 1, 1, 1);

        pm10lbl = new QLabel(gridLayoutWidget);
        pm10lbl->setObjectName(QStringLiteral("pm10lbl"));
        pm10lbl->setFont(font1);
        pm10lbl->setStyleSheet(QStringLiteral("font-weight: bold"));

        gridLayout->addWidget(pm10lbl, 5, 2, 1, 1);

        horizontalSpacer_4 = new QSpacerItem(40, 20, QSizePolicy::Expanding, QSizePolicy::Minimum);

        gridLayout->addItem(horizontalSpacer_4, 0, 1, 1, 1);

        horizontalSpacer_7 = new QSpacerItem(40, 20, QSizePolicy::Expanding, QSizePolicy::Minimum);

        gridLayout->addItem(horizontalSpacer_7, 4, 3, 1, 1);

        label = new QLabel(gridLayoutWidget);
        label->setObjectName(QStringLiteral("label"));

        gridLayout->addWidget(label, 5, 4, 1, 1);

        label_3 = new QLabel(gridLayoutWidget);
        label_3->setObjectName(QStringLiteral("label_3"));
        label_3->setFont(font);

        gridLayout->addWidget(label_3, 3, 1, 1, 1);

        humlbl = new QLabel(gridLayoutWidget);
        humlbl->setObjectName(QStringLiteral("humlbl"));
        humlbl->setFont(font1);
        humlbl->setStyleSheet(QStringLiteral("font-weight: bold"));

        gridLayout->addWidget(humlbl, 3, 2, 1, 1);

        templbl = new QLabel(gridLayoutWidget);
        templbl->setObjectName(QStringLiteral("templbl"));
        templbl->setFont(font1);
        templbl->setStyleSheet(QStringLiteral("font-weight: bold"));

        gridLayout->addWidget(templbl, 2, 2, 1, 1);

        label_7 = new QLabel(gridLayoutWidget);
        label_7->setObjectName(QStringLiteral("label_7"));
        label_7->setFont(font);

        gridLayout->addWidget(label_7, 2, 1, 1, 1);

        MainWindow->setCentralWidget(centralWidget);

        retranslateUi(MainWindow);

        QMetaObject::connectSlotsByName(MainWindow);
    } // setupUi

    void retranslateUi(QMainWindow *MainWindow)
    {
        MainWindow->setWindowTitle(QApplication::translate("MainWindow", "MainWindow", nullptr));
        date->setText(QString());
        time->setText(QString());
        Ip->setText(QString());
        wifiImg->setText(QString());
        noiselbl->setText(QApplication::translate("MainWindow", "0", nullptr));
        label_10->setText(QApplication::translate("MainWindow", "PM 10 : ", nullptr));
        label_8->setText(QApplication::translate("MainWindow", "Noise: ", nullptr));
        label_5->setText(QApplication::translate("MainWindow", "Light Percentage:", nullptr));
        lightlbl->setText(QApplication::translate("MainWindow", "0", nullptr));
        label_12->setText(QApplication::translate("MainWindow", "Air Pollution: ", nullptr));
        pm2lbl->setText(QApplication::translate("MainWindow", "0", nullptr));
        aqilbl->setText(QApplication::translate("MainWindow", "0", nullptr));
        label_14->setText(QApplication::translate("MainWindow", "PM 2.5:", nullptr));
        pm10lbl->setText(QApplication::translate("MainWindow", "0", nullptr));
        label->setText(QApplication::translate("MainWindow", "TextLabel", nullptr));
        label_3->setText(QApplication::translate("MainWindow", "<html><head/><body><p>Humidity:</p></body></html>", nullptr));
        humlbl->setText(QApplication::translate("MainWindow", "0", nullptr));
        templbl->setText(QApplication::translate("MainWindow", "0", nullptr));
        label_7->setText(QApplication::translate("MainWindow", "Temperature: ", nullptr));
    } // retranslateUi

};

namespace Ui {
    class MainWindow: public Ui_MainWindow {};
} // namespace Ui

QT_END_NAMESPACE

#endif // UI_MAINWINDOW_H
