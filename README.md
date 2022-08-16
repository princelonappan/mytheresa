## Overview

This application provides the following API features.

- List All Products 
- Search

## Requirements and dependencies

- PHP >= 7.2
- Symfony CLI version  v4.28.1

## Features

- This system allows to search the products through the category and price less than parameters. 
- Products are stored in the JSON file format.

## Installation

First, clone the repo:
```bash
$ git clone https://github.com/princelonappan/loudly-task.git
```

#### Running as a Docker container

The following docker command will run the application.

```
$ cd folder-name
$ docker-compose up -d
```
This will start the application.

#### Run API Swagger

You can access the Swagger API through the following end point. <br />
```{{ base_url}}/api/doc```

#### Run Test

- Identify the container id by running '**docker ps**' 
- Run the following command - 
- **docker exec -ti *containerid* bash**
- Run the command **php bin/phpunit**
