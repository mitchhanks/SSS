# Secure Screening Test

This project is a Laravel and React-based application for managing and viewing tickets. The backend is built with Laravel 10, while the frontend is developed with React and utilizes Vite for bundling and development.

---

## Requirements

Ensure you have the following installed on your system:

1. **PHP** (>= 8.2)
2. **Composer** (Latest version)
3. **Node.js** (>= 16.x)
4. **npm** or **yarn**
5. **MySQL** (or any other database supported by Laravel)
6. **Docker** (optional, if using containers)

---

## Setup Instructions

### 1. Clone the Repository

Clone the repository to your local machine:
```bash
git clone git@github.com:mitchhanks/SSS.git
cd SSS
```

### 2. Backend Setup (Laravel)

#### Install Dependencies

Install PHP and Laravel dependencies using Composer:
```bash
composer install
```

#### Environment Configuration

Copy the example `.env` file and configure your environment:
```bash
cp .env.example .env
```
Update the `.env` file with your database credentials and other configurations:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

#### Generate Application Key

Run the following command to generate a unique application key:
```bash
php artisan key:generate
```

#### Migrate the Database

Run the migrations to set up the database:
```bash
php artisan migrate
```

#### Seed the Database

Seed the database with dummy data (if applicable):
```bash
php artisan db:seed
```

#### Start the Laravel Server

Start the Laravel development server:
```bash
php artisan serve
```
This will run the backend at `http://localhost:8000`.

#### Schedule Worker

Start the scheduler worker to process scheduled tasks:
```bash
php artisan schedule:work
```
This ensures that ticket generation and other scheduled tasks are handled correctly.

---

### 3. Frontend Setup (React)

#### Install Dependencies

Navigate to the `resources/js` directory and install Node.js dependencies:
```bash
npm install
```

#### Start the Frontend Development Server

Start the Vite development server:
```bash
npm run dev
```
This will run the frontend at `http://localhost:3000` (or a different port, as indicated in the terminal).

---

## Accessing the Application

1. **Open the frontend in your browser**: Go to the Vite server URL (e.g., `http://localhost:3000`).
2. **Ensure the backend is running**: The frontend communicates with the Laravel backend at `http://localhost:8000`. Ensure both are running simultaneously.

---

## Notes

- Ensure the `.env` file is correctly configured for both the backend and database.
- Run the `schedule:work` command in a separate terminal to ensure background tasks like ticket generation are executed.
- If using Docker, you may need to adjust the `.env` configuration for containerized environments.

---

Let me know if you encounter any issues while setting this up!

