CREATE SCHEMA IF NOT EXISTS lbaw24124;
SET DateStyle TO European;

-- Drop Tables
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS follow_user CASCADE;
DROP TABLE IF EXISTS topic CASCADE;
DROP TABLE IF EXISTS follow_topics CASCADE;
DROP TABLE IF EXISTS tag CASCADE;
DROP TABLE IF EXISTS follow_tags CASCADE;
DROP TABLE IF EXISTS article_page CASCADE;
DROP TABLE IF EXISTS article_tag CASCADE;
DROP TABLE IF EXISTS vote_article CASCADE;
DROP TABLE IF EXISTS favourite_article CASCADE;
DROP TABLE IF EXISTS check_article CASCADE;
DROP TABLE IF EXISTS comment CASCADE;
DROP TABLE IF EXISTS vote_comment CASCADE;
DROP TABLE IF EXISTS reply CASCADE;
DROP TABLE IF EXISTS vote_reply CASCADE;
DROP TABLE IF EXISTS report CASCADE;
DROP TABLE IF EXISTS report_user CASCADE;
DROP TABLE IF EXISTS report_article CASCADE;
DROP TABLE IF EXISTS report_comment CASCADE;
DROP TABLE IF EXISTS propose_new_tag CASCADE;
DROP TABLE IF EXISTS appeal_to_unban CASCADE;
DROP TABLE IF EXISTS ask_to_become_fact_checker CASCADE;
DROP TABLE IF EXISTS notifications CASCADE;
DROP TABLE IF EXISTS comment_notification CASCADE;
DROP TABLE IF EXISTS reply_notification CASCADE;
DROP TABLE IF EXISTS upvote_article_notification CASCADE;
DROP TABLE IF EXISTS upvote_comment_notification CASCADE;
DROP TABLE IF EXISTS upvote_reply_notification CASCADE;



-- Tables
--R01
CREATE TABLE users(
    id SERIAL PRIMARY KEY,
    display_name VARCHAR(20) DEFAULT NULL,
    username VARCHAR(20) UNIQUE,
    email VARCHAR(256) UNIQUE,
    password VARCHAR(256),
    profile_picture VARCHAR(256) DEFAULT 'images/profile/default.jpg',
    description VARCHAR(300) DEFAULT NULL,
    reputation INTEGER DEFAULT 3,
    upvote_notification BOOLEAN DEFAULT TRUE,
    comment_notification BOOLEAN DEFAULT TRUE,
    is_banned BOOLEAN DEFAULT FALSE,
    is_admin BOOLEAN DEFAULT FALSE,
    is_fact_checker BOOLEAN DEFAULT FALSE,
    is_deleted BOOLEAN DEFAULT FALSE,
    remember_token VARCHAR(100) DEFAULT NULL,
    CHECK (reputation BETWEEN 0 AND 5)
);

--R02
CREATE TABLE follow_user(
    follower_id INTEGER REFERENCES users (id) ON UPDATE CASCADE,
    following_id INTEGER REFERENCES users (id) ON UPDATE CASCADE,
    PRIMARY KEY (follower_id, following_id)
);

--R08
CREATE TABLE topic(
    id SERIAL PRIMARY KEY,
    name VARCHAR(30)
);

--R09
CREATE TABLE follow_topics(
    user_id INTEGER REFERENCES users (id) ON UPDATE CASCADE,
    topic_id INTEGER REFERENCES topic (id) ON UPDATE CASCADE,
    PRIMARY KEY(user_id, topic_id)
);

--R10
CREATE TABLE tag(
    id SERIAL PRIMARY KEY,
    name VARCHAR(30),
    is_trending BOOLEAN DEFAULT FALSE
);

--R11
CREATE TABLE follow_tags(
    user_id INTEGER REFERENCES users (id) ON UPDATE CASCADE,
    tag_id INTEGER REFERENCES tag (id) ON UPDATE CASCADE,
    PRIMARY KEY(user_id, tag_id)
);

