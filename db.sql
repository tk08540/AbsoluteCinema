
DROP DATABASE if exists moviereviewer; 
CREATE
DATABASE moviereviewer CHARACTER
SET
    utf8mb4
COLLATE utf8mb4_unicode_ci;
USE moviereviewer;

-- =========================
-- USERS
-- =========================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM ('user', 'admin') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- MOVIES
-- =========================
CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    genre VARCHAR(50),
    release_year YEAR,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================
-- REVIEWS
-- =========================
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    movie_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 10),
    review_text TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_reviews_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT fk_reviews_movie FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE,
    UNIQUE (user_id, movie_id)
);

-- primeri
INSERT INTO movies (title, description, genre, release_year, image_url, created_at)
VALUES
(
    'Inception',
    'Starring: Leonardo DiCaprio, Joseph Gordon-Levitt.<br>Cobb, a skilled thief who commits corporate espionage by infiltrating the subconscious of his targets is offered a chance to regain his old life as payment for a task considered to be impossible: "inception", the implantation of another person\'s idea into a target\'s subconscious.',
    'Sci-Fi',
    2010,
    'https://www.themoviedb.org/t/p/w1280/xlaY2zyzMfkhk0HSC5VUwzoZPU1.jpg',
    '2026-05-10 10:00:00'
),
(
    'The Dark Knight',
    'Starring: Christian Bale, Heath Ledger.<br>Batman raises the stakes in his war on crime. With the help of Lt. Jim Gordon and District Attorney Harvey Dent, Batman sets out to dismantle the remaining criminal organizations that plague the streets. The partnership proves to be effective, but they soon find themselves prey to a reign of chaos unleashed by a rising criminal mastermind known to the terrified citizens of Gotham as the Joker.',
    'Action',
    2008,
    'https://www.themoviedb.org/t/p/w1280/qJ2tW6WMUDux911r6m7haRef0WH.jpg',
    '2026-05-11 11:00:00'
),

(
    'Fight Club',
    'Starring: Edward Norton, Brad Pitt.<br>A ticking-time-bomb insomniac and a slippery soap salesman channel primal male aggression into a shocking new form of therapy. Their concept catches on, with underground "fight clubs" forming in every town, until an eccentric gets in the way and ignites an out-of-control spiral toward oblivion.',
    'Drama',
    1999,
    'https://www.themoviedb.org/t/p/w1280/jSziioSwPVrOy9Yow3XhWIBDjq1.jpg',
    '2026-05-12 12:00:00'
),
(
    'Drive',
    'Starring: Ryan Gosling, Carey Mulligan.<br>Driver is a skilled Hollywood stuntman who moonlights as a getaway driver for criminals. Though he projects an icy exterior, lately he\'s been warming up to a pretty neighbor named Irene and her young son, Benicio. When Irene\'s husband gets out of jail, he enlists Driver\'s help in a million-dollar heist. The job goes horribly wrong, and Driver must risk his life to protect Irene and Benicio from the vengeful masterminds behind the robbery.',
    'Crime',
    2011,
    'https://www.themoviedb.org/t/p/w1280/602vevIURmpDfzbnv5Ubi6wIkQm.jpg',
    '2026-05-13 13:00:00'
),
(
    'Pulp Fiction',
    'Starring: John Travolta, Samuel L. Jackson.<br>A burger-loving hit man, his philosophical partner, a drug-addled gangster\'s moll and a washed-up boxer converge in this sprawling, comedic crime caper. Their adventures unfurl in three stories that ingeniously trip back and forth in time.',
    'Crime',
    1994,
    'https://www.themoviedb.org/t/p/w1280/vQWk5YBFWF4bZaofAbv0tShwBvQ.jpg',
    '2026-05-14 14:00:00'
),
(
    'The Godfather',
    'Starring: Marlon Brando, Al Pacino.<br>Spanning the years 1945 to 1955, a chronicle of the fictional Italian-American Corleone crime family. When organized crime family patriarch, Vito Corleone barely survives an attempt on his life, his youngest son, Michael steps in to take care of the would-be killers, launching a campaign of bloody revenge.',
    'Crime',
    1972,
    'https://www.themoviedb.org/t/p/w1280/3bhkrj58Vtu7enYsRolD1fZdja1.jpg',
    '2026-05-15 15:00:00'
),

