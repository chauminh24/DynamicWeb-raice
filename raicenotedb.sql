INSERT INTO products (name, description, price, stock_quantity, category, is_active, ingredients, alcohol_percentage, aging_period, production_guidelines, is_bundle, product_type) VALUES
-- Individual Rice Wines
('Makgeolli', 'A traditional Korean rice wine with a slightly sweet flavor and milky appearance.', 12.99, 150, 'Korean Rice Wine', 1, 'Rice, Nuruk, Water', 6.5, 10, 'Fermented for 10 days in low temperature', 0, 'Single Product'),
('Soju', 'A clear, distilled Korean rice wine with a smooth and neutral taste.', 8.99, 200, 'Korean Rice Wine', 1, 'Rice, Water', 16.0, 0, 'Distilled to achieve a pure and smooth taste', 0, 'Single Product'),
('Sake', 'A popular Japanese rice wine with a light, smooth flavor profile.', 15.99, 120, 'Japanese Rice Wine', 1, 'Rice, Koji, Water', 15.0, 30, 'Aged and brewed in low temperatures', 0, 'Single Product'),
('Nigori Sake', 'A coarse-filtered Japanese sake with a cloudy appearance and bold taste.', 18.50, 100, 'Japanese Rice Wine', 1, 'Rice, Koji, Water', 14.5, 20, 'Unfiltered for a rich flavor', 0, 'Single Product'),
('Shaoxing', 'A Chinese yellow wine with a distinct aroma and flavor, perfect for both drinking and cooking.', 10.50, 80, 'Chinese Rice Wine', 1, 'Glutinous rice, Wheat, Water', 13.0, 90, 'Brewed traditionally in clay jars', 0, 'Single Product'),
('Mijiu', 'A mildly sweet and smooth Chinese rice wine, often enjoyed warm.', 9.75, 100, 'Chinese Rice Wine', 1, 'Rice, Water', 10.0, 60, 'Fermented with yeast and aged for a smooth taste', 0, 'Single Product'),
('Jinro Soju', 'A popular Korean soju known for its light and crisp flavor.', 7.99, 200, 'Korean Rice Wine', 1, 'Rice, Barley, Tapioca', 17.5, 0, 'Distilled with a mild finish', 0, 'Single Product'),

-- Bundle Products
('Korean Rice Wine Tasting Bundle', 'A selection of popular Korean rice wines, including Makgeolli and Soju.', 20.99, 50, 'Korean Bundle', 1, 'Makgeolli, Soju', NULL, NULL, 'Includes various popular Korean rice wines.', 1, 'Bundle'),
('Japanese Sake Experience', 'Enjoy different types of Japanese sake, including traditional and Nigori sake.', 25.99, 40, 'Japanese Bundle', 1, 'Sake, Nigori Sake', NULL, NULL, 'Includes both filtered and unfiltered sake varieties.', 1, 'Bundle'),
('Chinese Rice Wine Collection', 'A collection of classic Chinese rice wines: Shaoxing and Mijiu.', 18.50, 30, 'Chinese Bundle', 1, 'Shaoxing, Mijiu', NULL, NULL, 'Perfect for pairing with Chinese dishes or enjoying alone.', 1, 'Bundle'),

