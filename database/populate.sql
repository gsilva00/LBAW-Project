SET DateStyle TO European;

TRUNCATE TABLE Users CASCADE;
TRUNCATE TABLE FollowUser CASCADE;
TRUNCATE TABLE Topic CASCADE;
TRUNCATE TABLE FollowTopic CASCADE;
TRUNCATE TABLE Tag CASCADE;
TRUNCATE TABLE FollowTag CASCADE;
TRUNCATE TABLE ArticlePage CASCADE;
TRUNCATE TABLE ArticleTag CASCADE;
TRUNCATE TABLE VoteArticle CASCADE;
TRUNCATE TABLE FavouriteArticle CASCADE;
TRUNCATE TABLE CheckArticle CASCADE;
TRUNCATE TABLE Comment CASCADE;
TRUNCATE TABLE VoteComment CASCADE;
TRUNCATE TABLE Reply CASCADE;
TRUNCATE TABLE VoteReply CASCADE;
TRUNCATE TABLE Notifications CASCADE;
TRUNCATE TABLE CommentNotification CASCADE;
TRUNCATE TABLE ReplyNotification CASCADE;
TRUNCATE TABLE UpvoteArticleNotification CASCADE;
TRUNCATE TABLE UpvoteCommentNotification CASCADE;
TRUNCATE TABLE UpvoteReplyNotification CASCADE;
TRUNCATE TABLE Report CASCADE;
TRUNCATE TABLE ReportArticle CASCADE;
TRUNCATE TABLE ReportComment CASCADE;
TRUNCATE TABLE ReportUser CASCADE;
TRUNCATE TABLE AppealToUnban CASCADE;
TRUNCATE TABLE AskToBecomeFactChecker CASCADE;
TRUNCATE TABLE ProposeNewTag CASCADE;

-- password: password123
INSERT INTO Users (display_name, username, email, password, profile_picture, description, reputation, upvote_notification, comment_notification, is_banned, is_admin, is_fact_checker) VALUES
('Alice Johnson', 'alicej', 'alice@example.com', '$2y$10$42AGNdGmhSAyAIDrAaFJ5upCtIoGTB.1SkcMhhiQUR.Ni1nRd7mDG', 'default.jpg', 'Enthusiastic writer', 5, true, true, false, false, true),
('Bob Smith', 'bobsmith', 'bob@example.com', '$2y$10$42AGNdGmhSAyAIDrAaFJ5upCtIoGTB.1SkcMhhiQUR.Ni1nRd7mDG', 'default.jpg', 'Tech enthusiast', 3, true, true, false, false, false),
('Carol White', 'carolw', 'carol@example.com', '$2y$10$42AGNdGmhSAyAIDrAaFJ5upCtIoGTB.1SkcMhhiQUR.Ni1nRd7mDG', 'default.jpg', 'Fact checker', 2, true, true, false, false, false),
('John Admin', 'notAdmin', 'admin@example.com', '$2y$10$42AGNdGmhSAyAIDrAaFJ5upCtIoGTB.1SkcMhhiQUR.Ni1nRd7mDG', 'default.jpg', 'Admin', 4, true, true, false, true, true),
('Miguel Sousa', 'miguelS', 'miguels@example.com', '$2y$10$42AGNdGmhSAyAIDrAaFJ5upCtIoGTB.1SkcMhhiQUR.Ni1nRd7mDG', 'default.jpg', 'Portuguese writer', 0, true, true, true, false, false);


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
(5, 'Science'),
(6, 'Business');


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
(6, 'Vaccines', false);

INSERT INTO FollowTag (user_id, tag_id) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 3);