(
    'Knight and Day',
    'Starring: Tom Cruise, Cameron Diaz.<br>A fugitive couple goes on a glamorous and sometimes deadly adventure where nothing and no one – even themselves – are what they seem. Amid shifting alliances and unexpected betrayals, they race across the globe, with their survival ultimately hinging on the battle of truth vs. trust.',
    'Action',
    2010,
    'https://www.themoviedb.org/t/p/w1280/a7JmOBMNj5erYTgt4u1mQgvHItu.jpg',
    '2026-05-16 16:00:00'
),
(
    'Mission: Impossible',
    'Starring: Tom Cruise, Jon Voight.<br>When Ethan Hunt, the leader of a crack espionage team whose perilous operation has gone awry with no explanation, discovers that a mole has penetrated the CIA, he\'s surprised to learn that he\'s the prime suspect. To clear his name, Hunt now must ferret out the real double agent and, in the process, even the score.',
    'Action',
    1996,
    'https://www.themoviedb.org/t/p/w1280/l5uxY5m5OInWpcExIpKG6AR3rgL.jpg',
    '2026-05-17 17:00:00'
),
(
    'The Amazing Spider-Man',
    'Starring: Andrew Garfield, Emma Stone.<br>Peter Parker is an outcast high schooler abandoned by his parents as a boy, leaving him to be raised by his Uncle Ben and Aunt May. Like most teenagers, Peter is trying to figure out who he is and how he got to be the person he is today. As Peter discovers a mysterious briefcase that belonged to his father, he begins a quest to understand his parents\' disappearance – leading him directly to Oscorp and the lab of Dr. Curt Connors, his father\'s former partner. As Spider-Man is set on a collision course with Connors\' alter ego, The Lizard, Peter will make life-altering choices to use his powers and shape his destiny to become a hero.',
    'Action',
    2012,
    'https://www.themoviedb.org/t/p/w1280/jexoNYnPd6vVrmygwF6QZmWPFdu.jpg',
    '2026-05-18 18:00:00'
),
(
    'Tropic Thunder',
    'Starring: Ben Stiller, Robert Downey Jr.<br>A group of self-absorbed actors set out to make the most expensive war film ever. After ballooning costs force the studio to cancel the movie, the frustrated director refuses to stop shooting, leading his cast into the jungles of Southeast Asia, where they encounter real bad guys.',
    'Comedy',
    2008,
    'https://www.themoviedb.org/t/p/w1280/zAurB9mNxfYRoVrVjAJJwGV3sPg.jpg',
    '2026-05-19 19:00:00'
),
(
    'Interstellar',
    'Starring: Matthew McConaughey, Anne Hathaway.<br>The adventures of a group of explorers who make use of a newly discovered wormhole to surpass the limitations on human space travel and conquer the vast distances involved in an interstellar voyage.',
    'Sci-Fi',
    2014,
    'https://www.themoviedb.org/t/p/w1280/yQvGrMoipbRoddT0ZR8tPoR7NfX.jpg',
    '2026-05-20 20:00:00'
),
(
    'The Nice Guys',
    'Starring: Ryan Gosling, Russell Crowe.<br>A private eye and a hired enforcer investigate the disappearance of a girl and uncover a conspiracy in 1970s Los Angeles.',
    'Comedy',
    2016,
    'https://www.themoviedb.org/t/p/w1280/clq4So9spa9cXk3MZy2iMdqkxP2.jpg',
    '2026-05-21 21:00:00'
),
(
    'La La Land',
    'Starring: Ryan Gosling, Emma Stone.<br>Mia, an aspiring actress, serves lattes to movie stars in between auditions and Sebastian, a jazz musician, scrapes by playing cocktail party gigs in dingy bars, but as success mounts they are faced with decisions that begin to fray the fragile fabric of their love affair, and the dreams they worked so hard to maintain in each other threaten to rip them apart.',
    'Romance',
    2016,
    'https://www.themoviedb.org/t/p/w1280/uDO8zWDhfWwoFdKS4fzkUJt0Rf0.jpg',
    '2026-05-22 22:00:00'
),
(
    'Avengers: Infinity War',
    'Starring: Robert Downey Jr., Chris Hemsworth.<br>As the Avengers and their allies have continued to protect the world from threats too large for any one hero to handle, a new danger has emerged from the cosmic shadows: Thanos. A despot of intergalactic infamy, his goal is to collect all six Infinity Stones, artifacts of unimaginable power, and use them to inflict his twisted will on all of reality. Everything the Avengers have fought for has led up to this moment - the fate of Earth and existence itself has never been more uncertain.',
    'Action',
    2018,
    'https://www.themoviedb.org/t/p/w1280/7WsyChQLEftFiDOVTGkv3hFpyyt.jpg',
    '2026-05-23 23:00:00'
),
(
    'Money Plane',
    'Starring: Adam Copeland, Kelsey Grammer.<br>A professional thief with $40 million in debt and his family\'s life on the line must commit one final heist - rob a futuristic airborne casino filled with the world\'s most dangerous criminals.',
    'Action',
    2020,
    'https://www.themoviedb.org/t/p/w1280/6CoRTJTmijhBLJTUNoVSUNxZMEI.jpg',
    '2026-05-24 23:30:00'
),
(
    'Project Hail Mary',
    'Starring: Ryan Gosling, Sandra Hüller.<br>Science teacher Ryland Grace wakes up on a spaceship light years from home with no recollection of who he is or how he got there. As his memory returns, he begins to uncover his mission: solve the riddle of the mysterious substance causing the sun to die out. He must call on his scientific knowledge and unorthodox ideas to save everything on Earth from extinction.',
    'Sci-Fi',
    2026,
    'https://www.themoviedb.org/t/p/w1280/yihdXomYb5kTeSivtFndMy5iDmf.jpg',
    '2026-05-25 23:59:00'
);

