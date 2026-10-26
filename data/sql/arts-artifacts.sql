-- =====================================================================
-- Art & Artifacts Database Schema & Seed Data
-- Standardized on Museum Cataloging Standards (Object-centric terminology)
-- =====================================================================

-- ---------------------------------------------------------------------
-- 1. Table: department
-- ---------------------------------------------------------------------
CREATE TABLE department (
    department_id       INT AUTO_INCREMENT PRIMARY KEY,
    department_name     VARCHAR(100) NOT NULL,
    department_code     VARCHAR(10) UNIQUE,
    description         TEXT,
    floor_location      VARCHAR(50),
    established_year    YEAR,
    is_active           BOOLEAN DEFAULT TRUE,
    curator_name        VARCHAR(100),
    contact_email       VARCHAR(150),
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO department (department_id, department_name, department_code, description, floor_location, established_year, is_active, curator_name, contact_email) VALUES
(1, 'Egyptian Art', 'EGY', 'Art and artifacts of ancient Egypt from the prehistoric period to the Roman period.', 'Floor 1, Wing A', 1870, TRUE, 'Dr. Zahi Hawass', 'egyptian@museum.org'),
(2, 'Greek and Roman Art', 'GRE', 'Comprehensive collection of classical Greek and Roman sculpture, pottery, and metalwork.', 'Floor 1, Wing B', 1872, TRUE, 'Dr. Sarah Alpert', 'greeklan@museum.org'),
(3, 'Asian Art', 'ASN', 'Arts of East Asia, South and Southeast Asia, and the Himalayas.', 'Floor 2, Wing A', 1915, TRUE, 'Dr. Kenji Sato', 'asianart@museum.org'),
(4, 'European Paintings', 'EUR', 'European paintings from the 13th through the early 20th century.', 'Floor 2, Wing B', 1870, TRUE, 'Dr. Claire Dupont', 'eurpaintings@museum.org'),
(5, 'Arms and Armor', 'ARM', 'European and Near Eastern armor, swords, firearms, and equestrian equipment.', 'Floor 1, Gallery 371', 1912, TRUE, 'Sir Reginald Vance', 'armor@museum.org'),
(6, 'American Wing', 'AMR', 'American fine and decorative arts from the late 17th through the early 20th century.', 'Floor 3, Wing A', 1924, TRUE, 'Eleanor Roosevelt Jr.', 'americanwing@museum.org'),
(7, 'Arts of Africa, Oceania, and the Americas', 'AOA', 'Diverse artistic traditions of sub-Saharan Africa, the Pacific Islands, and the Americas.', 'Floor 1, Wing C', 1969, TRUE, 'Dr. Kofi Mensah', 'aoa@museum.org'),
(8, 'Modern and Contemporary Art', 'MOD', 'Twentieth- and twenty-first-century art, including paintings, sculptures, and mixed media.', 'Floor 4, Main Gallery', 1967, TRUE, 'Maya Lin', 'modernart@museum.org'),
(9, 'Drawings and Prints', 'DRW', 'Works on paper including drawings, prints, artist books, and architectural models.', 'Floor 2, Study Room', 1870, TRUE, 'Julian Barnes', 'prints@museum.org'),
(10, 'Costume Institute', 'COS', 'Fashion history featuring regional costumes, haute couture, and historical garments.', 'Floor Basement, Vault C', 1937, TRUE, 'Anna Wintour', 'costume@museum.org');

-- ---------------------------------------------------------------------
-- 2. Table: culture
-- ---------------------------------------------------------------------
CREATE TABLE culture (
    culture_id          INT AUTO_INCREMENT PRIMARY KEY,
    culture_name        VARCHAR(100) NOT NULL,
    region              VARCHAR(100),
    continent           ENUM('africa','asia','europe','north_america','south_america','oceania','antarctica'),
    language_family     VARCHAR(100),
    time_period_start   INT,
    time_period_end     INT,
    description         TEXT,
    is_extinct_culture  BOOLEAN DEFAULT FALSE,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO culture (culture_id, culture_name, region, continent, language_family, time_period_start, time_period_end, description, is_extinct_culture) VALUES
(1, 'Ancient Egyptian', 'Nile River Valley', 'africa', 'Afroasiatic', -3100, -30, 'Civilization of ancient northeastern Africa along the lower reaches of the Nile River.', TRUE),
(2, 'Ancient Greek', 'Attica and Peloponnese', 'europe', 'Indo-European', -800, -146, 'Classical Hellenic civilization known for philosophy, democracy, and monumental art.', TRUE),
(3, 'Roman', 'Italian Peninsula and Mediterranean', 'europe', 'Indo-European', -753, 476, 'Ancient Roman civilization from the founding of the city to the fall of the Western Empire.', TRUE),
(4, 'Dynastic Chinese', 'Central China', 'asia', 'Sino-Tibetan', -1600, 1912, 'Imperial dynasties of China spanning the Shang through the Qing dynasties.', FALSE),
(5, 'Navajo (Diné)', 'American Southwest', 'north_america', 'Na-Dené', 1500, 2026, 'Indigenous people of the Southwestern United States renowned for weaving and silverwork.', FALSE),
(6, 'Yoruba', 'West Africa', 'africa', 'Niger-Congo', 1100, 2026, 'Ethnic group native to Southwestern Nigeria and parts of Benin and Togo.', FALSE),
(7, 'Mesoamerican (Maya)', 'Mesoamerica', 'north_america', 'Mayan', -2000, 1697, 'Indigenous civilization of Central America famed for hieroglyphic script and mathematics.', TRUE),
(8, 'Japanese Edo', 'Japan', 'asia', 'Japonic', 1603, 1868, 'Tokugawa shogunate period characterized by economic growth and ukiyo-e art.', TRUE),
(9, 'Celtic', 'Western Europe', 'europe', 'Indo-European', -1200, 400, 'Iron Age tribal societies across Western and Central Europe.', TRUE),
(10, 'Inca', 'Andean Region', 'south_america', 'Quechuan', 1438, 1572, 'Largest empire in pre-Columbian America centered in the Andes.', TRUE);

-- ---------------------------------------------------------------------
-- 3. Table: period
-- ---------------------------------------------------------------------
CREATE TABLE period (
    period_id           INT AUTO_INCREMENT PRIMARY KEY,
    period_name         VARCHAR(100) NOT NULL,
    era                 ENUM('ancient','classical','medieval','renaissance','early_modern','modern','contemporary'),
    start_year          INT,
    end_year            INT,
    dynasty             VARCHAR(100),
    geographic_scope    VARCHAR(100),
    description         TEXT,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO period (period_id, period_name, era, start_year, end_year, dynasty, geographic_scope, description) VALUES
(1, 'Old Kingdom', 'ancient', -2686, -2181, '4th to 6th Dynasty', 'Egypt', 'Age of the Pyramids and monumental stone architecture.'),
(2, 'Classical Period', 'classical', -480, -323, 'Hellenic Period', 'Greece', 'Golden age of Athens, classical sculpture, and dramatic arts.'),
(3, 'Augustan Roman', 'classical', -27, 14, 'Julio-Claudian Dynasty', 'Roman Empire', 'Beginning of the Pax Romana under Emperor Augustus.'),
(4, 'Tang Dynasty', 'medieval', 618, 907, 'Tang Dynasty', 'China', 'Golden age of cosmopolitan culture, poetry, and porcelain.'),
(5, 'Italian Renaissance', 'renaissance', 1400, 1600, 'Medici Era', 'Italy', 'Cultural rebirth centered on humanism, perspective painting, and classical revival.'),
(6, 'Edo Period', 'early_modern', 1603, 1868, 'Tokugawa Shogunate', 'Japan', 'Isolationist peace, urban merchant culture, and woodblock printing.'),
(7, 'Victorian Era', 'modern', 1837, 1901, 'Victorian Era', 'United Kingdom and Empire', 'Industrial revolution, expansion, and ornate decorative arts.'),
(8, 'Modern Era', 'modern', 1900, 1950, 'Interwar Period', 'Global', 'Avant-garde movements, cubism, surrealism, and abstract expressionism.'),
(9, 'Contemporary', 'contemporary', 1950, 2026, 'Post-War Era', 'Global', 'Globalized artistic production, digital art, and conceptual installations.'),
(10, 'Post-Classic Maya', 'medieval', 900, 1519, 'Mayan City-States', 'Mesoamerica', 'Rise of Chichen Itza and vibrant coastal trade networks.');

-- ---------------------------------------------------------------------
-- 4. Table: medium
-- ---------------------------------------------------------------------
CREATE TABLE medium (
    medium_id               INT AUTO_INCREMENT PRIMARY KEY,
    medium_name             VARCHAR(100) NOT NULL,
    material_category       ENUM('stone','metal','wood','textile','ceramic','paint','paper','glass','organic','mixed','other'),
    description             TEXT,
    is_fragile              BOOLEAN DEFAULT FALSE,
    density_category        ENUM('low','medium','high'),
    common_era_introduced   INT,
    conservation_notes      TEXT,
    created_at              TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at              TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO medium (medium_id, medium_name, material_category, description, is_fragile, density_category, common_era_introduced, conservation_notes) VALUES
(1, 'Limestone', 'stone', 'Fine-grained sedimentary rock commonly used in Egyptian and Greek relief carvings.', FALSE, 'high', -3500, 'Sensitive to acidic environments and moisture.'),
(2, 'Bronze', 'metal', 'Copper and tin alloy favored for statuary and weaponry.', FALSE, 'high', -3000, 'Susceptible to bronze disease if exposed to chloride.'),
(3, 'Terracotta', 'ceramic', 'Fired clay used for figurines, pottery, and architectural elements.', TRUE, 'medium', -5000, 'Porous material; store in climate-controlled conditions.'),
(4, 'Oil on Canvas', 'paint', 'Pigments bound with drying oil applied to stretched canvas.', TRUE, 'low', 1400, 'Requires stable humidity to prevent canvas warping and paint cracking.'),
(5, 'Wool and Cotton', 'textile', 'Woven fiber textiles used in rugs, wall hangings, and historical garments.', TRUE, 'low', -3000, 'Protect from light exposure and textile pests.'),
(6, 'Gold Leaf', 'metal', 'Hammered gold sheets applied to decorative surfaces.', FALSE, 'high', -2500, 'Delicate surface layer; avoid abrasive cleaning.'),
(7, 'Porcelain', 'ceramic', 'Translucent ceramic fired at high temperatures.', TRUE, 'medium', 600, 'Brittle; protect against impact and thermal shock.'),
(8, 'Ink on Paper', 'paper', 'Traditional calligraphy and drawing ink applied to handmade paper.', TRUE, 'low', 100, 'Extremely light-sensitive; exhibit under low lux levels.'),
(9, 'Carved Wood', 'wood', 'Polychrome or natural timber sculptures and masks.', TRUE, 'medium', -4000, 'Prone to splitting with fluctuations in relative humidity.'),
(10, 'Blown Glass', 'glass', 'Translucent silicate glass vessels and ornaments.', TRUE, 'low', -100, 'High risk of breakage under mechanical stress.');

-- ---------------------------------------------------------------------
-- 5. Table: artist
-- ---------------------------------------------------------------------
CREATE TABLE artist (
    artist_id    INT AUTO_INCREMENT PRIMARY KEY,
    full_name    VARCHAR(150) NOT NULL,
    display_name VARCHAR(150),
    nationality  VARCHAR(100),
    birth_date   DATE,
    death_date   DATE,
    gender       ENUM('male','female','unknown','other'),
    biography    TEXT,
    is_anonymous BOOLEAN DEFAULT FALSE,
    wikidata_url VARCHAR(255),
    created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO artist (artist_id, full_name, display_name, nationality, birth_date, death_date, gender, biography, is_anonymous, wikidata_url) VALUES
(1, 'Leonardo di ser Piero da Vinci', 'Leonardo da Vinci', 'Italian', '1452-04-15', '1519-05-02', 'male', 'High Renaissance polymath, painter of the Mona Lisa and The Last Supper.', FALSE, 'https://www.wikidata.org/wiki/Q762'),
(2, 'Michelangelo di Lodovico Buonarroti Simoni', 'Michelangelo', 'Italian', '1475-03-06', '1564-02-18', 'male', 'Sculptor, painter, and architect of the High Renaissance.', FALSE, 'https://www.wikidata.org/wiki/Q5592'),
(3, 'Rembrandt Harmenszoon van Rijn', 'Rembrandt', 'Dutch', '1606-07-15', '1669-10-04', 'male', 'Master draftsman and printmaker of the Dutch Golden Age.', FALSE, 'https://www.wikidata.org/wiki/Q5598'),
(4, 'Vincent Willem van Gogh', 'Vincent van Gogh', 'Dutch', '1853-03-30', '1890-07-29', 'male', 'Post-Impressionist painter whose work had a far-reaching influence.', FALSE, 'https://www.wikidata.org/wiki/Q5582'),
(5, 'Pablo Ruiz y Picasso', 'Pablo Picasso', 'Spanish', '1881-10-25', '1973-04-08', 'male', 'Co-founder of the Cubist movement and prolific 20th-century artist.', FALSE, 'https://www.wikidata.org/wiki/Q5593'),
(6, 'Katsushika Hokusai', 'Hokusai', 'Japanese', '1760-10-31', '1849-05-10', 'male', 'Ukiyo-e painter and printmaker, creator of The Great Wave off Kanagawa.', FALSE, 'https://www.wikidata.org/wiki/Q5586'),
(7, 'Claude Monet', 'Claude Monet', 'French', '1840-11-14', '1926-12-05', 'male', 'Founder of French Impressionist painting.', FALSE, 'https://www.wikidata.org/wiki/Q296'),
(8, 'Anonymous Master', 'Anonymous', 'Unknown', '1000-01-01', '1500-01-01', 'unknown', 'Historical artisan whose individual identity is lost to time.', TRUE, 'https://www.wikidata.org/wiki/Q4233718'),
(9, 'Frida Kahlo', 'Frida Kahlo', 'Mexican', '1907-07-06', '1954-07-13', 'female', 'Mexican painter known for her uncompromising and vividly colored self-portraits.', FALSE, 'https://www.wikidata.org/wiki/Q5589'),
(10, 'Georgia Totto O\'Keeffe', 'Georgia O\'Keeffe', 'American', '1887-11-15', '1986-03-06', 'female', 'Known as the \'Mother of American Modernism\', famous for flower paintings and New York skyscrapers.', FALSE, 'https://www.wikidata.org/wiki/Q189140');

-- ---------------------------------------------------------------------
-- 6. Table: artifact
-- ---------------------------------------------------------------------
CREATE TABLE artifact (
    object_id                   INT AUTO_INCREMENT PRIMARY KEY,
    title                       VARCHAR(255) NOT NULL,
    object_name                 VARCHAR(100),
    department_id               INT,
    culture_id                  INT,
    period_id                   INT,
    medium_id                   INT,
    object_date                 VARCHAR(50),
    start_year                  INT,
    end_year                    INT,
    height_cm                   DECIMAL(8,2),
    width_cm                    DECIMAL(8,2),
    credit_line                 VARCHAR(255),
    is_highlight                BOOLEAN DEFAULT FALSE,
    is_public_domain            BOOLEAN DEFAULT FALSE,
    acquisition_date            DATE,
    rights_and_reproduction     ENUM('public_domain','restricted','unknown') DEFAULT 'unknown',
    created_at                  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at                  TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_artifact_department FOREIGN KEY (department_id) REFERENCES department(department_id),
    CONSTRAINT fk_artifact_culture    FOREIGN KEY (culture_id)    REFERENCES culture(culture_id),
    CONSTRAINT fk_artifact_period     FOREIGN KEY (period_id)     REFERENCES period(period_id),
    CONSTRAINT fk_artifact_medium     FOREIGN KEY (medium_id)     REFERENCES medium(medium_id)
);

INSERT INTO artifact (object_id, title, object_name, department_id, culture_id, period_id, medium_id, object_date, start_year, end_year, height_cm, width_cm, credit_line, is_highlight, is_public_domain, acquisition_date, rights_and_reproduction) VALUES
(1, 'Statue of Hatshepsut', 'Statue', 1, 1, 1, 1, 'ca. 1473–1458 B.C.', -1473, -1458, 245.00, 80.00, 'Museum Excavation, 1925', TRUE, TRUE, '1926-01-15', 'public_domain'),
(2, 'The Parthenon Marbles (Fragment)', 'Sculpture', 2, 2, 2, 1, 'ca. 447–432 B.C.', -447, -432, 120.00, 95.00, 'Purchase, 1900', TRUE, TRUE, '1901-05-10', 'public_domain'),
(3, 'Roman Imperial Cuirass', 'Armor', 5, 3, 3, 2, 'ca. 1st Century A.D.', 1, 100, 65.00, 50.00, 'Rogers Fund, 1910', FALSE, TRUE, '1910-08-20', 'public_domain'),
(4, 'Tang Dynasty Camel Figurine', 'Statuette', 3, 4, 4, 3, 'ca. 8th century', 700, 800, 85.00, 35.00, 'Gift of John D. Rockefeller Jr., 1930', TRUE, TRUE, '1930-11-12', 'public_domain'),
(5, 'Navajo Chief Blanket', 'Textile', 7, 5, 7, 5, 'ca. 1870', 1870, 1880, 180.00, 140.00, 'Purchase, Edward C. Moore Bequest, 1923', TRUE, TRUE, '1923-04-05', 'public_domain'),
(6, 'Yoruba Beaded Crown', 'Crown', 7, 6, 7, 5, 'ca. 19th century', 1800, 1900, 50.00, 30.00, 'The Michael C. Rockefeller Memorial Collection, 1978', FALSE, TRUE, '1978-09-15', 'public_domain'),
(7, 'Under the Wave off Kanagawa (The Great Wave)', 'Woodblock Print', 9, 8, 6, 8, 'ca. 1830–33', 1830, 1833, 25.70, 37.80, 'H. O. Havemeyer Collection, Bequest of Mrs. H. O. Havemeyer, 1929', TRUE, TRUE, '1929-03-01', 'public_domain'),
(8, 'Study of a Young Woman', 'Painting', 4, 3, 5, 4, 'ca. 1650', 1645, 1655, 60.00, 48.00, 'Bequest of Benjamin Altman, 1913', TRUE, TRUE, '1913-05-20', 'public_domain'),
(9, 'Maya Relief Panel', 'Relief', 7, 7, 10, 1, 'ca. 700 A.D.', 650, 750, 110.00, 85.00, 'Dumbarton Oaks Loan, 1985', FALSE, TRUE, '1985-02-14', 'public_domain'),
(10, 'Modernist Iron Sculpture', 'Sculpture', 8, 4, 9, 2, 'ca. 1935', 1930, 1940, 150.00, 60.00, 'Purchase, 1968', FALSE, FALSE, '1968-10-10', 'restricted');

-- ---------------------------------------------------------------------
-- 7. Table: object_artist
-- ---------------------------------------------------------------------
CREATE TABLE object_artist (
    object_artist_id    INT AUTO_INCREMENT PRIMARY KEY,
    object_id           INT NOT NULL,
    artist_id           INT NOT NULL,
    artist_role         ENUM('creator','attributed','workshop_of','after','school_of','manner_of') DEFAULT 'creator',
    is_primary_artist   BOOLEAN DEFAULT TRUE,
    confidence_level    ENUM('confirmed','probable','uncertain') DEFAULT 'confirmed',
    notes               TEXT,
    display_order       INT DEFAULT 1,
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_objart_artifact FOREIGN KEY (object_id) REFERENCES artifact(object_id),
    CONSTRAINT fk_objart_artist   FOREIGN KEY (artist_id) REFERENCES artist(artist_id),
    CONSTRAINT uq_object_artist   UNIQUE (object_id, artist_id)
);

INSERT INTO object_artist (object_artist_id, object_id, artist_id, artist_role, is_primary_artist, confidence_level, notes, display_order) VALUES
(1, 1, 8, 'creator', TRUE, 'confirmed', 'Created by royal Egyptian workshop artisans.', 1),
(2, 2, 8, 'creator', TRUE, 'probable', 'Attributed to classical Greek master sculptors.', 1),
(3, 3, 8, 'creator', TRUE, 'confirmed', 'Imperial Roman armorer.', 1),
(4, 4, 8, 'creator', TRUE, 'confirmed', 'Tang dynasty imperial kiln ceramicist.', 1),
(5, 5, 8, 'creator', TRUE, 'confirmed', 'Navajo weaver artisan.', 1),
(6, 6, 8, 'creator', TRUE, 'confirmed', 'Yoruba royal beadworker guild.', 1),
(7, 7, 6, 'creator', TRUE, 'confirmed', 'Designed by Katsushika Hokusai.', 1),
(8, 8, 3, 'creator', TRUE, 'confirmed', 'Painted by Rembrandt van Rijn.', 1),
(9, 9, 8, 'creator', TRUE, 'confirmed', 'Classic Maya relief carver.', 1),
(10, 10, 5, 'creator', TRUE, 'confirmed', 'Sculpture attributed to the modern era.', 1);

-- ---------------------------------------------------------------------
-- 8. Table: object_image
-- ---------------------------------------------------------------------
CREATE TABLE object_image (
    image_id    INT AUTO_INCREMENT PRIMARY KEY,
    object_id   INT NOT NULL,
    image_url   VARCHAR(500) NOT NULL,
    image_type  ENUM('primary','additional','detail','conservation') DEFAULT 'primary',
    width_px    INT,
    height_px   INT,
    file_format ENUM('jpg','png','tiff','webp') DEFAULT 'jpg',
    is_primary  BOOLEAN DEFAULT FALSE,
    alt_text    VARCHAR(255),
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_image_artifact FOREIGN KEY (object_id) REFERENCES artifact(object_id)
);

INSERT INTO object_image (image_id, object_id, image_url, image_type, width_px, height_px, file_format, is_primary, alt_text) VALUES
(1, 1, 'https://images.metmuseum.org/CRDImages/eg/original/DP123456.jpg', 'primary', 2000, 3000, 'jpg', TRUE, 'Statue of Queen Hatshepsut in limestone.'),
(2, 2, 'https://images.metmuseum.org/CRDImages/gr/original/DP234567.jpg', 'primary', 2500, 2000, 'jpg', TRUE, 'Fragment of Parthenon marble frieze.'),
(3, 3, 'https://images.metmuseum.org/CRDImages/aa/original/DP345678.jpg', 'primary', 1800, 2400, 'jpg', TRUE, 'Roman imperial bronze and leather cuirass.'),
(4, 4, 'https://images.metmuseum.org/CRDImages/as/original/DP456789.jpg', 'primary', 2200, 2200, 'jpg', TRUE, 'Glazed terracotta camel figurine from Tang dynasty.'),
(5, 5, 'https://images.metmuseum.org/CRDImages/ao/original/DP567890.jpg', 'primary', 3000, 2000, 'jpg', TRUE, 'Woven Navajo chief blanket with geometric stripes.'),
(6, 6, 'https://images.metmuseum.org/CRDImages/ao/original/DP678901.jpg', 'primary', 2000, 2000, 'jpg', TRUE, 'Yoruba ceremonial beaded crown.'),
(7, 7, 'https://images.metmuseum.org/CRDImages/dp/original/DP789012.jpg', 'primary', 3200, 2400, 'jpg', TRUE, 'The Great Wave off Kanagawa woodblock print.'),
(8, 8, 'https://images.metmuseum.org/CRDImages/ep/original/DP890123.jpg', 'primary', 2400, 3000, 'jpg', TRUE, 'Portrait study of a young woman by Rembrandt.'),
(9, 9, 'https://images.metmuseum.org/CRDImages/ao/original/DP901234.jpg', 'primary', 2100, 2800, 'jpg', TRUE, 'Maya limestone relief sculpture panel.'),
(10, 10, 'https://images.metmuseum.org/CRDImages/ma/original/DP012345.jpg', 'primary', 2000, 2000, 'jpg', TRUE, 'Modernist iron abstract sculpture.');

-- ---------------------------------------------------------------------
-- 9. Table: location
-- ---------------------------------------------------------------------
CREATE TABLE location (
    location_id     INT AUTO_INCREMENT PRIMARY KEY,
    country         TEXT,
    city            TEXT,
    address         TEXT,
    state_province  VARCHAR(100),
    postal_code     VARCHAR(20),
    country_code    CHAR(2)
);

INSERT INTO location (location_id, country, city, address, state_province, postal_code, country_code) VALUES
(1, 'United States', 'New York', '1000 5th Ave', 'New York', '10082', 'US'),
(2, 'United Kingdom', 'London', 'Cromwell Rd, South Kensington', 'London', 'SW7 5BD', 'GB'),
(3, 'France', 'Paris', 'Rue de Rivoli', 'Île-de-France', '75001', 'FR'),
(4, 'Egypt', 'Cairo', 'Tahrir Square', 'Cairo Governorate', '11511', 'EG'),
(5, 'Japan', 'Tokyo', '13-9 Uenopark, Taitoku', 'Tokyo', '110-8712', 'JP'),
(6, 'Italy', 'Rome', 'Piazza del Colosseo', 'Lazio', '00184', 'IT'),
(7, 'Germany', 'Berlin', 'Museumsinsel', 'Berlin', '10117', 'DE'),
(8, 'Canada', 'Montreal', '1379 Sherbrooke St W', 'Quebec', 'H3G 1J5', 'CA'),
(9, 'Mexico', 'Mexico City', 'Paseo de la Reforma y Calzada Gandhi s/n', 'CDMX', '11560', 'MX'),
(10, 'Spain', 'Madrid', 'Calle de Ruiz de Alarcón, 23', 'Madrid', '28014', 'ES');

-- ---------------------------------------------------------------------
-- 10. Table: user
-- ---------------------------------------------------------------------
CREATE TABLE user (
    user_id         INT AUTO_INCREMENT PRIMARY KEY,
    username        VARCHAR(50) NOT NULL UNIQUE,
    email           VARCHAR(150) NOT NULL UNIQUE,
    password_hash   VARCHAR(255) NOT NULL,
    full_name       VARCHAR(150),
    account_status  ENUM('active','suspended','deactivated') DEFAULT 'active',
    role            ENUM('visitor','member','curator','admin') DEFAULT 'visitor',
    date_joined     DATE,
    last_login      TIMESTAMP NULL,
    profile_bio     TEXT
);

INSERT INTO user (user_id, username, email, password_hash, full_name, account_status, role, date_joined, profile_bio) VALUES
(1, 'alice_smith', 'alice@example.com', '$2y$10$abcdefghijklmnopqrstuvwx123456', 'Alice Smith', 'active', 'admin', '2025-12-01', 'System administrator and art enthusiast.'),
(2, 'bob_jones', 'bob@example.com', '$2y$10$abcdefghijklmnopqrstuvwx234567', 'Bob Jones', 'active', 'member', '2025-12-05', 'Student developer exploring museum APIs.'),
(3, 'carol_davis', 'carol@example.com', '$2y$10$abcdefghijklmnopqrstuvwx345678', 'Carol Davis', 'active', 'curator', '2025-12-10', 'Museum curator and artifact researcher.'),
(4, 'david_brown', 'david@example.com', '$2y$10$abcdefghijklmnopqrstuvwx456789', 'David Brown', 'active', 'curator', '2026-01-15', 'Specialist in classical antiquities.'),
(5, 'emma_wilson', 'emma@example.com', '$2y$10$abcdefghijklmnopqrstuvwx567890', 'Emma Wilson', 'active', 'visitor', '2026-02-01', 'Art history student.'),
(6, 'frank_miller', 'frank@example.com', '$2y$10$abcdefghijklmnopqrstuvwx678901', 'Frank Miller', 'active', 'member', '2026-02-20', 'Digital media designer.'),
(7, 'grace_taylor', 'grace@example.com', '$2y$10$abcdefghijklmnopqrstuvwx789012', 'Grace Taylor', 'active', 'curator', '2026-03-05', 'Anthropology researcher.'),
(8, 'henry_anderson', 'henry@example.com', '$2y$10$abcdefghijklmnopqrstuvwx890123', 'Henry Anderson', 'suspended', 'visitor', '2026-04-10', 'Casual visitor.'),
(9, 'isabel_thomas', 'isabel@example.com', '$2y$10$abcdefghijklmnopqrstuvwx901234', 'Isabel Thomas', 'active', 'curator', '2026-05-01', 'Asian art historian.'),
(10, 'jack_white', 'jack@example.com', '$2y$10$abcdefghijklmnopqrstuvwx012345', 'Jack White', 'active', 'visitor', '2026-06-12', 'Guest portal explorer.');

-- ---------------------------------------------------------------------
-- 11. Table: exhibit
-- ---------------------------------------------------------------------
CREATE TABLE exhibit (
    exhibit_id          INT AUTO_INCREMENT PRIMARY KEY,
    user_id             INT NOT NULL,
    location_id         INT NOT NULL,
    exhibit_name        VARCHAR(150) NOT NULL,
    description         TEXT,
    is_public           BOOLEAN DEFAULT FALSE,
    cover_image_url     VARCHAR(500),
    visibility          ENUM('private','public','unlisted') DEFAULT 'private',
    created_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    view_count          INT DEFAULT 0,
    CONSTRAINT fk_exhibit_user     FOREIGN KEY (user_id)     REFERENCES user(user_id),
    CONSTRAINT fk_exhibit_location FOREIGN KEY (location_id) REFERENCES location(location_id)
);

INSERT INTO exhibit (exhibit_id, user_id, location_id, exhibit_name, description, is_public, visibility, view_count) VALUES
(1, 1, 1, 'Tech & Art Fusion', 'Exploring software development inspiration through ancient and modern artifacts.', TRUE, 'public', 1420),
(2, 2, 8, 'College Project Showcase', 'Selected artifacts compiled for student programming projects.', TRUE, 'public', 890),
(3, 3, 1, 'Classical Masterpieces', 'Key highlights of Greek, Roman, and Egyptian antiquity.', TRUE, 'public', 2340),
(4, 4, 2, 'Imperial Arms & Armor', 'Comprehensive review of historical protection and weaponry.', FALSE, 'private', 120),
(5, 5, 5, 'Edo Period Woodblock Prints', 'Stunning ukiyo-e masterpieces from Japanese history.', TRUE, 'public', 1650),
(6, 6, 3, 'Renaissance Visions', 'Masterworks from the Italian and Northern European Renaissance.', TRUE, 'public', 2110),
(7, 7, 4, 'African Heritage & Material Culture', 'Deep dive into textile arts, crowns, and ethnographic artifacts.', TRUE, 'public', 950),
(8, 8, 6, 'Roman Imperial Power', 'Statues, cuirasses, and imperial art of the ancient Roman Empire.', FALSE, 'private', 45),
(9, 9, 5, 'Asian Ceramics & Sculptures', 'Terracotta figures, pottery, and classical East Asian arts.', TRUE, 'public', 1120),
(10, 1, 9, 'Mesoamerican Sculptural Arts', 'Relief panels and stone carvings of Central America.', TRUE, 'unlisted', 310);

-- ---------------------------------------------------------------------
-- 12. Table: exhibit_object
-- ---------------------------------------------------------------------
CREATE TABLE exhibit_object (
    exhibit_object_id   INT AUTO_INCREMENT PRIMARY KEY,
    exhibit_id          INT NOT NULL,
    object_id           INT NOT NULL,
    display_order       INT DEFAULT 1,
    personal_note       TEXT,
    added_at            TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_featured         BOOLEAN DEFAULT FALSE,
    highlight_color     VARCHAR(20),
    tag                 ENUM('favorite','to_research','loaned','archived'),
    updated_at          TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_exhobj_exhibit  FOREIGN KEY (exhibit_id) REFERENCES exhibit(exhibit_id),
    CONSTRAINT fk_exhobj_artifact FOREIGN KEY (object_id)  REFERENCES artifact(object_id),
    CONSTRAINT uq_exhibit_object  UNIQUE (exhibit_id, object_id)
);

INSERT INTO exhibit_object (exhibit_object_id, exhibit_id, object_id, display_order, personal_note, is_featured, highlight_color, tag) VALUES
(1, 1, 1, 1, 'Great example of Egyptian monumental sculpture.', TRUE, '#4A90E2', 'favorite'),
(2, 1, 7, 2, 'Incredible woodblock color technique.', TRUE, '#E94E77', 'favorite'),
(3, 2, 5, 1, 'Stunning geometric weaving pattern.', FALSE, '#50E3C2', 'to_research'),
(4, 3, 2, 1, 'Classic Greek architectural sculpture.', TRUE, '#F5A623', 'favorite'),
(5, 4, 3, 1, 'Intricate Roman armor craftsmanship.', FALSE, '#B8E986', 'archived'),
(6, 5, 7, 1, 'Hokusai masterpiece.', TRUE, '#7ED321', 'favorite'),
(7, 6, 8, 1, 'Masterful Rembrandt portrait study.', TRUE, '#9013FE', 'favorite'),
(8, 7, 6, 1, 'Royal Yoruba beaded artwork.', TRUE, '#D0021B', 'to_research'),
(9, 9, 4, 1, 'Tang dynasty terracotta camel.', FALSE, '#F8E71C', 'loaned'),
(10, 10, 9, 1, 'Maya limestone relief panel.', TRUE, '#7B68EE', 'favorite');