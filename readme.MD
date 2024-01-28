# Laravel Smart Migrations

Laravel Smart Migrations is an innovative package designed to supercharge your Laravel migration workflow. By leveraging artificial intelligence, specifically OpenAI's GPT-3, this package intelligently generates foundational files such as models, factories, seeders, requests, resources, and controllers based on your migrations. Moreover, it provides AI-driven enhancements to these files, ensuring they are not only functional but also adhere to best practices and real-world application needs.

## Features

- **Smart Migrations**: Detect migrations marked as smart and automatically generate corresponding Laravel components.
- **OpenAI Enhancements**: Utilize AI to enhance files with realistic and relevant content, tailored to your specific migration structure.
- **Efficiency Boost**: Speed up the development process by generating the boilerplate code for an entire feature set in your application.
- **Customizability**: Tailor the AI enhancements to fit your project's unique requirements through configurable settings.

## Installation

To install the package, run the following command in your Laravel project:

```bash
composer require ricardovanderspoel/laravel-smart-migrations
```

Next, you'll need to configure the .env file by adding your OpenAI API key:

```
OPENAI_API_KEY=your_openai_api_key_here
```

Optionally, you can publish the package configuration to customize the AI enhancements:

```bash
php artisan vendor:publish --provider="RicardoVanDerSpoel\LaravelSmartMigrations\LaravelSmartMigrationsServiceProvider"
```

## Usage

To run smart migrations and automatically generate and enhance the foundational files, execute:

```bash
php artisan migrate:smart
```

Ensure your migrations include the `protected $is_smart = true;` property to be recognized as smart migrations by the package.

## Configuration

The published config file `config/smartmigrations.php` contains definitions for AI enhancements. You can customize the context, specify related context files, and set up different aspects of AI behavior to suit your project requirements.

## Contributing

Contributions are welcome, and we accept contributions via Pull Requests on GitHub.

- Fork the repository
- Create your feature branch (`git checkout -b feature/amazing-feature`)
- Commit your changes (`git commit -am 'Add some amazing feature'`)
- Push to the branch (`git push origin feature/amazing-feature`)
- Open a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](LICENSE.md).