INSERT INTO
    users (
        username,
        email,
        password_hash,
        role
    )
VALUES (
        'admin',
        'admin@admin.com',
        '$2y$10$xNqX2A0H0znzIogy3jhLGurvaTvPDyIcgMLKNTnds8C4yFgeCKI3q',
        'admin'
    ),
    (
    'miha123',
    'miha123@mail.com',
    '$2y$10$wcILxq4d8AlTeTqAsx2c7eapKfDx7FVSpHYYXAswj9mZYcPsj35Zq',
    'user'
    ),
    (
        'ana_rose',
        'anarose@mail.com',
        '$2y$10$wcILxq4d8AlTeTqAsx2c7eapKfDx7FVSpHYYXAswj9mZYcPsj35Zq',
        'user'
    ),
    (
        'cinephile88',
        'cinephile88@mail.com',
        '$2y$10$wcILxq4d8AlTeTqAsx2c7eapKfDx7FVSpHYYXAswj9mZYcPsj35Zq',
        'user'
    ),
    (
        'batmanfan',
        'batmanfan@mail.com',
        '$2y$10$wcILxq4d8AlTeTqAsx2c7eapKfDx7FVSpHYYXAswj9mZYcPsj35Zq',
        'user'
    ),
    (
        'moviejunkie',
        'moviejunkie@mail.com',
        '$2y$10$wcILxq4d8AlTeTqAsx2c7eapKfDx7FVSpHYYXAswj9mZYcPsj35Zq',
        'user'
    ),
    (
        'lazycritic',
        'lazycritic@mail.com',
        '$2y$10$wcILxq4d8AlTeTqAsx2c7eapKfDx7FVSpHYYXAswj9mZYcPsj35Zq',
        'user'
    ),
    (
        'filmlover',
        'filmlover@mail.com',
        '$2y$10$wcILxq4d8AlTeTqAsx2c7eapKfDx7FVSpHYYXAswj9mZYcPsj35Zq',
        'user'
    ),
    (
        'scifiguy',
        'scifiguy@mail.com',
        '$2y$10$wcILxq4d8AlTeTqAsx2c7eapKfDx7FVSpHYYXAswj9mZYcPsj35Zq',
        'user'
    ),
    (
        'nightwatch',
        'nightwatch@mail.com',
        '$2y$10$wcILxq4d8AlTeTqAsx2c7eapKfDx7FVSpHYYXAswj9mZYcPsj35Zq',
        'user'
    ),
    (
        'reviewmaster',
        'reviewmaster@mail.com',
        '$2y$10$wcILxq4d8AlTeTqAsx2c7eapKfDx7FVSpHYYXAswj9mZYcPsj35Zq',
        'user'
    ),
    (
        'popcorn_eater',
        'popcorneater@mail.com',
        '$2y$10$wcILxq4d8AlTeTqAsx2c7eapKfDx7FVSpHYYXAswj9mZYcPsj35Zq',
        'user'
    );

    INSERT INTO
    reviews (
        movie_id,
        user_id,
        rating,
        review_text,
        created_at
    )
