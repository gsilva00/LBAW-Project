INSERT INTO User (id, display_name, username, email, password, profile_picture, description, reputation, upvote_notification, comment_notification, is_banned, is_admin, is_fact_checker) VALUES
(1, 'Alice Johnson', 'alicej', 'alice@example.com', 'password123', 'pic1.jpg', 'Enthusiastic writer', 5, true, true, false, false, true),
(2, 'Bob Smith', 'bobsmith', 'bob@example.com', 'password123', 'pic2.jpg', 'Tech enthusiast', 3, true, true, false, false, false),
(3, 'Carol White', 'carolw', 'carol@example.com', 'password123', 'pic3.jpg', 'Fact checker', 2, true, true, false, false, false),
(4, 'John Admin', 'notAdmin', 'admin@example.com', 'password123', 'pic4.jpg', 'Admin', 4, true, true, false, true, true);

INSERT INTO FollowUser (follower_id, following_id) VALUES
(1, 2),
(1, 3),
(2, 1),
(3, 1);

INSERT INTO Topic (id, name) VALUES
(1, 'Technology'),
(2, 'Environment'),
(3, 'Politics'),
(4, 'Health'),
(5, 'Science');

INSERT INTO FollowTopic (user_id, topic_id) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 3);

INSERT INTO Tag (id, name, is_trending) VALUES
(1, 'AI', true),
(2, 'Climate', false),
(3, 'COVID-19', false),
(4, 'American Elections', true),
(5, 'Space', false),
(6, "Vaccines", false);

INSERT INTO FollowTag (user_id, tag_id) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 3);

INSERT INTO ArticlePage (id, title, subtitle, content, create_date, edit_date, article_image, upvotes, downvotes, is_edited, is_deleted, topic_id, author_id) VALUES
(1, 'The Future of AI', 'Innovations in AI', 'Content about AI...', '2024-01-01 10:00', '2024-01-02 11:00', 'img1.jpg', 2, 0, true, false, 1, 1),
(2, 'Climate Change', 'Urgent Action Needed', 'Discussion on CC...', '2024-02-01 10:00', NULL, 'img2.jpg', 1, 1, false, false, 2, 2),
(3, 'COVID-19 Vaccines', 'Progress and Challenges', 'Latest updates on vaccines...', '2024-03-01 10:00', NULL, 'img3.jpg', 50, 10, false, false, 4, 3);

INSERT INTO ArticleTag (article_id, tag_id) VALUES
(1, 1),
(2, 2),
(3, 3),
(3, 6);

INSERT INTO VoteArticle (user_id, article_id, is_upvote) VALUES
(1, 1, true),
(1, 2, true),
(2, 1, true),
(3, 2, false);

INSERT INTO FavouriteArcticle (user_id, article_id) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 2);

INSERT INTO CheckArticle (user_id, article_id, context, verdict) VALUES
(1, 2, 'This article is misleading', 'False'),
(1, 1, 'No Fake information have been written', 'True');

INSERT INTO Comment (id, content, cmt_date, upvotes, downvotes, is_edited, is_deleted, author_id, article_id) VALUES
(1, 'Great insights!', '2024-01-02 12:00', 2, 0, false, false, 2, 1),
(2, 'I disagree with...', '2024-01-03 13:00', 0, 2, false, false, 3, 1);

INSERT INTO VoteComment (user_id, comment_id, is_upvote) VALUES
(1, 1, true),
(1, 2, false),
(2, 1, true),
(3, 2, false);

INSERT INTO Reply (id, body, rpl_date, upvotes, downvotes, is_edited, is_deleted, author_id, comment_id) VALUES
(1, 'I see your point!', '2024-01-02 12:30', 3, 0, false, false, 1, 2);

INSERT INTO VoteReply (user_id, reply_id, is_upvote) VALUES
(1, 1, true),
(2, 1, true),
(3, 1, true);

INSERT INTO Notification (id, ntf_date, is_viewed, user_to, user_from) VALUES
(1, '2024-01-02 12:00', false, 1, 2),
(2, '2024-01-03 13:00', true, 1, 3),
(3, '2024-01-03 13:00', false, 2, 3),
(4, '2024-01-03 13:00', true, 1, 1),
(5, '2024-01-03 13:00', false, 2, 1),
(6, '2024-01-03 13:00', false, 1, 2),
(7, '2024-01-03 13:00', false, 2, 1),
(8, '2024-01-03 13:00', true, 1, 1),
(9, '2024-01-03 13:00', false, 2, 1),
(10, '2024-01-03 13:00', true, 3, 1);


INSERT INTO NotificationComment (id, ntf_id,comment_id) VALUES
(1, 1, 1),
(2, 2, 2);

INSERT INTO NotificationReply (id, ntf_id, reply_id) VALUES
(1, 3, 1);

INSERT INTO UpvoteArticleNotification (id, ntf_id, article_id) VALUES
(1, 4, 1),
(3, 5, 1),

INSERT INTO UpvoteCommentNotification (id, ntf_id, comment_id) VALUES
(1, 6, 1),
(2, 7, 1);

INSERT INTO UpvoteReplyNotification (id, ntf_id, reply_id) VALUES
(1, 8, 1),
(2, 9, 1),
(3, 10, 1);

INSERT INTO Report (id, description, report_date, is_accepted, reporter_id) VALUES
(1, 'This article is spreading fake news', '2024-01-02 12:00', false, 1),
(2, 'This comment is offensive', '2024-01-03 13:00', false, 1),
(3, 'This user has violent content', '2024-01-03 13:00', false, 2);

INSERT INTO ReportArticle (id, type, report_id, article_id) VALUES
(1, 'Fact Check', 1, 1);

INSERT INTO ReportComment (id, type, report_id, comment_id, reply_id) VALUES
(1, 'Harassment', 2, 2, NULL);

INSERT INTO ReportUser (id, type, report_id, user_id) VALUES
(1, 'Violence or Sexual Content', 3, 2);

INSERT INTO AppealToUnban(id , description, user_id) VALUES
(1, 'I am sorry for my actions', '2024-01-02 12:00', false, 1);

INSERT INTO AskToBecomeFactChecker(id, user_id) VALUES
(1, 'I would like to become a fact checker', '2024-01-02 12:00', false, 2);

INSERT INTO ProposeNewTag(id, name, user_id) VALUES
(1, 'New Tag', 1),
(2, 'Another Tag', 2);


