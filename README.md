# FrameForge Studio Portal

Local XAMPP/PHP/MySQL employee portal for a motion design and VFX studio.

## Install

1. Copy the `studio-portal` folder into `C:\xampp\htdocs\`.
2. Start **Apache** and **MySQL** in XAMPP.
3. Open phpMyAdmin, choose **Import**, and import `studio_portal.sql`.
4. Visit `http://localhost/studio-portal/`.
5. Sign in with `admin@frameforge.local` / `ChangeMe123!`, then change the seeded password immediately.

If your MySQL root account has a password, update `DB_PASS` in `config.php`. Uploaded content is stored under `uploads/` in the project directory.

## Security and behavior

Passwords use PHP password hashing, every write form uses CSRF protection, prepared statements, server-side validation, and restricted MIME/type/size upload validation. Attendance uses PHP server time and the timezone configured under Settings (default `Asia/Karachi`).
