#!/usr/bin/env python3
'''Author: Paolo Canofari

Copyright (C) 2018 Seeweb Srl

This file is part of SeewebIoT.
SeewebIoT is free software: you can redistribute it and/or modify
it under the terms of the GNU Lesser General Public License as published by
the Free Software Foundation, either version 2.1 of the License, or
(at your option) any later version.

SeewebIoT is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License
along with SeewebIoT.  If not, see <http://www.gnu.org/licenses/>.'''

import serial.tools.list_ports
import time
import serial
import json
import glob
import os

temp_list = glob.glob ('/dev/ttyUSB[0-9]') #list of every usb serial port

result = []

def read_nova_dust_sensor(device):
	dev = serial.Serial(device, 9600, dsrdtr=True, rtscts=True)

	if not dev.isOpen():
		dev.open()

	msg = dev.read(10)
	assert msg[0] == ord(b'\xaa')
	assert msg[1] == ord(b'\xc0')
	assert msg[9] == ord(b'\xab')
	pm25 = (msg[3] * 256 + msg[2]) / 10.0
	pm10 = (msg[5] * 256 + msg[4]) / 10.0
	checksum = sum(v for v in msg[2:8]) % 256
	assert checksum == msg[8]
	return ("\"pm10\": "+str(pm10) + ", \"pm2\": " + str(pm25))


def scan_ports():
	for a_port in temp_list: #for every usb serial port

		try:
			s = serial.Serial(a_port, 9600, dsrdtr=True, rtscts=True) #if connection opens without errors

			s.close()
			result.append(a_port) #append the current port to result list
		except serial.SerialException:
			pass
	print(result)


def writedata(data):
	file = open(os.getcwd() + "/data/data.json", "w")
	file.write(data)
	file.close()
	#print("Data printed correctly.")


def main():
	i = 0
	while i < len(result):

		ser = serial.Serial(result[i], 9600, dsrdtr=True, rtscts=True)
		print("Attempt to read")
		
		output = ser.read(20)
		print('Reading: ', output)

		if "Arduino".encode() in output:
			ser.write("OK".encode())
			print("Arduino found on port: ", result[i])

			while True:
				arduino_data = ser.readline().decode('ascii')
				print(arduino_data)
				nova_data = ""
				if i == 1:
					nova_data = read_nova_dust_sensor(result[0])
				elif i == 0:
					nova_data = read_nova_dust_sensor(result[1])
				writedata("{ " + arduino_data + "," + nova_data + " }")
		i = i + 1

scan_ports()
main()
