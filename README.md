# Migration to Cloud with containerization (Docker & Doker Compose)
This project will allow you to work with docker containers, building images from scratch and running them locally and thereafter creating a docker compose to simulate how a multi-containers architecture can be managed.



## Introduction

We have two repo the php-todo-app and a tooling app repo. The repo will be cloned locally and docker file will be build to contain the application.

### Mysql in Container

Starting with the database
Pulling Mysql docker image
```sh
   docker pull mysql/my_mysql_db:latest
```
Verifying the image pulled
```sh
   docker images ls
```
![Images](Pulling%20mysql%20image.png)

## How to use this repository

The build is automatically triggered by a git push to your feature/[branch]

## First clone the repository to your workstation

```bash
git clone https://github.com/StegTechHub/tooling-02.git tooling
cd tooling
```

Create a feature branch. # Always start with feature/[name of your branch]

```bash
git branch -b feature/add-css-style-to-about-us-page
```

Update the application code in `./html/`

Then add/commit/push to gitlab

```bash
git status # to see your changes
```

```bash
git add --all # If you are satisfied with your changes and willing to push everything. Otherwise, select only the files to add
```

```bash
git commit -m "Put some message about this push here"
```

## Push your changes to gitlab, and merge to dev branch

```bash
git push --set-upstream origin feature/[Your branch name]
```

### Validate your changes have been triggered by gitlab-ci in

[tooling-scm](https://github.com/StegTechHub/tooling-02.git)

### Check the image have been pushed to

[Google Container Registry](https://console.cloud.google.com/gcr/images/non-prod-pdz/EU/tooling?project=non-prod-pdz&authuser=1&gcrImageListsize=30) (Depending on the environment. Either non-prod or prod)

## pulling the image

```bash
docker pull eu.gcr.io/$environment/tooling:${tag-version}
```

## Running (You can do this step without the pulling the above as it will put down if not found locally)

To run the container:

```bash
 docker run -d eu.gcr.io/$environment/tooling:${tag-version}
```

Default web root:

```bash
/usr/share/nginx/html
```
## Creating a Mysql Database container
Pulling mysql image from Docker Hub Registry 
```sh
   docker pull mysql/mysql-server:latest
```
Verifying docker image
```sh
  docker images ls 
```
Running mysql container in docker image 
```sh
   docker run --name my_mysql_db -e MYSQL_ROOT_PASSWORD=Passw0rd! -d mysql/mysql-server:latest
```
Verifying the container is running

```sh
   docker ps -a
```
Running mysql client container, instead of installing 
```sh
   docker run --network tooling_app_network --name mysql-client -it --rm mysql mysql -h mysqlserverhost -u tooling_user -p
```

Runnning the Tooling app

```sh
   docker build -t tooling:0.0.1 .
```

Running the container
```sh
   docker run -d \
  --network tooling_app_network \
  -p 8085:80 \
  -v $(pwd)/.env:/var/www/.env \
  -v $(pwd)/html/db_conn.php:/var/www/db_conn.php \
  -v $(pwd)/html/login.php:/var/www/login.php \
  -v $(pwd)/html/home.php:/var/www/home.php \
  -v $(pwd)/html/logout_popup.php:/var/www/logout_popup.php \
  -v $(pwd)/html:/var/www/html \
  --name tooling_app \
  tooling:0.0.1
```

Accessing the Application on Browser

