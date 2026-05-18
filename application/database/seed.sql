CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    created_at TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS matches (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    group_name TEXT NOT NULL,
    home_team TEXT NOT NULL,
    away_team TEXT NOT NULL,
    home_flag TEXT NOT NULL,
    away_flag TEXT NOT NULL,
    match_date TEXT NOT NULL,
    match_time TEXT NOT NULL,
    started INTEGER NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS predictions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    match_id INTEGER NOT NULL,
    home_goals INTEGER NOT NULL,
    away_goals INTEGER NOT NULL,
    updated_at TEXT NOT NULL,
    UNIQUE(user_id, match_id),
    FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY(match_id) REFERENCES matches(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS results (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    match_id INTEGER NOT NULL UNIQUE,
    home_score INTEGER,
    away_score INTEGER,
    updated_at TEXT,
    FOREIGN KEY(match_id) REFERENCES matches(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS admin_users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    created_at TEXT NOT NULL
);

INSERT INTO matches (group_name, home_team, away_team, home_flag, away_flag, match_date, match_time, started) VALUES
('A', 'USA', 'Mexico', '🇺🇸', '🇲🇽', '2026-06-11', '18:00', 0),
('A', 'Canada', 'Portugal', '🇨🇦', '🇵🇹', '2026-06-12', '15:00', 0),
('A', 'USA', 'Portugal', '🇺🇸', '🇵🇹', '2026-06-16', '18:00', 0),
('A', 'Mexico', 'Canada', '🇲🇽', '🇨🇦', '2026-06-17', '18:00', 0),
('A', 'Portugal', 'Mexico', '🇵🇹', '🇲🇽', '2026-06-21', '18:00', 0),
('A', 'Canada', 'USA', '🇨🇦', '🇺🇸', '2026-06-22', '18:00', 0),
('B', 'England', 'France', '🇬🇧', '🇫🇷', '2026-06-11', '21:00', 0),
('B', 'Spain', 'Japan', '🇪🇸', '🇯🇵', '2026-06-12', '21:00', 0),
('B', 'England', 'Japan', '🇬🇧', '🇯🇵', '2026-06-16', '21:00', 0),
('B', 'France', 'Spain', '🇫🇷', '🇪🇸', '2026-06-17', '21:00', 0),
('B', 'Japan', 'France', '🇯🇵', '🇫🇷', '2026-06-21', '21:00', 0),
('B', 'Spain', 'England', '🇪🇸', '🇬🇧', '2026-06-22', '21:00', 0),
('C', 'Germany', 'Brazil', '🇩🇪', '🇧🇷', '2026-06-13', '18:00', 0),
('C', 'Argentina', 'Australia', '🇦🇷', '🇦🇺', '2026-06-14', '18:00', 0),
('C', 'Germany', 'Australia', '🇩🇪', '🇦🇺', '2026-06-18', '18:00', 0),
('C', 'Brazil', 'Argentina', '🇧🇷', '🇦🇷', '2026-06-19', '18:00', 0),
('C', 'Australia', 'Brazil', '🇦🇺', '🇧🇷', '2026-06-23', '18:00', 0),
('C', 'Argentina', 'Germany', '🇦🇷', '🇩🇪', '2026-06-24', '18:00', 0),
('D', 'Netherlands', 'Italy', '🇳🇱', '🇮🇹', '2026-06-13', '21:00', 0),
('D', 'Colombia', 'South Korea', '🇨🇴', '🇰🇷', '2026-06-14', '21:00', 0),
('D', 'Netherlands', 'South Korea', '🇳🇱', '🇰🇷', '2026-06-18', '21:00', 0),
('D', 'Italy', 'Colombia', '🇮🇹', '🇨🇴', '2026-06-19', '21:00', 0),
('D', 'South Korea', 'Italy', '🇰🇷', '🇮🇹', '2026-06-23', '21:00', 0),
('D', 'Colombia', 'Netherlands', '🇨🇴', '🇳🇱', '2026-06-24', '21:00', 0),
('E', 'Senegal', 'Switzerland', '🇸🇳', '🇨🇭', '2026-06-14', '15:00', 0),
('E', 'Morocco', 'Uruguay', '🇲🇦', '🇺🇾', '2026-06-15', '15:00', 0),
('E', 'Senegal', 'Uruguay', '🇸🇳', '🇺🇾', '2026-06-19', '15:00', 0),
('E', 'Switzerland', 'Morocco', '🇨🇭', '🇲🇦', '2026-06-20', '15:00', 0),
('E', 'Uruguay', 'Switzerland', '🇺🇾', '🇨🇭', '2026-06-24', '15:00', 0),
('E', 'Morocco', 'Senegal', '🇲🇦', '🇸🇳', '2026-06-25', '15:00', 0),
('F', 'Croatia', 'Belgium', '🇭🇷', '🇧🇪', '2026-06-15', '18:00', 0),
('F', 'Ecuador', 'Poland', '🇪🇨', '🇵🇱', '2026-06-16', '18:00', 0),
('F', 'Croatia', 'Poland', '🇭🇷', '🇵🇱', '2026-06-20', '18:00', 0),
('F', 'Belgium', 'Ecuador', '🇧🇪', '🇪🇨', '2026-06-21', '18:00', 0),
('F', 'Poland', 'Belgium', '🇵🇱', '🇧🇪', '2026-06-25', '18:00', 0),
('F', 'Ecuador', 'Croatia', '🇪🇨', '🇭🇷', '2026-06-26', '18:00', 0),
('G', 'Denmark', 'Serbia', '🇩🇰', '🇷🇸', '2026-06-15', '21:00', 0),
('G', 'Tunisia', 'Chile', '🇹🇳', '🇨🇱', '2026-06-16', '21:00', 0),
('G', 'Denmark', 'Chile', '🇩🇰', '🇨🇱', '2026-06-20', '21:00', 0),
('G', 'Serbia', 'Tunisia', '🇷🇸', '🇹🇳', '2026-06-21', '21:00', 0),
('G', 'Chile', 'Serbia', '🇨🇱', '🇷🇸', '2026-06-25', '21:00', 0),
('G', 'Tunisia', 'Denmark', '🇹🇳', '🇩🇰', '2026-06-26', '21:00', 0),
('H', 'Saudi Arabia', 'Nigeria', '🇸🇦', '🇳🇬', '2026-06-11', '15:00', 0),
('H', 'Venezuela', 'Ivory Coast', '🇻🇪', '🇨🇮', '2026-06-12', '15:00', 0),
('H', 'Saudi Arabia', 'Ivory Coast', '🇸🇦', '🇨🇮', '2026-06-16', '15:00', 0),
('H', 'Nigeria', 'Venezuela', '🇳🇬', '🇻🇪', '2026-06-17', '15:00', 0),
('H', 'Ivory Coast', 'Nigeria', '🇨🇮', '🇳🇬', '2026-06-21', '15:00', 0),
('H', 'Venezuela', 'Saudi Arabia', '🇻🇪', '🇸🇦', '2026-06-22', '15:00', 0);