-- Creative Rice Wines
('Peach Makgeolli', 'A sweet and refreshing Korean rice wine infused with juicy peach flavor.', 14.99, 120, 'Korean Rice Wine', 1, 'Rice, Nuruk, Water, Peach Extract', 6.5, 10, 'Fermented with peach extract for a fruity twist', 0, 'Flavored Wine'),
('Yuzu Sake', 'A Japanese sake with a hint of citrus, created using the zest and juice of yuzu.', 19.50, 90, 'Japanese Rice Wine', 1, 'Rice, Koji, Water, Yuzu', 14.5, 25, 'Infused with fresh yuzu for a citrus aroma', 0, 'Flavored Wine'),
('Plum Soju', 'A unique Korean soju flavored with the richness of ripe plums.', 11.99, 150, 'Korean Rice Wine', 1, 'Rice, Plum Extract, Water', 13.5, 0, 'Mixed with plum essence for a tart, fruity taste', 0, 'Flavored Wine'),
('Lavender Sake', 'A floral Japanese sake infused with a delicate lavender aroma and smooth flavor.', 16.99, 80, 'Japanese Rice Wine', 1, 'Rice, Koji, Water, Lavender', 12.5, 15, 'Aged with lavender for a unique floral fragrance', 0, 'Flavored Wine'),
('Ginger Makgeolli', 'Korean rice wine with a kick, thanks to the addition of spicy ginger.', 13.50, 100, 'Korean Rice Wine', 1, 'Rice, Nuruk, Water, Ginger', 6.5, 10, 'Fermented with fresh ginger for a spicy twist', 0, 'Flavored Wine'),
('Honey Chrysanthemum Mijiu', 'A smooth Chinese rice wine with a touch of honey and chrysanthemum flower.', 15.75, 90, 'Chinese Rice Wine', 1, 'Rice, Chrysanthemum, Honey, Water', 10.0, 40, 'Infused with chrysanthemum and honey for floral and sweet notes', 0, 'Flavored Wine'),
('Matcha Nigori Sake', 'A Japanese cloudy sake infused with rich matcha flavor for a unique twist.', 20.99, 85, 'Japanese Rice Wine', 1, 'Rice, Koji, Water, Matcha', 14.0, 20, 'Unfiltered sake with matcha infusion', 0, 'Flavored Wine'),
('Mango Rice Wine', 'A tropical take on rice wine with ripe mango for a sweet and fruity experience.', 17.50, 75, 'Creative Rice Wine', 1, 'Rice, Nuruk, Water, Mango Extract', 8.5, 12, 'Fermented with mango for a tropical flavor', 0, 'Flavored Wine'),

-- Mixed Varieties
('Soju Cocktail Mix', 'A ready-to-drink mix of Soju flavors, including peach, lychee, and original.', 21.99, 70, 'Mixed Korean Rice Wine', 1, 'Rice, Water, Peach, Lychee, Original Soju', 13.0, 0, 'Packaged set of soju cocktail flavors', 1, 'Bundle'),
('Fruit Infusion Bundle', 'A selection of popular fruit-infused rice wines, including Peach Makgeolli, Plum Soju, and Mango Rice Wine.', 29.99, 60, 'Creative Bundle', 1, 'Peach Makgeolli, Plum Soju, Mango Rice Wine', NULL, NULL, 'Includes a range of fruity rice wines', 1, 'Bundle');

INSERT INTO bundle_items (bundle_id, product_id, quantity, individual_price, notes)
SELECT 
    (SELECT product_id FROM products WHERE name = 'Korean Rice Wine Tasting Bundle'),
    (SELECT product_id FROM products WHERE name = 'Makgeolli'),
    2, 12.99, 'Traditional Korean rice wine'
UNION ALL
SELECT 
    (SELECT product_id FROM products WHERE name = 'Korean Rice Wine Tasting Bundle'),
    (SELECT product_id FROM products WHERE name = 'Soju'),
    2, 8.99, 'Classic Korean soju';

INSERT INTO bundle_items (bundle_id, product_id, quantity, individual_price, notes)
SELECT 
    (SELECT product_id FROM products WHERE name = 'Japanese Sake Experience'),
    (SELECT product_id FROM products WHERE name = 'Sake'),
    1, 15.99, 'Traditional sake'
UNION ALL
SELECT 
    (SELECT product_id FROM products WHERE name = 'Japanese Sake Experience'),
    (SELECT product_id FROM products WHERE name = 'Nigori Sake'),
    1, 18.50, 'Unfiltered sake variant';

INSERT INTO bundle_items (bundle_id, product_id, quantity, individual_price, notes)
SELECT 
    (SELECT product_id FROM products WHERE name = 'Chinese Rice Wine Collection'),
    (SELECT product_id FROM products WHERE name = 'Shaoxing'),
    1, 10.50, 'Traditional Shaoxing wine'
