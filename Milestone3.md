## Milestone 3: Separating A/B Testing, Containerizing Laravel, and Deploying in Docker Swarm

###  Step 1: Setting Up A/B Testing Inside Laravel (Before Separation)
#### What We Had Initially (Monolithic Setup)
- Laravel Backend (`php artisan serve`)
- A/B Test logic built directly into Laravel routes and middleware
- A/B Test logs stored synchronously in MySQL
- Queue Worker not separate yet

**Check Code for A/B Test Logging in Laravel Routes**: `routes/web.php`


---

### Step 2: Moving A/B Testing Logging to a Separate Queue Worker


#### 1. Created a Laravel Job for Logging
```bash
php artisan make:job LogABTestEvent
```

#### 2. Updated the Job Logic
Refer to `app/Jobs/LogABTestEvent.php` for implementation details.

#### 3. Updated Routes to Dispatch Job Asynchronously
Refer to `routes/web.php`.

**Now, A/B Test logging happens asynchronously inside the queue worker.**

---

###  Step 3: Containerizing Laravel Backend & A/B Logging Worker
Once we separated the A/B Test logging logic, we containerized both Laravel and the worker.

#### 1. Laravel Backend Containerization
Refer to `Dockerfile`

**This container now runs only the Laravel backend.**

#### 2. A/B Test Logging Worker Containerization
Refer to `worker.Dockerfile`

**Now, the A/B test logging is completely separate from the backend.**

---

### Step 4: Running Laravel Backend & Worker as Separate Containers
Before moving to Docker Swarm, we tested running them separately in Docker.

#### 1. Running Laravel Backend
```bash
docker build -t cco-laravel-backend .
docker run -d -p 8000:8000 --name laravel-backend cco-laravel-backend
```

#### 2️. Running A/B Test Worker
```bash
docker build -t cco-worker -f worker.Dockerfile .
docker run -d --name worker cco-worker
```
 **Now, A/B logging happens asynchronously inside the worker.**

---

###  Step 5: Ensuring Database & Redis Connectivity
To ensure Laravel could communicate with MySQL and Redis:
```bash
docker network create laravel_network
docker run -d --network=laravel_network --name database -e MYSQL_ROOT_PASSWORD=root mysql:8.0
docker run -d --network=laravel_network --name redis redis:alpine
```

**Now, the Laravel Backend & Worker communicate via the same network.**

---

### Step 6: Debugging Issues (Pre-Swarm)
Ran into several problems that needed fixing:

| **Issue** | **Solution** |
|-----------|-------------|
| Worker failed (`Exited (1)`) | Verified logs using `docker logs worker`, found missing `.env`, copied it. |
| MySQL connection errors (`SQLSTATE[HY000] [2002] Connection refused`) | Used `DB_HOST=database` instead of `127.0.0.1`. |
| Redis cache not working in Laravel | Ensured `CACHE_DRIVER=redis` and `SESSION_DRIVER=redis` in `.env`. |
| Some containers not starting properly | Restarted Laravel queue using `php artisan queue:restart`. |

**After debugging, everything was running correctly in standalone Docker.**

---

### Step 7: Migrating Everything to Docker Swarm
Once everything was working perfectly as individual containers, we migrated to Docker Swarm.

#### 1️. Install Docker and Set Up Swarm
If Docker is not installed, download and install it from [Docker's official website](https://www.docker.com/get-started/).

Initialize Swarm:
```bash
docker swarm init
```


####  I then followed the steps provided in the Milestone 3 prompt.


**Checked if services were running:**
```bash
docker stack services myapplication
```

**Now, Laravel Backend & A/B Test Logging Worker are running separately in Swarm!**

---

##  **Next Steps for Milestone 4**
### 1.  Pull Changes from GitHub

### 2. Build and Start the Services
```bash
docker compose build
docker compose up -d
```

### 3. Verify That Everything Is Running
```bash
docker ps
```
Expected output:
```
CONTAINER ID   IMAGE                 STATUS        PORTS                NAMES
xxxxxxx        cco-laravel-backend   Up           8000/tcp, 9000/tcp   cco-laravel-backend-1
xxxxxxx        cco-worker            Up           9000/tcp             cco-worker-1
xxxxxxx        mysql:8.0             Up           3306/tcp, 33060/tcp   cco-database-1
xxxxxxx        redis:alpine          Up           6379/tcp             cco-redis-1
```

