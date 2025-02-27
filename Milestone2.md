# CPSC 445/545 - Milestone 2: Load Testing

## 🔹 API Endpoints Tested
- `POST /login`
- `POST /logout`
- `GET /profile`
- `PATCH /profile/switch-role`
- `PATCH /profile/update-braider-field`
- `GET /register`
- `POST /register`

## 🔹 Tools Used
- **Locust** for simulating multiple concurrent users.
- **Apache Benchmark (`ab`)** for additional performance testing.
- **Selenium WebDriver** for UI-based profile form testing.

## 🔹 Results
- **Max concurrent users before failure:** 50
- **Average response time for login:** 425.36ms
- **Average response time for logout:** 207.97ms
- **Average response time for profile fetch:** 219.23ms
- **Average response time for role switch:** 202.28ms
- **Average response time for profile update:** 260.82ms
- **Average response time for registration:** 208.2ms
- **Error rate:** **0%** (No failures)

## 🔹 Issues Found & Solutions Implemented
### **1️. At first I found High Failure rate**
✅ **Fixed by ensuring each request fetches a fresh CSRF token.**  

### **2️. Session Conflicts During Login**
✅ **Implemented unique user registration before login.**  

### **3️. Profile Updates & Role Switching Failing**
✅ **Ensured users are logged in before making profile changes.**  

## 🔹 Conclusion
The application successfully handled multiple concurrent users **without failures** after implementing fixes for CSRF tokens, session management, and unique user registrations.

---
```
Type     Name                                                                          # reqs      # fails |    Avg     Min     Max    Med |   req/s  failures/s
--------|----------------------------------------------------------------------------|-------|-------------|-------|-------|-------|-------|--------|-----------
POST     /login                                                                            10     0(0.00%) |    425     330     733    410 |    0.22        0.00
POST     /logout                                                                           50     0(0.00%) |    206      94     961    160 |    1.11        0.00
GET      /profile                                                                          51     0(0.00%) |    221      97     712    190 |    1.13        0.00
PATCH    /profile/switch-role                                                              45     0(0.00%) |    222      96     854    180 |    1.00        0.00
PATCH    /profile/update-braider-field                                                     37     0(0.00%) |    233      98    1179    150 |    0.82        0.00
GET      /register                                                                         10     0(0.00%) |    252     124     796    150 |    0.22        0.00
POST     /register                                                                         10     0(0.00%) |    208     101     363    200 |    0.22        0.00
--------|----------------------------------------------------------------------------|-------|-------------|-------|-------|-------|-------|--------|-----------
         Aggregated                                                                       213     0(0.00%) |    230      94    1179    180 |    4.72        0.00

Response time percentiles (approximated)
Type     Name                                                                                  50%    66%    75%    80%    90%    95%    98%    99%  99.9% 99.99%   100% # reqs
--------|--------------------------------------------------------------------------------|--------|------|------|------|------|------|------|------|------|------|------|------
POST     /login                                                                                410    420    420    440    730    730    730    730    730    730    730     10
POST     /logout                                                                               160    210    220    230    260    630    960    960    960    960    960     50
GET      /profile                                                                              190    210    230    260    400    520    560    710    710    710    710     51
PATCH    /profile/switch-role                                                                  180    210    240    290    420    520    850    850    850    850    850     45
PATCH    /profile/update-braider-field                                                         150    200    230    260    460    820   1200   1200   1200   1200   1200     37
GET      /register                                                                             170    200    210    490    800    800    800    800    800    800    800     10
POST     /register                                                                             200    210    210    300    360    360    360    360    360    360    360     10
--------|--------------------------------------------------------------------------------|--------|------|------|------|------|------|------|------|------|------|------|------
         Aggregated                                                                            180    210    240    270    420    560    810    850   1200   1200   1200    213`
```
 **Attached screenshots.**  
[Screenshots of Tests](https://drive.google.com/file/d/1Y9lKt32YPkAWDST50AvAno2NyvRFMjZ_/view?usp=sharing)
