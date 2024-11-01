Here's the complete database structure, incorporating the new product import and purchase modules alongside the previously defined tables.

---

### 1. Users Table

| Column Name      | Data Type                                | Description                                         |
|------------------|------------------------------------------|-----------------------------------------------------|
| id               | bigint                                   | Primary key (auto-increment)                        |
| name             | varchar(255)                             | Full name of the user                               |
| email            | varchar(255)                             | Unique email for user login                         |
| password         | varchar(255)                             | Hashed password for authentication                  |
| role             | enum('admin', 'manager')                 | Role of the user                                    |
| created_at       | timestamp                               | Timestamp of record creation                        |
| updated_at       | timestamp                               | Timestamp of last update                            |

---

### 2. Customers Table

| Column Name      | Data Type                               | Description                                         |
|------------------|-----------------------------------------|-----------------------------------------------------|
| id               | bigint                                  | Primary key (auto-increment)                        |
| name             | varchar(255)                            | Full name of the customer                           |
| email            | varchar(255)                            | Unique email for the customer                       |
| phone            | varchar(50)                             | Contact number for the customer                     |
| address          | varchar(255)                            | Shipping address for delivery                       |
| created_at       | timestamp                               | Timestamp of record creation                        |
| updated_at       | timestamp                               | Timestamp of last update                            |

---

### 3. Products Table

| Column Name      | Data Type                               | Description                                         |
|------------------|-----------------------------------------|-----------------------------------------------------|
| id               | bigint                                  | Primary key (auto-increment)                        |
| name             | varchar(255)                            | Name of the product                                 |
| sku              | varchar(100)                            | Unique stock-keeping unit identifier                |
| category_id      | bigint                                  | Foreign key to `categories` table                   |
| supplier_id      | bigint                                  | Foreign key to `suppliers` table                    |
| price            | decimal(10, 2)                          | Price of the product                                |
| quantity         | int                                     | Current quantity of the product in stock            |
| created_at       | timestamp                               | Timestamp of record creation                        |
| updated_at       | timestamp                               | Timestamp of last update                            |

---

### 4. Categories Table

| Column Name      | Data Type                               | Description                                         |
|------------------|-----------------------------------------|-----------------------------------------------------|
| id               | bigint                                  | Primary key (auto-increment)                        |
| name             | varchar(255)                            | Name of the category                                |
| created_at       | timestamp                               | Timestamp of record creation                        |
| updated_at       | timestamp                               | Timestamp of last update                            |

---

### 5. Suppliers Table

| Column Name      | Data Type                               | Description                                         |
|------------------|-----------------------------------------|-----------------------------------------------------|
| id               | bigint                                  | Primary key (auto-increment)                        |
| name             | varchar(255)                            | Name of the supplier                                |
| contact_info     | varchar(255)                            | Contact information for the supplier                |
| address          | varchar(255)                            | Address of the supplier                             |
| created_at       | timestamp                               | Timestamp of record creation                        |
| updated_at       | timestamp                               | Timestamp of last update                            |

---

### 6. Inventory Movements Table

| Column Name      | Data Type                               | Description                                         |
|------------------|-----------------------------------------|-----------------------------------------------------|
| id               | bigint                                  | Primary key (auto-increment)                        |
| product_id       | bigint                                  | Foreign key to `products` table                     |
| movement_type    | enum('in', 'out')                       | Type of movement: 'in' for restock, 'out' for sale  |
| quantity         | int                                     | Quantity moved                                      |
| user_id          | bigint                                  | Foreign key to `users` table                        |
| created_at       | timestamp                               | Timestamp of the movement                           |

---

### 7. Stock Adjustments Table

| Column Name      | Data Type                               | Description                                         |
|------------------|-----------------------------------------|-----------------------------------------------------|
| id               | bigint                                  | Primary key (auto-increment)                        |
| product_id       | bigint                                  | Foreign key to `products` table                     |
| previous_quantity| int                                     | Quantity before adjustment                          |
| new_quantity     | int                                     | Adjusted quantity                                   |
| user_id          | bigint                                  | Foreign key to `users` table                        |
| reason           | varchar(255)                            | Reason for the adjustment                           |
| created_at       | timestamp                               | Timestamp of the adjustment                         |

