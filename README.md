TradeMate – Backend (Laravel)

A smart job-matching platform connecting Homeowners with skilled Trade Professionals such as plumbers, electricians, decorators, scaffolders, and more.
TradeMate streamlines job posting, service hiring, and skill-based job hunting with secure authentication, subscription rules, and role-based permissions.

✅ Key Features
👤 User Roles
Role	Description
Super Admin	Complete system control, approve trade workers, manage roles & permissions, subscription plans, categories, jobs
Homeowner	Register/Login, create profile, post jobs, manage bookings
Trade Person	Register/Login, choose profession, subscribe to apply for jobs, receive job alerts & apply
🎯 Core Functionalities

Role-based authentication (Super Admin / Homeowner / Trade Person)

Job Posting by Homeowners

Job Apply System

Trade Person must select/activate a subscription plan before applying

Applications require Super Admin approval

Category-based Job Notifications

Subscription system

Profile Management

Contact Us & About Us

Admin Panel with Roles & Permissions (Spatie)

🛠️ Tech Stack
Category	Tools
Backend Framework	Laravel
Authentication	Laravel Breeze / Sanctum / Passport (your choice)
Authorization	Spatie Roles & Permissions
Database	MySQL / PostgreSQL
API Format	REST JSON APIs
Deployment	Linux / Nginx / Apache / Docker (future)
📦 Installation & Setup
1️⃣ Clone the repository
git clone https://github.com/yourusername/trademate-backend.git
cd trademate-backend

2️⃣ Install dependencies
composer install
npm install

3️⃣ Environment Setup
cp .env.example .env
php artisan key:generate


Configure DB credentials inside .env

4️⃣ Migrate & Seed
php artisan migrate --seed

5️⃣ Storage Link
php artisan storage:link

6️⃣ Run server
php artisan serve

🔐 Authentication & User Roles
Default Role Creation:

Super Admin

Trade Person

Homeowner

Permissions Included:

User management

Job management

Category & Subscription management

Access control & approvals

🚀 API Modules
Module	Endpoints
Auth	Register, Login, Logout
Profile	View & Update profile
Jobs	Post, View, Apply, Approve
Subscription	Plans, Purchase
Notifications	Category-based alerts
Contact	Submit contact request
CMS	About Us, Policy, Terms
📂 Folder Structure
app/
 ├── Http/
 │   ├── Controllers/
 │   ├── Middleware/
 │   └── Requests/
 ├── Models/
 └── Services/
database/
routes/
resources/

💼 Future Enhancements

Push Notifications (Firebase / OneSignal)

Stripe/PayPal subscription billing

Realtime chat between Homeowner & Tradesperson

Review & rating system

Mobile App API support

🤝 Contribution Guide

Follow PSR-12 coding standards

Use feature branches & PR workflow

Respect migration & API versioning

🔗 ER Diagram

Users
 ├── id
 ├── name
 ├── email
 ├── password
 ├── role (homeowner/tradeperson)
 └── profile fields

Roles (Spatie)
Permissions (Spatie)
Role_has_permissions (Spatie)
Model_has_roles (Spatie)

Categories
 ├── id
 └── name

Jobs
 ├── id
 ├── user_id (homeowner)
 ├── category_id
 ├── title
 ├── description
 ├── budget
 └── status (open/closed)

JobApplications
 ├── id
 ├── job_id
 ├── tradeperson_id
 └── status (pending/approved/rejected)

SubscriptionPlans
 ├── id
 ├── name
 ├── price
 └── duration_days

UserSubscriptions
 ├── id
 ├── user_id
 ├── plan_id
 ├── start_date
 └── end_date

ContactMessages
 ├── id
 ├── name
 ├── email
 ├── message

AboutUs
 ├── id
 └── description


🛡️ Security Best Practices

.env not committed

CSRF protection enabled

SQL injection & XSS safe validation

Role & permission middleware on every protected route

📄 License

This project is licensed under the MIT License.

🙋 Need Help?

If you face any issue, feel free to contact the maintainers or open a GitHub issue.

⭐ If you like this project, please star the repo!
