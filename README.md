# Youdemy Platform

## Project Context
Youdemy is an online course platform aiming to revolutionize learning by providing an interactive and personalized system for students and teachers.

---

## Functional Requirements

### Front Office

#### Visitor
- Access the course catalog with pagination.
- Search for courses using keywords.
- Create an account with a choice of role (Student or Teacher).

#### Student
- View the course catalog.
- Search and consult course details (description, content, teacher, etc.).
- Enroll in courses after authentication.
- Access a "My Courses" section featuring joined courses.

#### Teacher
- Add new courses with the following details:
  - Title, description, content (video or document), tags, and category.
- Manage courses:
  - Modify, delete, and view enrollment details.
- Access a "Statistics" section with insights such as:
  - Number of enrolled students, number of courses, etc.

### Back Office

#### Administrator
- Validate teacher accounts.
- Manage users:
  - Activate, suspend, or delete accounts.
- Manage content:
  - Courses, categories, and tags.
  - Bulk insertion of tags for efficiency.
- Access global statistics:
  - Total number of courses.
  - Distribution by category.
  - Course with the highest student enrollment.
  - Top 3 teachers.

### Cross-functional Features
- A course can have multiple tags (many-to-many relationship).
- Implementation of polymorphism for methods like adding and displaying courses.
- Authentication and authorization system to protect sensitive routes.
- Access control ensuring users only access features relevant to their roles.

---

## Technical Requirements
- Adherence to OOP principles (encapsulation, inheritance, polymorphism).
- Relational database management with relationships (one-to-many, many-to-many).
- Use of PHP sessions for managing logged-in users.
- User data validation to ensure security.
- A comprehensive README file accompanying the project.

---

## Installation and Setup
1. Clone the repository:
   ```bash
   git clone <repository_url>
   ```
2. Navigate to the project directory:
   ```bash
   cd Youdemy
   ```
3. Configure the database:
   - Import the `database.sql` file into your preferred RDBMS.
   - Update database connection details in the configuration file.
4. Install necessary dependencies:
   ```bash
   composer install
   ```
5. Start the local development server:
   ```bash
   php -S localhost:8000
   ```
6. Access the application at `http://localhost:8000`.

---

## File Structure
```
youdemy/
├  src/
  ├── assets/          # Static assets (CSS, JS, images)
  ├── config/          # Configuration files
  ├── controllers/     # Application controllers
  ├── models/          # Data models
  ├── views/ # Application views
          
├── index.php        # Main entry point
├── README.md        # Project documentation
└── composer.json    # Composer dependencies
```

---

## Contribution Guidelines
1. Fork the repository.
2. Create a new branch for your feature:
   ```bash
   git checkout -b feature/your-feature-name
   ```
3. Commit your changes with descriptive messages:
   ```bash
   git commit -m "Add feature description"
   ```
4. Push the changes and create a pull request:
   ```bash
   git push origin feature/your-feature-name
   ```

---

## License
This project is licensed under the [MIT License](LICENSE).
