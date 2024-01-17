### Certifier ###

## Usage
A fully responsive, cross-platform project where one can do social login/signup via Google, Facebook, GitHub.
Upload certificate image.
Set text on image.
Upload data for certificates.
Put mail credentials and send the mail.
Your work will be done by Async Operations in background. 🛫

And your hectic work of creating a lot of certificates and attaching them for sending them via e-mail would be done in minutes. ⚡

## Installation Guide

1. Clone the repository
git clone https://github.com/pihujain9898/certifier

2. Switch to the repo folder
cd projectname

3. Install all the dependencies using composer
composer install

4. Copy the example env file and make the required configuration changes in the .env file
cp .env.example .env

5. Generate a new application key
php artisan key:generate

6. Run the database migrations (Set the database connection in .env before migrating)
php artisan migrate


## Supervisor Setup
1. Install Supervisor on your system
sudo apt update && sudo apt install supervisor

2. Create a Supervisor configuration file

sudo nano /etc/supervisor/conf.d/projectname-worker.conf

3. Add the following content to the file:
[program:projectname-worker] process_name=%(program_name)s_%(process_num)02d command=php /path/to/your/project/artisan queue:work --sleep=3 --tries=3 autostart=true autorestart=true user=yourusername numprocs=8 redirect_stderr=true stdout_logfile=/path/to/your/project/storage/logs/worker.log

Replace `/path/to/your/project` with the actual path to your Laravel application's artisan command and `yourusername` with your system's username.

4. Read the new Supervisor configurations and activate the new configuration
sudo supervisorctl reread sudo supervisorctl update

5. Start the queue command
sudo supervisorctl start projectname-worker:*

## Video Demonstration
https://www.linkedin.com/posts/darshil-jain-9aa43a126_project-web-laravel-activity-7038935753854205952-Ntim
