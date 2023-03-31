# Project architekture
Make sure please, that you read an [Application Architecture](architecture.md) file, before you move on into coding.
Information mantioned there, will help you understand my idea.

# Introduction
Welcome to the **OVCommerce** project. This project is a my personal project that is used to be a reference for my future projects. This project is e-commerce website that is built using the following technologies:

* PHP 8.2 over Nginx connected with MySQL 8.0. As a core of the project, I use the Symfony as my preferred framework.
* ReactJS as a frontend framework. Why? Because. Don't know the reason
* TailwindCSS as a CSS framework. Why? Because. Don't know the reason

Talking about project status monitoring, I use the following tools:

* Github as a source code repository
* Github Actions as a CI/CD tool
* Sentry as an error monitoring tool

This application cannot exists without caching. I use the following tools for caching:

* Redis as a cache server
* opcache as a PHP cache

# A target of this project
The goal of this e-commerce project is to create a responsive application that allows for efficient management of products, categories, orders, promotions, discounts, and content through an administrative panel. The application should integrate with various payment systems, automate business processes, generate reports and statistics, implement advanced product search features using technologies such as Elasticsearch, provide a product recommendation system based on purchase history and user behavior, implement an internal messaging system for users and customer service, implement a loyalty system with rewards for regular customers, and integrate with social media for product promotion and user interaction. The application should be able to handle a large number of users and orders, and be able to scale horizontally.

# Installation
## Requirements
* Knowledge of PHP, Symfony, ReactJS, and TailwindCSS.
* You should have a basic knowledge of Docker and Docker Compose, to be able to run the project locally.
* You should have a basic knowledge of Git, to be able to clone the project.
* You understand a basis of the nginx configuration

## Installation
Clone the project
Run `docker-compose -p ov-ecommerce up -d --build` build and start the project.

### Backend
1. Go to `ovc-admin` container `docker exec -it ovc-admin /bin/bash`
2. Run `composer install` to install the dependencies

## Frontend
1. Go to `ovc-client` container `docker exec -it ovc-client /bin/bash`
2. Run `yarn` command to install the dependencies