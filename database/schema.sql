create schema if not exists lbaw24124;
SET DateStyle TO European;

-- Drop Tables

DROP TABLE IF EXISTS Users CASCADE;
DROP TABLE IF EXISTS FollowUser CASCADE;
DROP TABLE IF EXISTS VoteArticle CASCADE;
DROP TABLE IF EXISTS FavouriteArticle CASCADE;
DROP TABLE IF EXISTS CheckArticle CASCADE;
DROP TABLE IF EXISTS Topic CASCADE;
DROP TABLE IF EXISTS FollowTopic CASCADE;
DROP TABLE IF EXISTS Tag CASCADE;
Drop TABLE IF EXISTS FollowTag CASCADE;
DROP TABLE IF EXISTS ArticlePage CASCADE;  
DROP TABLE IF EXISTS ArticleTag CASCADE;
DROP TABLE IF EXISTS Comment CASCADE;
DROP TABLE IF EXISTS VoteComment CASCADE;
DROP TABLE IF EXISTS Reply CASCADE;
DROP TABLE IF EXISTS VoteReply CASCADE;
DROP TABLE IF EXISTS Report CASCADE;
DROP TABLE IF EXISTS ReportComment CASCADE;
DROP TABLE IF EXISTS ReportArticle CASCADE;
DROP TABLE IF EXISTS ReportUser CASCADE;
DROP TABLE IF EXISTS ProposeNewTag CASCADE;
DROP TABLE IF EXISTS AppealToUnban CASCADE;
DROP TABLE IF EXISTS AskToBecomeFactChecker CASCADE;
DROP TABLE IF EXISTS Notifications CASCADE;
DROP TABLE IF EXISTS ReplyNotification CASCADE;
DROP TABLE IF EXISTS UpvoteReplyNotification CASCADE;
DROP TABLE IF EXISTS CommentNotification CASCADE;
DROP TABLE IF EXISTS UpvoteCommentNotification CASCADE;
DROP TABLE IF EXISTS UpvoteArticleNotification CASCADE;

-- Tables

