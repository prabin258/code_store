# Online MCQ Examination Documentation

The Online MCQ Examination is a web application designed to distribute exam questions to students and collect their responses. This documentation provides an overview of the project, its features, installation instructions, usage examples, and other relevant information.

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)

## Introduction

The Exam Question Distributor is developed to streamline the process of distributing exam questions to students and collecting their responses.
It allows teachers or administrators to upload the exam questions in  physics and chemistry and then randomly select and distribute a subset of these questions to individual students via email.
The system also manages the expiration of exam links to ensure students complete the exam within a specific time frame.

## Features

The main features of the Exam Question Distributor include:

1. **Random Question Selection**: The system randomly selects a subset of exam questions from the question bank in database added by the administrator or teacher.

2. **Email Distribution**: Each student receives a unique exam link via email, allowing them to access the questions online and submit them.

3. **Expiry Time**: Students must complete the exam within a specified time (configurable by the teacher/administrator) from the moment they receive the email.

4. **Responses Recording**: The system records students' responses to each question and stores them securely.

5. **Admin Panel**: An admin panel is available for managing students, uploading exam questions, and monitoring the overall exam process.

## Installation

To run the Exam Question Distributor, follow these steps:

 1. **Configure Database Connection**: Open all the `.php` file in the project and update the database connection credentials (e.g., host, username, password) to match your local setup.

2. **Database Setup**: first run the `allowed_login.php` and `selected_questions.php` provided in the project. This sets up database required and gives the admin login information. 
 
3. **SMTP Configuration**: Update the SMTP settings (SMTP server, port, sender email, and authentication credentials) in the `exam_question_distributer.php` to enable email functionality.

4. **Web Server**: Deploy the project on a web server (e.g., Apache, Nginx) with PHP support.

5. **Access the Application**: Navigate to the project URL in your web browser to access the application.

## Usage

### Step 1: Admin Uploads Questions

1. The admin logs in to the system using the admin credentials, which is specified in the `allowed_login.php`and the login process is varified by `login_processor.php`.
2. In the admin panel, the admin uploads sets of exam questions, using UI, for physics and chemistry  along with the correct answers and also uploads information about students.
3. The questions and student informations are stored in the database for later distribution.
4. There is the `Generate Questionnaire` button in admin panal, which on click shows the input field for Title and Expiry time  of the test.
5. Once the information in 4 is submitted, `random_question_generator.php` selects 5 question from physics and 5 questions from chemistry randomly from the respective database and adds
   them to new database `selected` questions` and delete those questions from current database. Along with this, a link is sent to the email address of all the students stored in
   database.

### Step 2: Generate Tokens and Distribute Questions

1. Once the admin initiates the exam distribution process, a unique token is generated for all students. The token and the expiry date is stored in the new database for later use. 
2. The token is embedded in the url and a unique link is sent to all the student's email directing them to `exam_question_distributer.php`, which through tokens checks if the link is still valid and if valid it
   gives the questionnaire, else it rejects the request.

### Step 3: Student Takes the Exam

1. Students receive the exam link via email.
2. Students click on the link to access their exam questions online if the link is still valid.
3. Students answer the questions within the specified time frame (expiry time), and submit the answers along with their name and email address.

### Step 4: Collect and Record Responses

1. The system records the students' responses to each question and stores them in the database.




---

Developed by Prabin Lamichhane