---

### 8. Orders Table

| Column Name      | Data Type                               | Description                                         |
|------------------|-----------------------------------------|-----------------------------------------------------|
| id               | bigint                                  | Primary key (auto-increment)                        |
| order_number     | varchar(100)                            | Unique identifier for the order                     |
| customer_id      | bigint                                  | Foreign key to `customers` table                    |
| total_amount     | decimal(10, 2)                          | Total value of the order                            |
| status           | enum('pending', 'completed', 'cancelled') | Current status of the order                        |
| created_at       | timestamp                               | Timestamp of the order creation                     |
| updated_at       | timestamp                               | Timestamp of last update                            |

---

### 9. Order Items Table

| Column Name      | Data Type                               | Description                                         |
|------------------|-----------------------------------------|-----------------------------------------------------|
| id               | bigint                                  | Primary key (auto-increment)                        |
| order_id         | bigint                                  | Foreign key to `orders` table                       |
| product_id       | bigint                                  | Foreign key to `products` table                     |
| quantity         | int                                     | Number of units of the product ordered              |
| price            | decimal(10, 2)                          | Price of the product at the time of ordering        |

---

### 10. Product Imports Table

| Column Name      | Data Type                               | Description                                         |
|------------------|-----------------------------------------|-----------------------------------------------------|
| id               | bigint                                  | Primary key (auto-increment)                        |
| file_name        | varchar(255)                            | Name of the Excel file used for import              |
| total_records    | int                                     | Number of records in the Excel file                 |
| successful_imports| int                                    | Count of successfully imported products             |
| failed_imports   | int                                     | Count of failed imports                             |
| import_status    | enum('pending', 'in_progress', 'completed', 'failed') | Status of the import job                           |
| created_at       | timestamp                               | Timestamp of record creation                        |
| updated_at       | timestamp                               | Timestamp of last update                            |

---

### 11. Purchases Table

| Column Name      | Data Type                               | Description                                         |
|------------------|-----------------------------------------|-----------------------------------------------------|
| id               | bigint                                  | Primary key (auto-increment)                        |
| purchase_number  | varchar(100)                            | Unique identifier for the purchase                  |
| supplier_id      | bigint                                  | Foreign key to `suppliers` table                    |
| total_amount     | decimal(10, 2)                          | Total value of the purchase                         |
| status           | enum('pending', 'received', 'cancelled') | Current status of the purchase                     |
| created_at       | timestamp                               | Timestamp of purchase creation                      |
| updated_at       | timestamp                               | Timestamp of last update                            |

---

### 12. Purchase Items Table

| Column Name      | Data Type                               | Description                                         |
|------------------|-----------------------------------------|-----------------------------------------------------|
| id               | bigint                                  | Primary key (auto-increment)                        |
| purchase_id      | bigint                                  | Foreign key to `purchases` table                    |
| product_id       | bigint                                  | Foreign key to `products` table                     |
| quantity         | int                                     | Quantity of the product purchased                   |
| cost_price       | decimal(10, 2)                          | Cost price of the product per unit                  |

---

### Relationships Overview

- **Users**: Create **Inventory Movements** and **Stock Adjustments** and manage **Orders**.
- **Customers**: Each order in the **Orders Table** links to a customer in the **Customers Table**.
- **Products**: Products can have many **Inventory Movements**, **Stock Adjustments**, **Order Items**, **Purchase Items** and are imported through **Product Imports**.
- **Categories**: Each category can have many **Products**.
- **Suppliers**: Can supply multiple **Products** and have multiple **Purchases**.
- **Orders**: Each order can have multiple **Order Items**.
- **Purchases**: Each purchase has multiple **Purchase Items** tracking products and quantities bought.

Todo: Add import product in excel format..