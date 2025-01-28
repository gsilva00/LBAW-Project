---
title: EAP
---

# EAP: Architecture Specification and Prototype

## A7: Web Resources Specification

This artifact describes the openAPI specification for NewFlow's system, as well as a description of its web resources and permissions. This api includes the crating, reading, updating and deleting operations for each existing resource.

### 1. Overview

To better understand how the vertical prototype will be designed, the web resources to be implemented are identified and described concisely below.

<table>
  <tr>
    <td><strong>M01: Authentication</strong></td>
    <td>Web resources for user authentication and registration. Features include login, logout, credential recovery, and registration.</td>
  </tr>
  <tr>
    <td><strong>M02: Individual Profile</strong></td>
    <td>Web resources for individual profile management, including viewing and editing profile information and managing notifications.</td>
  </tr>
  <tr>
    <td><strong>M03: News</strong></td>
    <td>Web resources for news articles. Features include a home page, viewing other users' articles, creating, editing, and deleting personal articles, a liked articles page, and a following authors page.</td>
  </tr>
  <tr>
    <td><strong>M04: Search</strong></td>
    <td>Web resources for searching and filtering content such as articles, users, and comments with different privileges.</td>
  </tr>
  <tr>
    <td><strong>M05: Topics and Tags</strong></td>
    <td>Web resources related to tags and topics, including a trending tag page, viewing tags, selecting tags and topics for articles, as well as following topics/tags</td>
  </tr>
  <tr>
    <td><strong>M06: Comments</strong></td>
    <td>Web resources for managing comments and replies, including creating, editing, and deleting comments and replies.</td>
  </tr>
  <tr>
    <td><strong>M07: Votes</strong></td>
    <td>Web resources for liking and disliking comments and articles. Features include liking and disliking content, annulating likes/dislikes, and viewing total vote difference.</td>
  </tr>
  <tr>
    <td><strong>M08: Report and Fact Checking</strong></td>
    <td>Web resources for reporting articles, users, and comments. Features include reporting content, verifying report authenticity, adding strikes to users, banning/unbanning users, and blocking article and comment visibility.</td>
  </tr>
  <tr>
    <td><strong>M09: Administration and Static Pages</strong></td>
    <td>Web resources for managing report authenticity conflicts, viewing unban appeals, managing tag proposals, viewing user permissions, and updating static content such as dashboard, about, contact, services, and FAQ.</td>
  </tr>
</table>

Table 1: NewFlow Overview of the Web Resources

### 2. Permissions

Permissions delineate who can access certain resources in the modules described above:

| Code | Role          | Description                                                        |
| ---- | ------------- | ------------------------------------------------------------------ |
| GUE  | Guest         | Users without privileges                                           |
| USR  | User          | Authenticated users                                                |
| OWN  | Owner         | Users that are the owners of an article, comment, reply or profile |
| FAC  | Fact Checker  | System moderators who verify content veracity                      |
| ADM  | Administrator | System administrators                                              |

Table 2: NewFlow Permissions

### 3. OpenAPI Specification

