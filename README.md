# CS4760-Food

## GCP database connection 

To connect to a cloud SQL, you need to configure access to your cloud instance. For more information on configuration, please refer to [configure-instance-mysql](https://cloud.google.com/sql/docs/mysql/connect-admin-ip#configure-instance-mysql).

- Start your SQL instance.

- Find the IP address of your (or client where the PHP program is hosted) machine, using [What's my IP](http://ipv4.whatismyv6.com/).

- Copy that IP address, you will later give permission to this IP address to access your SQL instance.

- Go to the overview page of your [cloud instance](https://console.cloud.google.com/sql/instances).

- Select the Connections tab.

  ![php connecting to sql instance](http://www.cs.virginia.edu/~up3f/cs4750/images/gcp-images/gcp-mysql-images/php-gcp-db-gcp-2.png)

- Under Authorized networks, click Add network

  ![php connecting to sql instance](http://www.cs.virginia.edu/~up3f/cs4750/images/gcp-images/gcp-mysql-images/php-gcp-db-gcp-3.png)

- Enter the IP address you got previously, click `Done` and then click `Save`.

  ![php connecting to sql instance](http://www.cs.virginia.edu/~up3f/cs4750/images/gcp-images/gcp-mysql-images/php-gcp-db-gcp-4.png)



### XAMPP Local Deployment

* Clone the repo to `./XAMPP/htdocs`

* http://localhost/CS4760-Food/index.html#

* http://localhost/CS4760-Food/search.php

  