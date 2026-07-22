# Product Inventory System - Implementation Plan

## Steps

### Phase 1: Database

- [x] Step 1: Fix `database.sql` - Ensure it contains the proper `products` table schema
- [x] Step 2: Update `db.php` - Include connection logic from config.php

### Phase 2: Application

- [x] Step 3: Build `index.php` with:
  - Bootstrap-styled form (5 fields: Product Name, Category, Price, Quantity, Supplier)
  - "Add Product" submit button (POST to same page)
  - PHP INSERT logic on form submission
  - Clean HTML table listing all inventory items from DB

### Phase 3: Version Control

- [x] Step 4: Initialize Git repo, add files, commit changes
- [x] Step 5: Push to public GitHub repository
