Project: User Login, Registration, and Cart Logic

Description:
This project implements a basic user login and registration system with personalized cart functionality. Each user has a separate cart that persists independently, ensuring users do not share cart data.

Features:
- User registration with validation
- User login authentication
- User-specific cart storage and retrieval
- Cart data is isolated per user session

How it Works:
1. User registers using the registration form.
2. User logs in with credentials.
3. Upon login, each user’s cart data is loaded separately.
4. Cart operations (add, remove, update) only affect the logged-in user's cart.

Usage:
- Include the login and registration scripts in your application.
- Integrate the cart logic inside the user session context.
- Ensure database or session storage is configured to keep user carts separate.

Setup:
- Configure the database with the user and cart tables.
- Update database connection settings in the code.
- Run the registration and login forms to test functionality.

Notes:
- This is a simple implementation suitable for learning or basic projects.
- For production use, enhance security measures such as password hashing and input sanitization.

- Contact:
For questions, improvements contact thakurr10911@gmail.com.