UNION ALL
SELECT 
    (SELECT product_id FROM products WHERE name = 'Chinese Rice Wine Collection'),
    (SELECT product_id FROM products WHERE name = 'Mijiu'),
    1, 9.75, 'Classic Mijiu';

    INSERT INTO bundle_items (bundle_id, product_id, quantity, individual_price, notes)
SELECT 
    (SELECT product_id FROM products WHERE name = 'Festive RaiceNote Bundle'),
    (SELECT product_id FROM products WHERE name = 'Peppermint Makgeolli'),
    1, 14.99, 'Festive Peppermint-Infused Korean Makgeolli'
UNION ALL
SELECT 
    (SELECT product_id FROM products WHERE name = 'Festive RaiceNote Bundle'),
    (SELECT product_id FROM products WHERE name = 'Cranberry Sake'),
    1, 19.99, 'Cranberry-Infused Seasonal Japanese Sake'
UNION ALL
SELECT 
    (SELECT product_id FROM products WHERE name = 'Festive RaiceNote Bundle'),
    (SELECT product_id FROM products WHERE name = 'Spiced Mijiu'),
    1, 11.99, 'Cinnamon and Spice-Filled Chinese Mijiu';


-- Create users data
INSERT INTO users (email, password_hash, first_name, last_name, phone, is_admin, address, date_of_birth) VALUES
('admin@raicenote.com', SHA2('admin123', 256), 'Admin', 'User', '+1234567890', 1, '123 Admin Street, Business District, 12345', '1980-01-01'),
('john.smith@email.com', SHA2('pass123', 256), 'John', 'Smith', '+1234567891', 0, '456 Oak Ave, Springfield, 12346', '1985-03-15'),
('mary.johnson@email.com', SHA2('pass456', 256), 'Mary', 'Johnson', '+1234567892', 0, '789 Pine St, Riverside, 12347', '1990-06-22'),
('david.lee@email.com', SHA2('pass789', 256), 'David', 'Lee', '+1234567893', 0, '321 Maple Dr, Hillside, 12348', '1988-09-10'),
('sarah.wilson@email.com', SHA2('pass321', 256), 'Sarah', 'Wilson', '+1234567894', 0, '654 Cedar Ln, Lakeside, 12349', '1992-12-05'),
('michael.brown@email.com', SHA2('pass654', 256), 'Michael', 'Brown', '+1234567895', 0, '987 Birch Rd, Mountain View, 12350', '1987-04-18'),
('emily.davis@email.com', SHA2('pass987', 256), 'Emily', 'Davis', '+1234567896', 0, '147 Elm St, Seaside, 12351', '1995-07-30'),
('james.wilson@email.com', SHA2('passabc', 256), 'James', 'Wilson', '+1234567897', 0, '258 Walnut Ave, Downtown, 12352', '1983-11-25'),
('lisa.anderson@email.com', SHA2('passdef', 256), 'Lisa', 'Anderson', '+1234567898', 0, '369 Cherry Ln, Uptown, 12353', '1993-02-14'),
('robert.taylor@email.com', SHA2('passghi', 256), 'Robert', 'Taylor', '+1234567899', 0, '741 Pineapple St, Beachside, 12354', '1986-08-08');

-- Create events data
INSERT INTO events (name, description, start_time, end_time, capacity, price, location, event_type, requirements, is_active) VALUES
('Sake Brewing Workshop', 'Learn the traditional art of sake brewing', '2024-11-15 10:00:00', '2024-11-15 16:00:00', 15, 149.99, 'Main Brewery - 123 Brew St', 'Workshop', 'Must be 21+. No experience necessary. All materials provided.', 1),
('Wine Tasting Evening', 'Explore our premium rice wine collection', '2024-11-20 18:00:00', '2024-11-20 21:00:00', 30, 59.99, 'Tasting Room - 123 Brew St', 'Tasting', 'Must be 21+. Light appetizers included.', 1),
('Korean Rice Wine Festival', 'Celebration of Korean rice wine culture', '2024-12-01 11:00:00', '2024-12-01 20:00:00', 100, 79.99, 'Central Park Event Space', 'Festival', 'Must be 21+. Food vendors available.', 1),
('Beginner''s Brewing Class', 'Introduction to rice wine brewing', '2024-11-25 14:00:00', '2024-11-25 17:00:00', 20, 89.99, 'Training Room - 123 Brew St', 'Workshop', 'Must be 21+. All materials provided.', 1),
('Premium Sake Dinner', 'Five-course dinner with sake pairings', '2024-12-10 19:00:00', '2024-12-10 22:00:00', 40, 199.99, 'Grand Hall - Luxury Hotel', 'Dining', 'Must be 21+. Formal attire required.', 1);

