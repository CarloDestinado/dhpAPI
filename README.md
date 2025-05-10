# projectvantage-laravel Project

## Feature List:
### 1. Authentication
- Register
- Login
- Password Reset
- Logout
### 2. Profile Page
- Get Profile Info
- Change Profile Info
- Change Password
### 3. User Page
- Get Users
- Add User
- Edit User
- Remove User
### 4. Project Page
- Get Projects
- Add Project
- Edit Project
- Remove Project
- Get Tasks
- Add Task
- Edit Task
- Remove Task
### 5. Teams Page
- Get Teams
- Add Team
- Edit Team
- Remove Team
- Get Team Members
- Add Member
- Remove Member
- Get Projects
- Assign Team to a Project
### 6. Task Page
- Get Team Members
- Get Tasks
- Assign Task
- Replace Task
- Remove Task
- Complete Task
### 7. Roles Page
- Get Roles
- Add Role
- Edit Role
- Remove Role
### 8. Status Page
- Get Statuses
- Add Status
- Edit Status
- Remove Status

## Prerequisites

Before setting up the project, ensure you have the following installed:

- [XAMPP](https://www.apachefriends.org/download.html) (includes PHP, MySQL, and Apache)
- [Visual Studio Code](https://code.visualstudio.com/download) (recommended code editor)
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/en/download/) (>= 14.x)
- [Git](https://git-scm.com/downloads)

## Setup Instructions

1. Clone the repository:
   ```
   git clone https://github.com/your-username/sim.git](https://github.com/ScepticMaku/projectvantage-laravel.git
   cd projectvantage
   ```

2. Open terminal and install PHP dependencies:
   ```
   composer install
   ```

3. Create a copy of the `.env.example` file and rename it to `.env`:
   ```
   cp .env.example .env
   ```

4. Generate an application key:
   ```
   php artisan key:generate
   ```

5. Configure your database in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=projectvantage
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. Run database migrations:
   ```
   php artisan migrate
   ```

7. Start the development server:
    ```
    php artisan serve
    ```

8. Visit `http://localhost:8000` in your browser to see the application.

## Running the Application

1. Start the Laravel development server:
   ```
   php artisan serve
   ```

2. Access the application at `http://localhost:8000`

## Additional Configuration

- To configure other services or features, refer to the Laravel documentation: [https://laravel.com/docs](https://laravel.com/docs)

## Troubleshooting

If you encounter any issues during setup or running the application, please check the Laravel and Vue.js documentation or open an issue in this repository.

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct and the process for submitting pull requests.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.
