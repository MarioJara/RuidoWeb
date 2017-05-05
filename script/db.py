from scipy.io.wavfile import read
import numpy as np
import numpy
import math
import sys
from math import log10, log, sqrt, pow
from scipy.signal import lfilter
from A_weighting import A_weighting
#from cmath import sqrt

samplerate = 44100 #samples per second
t = 10 #seconds
samples = samplerate * t

B, A = A_weighting(samplerate)

trim = 93.97940008672037609572522210551 #p0-based offset (ask Matthias)

mic_gain = 12 #in dB (a gain of 12dB corresponds to 50%)


numchunks = 10

#Quick&dirty calibration
meteor_calibration_100 = -9 #dB offset, at gain 100% / 22 dB
meteor_calibration_50 = 0 #db offser, at gain 50% / 12 dB
calibration = meteor_calibration_50


def compute_leq(chunk):
	#Loudness (code from analyse.loudness()):
	#data = numpy.array(chunk, dtype=float) / 32768.0
	#ms = math.sqrt(numpy.sum(data ** 2.0) / len(data)) #I don't think it needs the sqrt!?
	#if ms < 10e-8: ms = 10e-8
	#return 10.0 * math.log(ms, 10.0)

	data = numpy.array(chunk, dtype=float) / 32768.0
	ms = numpy.sum(data ** 2.0) / len(data)
	if ms < 10e-8: ms = 10e-8 #?

	return (10.0 * math.log(ms, 10.0)) + trim


def read_dbs(filename):
	samprate, wavdata = read(filename)
	chunks = np.array_split(wavdata, numchunks)

        try:
            dbs = [20*log10( sqrt(np.mean(chunk**2)) ) for chunk in chunks]
        except Exception, e:
            dbs = [20*log10( sqrt(max(chunk**2)) ) for chunk in chunks]

	db_max = max(dbs)
	#db_min = min(dbs)
	#db_ave = np.mean(dbs)

	#print "Max:"
	print db_max

	#print "Min:"
	#print db_min

	#print "Average:"

	#print db_ave

	#return dbs

if __name__ == "__main__":
    try:
        params = len(sys.argv) -1
        if params >= 1:
            read_dbs("uploads/" + sys.argv[1])
        else:
            print "usage: %s file_name" % sys.argv[0]
            sys.exit(2)

    except Exception, e:
        print e