--R06
CREATE TABLE article_page(
    id SERIAL PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    subtitle VARCHAR(50) NOT NULL,
    content VARCHAR(10000),
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    edit_date TIMESTAMP DEFAULT NULL,
    article_image VARCHAR(256) DEFAULT 'images/article/default.png',
    upvotes INTEGER DEFAULT 0,
    downvotes INTEGER DEFAULT 0,
    is_edited BOOLEAN DEFAULT FALSE,
    is_deleted BOOLEAN DEFAULT FALSE,
    topic_id INTEGER REFERENCES topic (id) ON UPDATE CASCADE NOT NULL,
    author_id INTEGER REFERENCES users (id) ON UPDATE CASCADE NOT NULL,
    CHECK (edit_date IS NULL OR edit_date >= create_date),
    CHECK (upvotes >= 0),
    CHECK (downvotes >= 0)
);

--R07
CREATE TABLE article_tag(
    article_id INTEGER REFERENCES article_page (id) ON UPDATE CASCADE ON DELETE CASCADE,
    tag_id INTEGER REFERENCES tag (id) ON UPDATE CASCADE,
    PRIMARY KEY(article_id, tag_id)
);

--R03
CREATE TABLE vote_article(
    user_id INTEGER REFERENCES users (id) ON UPDATE CASCADE,
    article_id INTEGER REFERENCES article_page (id) ON UPDATE CASCADE,
    type VARCHAR(10) DEFAULT 'Upvote',
    CHECK (type = 'Upvote' OR type = 'Downvote'),
    PRIMARY KEY (user_id, article_id)
);

--R04
CREATE TABLE favourite_article(
    user_id INTEGER REFERENCES users (id) ON UPDATE CASCADE,
    article_id INTEGER REFERENCES article_page (id) ON UPDATE CASCADE,
    PRIMARY KEY(user_id, article_id)
);

--R05
CREATE TABLE check_article(
    article_id INTEGER PRIMARY KEY REFERENCES article_page (id) ON UPDATE CASCADE,
    user_id INTEGER REFERENCES users (id) ON UPDATE CASCADE NOT NULL,
    context VARCHAR(1000),
    verdict VARCHAR(10) NOT NULL,
    CHECK (verdict = 'True' OR verdict = 'False' OR verdict = 'Imprecise')
);

--R12
CREATE TABLE comment(
    id SERIAL PRIMARY KEY,
    content VARCHAR(300) NOT NULL,
    cmt_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    upvotes INTEGER DEFAULT 0,
    downvotes INTEGER DEFAULT 0,
    is_edited BOOLEAN DEFAULT FALSE,
    is_deleted BOOLEAN DEFAULT FALSE,  
    author_id INTEGER REFERENCES users (id) ON UPDATE CASCADE NOT NULL,
    article_id INTEGER REFERENCES article_page (id) ON UPDATE CASCADE NOT NULL,
    CHECK (upvotes >= 0),
    CHECK (downvotes >= 0)
);

--R13
CREATE TABLE vote_comment(
    user_id INTEGER REFERENCES users (id) ON UPDATE CASCADE,
    comment_id INTEGER REFERENCES comment (id) ON UPDATE CASCADE,
    type VARCHAR(10) DEFAULT 'Upvote',
    CHECK (type = 'Upvote' OR type = 'Downvote'),
    PRIMARY KEY(user_id, comment_id)
);

--R14
CREATE TABLE reply(
    id SERIAL PRIMARY KEY,
    content VARCHAR(300) NOT NULL,
    rpl_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    upvotes INTEGER DEFAULT 0,
    downvotes INTEGER DEFAULT 0,
    is_edited BOOLEAN DEFAULT FALSE,
    is_deleted BOOLEAN DEFAULT FALSE,
    author_id INTEGER REFERENCES users (id) ON UPDATE CASCADE NOT NULL,
    comment_id INTEGER REFERENCES comment (id) ON UPDATE CASCADE NOT NULL,
    CHECK (upvotes >= 0),
    CHECK (downvotes >= 0)
);

--R15
CREATE TABLE vote_reply(
    user_id INTEGER REFERENCES users (id) ON UPDATE CASCADE,
    reply_id INTEGER REFERENCES reply (id) ON UPDATE CASCADE,
    type VARCHAR(10) DEFAULT 'Upvote',
    CHECK (type = 'Upvote' OR type = 'Downvote'),
    PRIMARY KEY(user_id, reply_id)
);

--R16
CREATE TABLE report(
    id SERIAL PRIMARY KEY,
    description VARCHAR(300),
    report_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    is_accepted BOOLEAN DEFAULT FALSE,
    reporter_id INTEGER REFERENCES users (id) ON UPDATE CASCADE NOT NULL
);

