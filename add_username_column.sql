-- Add username column to users table
USE google_cards;

-- Add username column
ALTER TABLE users ADD COLUMN username VARCHAR(50) UNIQUE AFTER name;

-- Create index for username
CREATE INDEX idx_users_username ON users(username);

-- Update existing users with a default username based on their email
UPDATE users SET username = SUBSTRING_INDEX(email, '@', 1) WHERE username IS NULL; 