-- Create bookings data
INSERT INTO bookings (user_id, event_id, number_of_participants, total_amount, status, special_requests) VALUES
(2, 1, 2, 299.98, 'Confirmed', 'Vegetarian meal options needed'),
(3, 1, 1, 149.99, 'Confirmed', NULL),
(4, 2, 3, 179.97, 'Confirmed', 'Prefer non-spicy food pairings'),
(5, 2, 2, 119.98, 'Pending', NULL),
(6, 3, 4, 319.96, 'Confirmed', 'Group seating requested'),
(7, 4, 1, 89.99, 'Confirmed', 'Gluten-free options needed'),
(8, 5, 2, 399.98, 'Confirmed', 'Anniversary celebration - window seating preferred'),
(9, 3, 3, 239.97, 'Cancelled', NULL),
(10, 4, 2, 179.98, 'Confirmed', 'First-time brewers');

-- Create production_batches data
INSERT INTO production_batches (product_id, start_date, expected_completion_date, quantity_produced, status, batch_number, notes, target_alcohol_percentage, recipe_variation, expected_yield, quality_grade) VALUES
(1, '2024-10-01', '2024-10-11', 500, 'Completed', 'MK241001', 'Standard Makgeolli batch', 6.5, 'Traditional', 480, 'A'),
(2, '2024-10-05', '2024-10-05', 1000, 'Completed', 'SJ241005', 'Standard Soju production', 16.0, 'Classic', 980, 'A+'),
(3, '2024-10-10', '2024-11-09', NULL, 'In Progress', 'SK241010', 'Premium sake batch', 15.0, 'Premium', 400, NULL),
(4, '2024-10-15', '2024-11-04', NULL, 'In Progress', 'NS241015', 'Nigori sake production', 14.5, 'Unfiltered', 300, NULL),
(12, '2024-10-01', '2024-10-11', 400, 'Completed', 'PM241001', 'Peach Makgeolli special', 6.5, 'Fruit Infused', 385, 'A'),
(13, '2024-10-08', '2024-11-02', NULL, 'In Progress', 'YS241008', 'Yuzu sake batch', 14.5, 'Citrus Infused', 250, NULL);

-- Create production_logs data
INSERT INTO production_logs (batch_id, action, description, recorded_by, temperature, humidity, quality_checks, phase, adjustments_made) VALUES
(1, 'Start', 'Initial rice washing and soaking', 'Kim Jin', 20.5, 65.0, 'Rice quality verified', 'Preparation', 'None'),
(1, 'Fermentation', 'Added nuruk and water', 'Kim Jin', 18.0, 70.0, 'pH level: 6.5', 'Primary Fermentation', 'Temperature adjusted -2°C'),
(1, 'Check', 'Day 5 fermentation check', 'Park Min', 18.5, 68.0, 'Alcohol content: 4%', 'Primary Fermentation', 'None'),
(1, 'Completion', 'Batch completed', 'Kim Jin', 19.0, 65.0, 'Final alcohol content: 6.5%', 'Completion', 'None'),
(2, 'Start', 'Preparation for distillation', 'Lee Soo', 22.0, 60.0, 'Base mixture verified', 'Preparation', 'None'),
(2, 'Distillation', 'First run distillation', 'Lee Soo', 78.5, 55.0, 'Alcohol vapor temperature optimal', 'Distillation', 'Pressure adjusted +0.2 bar'),
(3, 'Start', 'Rice washing and koji preparation', 'Tanaka Yuki', 21.0, 65.0, 'Koji quality verified', 'Preparation', 'None'),
(3, 'Fermentation', 'Added koji and water', 'Tanaka Yuki', 12.0, 70.0, 'pH level: 6.8', 'Primary Fermentation', 'None');