--R17
CREATE TABLE report_user(
    id SERIAL PRIMARY KEY,
    type VARCHAR(30) NOT NULL,
    report_id INTEGER REFERENCES report (id) ON UPDATE CASCADE,
    user_id INTEGER REFERENCES users (id) ON UPDATE CASCADE,
    CHECK(type = 'Disinformation' OR type = 'Spam' OR type = 'Harassment' OR type = 'Violence or Sexual Content' or type = 'Impersonation')
);

--R18
CREATE TABLE report_article(
    id SERIAL PRIMARY KEY,
    type VARCHAR(30) NOT NULL,
    report_id INTEGER REFERENCES report (id) ON UPDATE CASCADE,
    article_id INTEGER REFERENCES article_page (id) ON UPDATE CASCADE,
    CHECK(type = 'Fact Check' OR type = 'Harassment' OR type = 'Spam' OR type = 'Violence or Sexual Content')
);

--R19
CREATE TABLE report_comment(
    id SERIAL PRIMARY KEY,
    type VARCHAR(30) NOT NULL,
    report_id INTEGER REFERENCES report (id) ON UPDATE CASCADE NOT NULL,
    comment_id INTEGER REFERENCES comment (id) ON UPDATE CASCADE,
    reply_id INTEGER REFERENCES reply (id) ON UPDATE CASCADE,
    CHECK(type = 'Disinformation' OR type = 'Harassment' OR type = 'Spam' OR type = 'Violence or Sexual Content'),
    CHECK((comment_id IS NOT NULL AND reply_id IS NULL) OR (comment_id IS NULL AND reply_id IS NOT NULL))
);

--R20
CREATE TABLE propose_new_tag(
    id SERIAL PRIMARY KEY,
    name VARCHAR(30),
    user_id INTEGER REFERENCES users (id) ON UPDATE CASCADE
);

--R21
CREATE TABLE appeal_to_unban(
    id SERIAL PRIMARY KEY,
    description TEXT,
    user_id INTEGER REFERENCES users (id) ON UPDATE CASCADE NOT NULL
);

--R22
CREATE TABLE ask_to_become_fact_checker(
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users (id) ON UPDATE CASCADE NOT NULL
);

--R23
CREATE TABLE notifications(
    id SERIAL PRIMARY KEY,
    ntf_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    is_viewed BOOLEAN DEFAULT FALSE,
    user_to INTEGER REFERENCES users (id) ON UPDATE CASCADE ,
    user_from INTEGER REFERENCES users (id) ON UPDATE CASCADE 
);

--R24
CREATE TABLE comment_notification(
    id SERIAL PRIMARY KEY,
    ntf_id INTEGER REFERENCES notifications (id) ON UPDATE CASCADE,
    comment_id INTEGER REFERENCES comment (id) ON UPDATE CASCADE 
);

--R25
CREATE TABLE reply_notification(
    id SERIAL PRIMARY KEY,
    ntf_id INTEGER REFERENCES notifications (id) ON UPDATE CASCADE,
    reply_id INTEGER REFERENCES reply (id) ON UPDATE CASCADE
);

--R26
CREATE TABLE upvote_article_notification(
    id SERIAL PRIMARY KEY,
    ntf_id INTEGER REFERENCES notifications (id) ON UPDATE CASCADE,
    article_id INTEGER REFERENCES article_page (id) ON UPDATE CASCADE
);

--R27
CREATE TABLE upvote_comment_notification(
    id SERIAL PRIMARY KEY,
    ntf_id INTEGER REFERENCES notifications (id) ON UPDATE CASCADE,
    comment_id INTEGER REFERENCES comment (id) ON UPDATE CASCADE
);

--R28
CREATE TABLE upvote_reply_notification(
    id SERIAL PRIMARY KEY,
    ntf_id INTEGER REFERENCES notifications (id) ON UPDATE CASCADE,
    reply_id INTEGER REFERENCES reply (id) ON UPDATE CASCADE
);



-- Performance Indexes

--I1
CREATE INDEX i_article_author ON article_page (author_id); 
--I2
CREATE INDEX i_notifications_date ON notifications(ntf_date DESC);
--I3
CREATE INDEX i_article_cdate ON article_page(create_date DESC);


-- Store a column with the full text from article_page
ALTER TABLE article_page
ADD COLUMN tsv tsvector;