--R01
CREATE TABLE Users(
    id SERIAL PRIMARY KEY,
    display_name VARCHAR(20) DEFAULT NULL,
    username VARCHAR(20) UNIQUE,
    email VARCHAR(256) DEFAULT 'images/profile/default.jpg',
    password VARCHAR(256),
    profile_picture VARCHAR(256) DEFAULT NULL,
    description VARCHAR(300) DEFAULT NULL,
    reputation INT DEFAULT 3,
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
CREATE TABLE FollowUser(
    follower_id INTEGER REFERENCES Users (id) ON UPDATE CASCADE,
    following_id INTEGER REFERENCES Users (id) ON UPDATE CASCADE,
    PRIMARY KEY (follower_id, following_id)
);

--R08
CREATE TABLE Topic(
    id SERIAL PRIMARY KEY,
    name VARCHAR(30)
);

--R09
CREATE TABLE FollowTopic(
    user_id INTEGER REFERENCES Users (id) ON UPDATE CASCADE,
    topic_id INTEGER REFERENCES Topic (id) ON UPDATE CASCADE,
    PRIMARY KEY(user_id, topic_id)
);

--R10
CREATE TABLE Tag(
    id SERIAL PRIMARY KEY,
    name VARCHAR(30),
    is_trending BOOLEAN DEFAULT FALSE
);

--R11
CREATE TABLE FollowTag(
    user_id INTEGER REFERENCES Users (id) ON UPDATE CASCADE,
    tag_id INTEGER REFERENCES Tag (id) ON UPDATE CASCADE,
    PRIMARY KEY(user_id, tag_id)
);

--R06
CREATE TABLE ArticlePage(
    id SERIAL PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    subtitle VARCHAR(50) NOT NULL,
    content VARCHAR(10000),
    create_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    edit_date TIMESTAMP DEFAULT NULL,
    article_image VARCHAR(256) DEFAULT NULL,
    upvotes INTEGER DEFAULT 0,
    downvotes INTEGER DEFAULT 0,
    is_edited BOOLEAN DEFAULT FALSE,
    is_deleted BOOLEAN DEFAULT FALSE,
    topic_id INTEGER REFERENCES Topic (id) ON UPDATE CASCADE NOT NULL,
    author_id INTEGER REFERENCES Users (id) ON UPDATE CASCADE NOT NULL,
    CHECK (edit_date IS NULL OR edit_date >= create_date),
    CHECK (upvotes >= 0),
    CHECK (downvotes >= 0)
);

--R07
CREATE TABLE ArticleTag(
    article_id INTEGER REFERENCES ArticlePage (id) ON UPDATE CASCADE,
    tag_id INTEGER REFERENCES Tag (id) ON UPDATE CASCADE,
    PRIMARY KEY(article_id, tag_id)
);

--R03
CREATE TABLE VoteArticle(
    user_id INTEGER REFERENCES Users (id) ON UPDATE CASCADE,
    article_id INTEGER REFERENCES ArticlePage (id) ON UPDATE CASCADE,
    type VARCHAR(10) DEFAULT 'Upvote',
    CHECK (type = 'Upvote' OR type = 'Downvote'),
    PRIMARY KEY (user_id, article_id)
);

--R04
CREATE TABLE FavouriteArticle(
    user_id INTEGER REFERENCES Users (id) ON UPDATE CASCADE,
    article_id INTEGER REFERENCES ArticlePage (id) ON UPDATE CASCADE,
    PRIMARY KEY(user_id, article_id)
);

--R05
CREATE TABLE CheckArticle(
    article_id INTEGER PRIMARY KEY REFERENCES ArticlePage (id) ON UPDATE CASCADE,
    user_id INTEGER REFERENCES Users (id) ON UPDATE CASCADE NOT NULL,
    context VARCHAR(1000),
    verdict VARCHAR(10) NOT NULL,
    CHECK (verdict = 'True' OR verdict = 'False' OR verdict = 'Imprecise')
);

--R12
CREATE TABLE Comment(
    id SERIAL PRIMARY KEY,
    content VARCHAR(300) NOT NULL,
    cmt_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    upvotes INTEGER DEFAULT 0,
    downvotes INTEGER DEFAULT 0,
    is_edited BOOLEAN DEFAULT FALSE,
    is_deleted BOOLEAN DEFAULT FALSE,  
    author_id INTEGER REFERENCES Users (id) ON UPDATE CASCADE NOT NULL,
    article_id INTEGER REFERENCES ArticlePage (id) ON UPDATE CASCADE NOT NULL,
    CHECK (upvotes >= 0),
    CHECK (downvotes >= 0)
);

--R13
CREATE TABLE VoteComment(
    user_id INTEGER REFERENCES Users (id) ON UPDATE CASCADE,
    comment_id INTEGER REFERENCES Comment (id) ON UPDATE CASCADE,
    type VARCHAR(10) DEFAULT 'Upvote',
    CHECK (type = 'Upvote' OR type = 'Downvote'),
    PRIMARY KEY(user_id, comment_id)
);

--R14
CREATE TABLE Reply(
    id SERIAL PRIMARY KEY,
    content VARCHAR(300) NOT NULL,
    rpl_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    upvotes INTEGER DEFAULT 0,
    downvotes INTEGER DEFAULT 0,
    is_edited BOOLEAN DEFAULT FALSE,
    is_deleted BOOLEAN DEFAULT FALSE,
    author_id INTEGER REFERENCES Users (id) ON UPDATE CASCADE NOT NULL,
    comment_id INTEGER REFERENCES Comment (id) ON UPDATE CASCADE NOT NULL,
    CHECK (upvotes >= 0),
    CHECK (downvotes >= 0)
);

--R15
CREATE TABLE VoteReply(
    user_id INTEGER REFERENCES Users (id) ON UPDATE CASCADE,
    reply_id INTEGER REFERENCES Reply (id) ON UPDATE CASCADE,
    type VARCHAR(10) DEFAULT 'Upvote',
    CHECK (type = 'Upvote' OR type = 'Downvote'),
    PRIMARY KEY(user_id, reply_id)
);

--R16
CREATE TABLE Report(
    id SERIAL PRIMARY KEY,
    description VARCHAR(300),
    report_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    is_accepted BOOLEAN DEFAULT FALSE,
    reporter_id INTEGER REFERENCES Users (id) ON UPDATE CASCADE NOT NULL
);

--R17
CREATE TABLE ReportComment(
    id SERIAL PRIMARY KEY,
    type VARCHAR(30) NOT NULL,
    report_id INTEGER REFERENCES Report (id) ON UPDATE CASCADE NOT NULL,
    comment_id INTEGER REFERENCES Comment (id) ON UPDATE CASCADE,
    reply_id INTEGER REFERENCES Reply (id) ON UPDATE CASCADE,
    CHECK(type = 'Disinformation' OR type = 'Harassment' OR type = 'Spam' OR type = 'Violence or Sexual Content'),
    CHECK((comment_id IS NOT NULL AND reply_id IS NULL) OR (comment_id IS NULL AND reply_id IS NOT NULL))
);

--R18
CREATE TABLE ReportArticle(
    id SERIAL PRIMARY KEY,
    type VARCHAR(30) NOT NULL,
    report_id INTEGER REFERENCES Report (id) ON UPDATE CASCADE,
    article_id INTEGER REFERENCES ArticlePage (id) ON UPDATE CASCADE,
    CHECK(type = 'Fact Check' OR type = 'Harassment' OR type = 'Spam' OR type = 'Violence or Sexual Content')
);

--R19
CREATE TABLE ReportUser(
    id SERIAL PRIMARY KEY,
    type VARCHAR(30) NOT NULL,
    report_id INTEGER REFERENCES Report (id) ON UPDATE CASCADE,
    user_id INTEGER REFERENCES Users (id) ON UPDATE CASCADE,
    CHECK(type = 'Disinformation' OR type = 'Spam' OR type = 'Harassment' OR type = 'Violence or Sexual Content' or type = 'Impersonation')
);

--R20
CREATE TABLE ProposeNewTag(
    id SERIAL PRIMARY KEY,
    name VARCHAR(30),
    user_id INTEGER REFERENCES Users (id) ON UPDATE CASCADE
);

--R21
CREATE TABLE AppealToUnban(
    id SERIAL PRIMARY KEY,
    description TEXT,
    user_id INTEGER REFERENCES Users (id) ON UPDATE CASCADE NOT NULL
);

--R22
CREATE TABLE AskToBecomeFactChecker(
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES Users (id) ON UPDATE CASCADE NOT NULL
);

--R23
CREATE TABLE Notifications(
    id SERIAL PRIMARY KEY,
    ntf_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    is_viewed BOOLEAN DEFAULT FALSE,
    user_to INTEGER REFERENCES Users (id) ON UPDATE CASCADE ,
    user_from INTEGER REFERENCES Users (id) ON UPDATE CASCADE 
);

--R24    
CREATE TABLE ReplyNotification(
    id SERIAL PRIMARY KEY,
    ntf_id INTEGER REFERENCES Notifications (id) ON UPDATE CASCADE,
    reply_id INTEGER REFERENCES Reply (id) ON UPDATE CASCADE 
);

--R25
CREATE TABLE UpvoteReplyNotification(
    id SERIAL PRIMARY KEY,
    ntf_id INTEGER REFERENCES Notifications (id) ON UPDATE CASCADE,
    reply_id INTEGER REFERENCES Reply (id) ON UPDATE CASCADE 
);

--R26
CREATE TABLE CommentNotification(
    id SERIAL PRIMARY KEY,
    ntf_id INTEGER REFERENCES Notifications (id) ON UPDATE CASCADE,
    comment_id INTEGER REFERENCES Comment (id) ON UPDATE CASCADE 
);

--R27
CREATE TABLE UpvoteCommentNotification(
    id SERIAL PRIMARY KEY,
    ntf_id INTEGER REFERENCES Notifications (id) ON UPDATE CASCADE,
    comment_id INTEGER REFERENCES Comment (id) ON UPDATE CASCADE
);

--R28
CREATE TABLE UpvoteArticleNotification(
    id SERIAL PRIMARY KEY,
    ntf_id INTEGER REFERENCES Notifications (id) ON UPDATE CASCADE,
    article_id INTEGER REFERENCES ArticlePage (id) ON UPDATE CASCADE
);

-- Performance Indexes

--I1
CREATE INDEX i_article_author ON ArticlePage (author_id); 
--I2
CREATE INDEX i_notifications_date ON Notifications(ntf_date DESC);
--I3
CREATE INDEX i_article_cdate ON ArticlePage(create_date DESC);


-- Store a column with the full text from ArticlePage
ALTER TABLE ArticlePage
ADD COLUMN tsv tsvector;

-- Fill tsv with the concatenated text from title, subtitle, and content
UPDATE ArticlePage
SET tsv = setweight(to_tsvector(COALESCE(TRIM(title), '')), 'A') || setweight(to_tsvector(COALESCE(TRIM(subtitle), '')), 'B') || setweight(to_tsvector(COALESCE(TRIM(content), '')), 'C');

CREATE OR REPLACE FUNCTION articlepage_tsv_trigger() RETURNS trigger AS $$
BEGIN
    NEW.tsv := setweight(to_tsvector(COALESCE(TRIM(NEW.title), '')), 'A') || setweight ( to_tsvector ( COALESCE ( TRIM ( NEW.subtitle), '')), 'B') || setweight(to_tsvector(COALESCE(TRIM(NEW.content), '')), 'C');
RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER tsvupdate
BEFORE INSERT OR UPDATE ON ArticlePage
FOR EACH ROW EXECUTE FUNCTION articlepage_tsv_trigger();

CREATE INDEX i_article_tsv ON ArticlePage USING GIN(tsv);

-- Same process as previous table
ALTER TABLE Reply ADD COLUMN full_text_vector_r tsvector;

UPDATE Reply SET full_text_vector_r = to_tsvector ( COALESCE (content ));

CREATE OR REPLACE FUNCTION update_reply_full_text() RETURNS trigger AS $$
BEGIN
    NEW.full_text_vector_r := to_tsvector(COALESCE(NEW.content));
RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_reply_full_text_trigger
BEFORE INSERT OR UPDATE ON Reply
FOR EACH ROW EXECUTE FUNCTION update_reply_full_text();

CREATE INDEX i_reply_tsv ON Reply USING GIN(full_text_vector_r);


-- Same process as previous table
ALTER TABLE Comment ADD COLUMN full_text_vector tsvector;

UPDATE Comment SET full_text_vector = to_tsvector ( COALESCE (content ));

CREATE OR REPLACE FUNCTION update_comment_full_text() RETURNS trigger AS $$
BEGIN
    NEW.full_text_vector := to_tsvector(COALESCE(NEW.content));
RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_comment_full_text_trigger
BEFORE INSERT OR UPDATE ON Comment
FOR EACH ROW EXECUTE FUNCTION update_comment_full_text();

--I6
CREATE INDEX i_comment_tsv ON Comment USING GIN(full_text_vector);



-- Functions/Triggers

--TR1
CREATE OR REPLACE FUNCTION notify_comment() RETURNS trigger AS $$
DECLARE
    author INTEGER;
    notification_id INTEGER;
BEGIN
    SELECT author_id INTO author FROM ArticlePage WHERE id = NEW.article_id;

    IF (SELECT comment_notification FROM Users WHERE id = author) THEN
        INSERT INTO Notifications (ntf_date, is_viewed, user_to, user_from)
        VALUES (CURRENT_TIMESTAMP, FALSE, author, NEW.author_id)
        RETURNING id INTO notification_id;

        INSERT INTO CommentNotification (ntf_id, comment_id)
        VALUES (notification_id, NEW.id);
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER comment_notify_trigger
AFTER INSERT ON Comment
FOR EACH ROW EXECUTE FUNCTION notify_comment();

--TR2
CREATE OR REPLACE FUNCTION notify_reply() RETURNS trigger AS $$
DECLARE
    article_author_id INTEGER;
    notification_id INTEGER;
BEGIN
    SELECT author_id INTO article_author_id FROM ArticlePage WHERE id = (SELECT article_id FROM Comment WHERE id = NEW.comment_id);

    IF (SELECT comment_notification FROM Users WHERE id = article_author_id) THEN
        INSERT INTO Notifications (ntf_date, is_viewed, user_to, user_from)
        VALUES (CURRENT_TIMESTAMP, FALSE, article_author_id, NEW.author_id)
        RETURNING id INTO notification_id;

        INSERT INTO ReplyNotification (ntf_id, reply_id)
        VALUES (notification_id, NEW.id);
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER reply_notify_trigger
AFTER INSERT ON Reply
FOR EACH ROW EXECUTE FUNCTION notify_reply();

--TR3
CREATE OR REPLACE FUNCTION update_edit_date() RETURNS trigger AS $$
BEGIN
    NEW.edit_date := CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_edit_date_trigger
BEFORE UPDATE ON ArticlePage
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
BEFORE INSERT ON FollowUser
FOR EACH ROW EXECUTE FUNCTION prevent_self_follow();

--TR5
CREATE OR REPLACE FUNCTION prevent_multiple_likes_article() RETURNS trigger AS $$
BEGIN
    IF EXISTS (SELECT 1 FROM VoteArticle WHERE user_id = NEW.user_id AND article_id = NEW.article_id) THEN
        RAISE EXCEPTION 'A user cannot like the same article more than once';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_multiple_likes_trigger_article
BEFORE INSERT ON VoteArticle
FOR EACH ROW EXECUTE FUNCTION prevent_multiple_likes_article();

--TR6
CREATE OR REPLACE FUNCTION prevent_multiple_likes_comment() RETURNS trigger AS $$
BEGIN
    IF EXISTS (SELECT 1 FROM VoteComment WHERE user_id = NEW.user_id AND comment_id = NEW.comment_id) THEN
        RAISE EXCEPTION 'A user cannot like the same comment more than once';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_multiple_likes_trigger_comment
BEFORE INSERT ON VoteComment
FOR EACH ROW EXECUTE FUNCTION prevent_multiple_likes_comment();

--TR7
CREATE OR REPLACE FUNCTION prevent_multiple_likes_reply() RETURNS trigger AS $$
BEGIN
    IF EXISTS (SELECT 1 FROM VoteReply WHERE user_id = NEW.user_id AND reply_id = NEW.reply_id) THEN
        RAISE EXCEPTION 'A user cannot like the same reply more than once';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_multiple_likes_trigger_reply
BEFORE INSERT ON VoteReply
FOR EACH ROW EXECUTE FUNCTION prevent_multiple_likes_reply();

--TR8
CREATE OR REPLACE FUNCTION handle_report() RETURNS trigger AS $$
BEGIN
    IF NEW.status = 'accepted' AND NEW.handled_by IS NOT NULL THEN
        IF (SELECT reputation FROM Users WHERE id = NEW.user_id) = 0 THEN
            UPDATE Users SET is_banned = TRUE WHERE id = NEW.user_id;
        ELSIF (SELECT reputation FROM Users WHERE id = NEW.user_id) > 0 THEN
            UPDATE Users SET reputation = reputation - 1 WHERE id = NEW.user_id;
        END IF;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER handle_report_trigger
AFTER UPDATE ON Report
FOR EACH ROW EXECUTE FUNCTION handle_report();
