📌 To-Do List Application

A modern Full Stack To-Do List Application built with Laravel (backend) and Vue.js (frontend).
This app allows users to register, log in, and manage their personal tasks with a sleek interface and real-time updates.
![image alt](https://github.com/othman-geurrar/larav-vue-todo/blob/5b5a3377d11712bd22877b3bf3be3db9392595dd/Capture%20d%E2%80%99%C3%A9cran%202025-09-04%20225330.png)
![image alt](https://github.com/othman-geurrar/larav-vue-todo/blob/f7578c60caa67c8f99a7673c304c3bd85b8d8967/Capture%20d%E2%80%99%C3%A9cran%202025-09-04%20225400.png)
![image alt](https://github.com/othman-geurrar/larav-vue-todo/blob/f00e8737003dd1cd2389ec171927835266e28096/Capture%20d%E2%80%99%C3%A9cran%202025-09-04%20225634.png)

🚀 Tech Stack
🔹 Backend

Laravel (API)

MySQL (Database)

JWT Authentication

Laravel Sanctum / Middleware for security

🔹 Frontend

Vue.js 3

Pinia (State Management)

Axios (API calls)

TailwindCSS + ShadCN (modern UI)
⚙️ Installation Guide
1️⃣ Backend Setup (Laravel + MySQL)
# Clone the repository
git clone https://github.com/your-repo/todo-app.git

cd todo-app/backend

# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database (.env)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# Run migrations
php artisan migrate

# Start backend server
php artisan serve

2️⃣ Frontend Setup (Vue.js)
cd ../frontend

# Install dependencies
npm install

# Start development server
npm run dev
📂 Project Structure
todo-app/
│── backend/        # Laravel backend (API + Auth + DB)
│── vue/my-vue-app     # Vue.js frontend (UI + State Management)
🔑 Features

✅ User Authentication (Register / Login)
✅ JWT-based session management
✅ Create, Read, Update, Delete (CRUD) tasks
✅ Only authenticated users can access their own tasks
✅ Modern, responsive UI with Tailwind + ShadCN

🖥️ Usage

Visit http://127.0.0.1:8000
 → Backend API

Visit http://localhost:5173
 → Frontend app

Register a new account

Log in with your credentials

Start managing your tasks 🎯
