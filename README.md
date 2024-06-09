# President University E-Course

Welcome to the President University E-Course project! This repository contains the code and documentation for an innovative e-course platform developed to facilitate online learning and comprehensive educational management at President University. Our mission is to provide a seamless and intuitive platform that enhances the educational experience for students through efficient course management, streamlined procurement processes, and robust administrative functionalities.

## Table of Contents

- [Project Description](#project-description)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Usage](#usage)
- [Database Setup](#database-setup)
- [Folder Structure](#folder-structure)
- [Screenshots](#screenshots)

## Project Description

The President University E-Course platform is designed to address the growing need for digital transformation in education. As institutions worldwide transition to online and hybrid learning models, there is a pressing need for tools that not only facilitate content delivery but also streamline administrative processes. This platform serves as a comprehensive solution for managing courses, sales, procurement, and financial transactions, thereby reducing administrative burdens and improving overall efficiency.

### Objectives
The primary objectives of the platform are to:
- **Facilitate Online Learning**: Provide an accessible, interactive, and engaging online learning environment for students.
- **Optimize Procurement Processes**: Streamline the procurement of raw materials necessary for course activities, ensuring timely and efficient handling of orders, receipts, and payments.
- **Enhance Administrative Functions**: Support a wide range of administrative tasks, including tracking sales orders, managing accounts receivable and payable, and maintaining an accurate inventory of company assets.

### Key Benefits
- **User-Friendly Interface**: The platform is designed with a focus on user experience, ensuring that users can navigate and utilize its features with ease, regardless of their technical proficiency.
- **Comprehensive Features**: From course management to financial tracking, the platform offers a wide range of features that cater to the diverse needs of educational institutions, helping them to operate more efficiently and effectively.
- **Scalability**: The platform is built to handle increasing amounts of data and users, making it suitable for institutions of all sizes and adaptable to future growth and changes.

### Why President University E-Course?
With the increasing demand for online education, it is crucial to have a platform that not only supports content delivery but also integrates seamlessly with administrative functions. President University E-Course stands out by providing a holistic solution that addresses both educational and operational needs, ensuring a cohesive and efficient learning environment.

## Features

### Product Sales (Assignment 2)
- **Sales Order Management**: Create and manage sales orders with ease.
- **Payment Status Tracking**: Monitor and update the payment status for all orders.
- **Delivery Instructions**: Provide detailed delivery instructions and manage logistics.
- **Goods Management**: Record and update the number of goods sold and goods on hand to maintain accurate inventory.
- **Revenue Recording**: Track and record revenue and cash inflow to ensure financial transparency.

### Raw Material Procurement (Assignment 3)
- **Purchase Order Creation**: Create and manage purchase orders for raw materials necessary for course activities.
- **Goods Receipt**: Record the number of raw materials received to ensure accurate inventory management.
- **Payment Processing**: Manage and process payments for raw materials efficiently.
- **Expenditure Recording**: Track and record expenditures and cash outflow to maintain financial accountability.

### Sales Order (Assignment 4)
- **Sales Order Listing**: View and manage all sales orders in a centralized system.
- **Account Receivable Listing**: View and manage accounts receivable to ensure timely collections.
- **Account Payable Listing**: View and manage accounts payable to ensure timely payments and maintain good vendor relationships.

### Additional Features
- **High Achiever Employee Listing (Sales Department)**: List and manage high achiever employees in the Sales Department, supporting HR incentive programs.
- **High Achiever Employee Listing (Purchase Department)**: List and manage high achiever employees in the Purchase Department, supporting HR incentive programs.
- **Product Listing**: Manage and list company assets (products) to maintain accurate inventory records.
- **Raw Material Listing**: Manage and list company assets (raw materials) to ensure efficient procurement and inventory management.

## Technologies Used

- **Frontend**: HTML, CSS, JavaScript, Bootstrap
- **Backend**: PHP
- **Database**: MySQL, phpMyAdmin
- **Version Control**: Git, GitHub

## Usage

1. Open your browser and navigate to `http://localhost:8080`.
2. Register a new account or log in with existing credentials.
3. Explore the features, manage courses, sales, procurement, and track accounting information.

## Database Setup

1. Open phpMyAdmin and create a new database named `ecourses2`.
2. Import the database schema from the `database/ecourses2.sql` file into your newly created database.
3. Update the `config/database.php` file with your database credentials.

## Folder Structure

```
President-University-E-Course/
├── E-Course-Admin/
│   ├── admin/
│   ├── build/
│   ├── classes/
│   ├── database/
│   ├── dist/
│   ├── inc/
│   ├── libs/
│   ├── node_modules/
│   ├── plugins/
│   ├── uploads/
│   ├── .htaccess
│   ├── 404.html
│   ├── Project-Task.jpg
│   ├── config.php
│   ├── index.php
│   ├── initialize.php
│   ├── package-lock.json
│   ├── package.json
├── E-Course-Website/
│   ├── assets/
│   ├── database/
│   ├── node_modules/
│   ├── pages/
│   ├── package-lock.json
│   ├── package.json
├── README.md
```

- **E-Course-Admin/admin/**: Admin-related files and configurations.
- **E-Course-Admin/build/**: Build files for the admin interface.
- **E-Course-Admin/classes/**: PHP classes for handling backend logic.
- **E-Course-Admin/database/**: Database-related scripts and files.
- **E-Course-Admin/dist/**: Distribution files for the admin interface.
- **E-Course-Admin/inc/**: Includes files for reusable code.
- **E-Course-Admin/libs/**: Libraries used in the project.
- **E-Course-Admin/node_modules/**: Node.js modules for dependencies.
- **E-Course-Admin/plugins/**: Plugins used in the admin interface.
- **E-Course-Admin/uploads/**: Uploaded files.
- **E-Course-Admin/.htaccess**: Apache configuration file.
- **E-Course-Admin/404.html**: Custom 404 error page.
- **E-Course-Admin/Project-Task.jpg**: Project task image.
- **E-Course-Admin/config.php**: Configuration file for database connections.
- **E-Course-Admin/index.php**: Main entry point for the admin interface.
- **E-Course-Admin/initialize.php**: Initialization script.
- **E-Course-Admin/package-lock.json**: Lock file for Node.js dependencies.
- **E-Course-Admin/package.json**: Configuration file for Node.js dependencies.

- **E-Course-Website/assets/**: Assets such as images, stylesheets, and scripts.
- **E-Course-Website/database/**: Database-related scripts and files.
- **E-Course-Website/node_modules/**: Node.js modules for dependencies.
- **E-Course-Website/pages/**: Frontend pages of the website.
- **E-Course-Website/package-lock.json**: Lock file for Node.js dependencies.
- **E-Course-Website/package.json**: Configuration file for Node.js dependencies.

## Screenshots

Here are some screenshots of the President University E-Course platform:

### Admin Interface
![Admin Dashboard](path/to/admin-dashboard-screenshot.png)
*Admin dashboard showing an overview of sales orders, procurement, and employee performance.*

![Sales Order Management](path/to/sales-order-management-screenshot.png)
*Sales order management interface where sales orders are created, updated, and tracked.*

### Student Interface
![Student Dashboard](path/to/student-dashboard-screenshot.png)
*Student dashboard showing enrolled courses, progress tracking, and upcoming assignments.*

![Course Content](path/to/course-content-screenshot.png)
*Course content page displaying multimedia learning materials and interactive assignments.*
