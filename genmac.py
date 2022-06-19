#!/usr/bin/python

import random

def randomMAC1():
	mac1 = [ 0xF4, 0xCA, 0xE5,
		random.randint(0x00, 0x7f),
		random.randint(0x00, 0xff),
		random.randint(0x00, 0xff) ]
	return ':'.join(map(lambda x: "%02x" % x, mac1))

def randomMAC2():
	mac2 = [ 0x76, 0x75, 0x71,
		random.randint(0x00, 0x7f),
		random.randint(0x00, 0xff),
		random.randint(0x00, 0xff) ]
	return ':'.join(map(lambda x: "%02x" % x, mac2))

def randomMAC3():
	mac3 = [ 0xA6, 0xE7, 0x57,
		random.randint(0x00, 0x7f),
		random.randint(0x00, 0xff),
		random.randint(0x00, 0xff) ]
	return ':'.join(map(lambda x: "%02x" % x, mac3))

def randomMAC4():
	mac4 = [ 0x62, 0x98, 0x5C,
		random.randint(0x00, 0x7f),
		random.randint(0x00, 0xff),
		random.randint(0x00, 0xff) ]
	return ':'.join(map(lambda x: "%02x" % x, mac4))

def randomMAC5():
	mac5 = [ 0x00, 0x24, 0xD4,
		random.randint(0x00, 0x7f),
		random.randint(0x00, 0xff),
		random.randint(0x00, 0xff) ]
	return ':'.join(map(lambda x: "%02x" % x, mac5))

def randomMAC6():
	mac6 = [ 0x16, 0xB0, 0x28,
		random.randint(0x00, 0x7f),
		random.randint(0x00, 0xff),
		random.randint(0x00, 0xff) ]
	return ':'.join(map(lambda x: "%02x" % x, mac6))
#
print(randomMAC1() + " , " + randomMAC2() + " , " + randomMAC3() + " , " + randomMAC4() + " , " + randomMAC5() + " , " + randomMAC6())