-- Create inventory data
INSERT INTO inventory (product_id, batch_id, quantity, storage_location, expiry_date, batch_number, status, production_date, quality_status) VALUES
(1, 1, 480, 'Warehouse A-1', '2025-10-01', 'MK241001', 'Available', '2024-10-11', 'Passed'),
(2, 2, 980, 'Warehouse B-2', '2026-10-05', 'SJ241005', 'Available', '2024-10-05', 'Passed'),
(12, 5, 385, 'Warehouse A-3', '2025-10-01', 'PM241001', 'Available', '2024-10-11', 'Passed');

-- Create orders data
INSERT INTO orders (user_id, total_amount, status, shipping_address, payment_status, tracking_number) VALUES
(2, 149.97, 'Delivered', '456 Oak Ave, Springfield, 12346', 'Paid', 'TN123456789'),
(3, 89.99, 'Processing', '789 Pine St, Riverside, 12347', 'Paid', NULL),
(4, 299.99, 'Shipped', '321 Maple Dr, Hillside, 12348', 'Paid', 'TN987654321'),
(5, 45.98, 'Pending', '654 Cedar Ln, Lakeside, 12349', 'Pending', NULL),
(6, 199.99, 'Delivered', '987 Birch Rd, Mountain View, 12350', 'Paid', 'TN456789123');

-- Create order_items data
INSERT INTO order_items (order_id, product_id, quantity, unit_price, subtotal) VALUES
(1, 1, 2, 12.99, 25.98),
(1, 2, 1, 8.99, 8.99),
(2, 3, 1, 15.99, 15.99),
(3, 8, 1, 20.99, 20.99),
(4, 2, 2, 8.99, 17.98),
(5, 9, 1, 25.99, 25.99);

-- Create reviews data
INSERT INTO reviews (user_id, reference_id, review_type, rating, comment, is_verified, pros, cons, experience_level) VALUES
(2, 1, 'Product', 5, 'Excellent traditional Makgeolli!', 1, 'Authentic taste, Good value', 'None', 'Intermediate'),
(3, 2, 'Product', 4, 'Good quality Soju', 1, 'Smooth taste, Good price', 'Could be stronger', 'Expert'),
(4, 1, 'Event', 5, 'Amazing workshop experience', 1, 'Informative, Hands-on', 'Location bit far', 'Beginner'),
(5, 3, 'Product', 3, 'Decent sake but expected more', 1, 'Good aroma', 'Price bit high', 'Expert'),
(6, 2, 'Event', 5, 'Wonderful tasting event', 1, 'Great selection, Knowledgeable staff', 'None', 'Intermediate');

-- Create recipes data
INSERT INTO recipes (name, instructions, ingredients, difficulty_level, duration_days, notes, is_public) VALUES
('Traditional Makgeolli', 'Step 1: Wash and soak rice\nStep 2: Steam rice\nStep 3: Cool rice\nStep 4: Mix with nuruk\nStep 5: Ferment', 'Rice: 5kg\nNuruk: 1kg\nWater: 6.5L', 3, 7, 'Keep temperature between 18-22°C during fermentation', 1),
('Premium Sake', 'Step 1: Polish rice\nStep 2: Prepare koji\nStep 3: Create moto\nStep 4: Main fermentation', 'Premium rice: 10kg\nKoji rice: 3kg\nWater: 13L\nYeast starter: 1kg', 4, 30, 'Requires precise temperature control', 0),
('Fruit-Infused Makgeolli', 'Step 1: Create basic makgeolli\nStep 2: Secondary fermentation with fruit', 'Basic makgeolli base\nFresh fruit: 2kg\nSugar: 0.5kg', 2, 10, 'Use very ripe fruits for best results', 1),
('Quick Homebrew Rice Wine', 'Step 1: Prepare