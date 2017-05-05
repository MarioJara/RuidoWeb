import numpy as np

fs = 5e5
duration = 25
npts = int(fs*duration)
t = np.arange(npts, dtype=float)/fs
f = 8000
ref = 0.004
amp = ref * np.sqrt(2)
signal = amp * np.sin((f*duration) * np.linspace(0, 2*np.pi, npts))
signal = 33.4767465469

rms = np.sqrt(np.mean(signal**2))
dbspl = 94 + 20*np.log10(rms/ref)

print dbspl