In this section, the [NewFlow's openAPI specification](https://gitlab.up.pt/lbaw/lbaw2425/lbaw24124/-/blob/main/docs/a7_openapi.yaml?ref_type=heads) can be seen.

```yaml
# OpenAPI Specification for the NewFlow System

openapi: 3.0.0

info:
  version: "1.0"
  title: NewFlow Web API
  description: Web Resources Specification (A7) for NewFlow

servers:
  - url: https://lbaw24124.fe.up.pt/
    description: Production server

externalDocs:
  description: Find more info about the EAP artifact here.
  url: https://gitlab.up.pt/lbaw/lbaw2425/lbaw24124/-/wikis/eap.md

tags:
  - name: "M01: Authentication"
  - name: "M02: Individual Profile"
  - name: "M03: News"
  - name: "M04: Search"
  - name: "M05: Topics and Tags"
  - name: "M06: Comments"
  - name: "M07: Votes"
  - name: "M08: Report and Fact Checking"
  - name: "M09: Administration and Static Pages"

paths:
  #################################### Authentication ####################################

  /login:
    get:
      operationId: R101
      summary: "R101: Login Form"
      description: "Provide login form. Access: GUE"
      tags:
        - "M01: Authentication"
      responses:
        "200":
          description: "Ok. Show Log-in UI"

    post:
      operationId: R102
      summary: "R102: Login Action"
      description: "Processes the login form submission. Access: GUE"
      tags:
        - "M01: Authentication"

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                email:
                  type: string
                  format: email
                password:
                  type: string
                  format: password
              required:
                - email
                - password

      responses:
        "302":
          description: "Redirect after processing the login credentials."
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: "Successful authentication. Redirect to user profile."
                  value: "/homepage"

                302Error:
                  description: "Failed authentication. Redirect to login form."
                  value: "/login"

  /logout:
    post:
      operationId: R103
      summary: "R103: Logout Action"
      description: "Logout the current authenticated user. Access: USR"
      tags:
        - "M01: Authentication"
      responses:
        "302":
          description: "Redirect after processing logout."
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: "Successful logout. Redirect to login form."
                  value: "/login"

  /register:
    get:
      operationId: R104
      summary: "R104: Register Form"
      description: "Register a new user. Access: GUE"
      tags:
        - "M01: Authentication"

      responses:
        "200":
          description: "Ok. Show Sign-Up UI"

    post:
      operationId: R105
      summary: "R105: Register Action"
      description: "Processes the new user registration form submission. Access: GUE"
      tags:
        - "M01: Authentication"

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                username:
                  type: string
                email:
                  type: string
                  format: email
                password:
                  type: string
                  format: password
                confirm_password:
                  type: string
                  format: password
              required:
                - username
                - email
                - password
                - confirm_password

      responses:
        "302":
          description: "Redirect after processing the new user information."
          headers:
            Location:
              schema:
                type: string
              example:
                302Success:
                  description: "Successful registration. Redirect to home page."
                  value: "/homepage"

                302Failure:
                  description: "Failed registration. Redirect to register form."
                  value: "/register"

  ################################## Individual Profile ##################################

  /profile/user/{username}:
    get:
      operationId: R201
      summary: "R201: View user profile"
      description: "Show the individual user profile. Access: GUE, USR"
      tags:
        - "M02: Individual Profile"

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        "200":
          description: "Ok. Show User Profile UI."
        "404":
          description: "Not Found. This user does not exist."

  /profile/edit/{username}:
    get:
      operationId: R202
      summary: "R202: Edit user profile Form"
      description: "Show the edit individual user profile page. Access: OWN"
      tags:
        - "M02: Individual Profile"

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      responses:
        "200":
          description: "Ok. Show edit profile UI."
        "403":
          description: "Unauthorized. You do not possess the valid credentials to access that page."
          headers:
            Location:
              schema:
                type: string
              example:
                403Success:
                  description: "Redirecting to home page."
                  value: "/homepage"

    post:
      operationId: R203
      summary: "R203: Edit user profile Action"
      description: "Processes and saves the changes made by user. Access: OWN"
      tags:
        - "M02: Individual Profile"

      parameters:
        - in: path
          name: username
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                username:
                  type: string
                display_name:
                  type: string
                email:
                  type: string
                  format: email
                description:
                  type: string
                profile_picture:
                  type: string
                  format: binary
                cur_password:
                  type: string
                  format: password
                new_password:
                  type: string
                  format: password
                confirm_password:
                  type: string
                  format: password
              required:
                - username
                - email
                - cur_password

      responses:
        "302":
          description: "Redirect after processing the new user information."
          headers:
            Location:
              schema:
                type: string
              example:
                302Success:
                  description: "Edit successful. Redirect to individual user profile."
                  value: "/profile/user/{username}"
                302Failure:
                  description: "Edit failed. Redirect to edit individual user profile."
                  value: "/profile/edit/{username}"
        "403":
          description: "Unauthorized. You do not possess the valid credentials to edit that profile."
          headers:
            Location:
              schema:
                type: string
              example:
                403Success:
                  description: "Redirecting to home page."
                  value: "/homepage"

  /profile/delete/{id}:
    post:
      operationId: R204
      summary: "R204: Delete user profile"
      description: "Delete the individual user profile. Access: OWN, ADM"
      tags:
        - "M02: Individual Profile"

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        "302":
          description: "Redirect after deleting user information."
          headers:
            Location:
              schema:
                type: string
                example:
                  302Success:
                    description: "Successful delete. Redirect to login form."
                    value: "/login"

                  302Failure:
                    description: "Failure to delete. Redirect to user profile."
                    value: "/profile/user"
        "403":
          description: "You do not possess the credentials for this action."

  ######################################### News #########################################

  /homepage:
    get:
      operationId: R301
      summary: "R301: View Home Page"
      description: "Show the Home page. Access: GUE, USR"
      tags:
        - "M03: News"
      responses:
        "200":
          description: "Success. Display Home Feed."

  /user_feed:
    get:
      operationId: R302
      summary: "R302: View User News Feed"
      description: "Show the User News Feed page. Access: USR"
      tags:
        - "M03: News"
      responses:
        "200":
          description: "Success. Display User News Feed."
        "403":
          description: "Unauthorized. You do not possess the credentials to access that page."
          headers:
            Location:
              schema:
                type: string
              example:
                403Success:
                  description: "Redirecting to login page"
                  value: "/login"

  /most-voted:
    get:
      operationId: R303
      summary: "R303: View Most Voted News"
      description: "Show the Top News page. Access: GUE, USR"
      tags:
        - "M03: News"
      responses:
        "200":
          description: "Success. Display Most Voted News Feed."

  /article/{id}:
    get:
      operationId: R304
      summary: "R304: View News Item"
      description: "Show Article page. Access: GUE, USR"
      tags:
        - "M03: News"

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        "200":
          description: "Success. Display Article page."
        "404":
          description: "Not Found. This article does not exist."

  /create-article:
    get:
      operationId: R305
      summary: "R305: Create News Article Form"
      description: "Display create a new article UI. Access: USR"
      tags:
        - "M03: News"
      responses:
        "202":
          description: "Ok. Show create article UI."
        "403":
          description: "Unauthorized. You do not possess the credentials to create an article."
          headers:
            Location:
              schema:
                type: string
              example:
                403Success:
                  description: "Redirecting to login page."
                  value: "/login"

    post:
      operationId: R306
      summary: "R306: Create New Article Action"
      description: "Create a new article. Access: USR"
      tags:
        - "M03: News"

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                title:
                  type: string
                subtitle:
                  type: string
                content:
                  type: string
                image:
                  type: string
                  format: binary
              required:
                - title
                - subtitle
                - content

      responses:
        "302":
          description: "Redirect after processing the new article information."
          headers:
            Location:
              schema:
                type: string
              example:
                302Success:
                  description: "Successful. Redirect to the user profile."
                  value: "/profile/user/{username}"

                302Failure:
                  description: "Failed. Redirect to create article form."
                  value: "/create_article"

  /edit-article/{id}:
    get:
      operationId: R307
      summary: "R307: Edit article Form"
      description: "Show the edit article page. Access: OWN"
      tags:
        - "M03: News"

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        "200":
          description: "Ok. Show edit article UI."
        "403":
          description: "Unauthorized. You do not possess the valid credentials edit this article."

    post:
      operationId: R308
      summary: "R308: Edit article Action"
      description: "Processes and saves the changes made by user. Access: OWN"
      tags:
        - "M03: News"

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                title:
                  type: string
                subtitle:
                  type: string
                content:
                  type: string
                image:
                  type: string
                  format: binary
              required:
                - title
                - content

      responses:
        "302":
          description: "Redirect after processing the new article information."
          headers:
            Location:
              schema:
                type: string
              example:
                302Success:
                  description: "Edit successful. Redirect to the user profile."
                  value: "/profile/user/{username}"
                302Failure:
                  description: "Edit failed. Redirect to edit article page."
                  value: "/edit-article/{id}"

  /delete-article/{id}:
    post:
      operationId: R309
      summary: "R309: Delete an article."
      description: "Delete an article action. Access: OWN, ADM"
      tags:
        - "M03: News"

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                id:
                  type: integer
              required:
                - id

      responses:
        "302":
          description: "Redirect after deleting user information."
          headers:
            Location:
              schema:
                type: string
              example:
                302Success:
                  description: "Successful delete. Redirect to user profile"
                  value: "/profile/user/{username}"
        "403":
          description: "You do not possess the credentials for this action."

  ######################################## Search ########################################

  /search:
    get:
      operationId: R401
      summary: "R401: Search"
      description: "Show the search results page. Access: GUE, USR"
      tags:
        - "M04: Search"
      parameters:
        - in: query
          name: query
          schema:
            type: string
          required: true
          description: "The search query string"
      responses:
        "200":
          description: "Success. Display search results."
        "400":
          description: "Bad Request. Invalid search query."
        "500":
          description: "Internal Server Error. Unable to process search query."

  #################################### Topics and Tags ###################################

  /following/tags:
    get:
      operationId: R501
      summary: "R501: View Followed Tags Feed"
      description: "Show the followed tags feed. Access: USR"
      tags:
        - "M05: Topics and Tags"

      responses:
        "200":
          description: "Success. Display followed tags."

  /following/topics:
    get:
      operationId: R502
      summary: "R502: View Followed Topics Feed"
      description: "Show the followed topics feed. Access: USR"
      tags:
        - "M05: Topics and Tags"

      responses:
        "200":
          description: "Success. Display followed topics."

  /following/authors:
    get:
      operationId: R503
      summary: "R503: View Followed Authors Feed"
      description: "Show the followed authors feed. Access: USR"
      tags:
        - "M05: Topics and Tags"

      responses:
        "200":
          description: "Success. Display followed authors feed."

  /topic/{name}:
    get:
      operationId: R504
      summary: "R504: View Topic"
      description: "Show the topic page. Access: GUE, USR"
      tags:
        - "M05: Topics and Tags"
      parameters:
        - in: path
          name: name
          schema:
            type: string
          required: true
          description: "The name of the topic"
      responses:
        "200":
          description: "Success. Display topic page."
        "404":
          description: "Not Found. Topic does not exist."

  /tag/{name}:
    get:
      operationId: R505
      summary: "R505: View Tag"
      description: "Show the tag page. Access: GUE, USR"
      tags:
        - "M05: Topics and Tags"
      parameters:
        - in: path
          name: name
          schema:
            type: string
          required: true
          description: "The name of the tag"
      responses:
        "200":
          description: "Success. Display tag page."
        "404":
          description: "Not Found. Tag does not exist."

  /trending-tags:
    get:
      operationId: R506
      summary: "R506: View Trending Tags"
      description: "Show the trending tags page. Access: GUE, USR"
      tags:
        - "M05: Topics and Tags"
      responses:
        "200":
          description: "Success. Display trending tags page."

  ####################################### Comments #######################################

  # not part of the vertical prototype

  ######################################### Votes ########################################

  # not part of the vertical prototype

  ############################### Report and Fact Checking ###############################

  # not part of the vertical prototype

  ############################ Administration and Static Pages ###########################

  /admin-panel:
    get:
      operationId: R901
      summary: "R901: View Admin Panel"
      description: "Show the admin panel page. Access: ADM"
      tags:
        - "M09: Administration and Static Pages"
      responses:
        "200":
          description: "Success. Display admin panel."
        "403":
          description: "Unauthorized. You do not possess the valid credentials to access that page."
          headers:
            Location:
              schema:
                type: string
              example:
                403Success:
                  description: "Redirecting to home page."
                  value: "/homepage"

  /more-users:
    get:
      operationId: R902
      summary: "R902: View More Users"
      description: "Show more users for the admin panel page. Access: ADM"
      tags:
        - "M09: Administration and Static Pages"
      responses:
        "200":
          description: "Success. Display more users in admin panel."

  /create-user:
    post:
      operationId: R903
      summary: "R903: Create Custom User Action"
      description: "Create a new custom user. Access: ADM"
      tags:
        - "M09: Administration and Static Pages"

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                username:
                  type: string
                email:
                  type: string
                  format: email
                display_name:
                  type: string
                password:
                  type: string
                  format: password
                reputation:
                  type: integer
                upvote_notifications:
                  type: boolean
                upvoteNotifications:
                  type: boolean
                commentNotifications:
                  type: boolean
                isAdmin:
                  type: boolean
                isFactChecker:
                  type: boolean
                image:
                  type: string
                  format: binary
              required:
                - username
                - email
                - password

      responses:
        "302":
          description: "Redirect after processing the new custom user information."
          headers:
            Location:
              schema:
                type: string
              example:
                302Success:
                  description: "Successful. Redirect to admin panel."
                  value: "/admin-panel"
                302Failure:
                  description: "Failed. Redirect to admin panel."
                  value: "/admin-panel"
        "403":
          description: "You do not possess the credentials for this action."

  /contacts:
    get:
      operationId: R904
      summary: "R904: View Contacts"
      description: "Show the contacts page. Access: GUE, USR"
      tags:
        - "M09: Administration and Static Pages"
      responses:
        "200":
          description: "Success. Display contacts page."

  /about-us:
    get:
      operationId: R905
      summary: "R905: View About Us"
      description: "Show the about us page. Access: GUE, USR"
      tags:
        - "M09: Administration and Static Pages"
      responses:
        "200":
          description: "Success. Display about us page."
```

---

## A8: Vertical prototype

This section will list all the features and web resources currently implemented in our vertical prototype.

### 1. Implemented Features

#### 1.1. Implemented User Stories

<table>
<tr>
<td>

**User Story**

</td>

<td>

**Name**

</td>

<td>

**Priority**

</td>

<td>

**Description**

</td>
</tr>

<tr>
<td>US01</td>
<td>View News Item</td>
<td>High</td>
<td>As a User, I want to view news items, so that I can read an article in full.</td>
</tr>

<tr>
<td>US02</td>
<td>View Top News Feed</td>
<td>High</td>
<td>As a User, I want to view the top voted news, so that I can understand what are the most trending news reports.</td>
</tr>

<tr>
<td>US03</td>
<td>Search for News Items</td>
<td>High</td>
<td>As a User, I want to search for news, so that I can access the information I'm looking for easier.</td>
</tr>

<tr>
<td>US04</td>
<td>Exact Match Search</td>
<td>High</td>
<td>As a User, I want to search with an exact-match, so that I obtain news articles with titles matching my search.</td>
</tr>

<tr>
<td>US05</td>
<td>Full-text Search</td>
<td>High</td>
<td>As a User, I want to search in full-text, so that I obtain news articles with content matching my search.</td>
</tr>

<tr>
<td>US06</td>
<td>View News Item Details</td>
<td>High</td>
<td>As a User, I want to view the details of any particular article, so that I can see extra information about each news.</td>
</tr>

<tr>
<td>US07</td>
<td>View Comment Details</td>
<td>High</td>
<td>As a User, I want to view the details of any particular comment, so that I can see extra information about each comment.</td>
</tr>

<tr>
<td>US08</td>
<td>Home page feed</td>
<td>High</td>
<td>As a User, I I want to see a News Feed as soon as I enter the website, so that I can explore news articles as soon as I enter without having to search for them.</td>
</tr>

<tr>
<td>US09</td>
<td>Search over Multiple Attributes</td>
<td>Medium</td>
<td>As a User, I want to search over multiple attributes (author, title, etc.), so that I can be even more precise while searching for news.</td>
</tr>

<tr>
<td>US10</td>
<td>Search by Filters</td>
<td>Medium</td>
<td>As a User, I want to search by filters, so that I can narrow my search even further.</td>
</tr>

<tr>
<td>US11</td>
<td>View Recent News Feed</td>
<td>Medium</td>
<td>As a User, I want to view the most recent news, so that I'm aware of the latest events.</td>
</tr>

<tr>
<td>US12</td>
<td>View News Item Comments</td>
<td>Medium</td>
<td>As a User, I want to view news articles' comments, so that I can understand different perspectives about a subject.</td>
</tr>

<tr>
<td>US13</td>
<td>View Placeholders in Form Inputs</td>
<td>Medium</td>
<td>As a User, I want to view placeholders in form inputs, so that I have an example of what I need to type.</td>
</tr>

<tr>
<td>US14</td>
<td>View Contextual Error Messages</td>
<td>Medium</td>
<td>As a User, I want to view Contextual Error Messages, so that I can understand what is wrong with my input and the platform's activity.</td>
</tr>

<tr>
<td>US15</td>
<td>View the “About Us” Page</td>
<td>Medium</td>
<td>As a User, I want to view the “About Us” page, so that I can learn more about the platform origins, goals and objectives.</td>
</tr>

<tr>
<td>US17</td>
<td>View the "Platform Contacts" Page</td>
<td>Medium</td>
<td>As a User, I want to view the "Platform Contacts" page, so that I can contact the right entities about my interests in the platform.</td>
</tr>

<tr>
<td>US18</td>
<td>View Other Users' Profiles</td>
<td>Medium</td>
<td>As a User, I want to view other users’ profiles, so that I access more information about people in the website.</td>
</tr>

<tr>
<td>US20</td>
<td>View News Items Tags</td>
<td>Medium</td>
<td>As a User, I want to view the tags of a news article, so that I can know before reading what the news are about.</td>
</tr>

<tr>
<td>US22</td>
<td>Sign-In</td>
<td>High</td>
<td>As a Guest, I want to sign into the system, so that I can access my account.</td>
</tr>

<tr>
<td>US23</td>
<td>Registration</td>
<td>High</td>
<td>As a Guest, I want to register into the system, so that I can get access to comment or create my own articles.</td>
</tr>

<tr>
<td>US25</td>
<td>Logout</td>
<td>High</td>
<td>As an Authenticated User, I want to log out from my account, so that my account details are secure.</td>
</tr>

<tr>
<td>US26</td>
<td>Change Password</td>
<td>High</td>
<td>As an Authenticated User, I want to change my password, so that my account is safe from potential threats.</td>
</tr>

<tr>
<td>US27</td>
<td>View Personal Profile</td>
<td>High</td>
<td>As an Authenticated User, I want to view my profile, so that I can check what info is connected to my account.</td>
</tr>

<tr>
<td>US28</td>
<td>Edit Profile</td>
<td>High</td>
<td>As an Authenticated User, I want to edit my profile, so that I can rectify any mistake or update my information.</td>
</tr>

<tr>
<td>US29</td>
<td>View User News Feed</td>
<td>High</td>
<td>As an Authenticated User, I want to view my own customizable News Feeds (Following authors, topics and tags), so that I can read news about topics/tags and created by authors I enjoy.</td>
</tr>

<tr>
<td>US30</td>
<td>Create News Item</td>
<td>High</td>
<td>As an Authenticated User, I want to create new articles, so that I may be able to contribute to this website.</td>
</tr>

<tr>
<td>US31</td>
<td>Delete Account</td>
<td>Medium</td>
<td>As an Authenticated User, I want to delete my account, so that nobody usurps my account data.</td>
</tr>

<tr>
<td>US32</td>
<td>Change Profile Picture</td>
<td>Medium</td>
<td>As an Authenticated User, I want to have a profile picture, so that I can personalize my account.</td>
</tr>

<tr>
<td>US48</td>
<td>Edit News Item</td>
<td>High</td>
<td>As a News Author, I want to edit my news, so that my content is always updated.</td>
</tr>

<tr>
<td>US49</td>
<td>Delete News Item</td>
<td>High</td>
<td>As a News Author, I want to delete my news, so that its content is not available in the system.</td>
</tr>

<tr>
<td>US52</td>
<td>Administer User Accounts (search, view, edit, create)</td>
<td>High</td>
<td>As an Admin, I want to administer user accounts, so that I can maintain the integrity of the platform.</td>
</tr>

<tr>
<td>US54</td>
<td>Delete User Account</td>
<td>Medium</td>
<td>As an Admin, I want to delete a user account, so that users who engage in inappropriate behavior face the consequences.</td>
</tr>
</table>

Table 3: Implemented user stories

#### 1.2. Implemented Web Resources

**Module M01: Authentication**

| Web Resource Reference | URL            |
| ---------------------- | -------------- |
| R101: Login Form       | GET /login     |
| R102: Login Action     | POST /login    |
| R103: Logout Action    | POST /logout   |
| R104: Register Form    | GET /register  |
| R105: Register Action  | POST /register |

Table 4: Authentication implementation

**Module M02: Individual Profile**

| Web Resource Reference         | URL                           |
| ------------------------------ | ----------------------------- |
| R201: View user profile        | GET /profile/user/{username}  |
| R202: Edit user profile Form   | GET /profile/edit/{username}  |
| R203: Edit user profile Action | POST /profile/edit/{username} |
| R204: Delete user profile      | POST /profile/delete/{id}     |

Table 5: Individual Profile implementation

**Module M03: News**

| Web Resource Reference          | URL                       |
| ------------------------------- | ------------------------- |
| R301: View Home Page            | GET /homepage             |
| R302: View User News Feed       | GET /user_feed            |
| R303: View Most Voted News      | GET /most-voted           |
| R304: View News Item            | GET /article/{id}         |
| R305: Create News Article Form  | GET /create-article       |
| R306: Create New Article Action | POST /create-article      |
| R307: Edit article Form         | GET /edit-article/{id}    |
| R308: Edit article Action       | POST /edit-article/{id}   |
| R309: Delete an article         | POST /delete-article/{id} |

Table 6: News implementation

**Module M04: Search**

| Web Resource Reference | URL         |
| ---------------------- | ----------- |
| R401: Search           | GET /search |

Table 7: Search implementation

**Module M05: Topics and Tags**

| Web Resource Reference           | URL                    |
| -------------------------------- | ---------------------- |
| R501: View Followed Tags Feed    | GET /following/tags    |
| R502: View Followed Topics Feed  | GET /following/topics  |
| R503: View Followed Authors Feed | GET /following/authors |
| R504: View Topic                 | GET /topic/{name}      |
| R505: View Tag                   | GET /tag/{name}        |
| R506: View Trending Tags         | GET /trending-tags     |

Table 8: Topics and Tags implementation

**Module M09: Administration and Static Pages**

| Web Resource Reference          | URL               |
| ------------------------------- | ----------------- |
| R901: View Admin Panel          | GET /admin-panel  |
| R902: View More Users           | GET /more-users   |
| R903: Create Custom User Action | POST /create-user |
| R904: View Contacts             | GET /contacts     |
| R905: View About Us             | GET /about-us     |

Table 9: Administration and Static Pages implementation

### 2. Prototype

The prototype Docker image is available at GitLab's Registry Container and can be run with:

```bash
docker run -d --name lbaw24124 -p 8001:80 gitlab.up.pt:5050/lbaw/lbaw2425/lbaw24124:latest
```

The application will be available at http://localhost:8001/

Credentials:

- admin user: admin@example.com | password123
- regular user: alice@example.com | password123

The vertical prototype code is available in our group's repository, on branch [Vertical Prototype](https://gitlab.up.pt/lbaw/lbaw2425/lbaw24124/-/tree/VerticalPrototype?ref_type=heads)

---

## Revision history

22-12-2024:

- Altered module description of M05 in artifact A7

---

GROUP24124, 26/11/2024

- Gabriel Carvalho, up202208939@up.pt
- Guilherme Silva, up202205298@up.pt
- Valentina Cadime, up202206262@up.pt (Editor)
- Vasco Melo, up202207564@up.pt
