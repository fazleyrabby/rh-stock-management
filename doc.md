### 1. Users Table

| Column Name      | Data Type     | Description                                         |
|------------------|---------------|-----------------------------------------------------|
| id               | bigint        | Primary key (auto-increment)                        |
| name             | varchar(255)  | Full name of the user                               |
| email            | varchar(255)  | Unique email for user login                         |
| password         | varchar(255)  | Hashed password for authentication                  |
| role             | enum('admin', 'manager') | Role of the user (permissions and access levels) |
| created_at       | timestamp     | Timestamp of record creation                        |
| updated_at       | timestamp     | Timestamp of last update                            |

### 2. Customers Table

| Column Name      | Data Type     | Description                                         |
|------------------|---------------|-----------------------------------------------------|
| id               | bigint        | Primary key (auto-increment)                        |
| name             | varchar(255)  | Full name of the customer                           |
| email            | varchar(255)  | Unique email for the customer                       |
| phone            | varchar(50)   | Contact number for the customer                     |
| address          | varchar(255)  | Shipping address for delivery                       |
| created_at       | timestamp     | Timestamp of record creation                        |
| updated_at       | timestamp     | Timestamp of last update                            |

### 3. Products Table

| Column Name      | Data Type     | Description                                         |
|------------------|---------------|-----------------------------------------------------|
| id               | bigint        | Primary key (auto-increment)                        |
| name             | varchar(255)  | Name of the product                                 |
| sku              | varchar(100)  | Unique stock-keeping unit identifier                |
| category_id      | bigint        | Foreign key to `categories` table (categorizes the product) |
| supplier_id      | bigint        | Foreign key to `suppliers` table (source of the product) |
| price            | decimal(10, 2)| Price of the product                                |
| quantity         | int           | Current quantity of the product in stock            |
| created_at       | timestamp     | Timestamp of record creation                        |
| updated_at       | timestamp     | Timestamp of last update                            |

### 4. Categories Table

| Column Name      | Data Type     | Description                                         |
|------------------|---------------|-----------------------------------------------------|
| id               | bigint        | Primary key (auto-increment)                        |
| name             | varchar(255)  | Name of the category                                |
| created_at       | timestamp     | Timestamp of record creation                        |
| updated_at       | timestamp     | Timestamp of last update                            |

### 5. Suppliers Table

| Column Name      | Data Type     | Description                                         |
|------------------|---------------|-----------------------------------------------------|
| id               | bigint        | Primary key (auto-increment)                        |
| name             | varchar(255)  | Name of the supplier                                |
| contact_info     | varchar(255)  | Contact information for the supplier                |
| address          | varchar(255)  | Address of the supplier                             |
| created_at       | timestamp     | Timestamp of record creation                        |
| updated_at       | timestamp     | Timestamp of last update                            |

### 6. Inventory Movements Table

| Column Name      | Data Type     | Description                                         |
|------------------|---------------|-----------------------------------------------------|
| id               | bigint        | Primary key (auto-increment)                        |
| product_id       | bigint        | Foreign key to `products` table (the product being moved) |
| movement_type    | enum('in', 'out') | Type of movement: 'in' for restock, 'out' for sale or consumption |
| quantity         | int           | Quantity moved (positive for 'in', negative for 'out') |
| user_id          | bigint        | Foreign key to `users` table (user responsible for the movement) |
| created_at       | timestamp     | Timestamp of the movement                           |

### 7. Stock Adjustments Table

| Column Name      | Data Type     | Description                                         |
|------------------|---------------|-----------------------------------------------------|
| id               | bigint        | Primary key (auto-increment)                        |
| product_id       | bigint        | Foreign key to `products` table (the product being adjusted) |
| previous_quantity| int           | Quantity before adjustment                          |
| new_quantity     | int           | Adjusted quantity                                   |
| user_id          | bigint        | Foreign key to `users` table (user making the adjustment) |
| reason           | varchar(255)  | Reason for the adjustment (e.g., damage, miscount) |
| created_at       | timestamp     | Timestamp of the adjustment                         |

### 8. Orders Table

| Column Name      | Data Type     | Description                                         |
|------------------|---------------|-----------------------------------------------------|
| id               | bigint        | Primary key (auto-increment)                        |
| order_number     | varchar(100)  | Unique identifier for the order                     |
| customer_id      | bigint        | Foreign key to `customers` table (customer placing the order) |
| total_amount     | decimal(10, 2)| Total value of the order                            |
| status           | enum('pending', 'completed', 'cancelled') | Current status of the order |
| created_at       | timestamp     | Timestamp of the order creation                     |
| updated_at       | timestamp     | Timestamp of last update                             |

### 9. Order Items Table

| Column Name      | Data Type     | Description                                         |
|------------------|---------------|-----------------------------------------------------|
| id               | bigint        | Primary key (auto-increment)                        |
| order_id         | bigint        | Foreign key to `orders` table                       |
| product_id       | bigint        | Foreign key to `products` table                     |
| quantity         | int           | Number of units of the product ordered              |
| price            | decimal(10, 2)| Price of the product at the time of ordering        |

### Relationships Overview

- **Users**: Users can create **Inventory Movements** and **Stock Adjustments** and manage **Orders**.
- **Customers**: Each order in the **Orders Table** is linked to a customer in the **Customers Table**.
- **Products**: Each product can have many **Inventory Movements** and **Stock Adjustments**. Products can be part of many **Order Items**.
- **Categories**: Each category can have many **Products**.
- **Suppliers**: Each supplier can supply many **Products**.
- **Orders**: Each order can have many **Order Items**, allowing for a many-to-many relationship between orders and products.
