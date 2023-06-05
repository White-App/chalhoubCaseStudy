# Welcome to the 7 galaxies

Disclaimer: Being in the process of finalizing a mission currently, I unfortunately didn't have all the time I would have liked to have (it's not a 2-4 hours Case Study 😉). So I was able to complete the docker environment, the shopfinder module (with bonus: google maps/ nearby loc / directions / front display), the GraphQL API, and the start of a test case that I didn't not finalize but you can already see that a lot has been achieved.

Everything has been tested locally and works perfectly.

Have a pleasant day and see you very soon!

![Admin list](https://github.com/White-App/chalhoubCaseStudy/blob/origin/admin-index.png?raw=true)

![Admin edit](https://github.com/White-App/chalhoubCaseStudy/blob/origin/admin-edit.png?raw=true)

![Front list direction](https://github.com/White-App/chalhoubCaseStudy/blob/origin/front-show.png?raw=true)

## Setting Up The Magento Docker Environment

This guide assumes you have Docker and Docker Compose installed on your machine.

If not, please follow the official Docker installation instructions : [Docker engine](https://docs.docker.com/engine/install/)

### Step 1: Clone the Repository

Clone the repository:

`git clone <repository_url>`

### Step 2: Add Entry to Hosts File

You need to map the localhost IP address to magento2.local.
* For Linux and MacOS, you can do this by adding an entry to your /etc/hosts file.
  Open a terminal and type: `echo "127.0.0.1 magento2.local" | sudo tee -a /etc/hosts`

* For Windows, you will need to edit the hosts file manually.
  It's typically located at C:\Windows\System32\drivers\etc\hosts.

### Step 3: Configure Magento Access Keys
Before you can build your Docker image, you will need to provide your Magento Marketplace access keys so that Composer can download Magento.

Copy and edit auth.json.sample to auth.json in a text editor and change your <public-key> / <private-key> :

### Step 4: Start Docker Containers

Navigate to the directory where the docker-compose.yml file is located and spin up the Docker containers:

`docker-compose up -d`

`docker-compose exec app composer install`

`docker-compose exec app php bin/magento setup:install \
--db-host=db --db-name=magento --db-user=magento --db-password=magento \
--base-url=http://magento2.local --backend-frontname=admin \
--admin-firstname=admin --admin-lastname=admin --admin-email=bouarfamus@gmail.com \
--admin-user=admin --admin-password=admin123 --language=en_US \
--currency=USD --timezone=America/Chicago --use-rewrites=1 \
--elasticsearch-host=elasticsearch \
--elasticsearch-port=9200 \
--elasticsearch-username=admin \
--elasticsearch-password=magento`

The -d option is used to run the containers in detached mode (in the background).

### Step 5: Verify Installation

Open your browser and navigate to http://magento2.local. 
You should see the Magento homepage.

If you want to log in as admin before execute :
`docker-compose exec app php bin/magento module:disable Magento_TwoFactorAuth`

### Step 6 : Install ShopFinder

`docker-compose exec app composer require whiteapp/shopfinder`
`docker-compose exec app php bin/magento module:enable Whiteapp_ShopFinder`
`docker-compose exec app php bin/magento setup:upgrade`
`docker-compose exec app php bin/magento cache:clean`

### Step 6 : Activate ShopFinder

Go to admin : http://magento2.local/admin

In the left navbar, you'll find a new tab "WhiteApp". Click on it and then on "Settings".

You'll be redirected to the shop settings to activate the shopfinder module, add a google maps API Key 
and choose how max store you want to show.

Then you'll be able to list / add / edit stores in "WhiteApp" > "ShopFinder" 

# Note: Persistent MySQL Data
Thanks to the configuration in the Docker Compose file, MySQL data is persisted in a Docker volume. 
This means that even if you stop the Docker containers, your data will still be there when you start them again.



### To run the PHPUnit tests, you'll need to configure PHPUnit in your Magento installation. You can follow these steps:

Install PHPUnit globally or locally within your project using Composer.
Create a phpunit.xml configuration file in the root directory of your Magento installation. Define the necessary settings, such as the bootstrap file and the test suite.
Run the PHPUnit command from the root directory of your Magento installation:
`phpunit`
This command will execute all the tests defined in your test suite and display the results.

Please note that the provided example test cases are just templates, and you will need to adapt them to your module's specific implementation, dependencies, and test requirements.