VALUES

-- Inception
(
    1,
    2,
    10,
    'Absolutely mind-blowing concept and execution.',
    '2026-05-01 18:22:00'
),
(
    1,
    3,
    9,
    'Gets better every time I watch it.',
    '2026-05-02 20:14:00'
),
(
    1,
    4,
    8,
    'A bit confusing at times but still amazing.',
    '2026-05-03 16:45:00'
),
(
    1,
    5,
    10,
    'Nolan at his absolute best.',
    '2026-05-04 22:10:00'
),
(
    1,
    6,
    9,
    'The hallway fight scene is legendary.',
    '2026-05-05 19:32:00'
),

-- The Dark Knight
(
    2,
    2,
    10,
    'Best superhero movie ever made.',
    '2026-05-06 21:20:00'
),
(
    2,
    7,
    10,
    'Heath Ledger completely steals the show.',
    '2026-05-06 22:40:00'
),
(
    2,
    8,
    9,
    'Dark, intense and unforgettable.',
    '2026-05-07 18:15:00'
),
(
    2,
    9,
    10,
    'The Joker is one of the greatest villains ever.',
    '2026-05-07 23:11:00'
),
(
    2,
    10,
    9,
    'Amazing action and atmosphere.',
    '2026-05-08 17:55:00'
),

-- Fight Club
(
    3,
    3,
    10,
    'Completely changed how I look at movies.',
    '2026-05-08 20:10:00'
),
(
    3,
    5,
    9,
    'Disturbing but brilliant.',
    '2026-05-09 19:44:00'
),
(
    3,
    6,
    8,
    'Very unique atmosphere and storytelling.',
    '2026-05-09 21:16:00'
),
(
    3,
    11,
    9,
    'Excellent performances from both leads.',
    '2026-05-10 15:08:00'
),
(
    3,
    12,
    10,
    'One of the best plot twists ever.',
    '2026-05-10 23:02:00'
),

-- Drive
(
    4,
    2,
    9,
    'The soundtrack and visuals are incredible.',
    '2026-05-11 18:27:00'
),
(
    4,
    4,
    8,
    'Slow at times but extremely stylish.',
    '2026-05-11 21:36:00'
),
(
    4,
    7,
    9,
    'Ryan Gosling fits this role perfectly.',
    '2026-05-12 20:40:00'
),
(
    4,
    8,
    8,
    'Minimal dialogue but very effective.',
    '2026-05-12 22:55:00'
),
(
    4,
    10,
    9,
    'Beautiful cinematography and atmosphere.',
    '2026-05-13 19:10:00'
),

