# Knowledge Base (kb-new)

A modern Laravel-powered Knowledge Base platform with admin dashboard, article management, user roles, and analytics.

## Features

- **Admin Dashboard**: Manage users, articles, approvals, invitations, and system settings.
- **User Dashboard**: View stats, create articles, see top contributors, and manage your profile.
- **Article Approval Workflow**: Approve/reject articles with email notifications.
- **Role-based Access**: Permissions for admins, editors, and contributors.
- **Livewire Components**: Dynamic article lists and interactive UI.
- **Responsive Design**: Tailwind CSS for a clean, modern look.
- **Dark Mode**: Seamless light/dark theme support.

## Getting Started

### Prerequisites

- PHP >= 8.1
- Composer
- Node.js & npm
- MySQL or PostgreSQL

### Installation

1. **Clone the repository**
    ```sh
    git clone https://github.com/yourusername/kb-new.git
    cd kb-new
    ```

2. **Install dependencies**
    ```sh
    composer install
    npm install
    ```

3. **Copy and configure environment**
    ```sh
    cp .env.example .env
    # Edit .env with your database and mail settings
    ```

4. **Generate application key**
    ```sh
    php artisan key:generate
    ```

5. **Run migrations and seeders**
    ```sh
    php artisan migrate --seed
    ```

6. **Build frontend assets**
    ```sh
    npm run build
    ```

7. **Start the development server**
    ```sh
    php artisan serve
    ```

## Usage

- Visit `/admin` for the admin dashboard.
- Visit `/dashboard` for the user dashboard.
- Create, edit, and approve articles.
- Manage users and invitations.

## Folder Structure

- `app/Models` - Eloquent models (Article, User, etc.)
- `app/Services` - Business logic (e.g., ArticleApprovalService)
- `app/Traits` - Shared traits (e.g., SendsEmailNotifications)
- `resources/views` - Blade templates for dashboards and pages
- `resources/views/admin` - Admin dashboard views
- `resources/views/dashboard.blade.php` - User dashboard view
- `routes/web.php` - Web routes

## Contributing

Pull requests are welcome! For major changes, please open an issue first to discuss what you would like to change.

## License

[MIT](LICENSE)

## Credits

- Laravel
- Tailwind CSS
- Livewire
- All contributors
