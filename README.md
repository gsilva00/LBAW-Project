# lbaw24124
## Final Product

This version of NewFlow represents the final product for our system, where we showcase its flow as well its most relevant features. The following section will explain how to visualise and test NewFlow's system and provide some credentials to access the web server with.

### Docker Image

The prototype Docker image is available at the GitLab's Registry Container and can be run with:

``` bash
docker pull gitlab.up.pt:5050/lbaw/lbaw2425/lbaw24124:latest
docker run -d --name lbaw24124 -p 8001:80 gitlab.up.pt:5050/lbaw/lbaw2425/lbaw24124:latest
```

The application will be available at http://localhost:8001/

Credentials:
 - admin user: admin@example.com | password123
 - regular user: alice@example.com | password123

Mailtrap account:
 - email: lbaw24124@gmail.com
 - password: odeioWebDev