-- Fill tsv with the concatenated text from title, subtitle, and content
UPDATE article_page
SET tsv = setweight(to_tsvector(COALESCE(TRIM(title), '')), 'A') || setweight(to_tsvector(COALESCE(TRIM(subtitle), '')), 'B') || setweight(to_tsvector(COALESCE(TRIM(content), '')), 'C');

CREATE OR REPLACE FUNCTION articlepage_tsv_trigger() RETURNS trigger AS $$
BEGIN
    NEW.tsv := setweight(to_tsvector(COALESCE(TRIM(NEW.title), '')), 'A') || setweight ( to_tsvector ( COALESCE ( TRIM ( NEW.subtitle), '')), 'B') || setweight(to_tsvector(COALESCE(TRIM(NEW.content), '')), 'C');
RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER tsvupdate
BEFORE INSERT OR UPDATE ON article_page
FOR EACH ROW EXECUTE FUNCTION articlepage_tsv_trigger();

CREATE INDEX i_article_tsv ON article_page USING GIN(tsv);

-- Same process as previous table
ALTER TABLE reply ADD COLUMN full_text_vector_r tsvector;

UPDATE reply SET full_text_vector_r = to_tsvector ( COALESCE (content ));

CREATE OR REPLACE FUNCTION update_reply_full_text() RETURNS trigger AS $$
BEGIN
    NEW.full_text_vector_r := to_tsvector(COALESCE(NEW.content));
RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_reply_full_text_trigger
BEFORE INSERT OR UPDATE ON reply
FOR EACH ROW EXECUTE FUNCTION update_reply_full_text();

CREATE INDEX i_reply_tsv ON reply USING GIN(full_text_vector_r);


-- Same process as previous table
ALTER TABLE comment ADD COLUMN full_text_vector tsvector;

UPDATE comment SET full_text_vector = to_tsvector ( COALESCE (content ));

CREATE OR REPLACE FUNCTION update_comment_full_text() RETURNS trigger AS $$
BEGIN
    NEW.full_text_vector := to_tsvector(COALESCE(NEW.content));
RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_comment_full_text_trigger
BEFORE INSERT OR UPDATE ON comment
FOR EACH ROW EXECUTE FUNCTION update_comment_full_text();

--I6
CREATE INDEX i_comment_tsv ON comment USING GIN(full_text_vector);



-- Functions/Triggers

--TR1
CREATE OR REPLACE FUNCTION notify_comment() RETURNS trigger AS $$
DECLARE
    author INTEGER;
    notification_id INTEGER;
BEGIN
    SELECT author_id INTO author FROM article_page WHERE id = NEW.article_id;

    IF (SELECT comment_notification FROM users WHERE id = author) THEN
        INSERT INTO notifications (ntf_date, is_viewed, user_to, user_from)
        VALUES (CURRENT_TIMESTAMP, FALSE, author, NEW.author_id)
        RETURNING id INTO notification_id;

        INSERT INTO comment_notification (ntf_id, comment_id)
        VALUES (notification_id, NEW.id);
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER comment_notify_trigger
AFTER INSERT ON comment
FOR EACH ROW EXECUTE FUNCTION notify_comment();

--TR2
CREATE OR REPLACE FUNCTION notify_reply() RETURNS trigger AS $$
DECLARE
article_author_id INTEGER;
    comment_author_id INTEGER;
    notification_id INTEGER;
BEGIN
    -- Get the author of the article
SELECT author_id INTO article_author_id FROM article_page WHERE id = (SELECT article_id FROM comment WHERE id = NEW.comment_id);

-- Get the author of the comment
SELECT author_id INTO comment_author_id FROM comment WHERE id = NEW.comment_id;

-- Notify the article author if they have comment notifications enabled
IF (SELECT comment_notification FROM users WHERE id = article_author_id) THEN
    INSERT INTO notifications (ntf_date, is_viewed, user_to, user_from)
    VALUES (CURRENT_TIMESTAMP, FALSE, article_author_id, NEW.author_id)
        RETURNING id INTO notification_id;

INSERT INTO reply_notification (ntf_id, reply_id)
VALUES (notification_id, NEW.id);
END IF;

    -- Notify the comment author if they have comment notifications enabled
    IF (SELECT comment_notification FROM users WHERE id = comment_author_id) THEN
        INSERT INTO notifications (ntf_date, is_viewed, user_to, user_from)
        VALUES (CURRENT_TIMESTAMP, FALSE, comment_author_id, NEW.author_id)
            RETURNING id INTO notification_id;

