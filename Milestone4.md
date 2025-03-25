# Milestone 4: Chaos Engineering 

## Chaos Engineering: Kill Test

###  Objective
To verify if the system can **recover from unexpected crashes** by killing a key service and observing Docker Swarm’s automatic restart.

---

### Command Used

```powershell
docker run -it --rm `
  --name=pumba `
  -v "//var/run/docker.sock:/var/run/docker.sock" `
  gaiaadm/pumba `
  --log-level info `
  kill --signal SIGKILL re2:^myapplication_worker.*
```

This command forcefully stopped the myapplication_worker container with a SIGKILL signal.

---
### 🐳 Docker Swarm Service Status (After Kill)

```txt
ID             NAME                         IMAGE               DESIRED STATE   CURRENT STATE           ERROR
30ok0k0uqy3r   myapplication_worker.1       cco-worker:latest   Running         Running 24 seconds ago
zxvyt1h51b2p    \_ myapplication_worker.1   cco-worker:latest   Shutdown        Failed 30 seconds ago   "task: non-zero exit (137)"
```

---

### Outcome
- Docker Swarm detected the failure and spun up a new container automatically.

- The new instance of myapplication_worker resumed operations almost immediately.

- No manual intervention was required.

This confirms resilience in our deployment setup. The test has been passed: The system recovers automatically from unexpected service crashes as expected.


## Network Latency Experiment

We used **Pumba** to simulate network latency on our Docker Swarm deployment.  
The goal was to test if our system could tolerate network delays between services — specifically targeting the `myapplication_laravel-backend` service.

---

### Command Used

```sh
docker run -it --rm `
  --name=pumba `
  -v "//var/run/docker.sock:/var/run/docker.sock" `
  gaiaadm/pumba `
  netem --duration 30s delay --time 1000 re2:^myapplication_laravel-backend.*

---

###  Running Containers During Test

```txt
CONTAINER ID   IMAGE                        STATUS        PORTS
a5143003907d   gaiaadm/pumba                Up 8 seconds
532026cf7584   cco-worker:latest            Up 30 minutes 9000/tcp
6635be0a79a1   cco-laravel-backend:latest   Up 30 minutes 8000/tcp
1248b5cc70e5   mysql:8.0                    Up 3 hours    3306/tcp, 33060/tcp
68b3ace73ae2   redis:alpine                 Up 3 hours    6379/tcp

---
### Latency Observation (During Pumba Delay)
PS> Measure-Command { curl http://localhost:8000 }

Seconds           : 8
Milliseconds      : 667
TotalMilliseconds : 8667.5754

---

### After Delay Cleared

PS> Measure-Command { curl http://localhost:8000 }

Seconds           : 4
Milliseconds      : 143
TotalMilliseconds : 4143.9396

### Outcome

- During the test, the backend still loaded successfully, though significantly slower (~8.6 seconds).
- After the 30-second delay ended, response times dropped back to ~4.1 seconds.
- No errors or timeouts occurred during this test.

**This confirms the system handles latency gracefully, but performance degrades under stress — as expected.**

### 🧪 Extended Latency Test – User Experience

To more thoroughly test the impact of inter-service network delays, we ran a longer `pumba netem` delay of 1000ms for 2 minutes on the `myapplication_laravel-backend` service. During this time, we manually interacted with the app to observe real user experience.

#### Command: 

	```bash
		docker run -it --rm `
		>>   --name=pumba `
		>>   -v "//var/run/docker.sock:/var/run/docker.sock" `
		>>   gaiaadm/pumba `
		>>   netem --duration 120s delay --time 2000 re2:^myapplication_database.*

We attempted to mimick a slow database, eg if there was an enormous amount of traffick. 

#### 🔍 Test Actions
We used a stopwatch to measure how long specific actions took during and after the delay:

| Action              | During Delay (seconds) | After Delay (seconds) |
|---------------------|------------------------|------------------------|
| Logging in (Attempt 1)  | 21.99                   | 8.53                   |
| Logging in (Attempt 2)  | 17.21                   | 12.52                  |
| Logging in (Attempt 3)  | 16.00                   | 11.52                  |

#### 🔧 Additional Notes
- During the delay, login was **significantly slower**, ranging from ~16–22 seconds.
- After the delay expired, login times improved but were still slightly elevated, likely due to temporary caching or service resumption.
- No application crashes or critical errors occurred.
- Laravel logs showed **no session or queue-related exceptions**, confirming system resilience under stress.

✅ **Outcome:**  
Despite degraded performance during the delay window, the site remained usable. This confirms the system is tolerant of temporary network issues between services.


## Issues Encountered

1. **Pumba Cannot Connect to Docker Daemon**
   - Encountered multiple instances of:
     ```
     Cannot connect to the Docker daemon at unix:///var/run/docker.sock
     ```
   - Cause: Either the Docker daemon wasn't running or the volume mount was misconfigured.
   - Resolution: Verified Docker was running and ran the Pumba command via PowerShell with correctly escaped paths.

2. **Container Image Not Found**
   - During latency tests, Pumba failed with:
     ```
     failed to inspect container image: Error response from daemon: No such image
     ```
   - Cause: Old service replicas referenced outdated or removed images.
   - Resolution: Ensured all services were up-to-date with the correct images before running Pumba.

3. **Intermittent Laravel Errors from Missing Tables**
   - Early in testing, the Laravel app threw database errors such as:
     ```
     SQLSTATE[42S02]: Base table or view not found: 1146 Table 'laravel.sessions' doesn't exist
     ```
   - Resolution: Ran database migrations inside the container to ensure all tables were created.

4. **Need to Confirm Latency Test Behavior**
   - There was uncertainty on how to validate whether the Pumba latency delay was effective.
   - Resolution: Used PowerShell’s `Measure-Command` around `curl` calls before, during, and after the test, confirming the performance impact (e.g., ~8.6s vs. ~4.1s).

5. **Doubt About Test Duration**
   - Concern arose that 30 seconds might not be long enough to interact with the app (e.g., log in/out).
   - Plan: Rerun the latency test with a longer duration to allow interaction and observe live behavior.

