create schema if not exists lbaw24124;
SET DateStyle TO European;

-- Drop Tables
DROP TABLE IF EXISTS Users CASCADE;
DROP TABLE IF EXISTS FollowUser CASCADE;
DROP TABLE IF EXISTS VoteArticle CASCADE;
DROP TABLE IF EXISTS FavouriteArcticle CASCADE;
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
DROP TABLE IF EXISTS Notification CASCADE;
DROP TABLE IF EXISTS ReplyNotification CASCADE;
DROP TABLE IF EXISTS UpvoteReplyNotification CASCADE;
DROP TABLE IF EXISTS CommentNotification CASCADE;
DROP TABLE IF EXISTS UpvoteCommentNotification CASCADE;
DROP TABLE IF EXISTS UpvoterticleNotification CASCADE;

DROP FUNCTION IF EXISTS articlepage_tsv_trigger();

-- Tables

--R01
CREATE TABLE Users(
    id SERIAL PRIMARY KEY,
    display_name VARCHAR(20) DEFAULT NULL,
    username VARCHAR(20) UNIQUE,
    email VARCHAR(256) UNIQUE,
    password VARCHAR(256),
    profile_picture VARCHAR(256) DEFAULT NULL,
    description VARCHAR(300),
    reputation INT DEFAULT 0,
    upvote_notification BOOLEAN DEFAULT TRUE,
    comment_notification BOOLEAN DEFAULT TRUE,
    is_banned BOOLEAN DEFAULT FALSE,
    is_admin BOOLEAN DEFAULT FALSE,
    is_fact_checker BOOLEAN DEFAULT FALSE,
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
    article_image VARCHAR(256),
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
CREATE TABLE FavouriteArcticle(
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
    comment_id INTEGER REFERENCES Comment (id) ON UPDATE CASCADE NOT NULL
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
CREATE TABLE Notification(
    id SERIAL PRIMARY KEY,
    ntf_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    is_viewed BOOLEAN DEFAULT FALSE,
    user_to INTEGER REFERENCES Users (id) ON UPDATE CASCADE NOT NULL,
    user_from INTEGER REFERENCES Users (id) ON UPDATE CASCADE NOT NULL
);

--R24    
CREATE TABLE ReplyNotification(
    id SERIAL PRIMARY KEY,
    ntf_id INTEGER REFERENCES Notification (id) ON UPDATE CASCADE NOT NULL,
    reply_id INTEGER REFERENCES Reply (id) ON UPDATE CASCADE NOT NULL
);

--R25
CREATE TABLE UpvoteReplyNotification(
    id SERIAL PRIMARY KEY,
    ntf_id INTEGER REFERENCES Notification (id) ON UPDATE CASCADE NOT NULL,
    reply_id INTEGER REFERENCES Reply (id) ON UPDATE CASCADE NOT NULL
);

--R26
CREATE TABLE CommentNotification(
    id SERIAL PRIMARY KEY,
    ntf_id INTEGER REFERENCES Notification (id) ON UPDATE CASCADE NOT NULL,
    comment_id INTEGER REFERENCES Comment (id) ON UPDATE CASCADE NOT NULL
);

--R27
CREATE TABLE UpvoteCommentNotification(
    id SERIAL PRIMARY KEY,
    ntf_id INTEGER REFERENCES Notification (id) ON UPDATE CASCADE NOT NULL,
    comment_id INTEGER REFERENCES Comment (id) ON UPDATE CASCADE NOT NULL
);

--R28
CREATE TABLE UpvoterticleNotification(
    id SERIAL PRIMARY KEY,
    ntf_id INTEGER REFERENCES Notification (id) ON UPDATE CASCADE NOT NULL,
    article_id INTEGER REFERENCES ArticlePage (id) ON UPDATE CASCADE NOT NULL
);

-- Indexes

--I1
CREATE UNIQUE INDEX idx_user_username ON Users(username);
--I2
CREATE INDEX idx_articlepage_createdate ON ArticlePage(create_date DESC);
--I3
CREATE INDEX idx_followuser_useridfollow_followeduserid ON FollowUser(follower_id, following_id);
--I4
CREATE INDEX idx_topic_name ON Topic(name);
--I5
CREATE INDEX idx_tag_name ON Tag(name);
--I6
CREATE INDEX idx_article_tag ON ArticleTag(article_id, tag_id);

--Full Text Search Indexes
ALTER TABLE ArticlePage
ADD COLUMN tsv tsvector;

UPDATE ArticlePage 
SET tsv = to_tsvector(COALESCE(title, '') || ' ' || COALESCE(subtitle, '') || ' ' || COALESCE(content, ''));

CREATE FUNCTION articlepage_tsv_trigger() RETURNS trigger AS $$
BEGIN
  NEW.tsv := to_tsvector(COALESCE(NEW.title, '') || ' ' || COALESCE(NEW.subtitle, '') || ' ' || COALESCE(NEW.content, ''));
  RETURN NEW;
END
$$ LANGUAGE plpgsql;

CREATE TRIGGER tsvupdate
BEFORE INSERT OR UPDATE ON ArticlePage
FOR EACH ROW EXECUTE FUNCTION articlepage_tsv_trigger();

CREATE INDEX idx_articlepage_tsv ON ArticlePage USING GIN(tsv);

--Consultas Full-Text Search


-- Triggers

-- Transactions
