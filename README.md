# President University E-Course

Welcome to the President University E-Course project! This repository contains the code and documentation for an innovative e-course platform developed to facilitate online learning and comprehensive educational management at President University. The mission is to provide a seamless and intuitive platform that enhances the educational experience for students through efficient course management, streamlined procurement processes, and robust administrative functionalities.

## Table of Contents

- [Project Description](#project-description)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Database Setup](#database-setup)
- [Folder Structure](#folder-structure)

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

## Technologies Stack

- **Frontend**: HTML, CSS, JavaScript, Bootstrap, Tailwind
- **Backend**: PHP
- **Database**: MySQL, phpMyAdmin
- **Version Control**: Git, GitHub

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
