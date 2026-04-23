# Event Ticketing System 🎟️

A full-stack web application for managing events and booking tickets, built with the **Laravel 12** framework. This project was developed as a university assignment for the "Server-side Web Programming" course.

The system features role-based access control (Admin and User roles), a dynamic pricing engine, seat reservation logic, and automated barcode generation for purchased tickets.

## 🚀 Tech Stack
* **Backend:** PHP 8.x, Laravel 12
* **Database:** SQLite (via Eloquent ORM)
* **Frontend:** Blade Templates (HTML/CSS/JS)
* **Authentication:** Laravel Breeze / Starter Kits

## ✨ Key Features

### 👤 For Users (Public & Authenticated)
* **Event Discovery:** Browse upcoming events sorted by date, complete with cover images and real-time seat availability.
* **Seat Selection:** View available, booked, and currently selected seats for an event.
* **Dynamic Pricing:** Ticket prices automatically adjust based on the seat's base price, the remaining days until the event, and the current occupancy rate of the venue.
* **Ticket Wallet:** Access all purchased tickets, grouped by event, featuring scannable barcodes (e.g., Aztec, QR, or standard 1D barcodes).

### 🛡️ For Administrators
* **Dashboard Analytics:** View total events, total tickets sold, total revenue, and the top 3 most popular seats.
* **Event Management:** Create, update, or delete events. (Restrictions apply once ticket sales have started).
* **Seat Management:** Manage the venue's seating chart (Seat ID format: 1 Letter + 3 Digits, e.g., 'A123') and base prices.
* **Ticket Scanning:** A dedicated interface to scan ticket barcodes. It verifies validity, records the admission time, and prevents duplicate entries.

## ⚙️ Dynamic Pricing Algorithm
For events with dynamic pricing enabled, the final ticket price is calculated using the following variables:
* `BasePrice`: The default price of the specific seat.
* `DaysUntil`: Number of days remaining until the event date.
* `Occupancy`: The ratio of currently booked seats versus total venue capacity.

## 🛠️ Installation & Setup

git clone https://github.com/koppany19/laravel-ticket-booking-system.git

cd laravel-ticket-booking-system

composer install

npm install

npm run build

cp .env.example .env

php artisan key:generate

php artisan migrate --seed

php artisan serve