-- Pulp Fiction
(
    5,
    3,
    10,
    'Tarantino masterpiece.',
    '2026-05-13 22:18:00'
),
(
    5,
    4,
    9,
    'Dialogue is legendary.',
    '2026-05-14 17:45:00'
),
(
    5,
    5,
    10,
    'Every scene is memorable.',
    '2026-05-14 20:00:00'
),
(
    5,
    9,
    9,
    'Incredibly entertaining from start to finish.',
    '2026-05-15 18:22:00'
),
(
    5,
    11,
    10,
    'Samuel L. Jackson is amazing in this.',
    '2026-05-15 23:12:00'
),

-- The Godfather
(
    6,
    2,
    10,
    'One of the greatest films ever made.',
    '2026-05-16 16:50:00'
),
(
    6,
    6,
    9,
    'Classic crime drama with amazing performances.',
    '2026-05-16 19:28:00'
),
(
    6,
    8,
    10,
    'Marlon Brando is unforgettable.',
    '2026-05-17 21:41:00'
),
(
    6,
    10,
    9,
    'Slow but absolutely worth it.',
    '2026-05-17 23:09:00'
),
(
    6,
    12,
    10,
    'Masterpiece of cinema.',
    '2026-05-18 20:17:00'
),

-- Knight and Day
(
    7,
    3,
    7,
    'Fun action movie with great chemistry.',
    '2026-05-18 22:11:00'
),
(
    7,
    4,
    6,
    'Not perfect but entertaining.',
    '2026-05-19 16:05:00'
),
(
    7,
    5,
    7,
    'Tom Cruise carries the movie hard.',
    '2026-05-19 20:55:00'
),
(
    7,
    9,
    8,
    'Better than I expected.',
    '2026-05-20 18:13:00'
),
(
    7,
    11,
    6,
    'Good popcorn action film.',
    '2026-05-20 21:44:00'
),

-- Mission: Impossible
(
    8,
    2,
    9,
    'Classic spy thriller.',
    '2026-05-21 17:32:00'
),
(
    8,
    5,
    8,
    'Tom Cruise is fantastic as Ethan Hunt.',
    '2026-05-21 20:16:00'
),
(
    8,
    6,
    9,
    'The suspense scenes are incredible.',
    '2026-05-22 18:27:00'
),
(
    8,
    7,
    8,
    'Still holds up surprisingly well.',
    '2026-05-22 22:01:00'
),
(
    8,
    12,
    9,
    'Excellent action and pacing.',
    '2026-05-23 19:20:00'
),

-- The Amazing Spider-Man
(
    9,
    3,
    8,
    'Andrew Garfield deserved another movie.',
    '2026-05-23 21:50:00'
),
(
    9,
    4,
    7,
    'Solid reboot with great action scenes.',
    '2026-05-23 23:14:00'
),
(
    9,
    8,
    8,
    'Emma Stone and Andrew Garfield have amazing chemistry.',
    '2026-05-24 17:41:00'
),
(
    9,
    10,
    7,
    'Underrated Spider-Man movie.',
    '2026-05-24 20:05:00'
),
(
    9,
    11,
    8,
    'The Lizard was pretty cool.',
    '2026-05-24 22:38:00'
),

-- Tropic Thunder
(
    10,
    2,
    9,
    'One of the funniest comedies ever.',
    '2026-05-25 15:22:00'
),
(
    10,
    5,
    8,
    'Hilarious satire and amazing cast.',
    '2026-05-25 18:49:00'
),
(
    10,
    7,
    9,
    'Robert Downey Jr. is unbelievable here.',
    '2026-05-25 20:33:00'
),
(
    10,
    9,
    8,
    'Absolutely chaotic in the best way possible.',
    '2026-05-25 22:57:00'
),
(
    10,
    12,
    9,
    'Never stops being funny.',
    '2026-05-26 00:14:00'
),

