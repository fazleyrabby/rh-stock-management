Structure of the project

### 1. **Users Table**
This table tracks system users (e.g., admin, inventory managers).

| Column Name      | Data Type     | Description                         |
|------------------|---------------|-------------------------------------|
| id               | bigint        | Primary key (auto-increment)        |
| name             | varchar(255)  | Full name of the user               |
| email            | varchar(255)  | Unique email for login              |
| password         | varchar(255)  | Hashed password                     |
| role             | enum('admin', 'manager') | Role of the user            |
| created_at       | timestamp     | Timestamp of record creation        |
| updated_at       | timestamp     | Timestamp of last update            |

### 2. **Products Table**
This table stores details about the products being managed.

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

### 3. **Categories Table**
This table categorizes the products.

| Column Name      | Data Type     | Description                         |
|------------------|---------------|-------------------------------------|
| id               | bigint        | Primary key (auto-increment)        |
| name             | varchar(255)  | Category name                       |
| created_at       | timestamp     | Timestamp of record creation        |
| updated_at       | timestamp     | Timestamp of last update            |

### 4. **Suppliers Table**
This table tracks the suppliers for the products.

| Column Name      | Data Type     | Description                         |
|------------------|---------------|-------------------------------------|
| id               | bigint        | Primary key (auto-increment)        |
| name             | varchar(255)  | Supplier name                       |
| contact_info     | varchar(255)  | Contact information                 |
| address          | varchar(255)  | Supplier address                    |
| created_at       | timestamp     | Timestamp of record creation        |
| updated_at       | timestamp     | Timestamp of last update            |

### 5. **Inventory Movements Table**
This table logs every change in product quantity, whether incoming (stock added) or outgoing (stock removed).

| Column Name      | Data Type     | Description                         |
|------------------|---------------|-------------------------------------|
| id               | bigint        | Primary key (auto-increment)        |
| product_id       | bigint        | Foreign key to `products` table     |
| movement_type    | enum('in', 'out') | Type of movement: 'in' or 'out' |
| quantity         | int           | Quantity moved                      |
| user_id          | bigint        | Foreign key to `users` table        |
| created_at       | timestamp     | Timestamp of the movement           |

### 6. **Stock Adjustments Table**
This table logs any manual stock adjustments (e.g., correcting inventory count).

| Column Name      | Data Type     | Description                         |
|------------------|---------------|-------------------------------------|
| id               | bigint        | Primary key (auto-increment)        |
| product_id       | bigint        | Foreign key to `products` table     |
| previous_quantity| int           | Quantity before adjustment          |
| new_quantity     | int           | Adjusted quantity                   |
| user_id          | bigint        | Foreign key to `users` table        |
| reason           | varchar(255)  | Reason for the adjustment           |
| created_at       | timestamp     | Timestamp of the adjustment         |

### 7. **Orders Table**
If the system involves managing customer orders, the following table can be used to track them.

| Column Name      | Data Type     | Description                         |
|------------------|---------------|-------------------------------------|
| id               | bigint        | Primary key (auto-increment)        |
| order_number     | varchar(100)  | Unique order identifier             |
| customer_name    | varchar(255)  | Name of the customer                |
| total_amount     | decimal(10, 2)| Total order value                   |
| status           | enum('pending', 'completed', 'cancelled') | Order status |
| created_at       | timestamp     | Timestamp of the order              |
| updated_at       | timestamp     | Timestamp of last update            |

---

### Relationships:
- **Products** have many **Inventory Movements** and many **Stock Adjustments**.
- **Categories** have many **Products**.
- **Suppliers** have many **Products**.
- **Users** can create **Inventory Movements**, **Stock Adjustments**, and manage **Orders**.

This simple database structure can be extended based on additional requirements like customer management, reporting, or more complex roles and permissions.
