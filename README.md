## How to start the project

Get the env file

```bash
cp .env.example .env
```

Install composer dependencies

```bash
composer update
```

Install node dependencies (for livewire) and build

```bash
npm install && npm run dev
```

Start sail and generate a new app key

```bash
sail up
sail artisan key:generate
```

Migrate and seed the db (for testing)

```bash
sail artisan migrate:fresh --seed
```

You'll find the app running on localhost:80