INSERT INTO reply_notification (ntf_id, reply_id)
VALUES (notification_id, NEW.id);
END IF;

RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER reply_notify_trigger
AFTER INSERT ON reply
FOR EACH ROW EXECUTE FUNCTION notify_reply();

--TR3
CREATE OR REPLACE FUNCTION update_edit_date() RETURNS trigger AS $$
BEGIN
    NEW.edit_date := CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_edit_date_trigger
BEFORE UPDATE ON article_page
FOR EACH ROW
WHEN (OLD.title IS DISTINCT FROM NEW.title OR
      OLD.subtitle IS DISTINCT FROM NEW.subtitle OR
      OLD.content IS DISTINCT FROM NEW.content)
EXECUTE FUNCTION update_edit_date();

--TR4
CREATE OR REPLACE FUNCTION prevent_self_follow() RETURNS trigger AS $$
BEGIN
    IF NEW.follower_id = NEW.following_id THEN
        RAISE EXCEPTION 'A user cannot follow themselves';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_self_follow_trigger
BEFORE INSERT ON follow_user
FOR EACH ROW EXECUTE FUNCTION prevent_self_follow();

--TR5
CREATE OR REPLACE FUNCTION prevent_multiple_likes_article() RETURNS trigger AS $$
BEGIN
    IF EXISTS (SELECT 1 FROM vote_article WHERE user_id = NEW.user_id AND article_id = NEW.article_id) THEN
        RAISE EXCEPTION 'A user cannot like the same article more than once';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_multiple_likes_trigger_article
BEFORE INSERT ON vote_article
FOR EACH ROW EXECUTE FUNCTION prevent_multiple_likes_article();

--TR6
CREATE OR REPLACE FUNCTION prevent_multiple_likes_comment() RETURNS trigger AS $$
BEGIN
    IF EXISTS (SELECT 1 FROM vote_comment WHERE user_id = NEW.user_id AND comment_id = NEW.comment_id) THEN
        RAISE EXCEPTION 'A user cannot like the same comment more than once';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_multiple_likes_trigger_comment
BEFORE INSERT ON vote_comment
FOR EACH ROW EXECUTE FUNCTION prevent_multiple_likes_comment();

--TR7
CREATE OR REPLACE FUNCTION prevent_multiple_likes_reply() RETURNS trigger AS $$
BEGIN
    IF EXISTS (SELECT 1 FROM vote_reply WHERE user_id = NEW.user_id AND reply_id = NEW.reply_id) THEN
        RAISE EXCEPTION 'A user cannot like the same reply more than once';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_multiple_likes_trigger_reply
BEFORE INSERT ON vote_reply
FOR EACH ROW EXECUTE FUNCTION prevent_multiple_likes_reply();

--TR8
CREATE OR REPLACE FUNCTION handle_report() RETURNS trigger AS $$
BEGIN
    IF NEW.status = 'accepted' AND NEW.handled_by IS NOT NULL THEN
        IF (SELECT reputation FROM users WHERE id = NEW.user_id) = 0 THEN
            UPDATE users SET is_banned = TRUE WHERE id = NEW.user_id;
        ELSIF (SELECT reputation FROM users WHERE id = NEW.user_id) > 0 THEN
            UPDATE users SET reputation = reputation - 1 WHERE id = NEW.user_id;
        END IF;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER handle_report_trigger
AFTER UPDATE ON report
FOR EACH ROW EXECUTE FUNCTION handle_report();



ALTER TABLE users ADD COLUMN display_name_tsv tsvector;

UPDATE users SET display_name_tsv = to_tsvector(COALESCE(display_name, ''));

CREATE OR REPLACE FUNCTION update_display_name_tsv() RETURNS trigger AS $$
BEGIN
    NEW.display_name_tsv := to_tsvector(COALESCE(NEW.display_name, ''));
RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_display_name_tsv_trigger
    BEFORE INSERT OR UPDATE ON users
                         FOR EACH ROW EXECUTE FUNCTION update_display_name_tsv();

CREATE INDEX i_display_name_tsv ON users USING GIN(display_name_tsv);