INSERT INTO ArticlePage (id, title, subtitle, content, create_date, edit_date, article_image, upvotes, downvotes, is_edited, is_deleted, topic_id, author_id) VALUES
                                                                                                                                                                  (1, 'The Future of AI', 'Innovations in AI', 'The field of artificial intelligence (AI) has seen tremendous growth and innovation over the past few decades. From its early beginnings in the mid-20th century, AI has evolved into a powerful tool that is transforming industries and societies around the world.<?n?n>One of the most significant innovations in AI is the development of machine learning algorithms. These algorithms enable computers to learn from data and make predictions or decisions without being explicitly programmed. This has led to breakthroughs in areas such as image and speech recognition, natural language processing, and autonomous vehicles.<?n?n>Another major innovation is the rise of deep learning, a subset of machine learning that uses neural networks with many layers. Deep learning has achieved remarkable success in tasks that were previously thought to be beyond the reach of computers, such as playing complex games like Go and generating realistic human-like text and images.<?n?n>AI is also driving innovation in healthcare, where it is being used to develop new diagnostic tools, personalize treatment plans, and accelerate drug discovery. For example, AI algorithms can analyze medical images to detect diseases like cancer at an early stage, potentially saving lives.<?n?n>In the business world, AI is being used to optimize operations, improve customer service, and create new products and services. Companies are leveraging AI to analyze large datasets, automate routine tasks, and gain insights that were previously hidden.<?n?n>Despite these advancements, there are still many challenges to overcome. Ethical considerations, such as bias in AI algorithms and the impact of automation on jobs, need to be addressed. Additionally, ensuring the security and privacy of AI systems is crucial as they become more integrated into our daily lives.<?n?n>In conclusion, the innovation of AI is reshaping our world in profound ways. As technology continues to advance, it is essential to navigate the challenges and harness the potential of AI to create a better future for all.', '2024-01-01 10:00', '2024-01-02 11:00', 'default.jpg', 2, 0, true, false, 1, 1),
                                                                                                                                                                  (2, 'Climate Change', 'Urgent Action Needed', 'Discussion on CC...', '2024-02-01 10:00', NULL, 'default.jpg', 1, 1, false, false, 2, 2),
(3, 'COVID-19 Vaccines', 'Progress and Challenges', 'Latest updates on vaccines...', '2024-03-01 10:00', NULL, 'default.jpg', 50, 10, false, false, 4, 3);

INSERT INTO ArticleTag (article_id, tag_id) VALUES
(1, 1),
(2, 2),
(3, 3),
(3, 6);

INSERT INTO VoteArticle (user_id, article_id, type) VALUES
(1, 1, 'Upvote'),
(1, 2, 'Upvote'),
(2, 1, 'Upvote'),
(3, 2, 'Downvote');

INSERT INTO FavouriteArticle (user_id, article_id) VALUES
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

INSERT INTO VoteComment (user_id, comment_id, type) VALUES
(1, 1, 'Upvote'),
(1, 2, 'Downvote'),
(2, 1, 'Upvote'),
(3, 2, 'Downvote');

INSERT INTO Reply (id, content, rpl_date, upvotes, downvotes, is_edited, is_deleted, author_id, comment_id) VALUES
(1, 'I see your point!', '2024-01-02 12:30', 3, 0, false, false, 1, 2);

INSERT INTO VoteReply (user_id, reply_id, type) VALUES
(1, 1, 'Upvote'),
(2, 1, 'Upvote'),
(3, 1, 'Upvote');


INSERT INTO Notifications (id, ntf_date, is_viewed, user_to, user_from) VALUES
(4, '20/9/17 0:00', true, 1, 1),
(5, '23/3/17 0:00', false, 2, 1),
(6, '23/3/17 0:00', false, 1, 2),
(7, '8/10/17 0:00', false, 2, 1),
(8, '20/9/17 0:00', true, 1, 1),
(9, '11/9/21 0:00', false, 2, 1),
(10,'8/10/17 0:00', true, 3, 1);

INSERT INTO UpvoteArticleNotification (id, ntf_id, article_id) VALUES
(1, 4, 1),
(2, 5, 1);

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
(1, 'I am sorry for my actions', 5);

INSERT INTO AskToBecomeFactChecker(id, user_id) VALUES
(1, 1);

INSERT INTO ProposeNewTag(id, name, user_id) VALUES
(1, 'Política portuguesa', 1),
(2, 'Guerra na Ucrania', 2);


