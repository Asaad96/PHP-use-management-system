PHP-use-management-system
Project Overview This project is a simple user management system built entirely with native PHP (no frameworks).
It includes user registration, authentication, profile management, and logout functionalities — following all requirements from the assignment.

Features

User Registration

Requires name, username, phone number, email, password, and confirm password.
Validates unique username, phone, and email.
Passwords are hashed for secure storage.
Displays clear error messages on validation failure.
User Login

Login possible using either email or phone number.
Passwords are verified securely.
Integrated Yandex SmartCaptcha protection.
Redirects to profile page upon successful login.
Profile Page

Accessible only for authorized (logged-in) users.
Displays user information (name, username, email, phone).
Unauthorized users are redirected to the login page.
Edit Profile

Allows logged-in users to update their personal information (name, email, phone, password).
Ensures email and phone remain unique.
Password update is optional.
Logout

Securely destroys user session and redirects to login page.
Displays a confirmation message after logout.
