# ☕ Decaf - OSCP-style CTF Box

Decaf is a realistic Linux-based vulnerable machine designed for training in enumeration, cracking, and privilege escalation — packaged entirely in Docker.

## 🧩 Challenge Overview

**User Flag Path:** `/home/luna/local.txt`  
**Root Flag Path:** `/home/luna/proof.txt`

---

## 🛠 Setup Instructions
1. Clone the repo:
   ```bash
   git clone https://github.com/Brockkoli/decaf.git
   cd decaf

2. Build the Docker image:
   ```bash
   docker build -t decaf .
   
3. Run the container
   ```bash
   docker run -it -p 8080:80 -p 2222:22 -p 2121:21 decaf
=======
