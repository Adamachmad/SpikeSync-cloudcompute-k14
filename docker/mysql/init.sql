-- Initialize database for VolleyTrack SaaS
CREATE DATABASE IF NOT EXISTS volleytrack_db;
USE volleytrack_db;

-- Create basic indexing strategy
ALTER DATABASE volleytrack_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