-- Interstellar
(
    11,
    2,
    10,
    'Masterpiece. Emotional and visually stunning.',
    '2026-05-26 09:05:00'
),
(
    11,
    3,
    10,
    'Hans Zimmer soundtrack is unbelievable.',
    '2026-05-26 10:47:00'
),
(
    11,
    4,
    9,
    'One of my favorite sci-fi movies.',
    '2026-05-26 12:13:00'
),
(
    11,
    6,
    10,
    'The ending hits incredibly hard.',
    '2026-05-26 14:58:00'
),
(
    11,
    8,
    9,
    'Visually breathtaking and emotional.',
    '2026-05-26 16:24:00'
),

-- The Nice Guys
(
    12,
    5,
    8,
    'Underrated comedy with great chemistry.',
    '2026-05-26 17:10:00'
),
(
    12,
    6,
    9,
    'Ryan Gosling is hilarious in this.',
    '2026-05-26 17:44:00'
),
(
    12,
    7,
    8,
    'Very fun detective story.',
    '2026-05-26 18:12:00'
),
(
    12,
    10,
    9,
    'Crowe and Gosling work perfectly together.',
    '2026-05-26 18:47:00'
),
(
    12,
    11,
    8,
    'Deserved way more attention.',
    '2026-05-26 19:03:00'
),

-- La La Land
(
    13,
    2,
    9,
    'Beautiful music and cinematography.',
    '2026-05-26 19:20:00'
),
(
    13,
    4,
    8,
    'Emotional ending and fantastic performances.',
    '2026-05-26 19:41:00'
),
(
    13,
    5,
    9,
    'The opening scene is incredible.',
    '2026-05-26 20:02:00'
),
(
    13,
    8,
    10,
    'One of the best modern musicals.',
    '2026-05-26 20:18:00'
),
(
    13,
    12,
    9,
    'Emma Stone was amazing.',
    '2026-05-26 20:40:00'
),

-- Avengers: Infinity War
(
    14,
    2,
    10,
    'Thanos is one of the best MCU villains ever.',
    '2026-05-26 20:55:00'
),
(
    14,
    4,
    9,
    'The ending shocked me the first time I watched it.',
    '2026-05-26 21:11:00'
),
(
    14,
    6,
    10,
    'Perfect balance between action, humor and emotional moments.',
    '2026-05-26 21:28:00'
),
(
    14,
    8,
    9,
    'Seeing all the heroes together was incredible.',
    '2026-05-26 21:46:00'
),
(
    14,
    10,
    8,
    'Non-stop action and surprisingly emotional.',
    '2026-05-26 22:03:00'
),
(
    14,
    11,
    10,
    'One of the best superhero movies ever made.',
    '2026-05-26 22:21:00'
),

-- Money Plane
(
    15,
    3,
    3,
    'Ridiculous movie but somehow entertaining.',
    '2026-05-26 22:44:00'
),
(
    15,
    4,
    4,
    'Not good, but fun to laugh at.',
    '2026-05-26 22:57:00'
),
(
    15,
    7,
    2,
    'The dialogue is unbelievably bad.',
    '2026-05-26 23:11:00'
),
(
    15,
    9,
    5,
    'So bad it becomes funny.',
    '2026-05-26 23:26:00'
),
(
    15,
    10,
    3,
    'A true guilty pleasure.',
    '2026-05-26 23:40:00'
),

-- Project Hail Mary
(
    16,
    2,
    9,
    'Very excited for this adaptation.',
    '2026-05-27 00:02:00'
),
(
    16,
    5,
    8,
    'Great concept and Ryan Gosling is a good choice.',
    '2026-05-27 00:14:00'
),
(
    16,
    6,
    9,
    'Could become the next big sci-fi movie.',
    '2026-05-27 00:28:00'
),
(
    16,
    11,
    8,
    'The premise sounds incredibly interesting.',
    '2026-05-27 00:45:00'
),
(
    16,
    12,
    9,
    'One of my favourite movies of all time.',
    '2026-05-27 01:02:00'
);