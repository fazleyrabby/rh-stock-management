### 1. Users Table

| Column Name      | Data Type     | Description                         |
|------------------|---------------|-------------------------------------|
| id               | bigint        | Primary key (auto-increment)        |
| name             | varchar(255)  | Full name of the user               |
| email            | varchar(255)  | Unique email for login              |
| password         | varchar(255)  | Hashed password                     |
| role             | enum('admin', 'manager') | Role of the user            |
| created_at       | timestamp     | Timestamp of record creation        |
| updated_at       | timestamp     | Timestamp of last update            |

### 2. Customers Table

| Column Name      | Data Type     | Description                         |
|------------------|---------------|-------------------------------------|
| id               | bigint        | Primary key (auto-increment)        |
| name             | varchar(255)  | Full name of the customer           |
| email            | varchar(255)  | Unique email for the customer       |
| phone            | varchar(50)   | Contact number                      |
| address          | varchar(255)  | Shipping address                    |
| created_at       | timestamp     | Timestamp of record creation        |
| updated_at       | timestamp     | Timestamp of last update            |

### 3. Products Table

| Column Name      | Data Type     | Description                         |
|------------------|---------------|-------------------------------------|
| id               | bigint        | Primary key (auto-increment)        |
| name             | varchar(255)  | Product name                        |
| sku              | varchar(100)  | Unique stock-keeping unit identifier|
| category_id      | bigint        | Foreign key to `categories` table   |
| supplier_id      | bigint        | Foreign key to `suppliers` table    |
| price            | decimal(10, 2)| Price of the product                |
| quantity         | int           | Quantity of the product in stock    |
| created_at       | timestamp     | Timestamp of record creation        |
| updated_at       | timestamp     | Timestamp of last update            |

### 4. Categories Table

| Column Name      | Data Type     | Description                         |
|------------------|---------------|-------------------------------------|
| id               | bigint        | Primary key (auto-increment)        |
| name             | varchar(255)  | Category name                       |
| created_at       | timestamp     | Timestamp of record creation        |
| updated_at       | timestamp     | Timestamp of last update            |

### 5. Suppliers Table

| Column Name      | Data Type     | Description                         |
|------------------|---------------|-------------------------------------|
| id               | bigint        | Primary key (auto-increment)        |
| name             | varchar(255)  | Supplier name                       |
| contact_info     | varchar(255)  | Contact information                 |
| address          | varchar(255)  | Supplier address                    |
| created_at       | timestamp     | Timestamp of record creation        |
| updated_at       | timestamp     | Timestamp of last update            |

### 6. Inventory Movements Table

| Column Name      | Data Type     | Description                         |
|------------------|---------------|-------------------------------------|
| id               | bigint        | Primary key (auto-increment)        |
| product_id       | bigint        | Foreign key to `products` table     |
| movement_type    | enum('in', 'out') | Type of movement: 'in' or 'out' |
| quantity         | int           | Quantity moved                      |
| user_id          | bigint        | Foreign key to `users` table        |
| created_at       | timestamp     | Timestamp of the movement           |

### 7. Stock Adjustments Table

| Column Name      | Data Type     | Description                         |
|------------------|---------------|-------------------------------------|
| id               | bigint        | Primary key (auto-increment)        |
| product_id       | bigint        | Foreign key to `products` table     |
| previous_quantity| int           | Quantity before adjustment          |
| new_quantity     | int           | Adjusted quantity                   |
| user_id          | bigint        | Foreign key to `users` table        |
| reason           | varchar(255)  | Reason for the adjustment           |
| created_at       | timestamp     | Timestamp of the adjustment         |

### 8. Orders Table

| Column Name      | Data Type     | Description                         |
|------------------|---------------|-------------------------------------|
| id               | bigint        | Primary key (auto-increment)        |
| order_number     | varchar(100)  | Unique order identifier             |
| customer_id      | bigint        | Foreign key to `customers` table    |
| total_amount     | decimal(10, 2)| Total order value                   |
| status           | enum('pending', 'completed', 'cancelled') | Order status |
| created_at       | timestamp     | Timestamp of the order              |
| updated_at       | timestamp     | Timestamp of last update            |

### Relationships Overview

- **Users**: Users can create **Inventory Movements** and **Stock Adjustments** and manage **Orders**.
- **Customers**: Each order in the **Orders Table** is linked to a customer in the **Customers Table**.
- **Products**: Each product can have many **Inventory Movements** and **Stock Adjustments**.
- **Categories**: Each category can have many **Products**.
- **Suppliers**: Each supplier can have many **Products**.
