
<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions">
    <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

---

# To-Do List Application

This **To-Do List Application** is a Laravel-based project designed to help users manage their tasks effectively with real-time notifications and advanced features like file handling and task filtering.

---

## Key Features

- **User Authentication**:
  - Secure login and registration using Laravel's authentication system.
- **Task Management**:
  - Create, update, delete, and view tasks.
  - File handling (upload, view, download, delete) for tasks.
- **Data Integration**:
  - Import/export tasks to/from CSV files.
- **Sorting and Filtering**:
  - Sort tasks by deadline or added date in ascending/descending order.
  - Search tasks by title.
- **Real-Time Notifications**:
  - Integrated Pusher (web sockets) to notify users of task updates.
- **Data Cleanup and Archiving**:
  - Scheduled tasks for data maintenance.

---

## Getting Started

### Prerequisites

- **PHP** >= 8.0
- **Composer**
- **MySQL** or any preferred database
- **Node.js** and npm (optional for front-end scaffolding)
- **Pusher** account for real-time notifications

---

### Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/YazanM23/To-Do-List
   cd To-Do-List
   ```

2. **Install dependencies**:
   ```bash
   composer install
   npm install
   npm run dev
   ```

3. **Set up environment variables**:
   ```bash
   cp .env.example .env
   ```
   Configure the `.env` file with your database and Pusher credentials.

4. **Generate application key**:
   ```bash
   php artisan key:generate
   ```

5. **Run database migrations**:
   ```bash
   php artisan migrate
   ```

6. **Set Up Pusher**:
   - Install the Pusher PHP SDK:
     ```bash
     composer require pusher/pusher-php-server
     ```
   - Update your `.env` file with Pusher credentials:
     ```env
     BROADCAST_DRIVER=pusher

     PUSHER_APP_ID=your-app-id
     PUSHER_APP_KEY=your-app-key
     PUSHER_APP_SECRET=your-app-secret
     PUSHER_APP_CLUSTER=your-app-cluster
     ```
   - Add Pusher configuration to `config/broadcasting.php`:
     ```php
     'pusher' => [
         'driver' => 'pusher',
         'key' => env('PUSHER_APP_KEY'),
         'secret' => env('PUSHER_APP_SECRET'),
         'app_id' => env('PUSHER_APP_ID'),
         'options' => [
             'cluster' => env('PUSHER_APP_CLUSTER'),
             'useTLS' => true,
         ],
     ],
     ```

7. **Start the application**:
   ```bash
   php artisan serve
   ```

---

## Routes

### General Routes

- **Home**:  
  `GET /`  
  Displays the welcome page.

- **Dashboard**:  
  `GET /dashboard`  
  Displays the user dashboard (requires authentication).

- **Profile Management**:
  - `GET /profile` - Edit user profile.
  - `PATCH /profile` - Update profile details.
  - `DELETE /profile` - Delete user profile.

---

### Task Management Routes

- **Tasks**:
  - `GET /tasks` - Retrieve all tasks.
  - `GET /tasks/{id}/view` - View task details.
  - `POST /tasks` - Create a new task.
  - `PUT /tasks/{id}/update` - Update task details.
  - `DELETE /tasks/{id}/delete` - Delete a task.
  - `PUT /tasks/{id}/status` - Update task status.

- **File Handling**:
  - `POST /tasks/{id}/download` - Download a file associated with a task.
  - `DELETE /tasks/{id}/deleteFile` - Delete a file associated with a task.

- **Filters and Search**:
  - `GET /filter` - Filter tasks by date or deadline.
  - `GET /search` - Search tasks by title.

- **Import/Export**:
  - `GET /export` - Export tasks to a CSV file.

---

## License

This project is open-source and available under the [MIT License](LICENSE).

---

## Contact

For queries or feedback, reach out:

- **Name**: Yazan Mansour
- **Email**: Yazan.mansour2003@gmail.com
