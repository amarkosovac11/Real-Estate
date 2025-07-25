# 🏡 Real Estate Database Management System

A full-stack web-based real estate management platform designed to handle listings, users, and transactions with role-based control and database integrity. Built as part of a CS306 - Database Management course project.

## 📋 Table of Contents

- [Project Overview](#project-overview)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Database Design](#database-design)
- [User Roles](#user-roles)
- [Installation](#installation)
- [Authors](#authors)

---

## 🧠 Project Overview

The Real Estate DBMS is built to streamline property management operations for agents, clients, property owners, and administrators. It enables:

- Secure user authentication  
- Role-specific dashboards  
- Property listings and transactions  
- Administrative oversight  
- Data consistency via relational design and normalization  

This system is implemented using **MySQL** as the backend and a **PHP-based** frontend with **Bootstrap** styling.

---

## 🌟 Features

### ✅ Functional

- **Authentication System**: Login for all roles
- **Role-based Access**: Separate dashboards for Admin, Agent, Client, Owner
- **Property Management**: Add/update/delete properties
- **Listings**: Agents create listings
- **Transactions**: Clients can buy/rent properties
- **Admin Controls**: Manage all users, properties, and transactions

### 🔐 Non-Functional

- Hashed passwords (MD5 used for demo)
- Cascading deletes to maintain data integrity
- Responsive interface (Bootstrap)
- Normalized database schema (3NF)

---

## ⚙️ Technologies Used

- **Frontend**: HTML, CSS, JavaScript, Bootstrap  
- **Backend**: PHP  
- **Database**: MySQL  
- **Tools**: phpMyAdmin, dbdiagram.io  

---

## 🗃️ Database Design

The database is structured using 3NF principles and includes the following tables:

- `admin`, `agent`, `client`, `owner`  
- `property`, `listing`, `transaction`, `rentaldetails`  

### Key Concepts:

- **One-to-many**: Agent → Properties, Owner → Properties, Client → Transactions  
- **One-to-one**: Property ↔ Listing, Transaction ↔ RentalDetails  

For detailed ERD and table structure, see the `docs/` folder (if applicable).

---

## 👤 User Roles

| Role          | Capabilities                                                                 |
|---------------|-------------------------------------------------------------------------------|
| **Admin**     | Full control. Can manage users, properties, transactions, and listings.      |
| **Agent**     | Add/manage their own properties, initiate transactions, create listings.     |
| **Owner**     | Add/manage own properties (no listing or transaction access).                |
| **Client**    | Browse properties, initiate purchases or rentals, and view transactions.     |

---



## 👨‍💻 Authors

- **Amar Kosovac**
- **Faris Mujačić**

Spring 2025, Sarajevo.

