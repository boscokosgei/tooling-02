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
![Images](./Images/Pulling%20mysql%20image.png)

Deploying Mysql container
![Images](./Images/mysql_Container.png)


Creating a Docker network for the containers to communicate
![Images](./Images/Mysql_Db.png)
## Connecting to Mysql server from a second container running Mysql Client
![Images](./Images/mysql-client%20container.png)



## Clonning Tooling-app Repo 

```sh
git clone https://github.com/StegTechHub/tooling-02.git tooling
cd tooling-02
```

Updating the mysql database schema with the configuration file on db_conn.php

![Images](./Images/Update%20env%20Variables.png)
Update the application code in `./html/`

Creating a Dockerfile for tooling app
and building the image in order to run the container
![Images](./Images/Verifying%20Application%20is%20up.png)

## Accessing the Application on Browser
navigating to http://localhost:8085 to access the application
![Images](./Images/Login%20to%20Steghub%20app.png)

Logging in to the app with default username and password
![Images](./Images/Logged%20in%20successfully.png)

## Implementing a POC to migrate the PHP-Todo app into a containerised application
Using the same mysql database to connnect a php-todo-app and containerise the application by creating a dockerfile

### Clonning the php-todo-app
```sh
     git clone https://github.com/StegTechHub/php-todo
```
![Images](./Images/Cloning%20php-todo.png)

Creating a Dockerfile for php-todo-app
![Images](./Images/Creating%20Docker%20file%20for%20Php-todo.png)

Building the dockerfile fo the application
![Images](./Images/Run%20docker%20php-todo-app.png)

### Accessing the application 
Navigate to the browser to access the php-todo-app
![Images](./Images/php_todo_app%20working.png)

## Pushing the Image to Dockerhub
if already have an existing Dockerhub account login on cli via
```sh
   docker login
```

![Images](./Images/Pushing%20image%20to%20dockerhub.png)

Confirming the Docker Images on Dockerhub
![Images](./Images/image%20pushed%20to%20dockerhub.png)

### Creating a Jenkins Pipeline for the CI 
On the php-todo-app folder create a Jenkins file
Installing and running Jenkins on container
![Images](./Images/Installing%20Jenkins%20on%20VM.png)

Accessing the jenkins UI on the browser
![Images](./Images/Jenkins%20Up%20and%20Running.png)

Creating a Job 
![Images](./Images/Jenkins%20Pipeline.png)

Updating the Jenkins file to connect with Github repo
![Images](./Images/Jenkins%20pipeline%20configuration.png)

Building the pipeline
![Images](./Images/Pipeline%20Build%20Successful.png)

### Verifying that the images pushed from the CI can be found on Dockerhub
Accessing the Dockerhub and openning the images folder
![Images](./Images/Confirming%20Docker%20images%20match%20with%20build.png)


Accessing the Application on Browser

