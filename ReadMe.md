# E-Waste Recycling Management System
Overview: A full-stack web application that allows users to submit electronic waste pickup request, track their status, earn reward points and enable admins to manage request, assign recycling centers, and generate reports.
## Group Information
- Group Number: 4
- Course Name: Database Management System
- Instructor Name: Md. Fahmidur Rahman Sakib
- Group Members:
  - Dabosri Roy Porna – ID: 242-115-336
  - Tamzida Habiba Mim – ID: 242-115-334
  - Fahmida Yeasmin – ID: 242-115-332
  - Falguni Sharma – ID: 242-115-314


## Individual Contribution

| Dabosri Roy Porna | Authentication Module    | Registration, Login, Logout, Session Management |
| Tamzida Habiba Mim| User Request Module      | Submit Request, Dashboard, Track Status         |
| Fahmida Yeasmin   | Admin Management Module  | Approve/Reject/Assign/Complete Requests         |
| Falguni Sharma    | Rewards & Reports Module | Reward Calculation, Reports, Center Management  |

## Objective
The E‑Waste Recycling Management System is designed to help users submit electronic waste pickup requests, track their status, earn reward points, and allow admins to manage requests, assign recycling centers, and generate reports. The system encourages responsible e‑waste disposal and recycling.


## Features
### User Features
- **Register/Login** – Secure user registration and login with hashed passwords.
- **Submit E‑waste Request** – Users can submit pickup requests with waste type, quantity, and address.
- **Track Status** – Users can view all their requests and their status (Pending, Approved, Rejected, Completed).
- **View Rewards** – Users earn 5 points per item recycled; the rewards page shows total points and history.

### Admin Features
- **Manage Pickup Requests** – Admin can approve, reject, assign recycling centers, and mark requests as completed.
- **Manage Recycling Centers** – Admin can add or delete recycling centers.
- **Generate Reports** – Admin can view waste collected by type and performance by center.
- **Dashboard** – Admin dashboard shows summary statistics (total requests, pending, users, centers).

## Tech Stack
- **Frontend:** HTML, CSS, Bootstrap 5, Font Awesome
- **Backend:** PHP (PDO, Sessions)
- **Database:** MySQL
- **Server:** Apache (XAMPP)

## ER Diagram
erDiagram
    USERS ||--o{ REQUESTS : places
    USERS ||--|| REWARDS : earns
    RECYCLING_CENTERS ||--o{ REQUESTS : receives

    USERS {
        int id PK
        string name
        string email UK
        string phone
        string password
        enum role
        datetime created_at
    }

    ADMIN {
        int id PK
        string username UK
        string password
    }

    RECYCLING_CENTERS {
        int center_id PK
        string center_name
        text address
        string phone
    }

    REQUESTS {
        int request_id PK
        int user_id FK
        string waste_type
        int quantity
        text address
        date request_date
        enum status
        int center_id FK
    }

    REWARDS {
        int reward_id PK
        int user_id FK
        int points
    }

## Installation and setup
1. Install XAMPP and start Apache + MySQL.
2. Import the database from `ewaste_db.sql` (or run the provided SQL queries).
3. Copy the project folder to `C:\xampp\htdocs\ewaste`.
4. Open `http://localhost/ewaste/` in your browser.

### Project Structure
- `users` – Stores user details (name, email, phone, password, role).
- `admin` – Stores admin credentials.
- `recycling_centers` – Stores recycling center information.
- `requests` – Stores all pickup requests (linked to users and centers).
- `rewards` – Stores user reward points.

- ## Video Demonstration
[Click here to watch the video](https://youtu.be/YOUR_VIDEO_LINK)
