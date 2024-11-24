SET DateStyle TO European;

TRUNCATE TABLE users CASCADE;
TRUNCATE TABLE follow_user CASCADE;
TRUNCATE TABLE topic CASCADE;
TRUNCATE TABLE follow_topics CASCADE;
TRUNCATE TABLE tag CASCADE;
TRUNCATE TABLE follow_tags CASCADE;
TRUNCATE TABLE article_page CASCADE;
TRUNCATE TABLE article_tag CASCADE;
TRUNCATE TABLE vote_article CASCADE;
TRUNCATE TABLE favourite_article CASCADE;
TRUNCATE TABLE check_article CASCADE;
TRUNCATE TABLE comment CASCADE;
TRUNCATE TABLE vote_comment CASCADE;
TRUNCATE TABLE reply CASCADE;
TRUNCATE TABLE vote_reply CASCADE;
TRUNCATE TABLE report CASCADE;
TRUNCATE TABLE report_user CASCADE;
TRUNCATE TABLE report_article CASCADE;
TRUNCATE TABLE report_comment CASCADE;
TRUNCATE TABLE propose_new_tag CASCADE;
TRUNCATE TABLE appeal_to_unban CASCADE;
TRUNCATE TABLE ask_to_become_fact_checker CASCADE;
TRUNCATE TABLE notifications CASCADE;
TRUNCATE TABLE comment_notification CASCADE;
TRUNCATE TABLE reply_notification CASCADE;
TRUNCATE TABLE upvote_article_notification CASCADE;
TRUNCATE TABLE upvote_comment_notification CASCADE;
TRUNCATE TABLE upvote_reply_notification CASCADE;



-- password: password123
INSERT INTO users (display_name, username, email, password, profile_picture, description, reputation, upvote_notification, comment_notification, is_banned, is_admin, is_fact_checker) VALUES
('Alice Johnson', 'alicej', 'alice@example.com', '$2y$10$42AGNdGmhSAyAIDrAaFJ5upCtIoGTB.1SkcMhhiQUR.Ni1nRd7mDG', 'default.jpg', 'Enthusiastic writer', 5, true, true, false, false, true),
('Bob Smith', 'bobsmith', 'bob@example.com', '$2y$10$42AGNdGmhSAyAIDrAaFJ5upCtIoGTB.1SkcMhhiQUR.Ni1nRd7mDG', 'default.jpg', 'Tech enthusiast', 3, true, true, false, false, false),
('Carol White', 'carolw', 'carol@example.com', '$2y$10$42AGNdGmhSAyAIDrAaFJ5upCtIoGTB.1SkcMhhiQUR.Ni1nRd7mDG', 'default.jpg', 'Fact checker', 2, true, true, false, false, false),
('John Admin', 'notAdmin', 'admin@example.com', '$2y$10$42AGNdGmhSAyAIDrAaFJ5upCtIoGTB.1SkcMhhiQUR.Ni1nRd7mDG', 'default.jpg', 'Admin', 4, true, true, false, true, true),
('Miguel Sousa', 'miguelS', 'miguels@example.com', '$2y$10$42AGNdGmhSAyAIDrAaFJ5upCtIoGTB.1SkcMhhiQUR.Ni1nRd7mDG', 'default.jpg', 'Portuguese writer', 0, true, true, true, false, false);

INSERT INTO follow_user (follower_id, following_id) VALUES
(1, 2),
(1, 3),
(2, 1),
(3, 1);

INSERT INTO topic (id, name) VALUES
(1, 'Technology'),
(2, 'Environment'),
(3, 'Politics'),
(4, 'Health'),
(5, 'Science'),
(6, 'Business'),
(7, 'Sports');

INSERT INTO follow_topics (user_id, topic_id) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 3);

INSERT INTO tag (id, name, is_trending) VALUES
(1, 'AI', true),
(2, 'Climate', false),
(3, 'COVID-19', false),
(4, 'American Elections', true),
(5, 'Space', false),
(6, 'Vaccines', false),
(7, 'Football', true);

INSERT INTO follow_tags (user_id, tag_id) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 3);

INSERT INTO article_page (id, title, subtitle, content, create_date, edit_date, article_image, upvotes, downvotes, is_edited, is_deleted, topic_id, author_id) VALUES
(1, 'The Future of AI', 'Innovations in AI', 'The field of artificial intelligence (AI) has seen tremendous growth and innovation over the past few decades. From its early beginnings in the mid-20th century, AI has evolved into a powerful tool that is transforming industries and societies around the world.<?n?n>One of the most significant innovations in AI is the development of machine learning algorithms. These algorithms enable computers to learn from data and make predictions or decisions without being explicitly programmed. This has led to breakthroughs in areas such as image and speech recognition, natural language processing, and autonomous vehicles.<?n?n>Another major innovation is the rise of deep learning, a subset of machine learning that uses neural networks with many layers. Deep learning has achieved remarkable success in tasks that were previously thought to be beyond the reach of computers, such as playing complex games like Go and generating realistic human-like text and images.<?n?n>AI is also driving innovation in healthcare, where it is being used to develop new diagnostic tools, personalize treatment plans, and accelerate drug discovery. For example, AI algorithms can analyze medical images to detect diseases like cancer at an early stage, potentially saving lives.<?n?n>In the business world, AI is being used to optimize operations, improve customer service, and create new products and services. Companies are leveraging AI to analyze large datasets, automate routine tasks, and gain insights that were previously hidden.<?n?n>Despite these advancements, there are still many challenges to overcome. Ethical considerations, such as bias in AI algorithms and the impact of automation on jobs, need to be addressed. Additionally, ensuring the security and privacy of AI systems is crucial as they become more integrated into our daily lives.<?n?n>In conclusion, the innovation of AI is reshaping our world in profound ways. As technology continues to advance, it is essential to navigate the challenges and harness the potential of AI to create a better future for all.', '2024-01-01 10:00', '2024-01-02 11:00', 'default.jpg', 2, 0, true, false, 1, 1),
(2, 'Climate Change', 'Urgent Action Needed', 'Climate change is no longer a distant threat; it is a present-day crisis, reshaping the planet in real time. Rising temperatures, severe weather patterns, and rising sea levels are altering ecosystems, displacing communities, and threatening agriculture.<?n?n>Scientists have long warned about the dire consequences of continued greenhouse gas emissions. The primary drivers of these emissions—fossil fuel consumption and deforestation—are still accelerating the problem. The harsh reality of these predictions is becoming clearer each year as we witness more frequent and intense natural disasters.<?n?n>From devastating wildfires in California and Australia to catastrophic hurricanes in the Caribbean and the increasing frequency of droughts in Africa, these extreme weather events have caused widespread destruction. In many places, the damage to infrastructure, homes, and livelihoods has been severe, and the effects are not temporary—they have long-lasting consequences.<?n?n>Beyond the immediate damage to human communities, climate change is also endangering biodiversity. Rising ocean temperatures, for example, are bleaching coral reefs and threatening marine life. Likewise, many terrestrial species are struggling to adapt to rapidly changing environments, with some on the brink of extinction.<?n?n>While countries around the world have started implementing measures to combat climate change, including renewable energy adoption and international agreements, the scale of the crisis requires more urgent and transformative action.<?n?n>To avoid the worst impacts, experts argue that global emissions must be significantly reduced, fossil fuel dependence must be curtailed, and industrial practices must evolve. Thankfully, the growing adoption of renewable energy sources such as wind and solar power offers hope, though it will take more than just this to address the full scope of the problem.<?n?n>In conclusion, the fight against climate change is not one that can be left to governments alone. It requires a global effort from individuals, businesses, and policymakers alike. Only through collective action can we hope to slow the damage and build a more sustainable future for generations to come.', '2024-02-01 10:00', NULL, 'default.jpg', 1, 1, false, false, 2, 2),
(3, 'COVID-19 Vaccines', 'Progress and Challenges', 'COVID-19 vaccines have played a pivotal role in the global response to the pandemic, offering a powerful tool to protect individuals from severe illness and reduce the spread of the virus. Developed in record time, these vaccines have proven to be effective in preventing infection and, more importantly, in significantly lowering the risk of hospitalization and death.<?n?n>Since the first vaccines were rolled out in late 2020, millions of people around the world have received their doses. The rapid development of these vaccines was a scientific triumph, with pharmaceutical companies leveraging years of research on mRNA technology, alongside traditional vaccine methods, to create multiple safe and effective options.<?n?n>As more people get vaccinated, countries have seen a decline in COVID-19 cases, easing pressure on healthcare systems and allowing economies to reopen. However, the global distribution of vaccines has been uneven, with wealthier nations having faster access while low-income countries struggle to secure enough doses. This disparity has highlighted the need for greater international cooperation to ensure equitable vaccine distribution.<?n?n>In addition to their ability to protect against severe disease, vaccines have also contributed to reducing the burden on hospitals and healthcare workers, allowing them to focus on treating other critical conditions. As new variants of the virus, such as Delta and Omicron, emerged, vaccines were updated to enhance their effectiveness against these mutations, offering an added layer of defense.<?n?n>Despite the proven benefits of vaccination, vaccine hesitancy remains a challenge in many parts of the world. Misinformation, mistrust of government health recommendations, and concerns over potential side effects have slowed the uptake in some communities. Public health campaigns, along with clear and transparent communication, have been essential in addressing these concerns.<?n?n>In conclusion, COVID-19 vaccines have been a game-changer in the fight against the pandemic. They are critical not only in saving lives but also in moving the world closer to ending the crisis. Continued efforts are needed to vaccinate as many people as possible, including in underserved regions, to ensure the global community can reach herd immunity and prevent further outbreaks.', '2024-03-01 10:00', NULL, 'default.jpg', 0, 0, false, false, 4, 3),
(4, 'The American Elections', 'A Defining Moment in U.S. Democracy', 'The American elections are among the most closely watched political events in the world, with their outcomes having far-reaching implications not only for the United States but also for global politics. Every four years, millions of Americans cast their votes in the presidential election, a process that involves not just the public but also a complex system of primaries, caucuses, and the Electoral College.<?n?n>In the United States, elections are more than just a democratic exercise—they are a reflection of the nation''s values, priorities, and the direction in which its people wish to move. The elections serve as a check on government power and offer citizens the chance to shape policy, elect leaders, and influence the future of the country. The 2024 election is particularly important as it comes at a time of political polarization, economic challenges, and a changing social landscape.<?n?n>Presidential campaigns in the U.S. are long, often grueling affairs, with candidates vying for support through debates, rallies, advertising, and policy proposals. Political parties—primarily the Democratic and Republican parties—nominate their candidates through primary elections, and the final choice is made in a general election, where voters decide the next president. This system, while effective, has been critiqued for its complexity and the outsized influence of swing states and the Electoral College.<?n?n>In addition to the presidential race, Americans also vote for members of Congress, governors, and state legislators. These elections, often occurring in tandem with the presidential election, can shift the balance of power in Washington, D.C. and local governments, further shaping the legislative agenda and public policy. With voter turnout typically fluctuating, efforts to increase participation—especially among marginalized communities—have been at the forefront of many political campaigns.<?n?n>While elections in the U.S. are a cornerstone of democracy, they are also not without challenges. Voter suppression, misinformation, and foreign interference have been persistent issues, with the 2020 election serving as a focal point for debates on electoral integrity. The advent of mail-in voting and online misinformation also raised new concerns about election security and the accuracy of results. Nonetheless, the U.S. has continually worked to address these issues through legislation, reform, and increased transparency.<?n?n>In conclusion, American elections represent the essence of democracy, offering citizens the power to determine their leaders and influence national policy. As the 2024 elections approach, the nation remains at a crossroads, with voters tasked with choosing a path forward amid uncertainty. Whether or not the country will embrace unity or continue to grapple with division will depend on the choices made at the ballot box.', '2024-10-1 10:00', NULL, 'default.jpg', 0, 0, false, false, 3, 1),
(5, 'The Achievements of Science in Space', 'Unlocking the Mysteries of the Universe', 'Science has made extraordinary strides in space exploration, expanding our understanding of the universe and our place within it. From the early days of space travel to the cutting-edge technologies of today, humanity''s quest to explore the cosmos has led to numerous groundbreaking achievements. These discoveries not only enrich our knowledge of space but also offer profound insights into the origins and future of life on Earth.<?n?n>The most iconic achievement in space exploration is perhaps the Apollo 11 mission, which saw humans land on the Moon in 1969. This historic moment marked the first time a human set foot on another celestial body, with astronaut Neil Armstrong’s famous words, "That''s one small step for man, one giant leap for mankind," capturing the significance of the event. The success of the Apollo missions paved the way for further lunar exploration and helped fuel advancements in science and technology that have had lasting impacts on other fields.<?n?n>Another monumental achievement came with the launch of space telescopes, such as the Hubble Space Telescope. Launched in 1990, Hubble has provided breathtaking images of distant galaxies, nebulae, and stars, helping scientists study the formation of the universe, the nature of black holes, and the age of the cosmos. Hubble’s discoveries have expanded our knowledge of everything from the existence of exoplanets to the understanding of cosmic inflation, offering a deeper view into the fabric of space-time itself.<?n?n>More recently, missions to Mars have captivated the public’s imagination, with NASA''s Perseverance rover landing on the Red Planet in 2021. Perseverance''s mission to explore Mars'' surface, search for signs of ancient life, and collect soil samples is part of humanity’s broader goal to answer fundamental questions about the potential for life beyond Earth. Alongside Perseverance, the Ingenuity helicopter, the first powered flight on another planet, demonstrated the possibilities of aerial exploration on Mars, further highlighting the advancements in robotics and artificial intelligence.<?n?n>Space exploration has also been a catalyst for international collaboration. The International Space Station (ISS), a joint project involving the United States, Russia, Japan, Europe, and Canada, has served as a microgravity laboratory, enabling scientists to conduct experiments that would be impossible on Earth. Research conducted aboard the ISS has led to advancements in fields ranging from medicine to materials science, and its success demonstrates the power of global cooperation in advancing human knowledge.<?n?n>In addition to exploration, space science has provided Earth with invaluable data about our planet. Satellites orbiting the Earth have revolutionized our understanding of climate change, weather patterns, and natural disasters. Earth-observing satellites, such as the Copernicus Sentinel satellites, are helping scientists monitor the health of our planet and track the impacts of human activities on the environment. These advancements are essential as we confront the challenges of climate change and work toward sustainability.<?n?n>In conclusion, the achievements of science in space have expanded our knowledge in ways that were once thought unimaginable. From landing on the Moon to exploring distant planets, space exploration has opened new frontiers for humanity, offering insights into the universe and inspiring future generations. As technology continues to advance, the future of space science promises even greater discoveries, with the potential to answer some of humanity''s most profound questions about life, the universe, and everything in between.', '2024-01-01 10:00', NULL, 'default.jpg', 0, 0, false, false, 5, 2),
(6, 'The Boom of AI Businesses', 'Revolutionizing Industries and Shaping the Future', 'The rise of artificial intelligence (AI) has sparked a new wave of innovation, driving growth across various sectors and transforming industries in ways previously thought impossible. From healthcare to finance, AI is not just a tool but a game-changer, reshaping the business landscape and opening up new opportunities. As AI technologies continue to evolve, the businesses behind them are experiencing unprecedented growth, making AI one of the most valuable sectors in the global economy.<?n?n>AI’s impact on business has been profound, with companies integrating machine learning, natural language processing, and robotics into their operations to improve efficiency, reduce costs, and enhance customer experiences. Industries that once relied on manual labor and traditional processes are now utilizing AI-driven automation to streamline their workflows. For example, in manufacturing, AI-powered robots are able to perform tasks with precision and speed, significantly reducing production time and errors. This not only increases profitability but also pushes the boundaries of what can be achieved in automation.<?n?n>The tech industry, led by companies like Google, Amazon, and Microsoft, has been at the forefront of the AI revolution. These tech giants have invested heavily in AI research and development, leading to breakthroughs in areas like cloud computing, data analytics, and smart devices. AI-powered services such as virtual assistants, recommendation engines, and advanced search algorithms have become integral parts of our daily lives, helping businesses understand and anticipate consumer behavior. The boom in AI-powered applications has led to exponential growth in these tech companies, as businesses across all sectors scramble to integrate AI into their operations.<?n?n>Startups focused on AI are also flourishing, with entrepreneurs creating innovative solutions to meet the growing demand for AI tools. Companies specializing in AI for cybersecurity, autonomous vehicles, and predictive analytics are attracting significant venture capital funding. The rise of AI-driven startups is not only creating wealth but also spurring job creation in fields like data science, machine learning engineering, and AI ethics. As AI continues to evolve, the talent pool needed to support this burgeoning industry is expanding rapidly.<?n?n>One of the most exciting areas of AI business growth is in healthcare. AI is revolutionizing how medical professionals diagnose, treat, and prevent diseases. Machine learning algorithms are being used to analyze medical imaging, predict patient outcomes, and discover new drugs more efficiently than traditional methods. Companies like DeepMind and IBM Watson Health are pioneering AI applications in healthcare, demonstrating the potential for AI to improve patient care while reducing costs. As the technology matures, AI is expected to play an even larger role in personalized medicine and global health solutions.<?n?n>However, the rapid growth of AI businesses also raises ethical and regulatory questions. Concerns around data privacy, job displacement, and AI bias have led to calls for greater oversight and accountability in the AI industry. Governments and regulatory bodies are increasingly focusing on creating frameworks that balance innovation with responsibility. As AI continues to proliferate, ensuring ethical AI practices and protecting consumer rights will be crucial to maintaining public trust in these technologies.<?n?n>In conclusion, AI businesses are booming, revolutionizing industries and creating new economic opportunities. From automation and personalized services to healthcare advancements and innovative startups, AI is poised to shape the future of business in profound ways. As the industry grows, it will not only continue to transform the global economy but also challenge businesses to navigate the complexities of ethics, regulation, and workforce adaptation. The next decade promises to be an exciting time for AI, with endless possibilities on the horizon.', '2024-01-01 10:00', NULL, 'default.jpg', 0, 0, false, false, 6, 3),
(7, 'The Dark Side of AI', 'Creating Fake News Ahead of the American Election', 'As the 2024 American election approaches, concerns are rising over the potential misuse of artificial intelligence (AI) to spread fake news and misinformation. While AI has brought numerous benefits to various industries, its ability to generate realistic and convincing fake news is becoming a growing threat to the integrity of democratic processes. With AI-powered tools capable of producing articles, social media posts, and even deepfake videos, the stakes have never been higher.<?n?n>AI-generated fake news poses a significant challenge to the upcoming election, as malicious actors can exploit these technologies to create misleading narratives that sway public opinion. AI programs, such as large language models, can write articles that mimic the tone and style of reputable news sources, making it difficult for readers to discern fact from fiction. These AI systems can analyze vast amounts of data, including political statements, social media trends, and public sentiment, to craft stories that align with specific agendas or ideologies.<?n?n>One of the most concerning aspects of AI-generated fake news is its ability to spread rapidly on social media platforms. With algorithms designed to amplify engaging content, fake news articles created by AI can quickly go viral, reaching millions of people within hours. These stories often play on emotions, using sensationalist headlines and polarizing narratives to fuel division and mistrust. As people share these posts, often without verifying the information, the false narratives gain further traction, creating a snowball effect that can influence voter behavior.<?n?n>During election seasons, the consequences of such misinformation are particularly severe. AI-driven fake news can target specific demographics, spreading false claims about candidates, political parties, or voting processes. For example, AI-generated content might falsely claim that a candidate has committed a crime or spread rumors about the integrity of the election itself. These false stories, when amplified through social media and echo chambers, can erode trust in the electoral system, undermine confidence in candidates, and even discourage people from voting.<?n?n>Governments, tech companies, and media organizations are struggling to keep pace with the rise of AI-generated misinformation. While platforms like Facebook and Twitter have taken steps to identify and remove fake news, the sheer volume and sophistication of AI-generated content make this task increasingly difficult. AI tools can now create fake news that is highly persuasive, often indistinguishable from legitimate journalism, making detection and debunking an ongoing battle for fact-checkers and journalists.<?n?n>In response to this growing problem, experts are calling for increased regulation and oversight of AI technologies, especially in the context of elections. Some suggest that AI systems should be required to label content generated by machines, providing transparency for readers and making it easier to spot misinformation. Additionally, collaboration between governments, social media platforms, and AI companies is seen as essential to developing safeguards that prevent the exploitation of AI for political manipulation.<?n?n>In conclusion, the use of AI to create fake news presents a dangerous threat to the integrity of the upcoming American election. As AI becomes more advanced, its ability to deceive and manipulate public opinion grows, challenging the foundations of democratic processes. To safeguard the election and ensure that voters have access to accurate information, a coordinated effort is needed to regulate AI-generated content and combat misinformation. The future of democracy may depend on our ability to navigate this new technological landscape.', '2024-01-01 10:00', NULL, 'default.jpg', 0, 0, false, false, 3, 1),
(8, 'Poor handling of COVID-19', 'How it might influence the American Elections', 'As the United States heads toward the 2024 presidential election, the handling of the COVID-19 pandemic remains a crucial point of contention that could significantly influence voter sentiment. The pandemic has not only reshaped the daily lives of millions but also created a political divide, with voters increasingly aligning with candidates and parties based on how they perceive the government''s response to the crisis. The pandemic''s ongoing impact on public health, the economy, and social well-being will undoubtedly play a central role in determining the outcomes of the upcoming election.<?n?n>One of the most prominent factors influencing the election will be the public''s assessment of the government''s pandemic response. The initial handling of COVID-19 in 2020, which included lockdowns, mask mandates, and social distancing guidelines, drew sharp political divisions. Many Americans saw the government''s actions as either a necessary public health measure or an overreach of authority. As the election draws closer, voters are likely to evaluate how well their elected leaders managed both the immediate health crisis and its long-term economic effects. The effectiveness of vaccine distribution, the recovery of the economy, and the adequacy of healthcare systems are all likely to be key issues in the minds of voters.<?n?n>Furthermore, the role of state versus federal governance during the pandemic could heavily influence voter decisions. Different states adopted varying approaches to managing the virus, with some opting for stricter measures and others opting for more lenient policies. For example, states like California and New York implemented widespread lockdowns and mask mandates, while states like Florida and Texas chose more open approaches. The impact of these differing strategies on local economies and public health outcomes will likely be a point of debate among candidates and voters. Political leaders who strongly advocated for specific strategies may face scrutiny depending on their perceived success or failure in managing the pandemic.<?n?n>The economic consequences of COVID-19 will also be a major factor shaping voter priorities in the 2024 election. The pandemic led to widespread job losses, business closures, and disruptions in industries like travel, hospitality, and entertainment. In response, the federal government enacted a series of stimulus packages and unemployment benefits to provide relief, which may influence how voters perceive the government’s role in crisis management. Candidates who promise continued economic recovery, job creation, and support for small businesses will likely appeal to voters still reeling from the pandemic’s economic fallout. On the other hand, those who criticize past economic relief efforts may tap into voter frustrations over inflation or national debt.<?n?n>Health disparities that were exacerbated by the pandemic may also factor into voting decisions, particularly in marginalized communities. COVID-19 disproportionately affected low-income and minority populations, leading to calls for greater equity in healthcare access and government support. Candidates who advocate for healthcare reform, expanded access to vaccines, and better preparedness for future health crises may gain significant support from communities hardest hit by the pandemic. Conversely, candidates who downplay the ongoing health risks or fail to address disparities in healthcare could face backlash from these communities.<?n?n>In addition to policy concerns, the handling of COVID-19 could influence voter trust in the electoral process itself. The pandemic prompted changes in how elections were conducted, including an increase in mail-in voting and the use of early voting. Some voters and political figures expressed concerns over the security and integrity of these methods, raising questions about potential voter fraud. As the 2024 election approaches, the debate over election security could become intertwined with lingering doubts about the pandemic response, potentially affecting voter turnout and confidence in the electoral system.<?n?n>In conclusion, the handling of COVID-19 will be a major factor in the 2024 elections, shaping public opinion and voter behavior. From economic recovery to healthcare reform, the pandemic’s impact on voters’ lives will heavily influence their choices at the ballot box. How candidates address these issues—whether by advocating for continued recovery efforts or criticizing past responses—will ultimately determine who gains the trust of the American people in this pivotal election. The fallout from COVID-19 may very well shape the future political landscape of the United States for years to come.', '2024-01-01 10:00', NULL, 'default.jpg', 0, 0, false, false, 3, 2),
(9, 'The Evolution of Football Tactics', 'From Traditional to Modern Play', 'Football, or soccer as it’s called in some countries, has evolved significantly over the years. What started as a simple game with basic rules has transformed into a highly strategic sport, with teams employing complex tactics to outsmart their opponents. This evolution of football tactics has changed the way the game is played, turning it into a more dynamic and fast-paced spectacle.<?n?n>In the early days of football, teams primarily relied on basic formations, such as the 2-3-5 system, which consisted of two defenders, three midfielders, and five forwards. This attacking style prioritized offense, with the idea of overwhelming the opposition with sheer numbers in the attacking third. However, as teams began to understand the importance of balance between defense and attack, formations started to evolve to provide more stability. By the 1960s, the 4-4-2 formation, which is still commonly used today, became a popular choice, providing a more solid defensive structure while still allowing for attacking opportunities.<?n?n>The 21st century has witnessed even more tactical innovation, with managers like Pep Guardiola, Jurgen Klopp, and Mauricio Pochettino leading the charge in modern football strategies. One of the most influential tactical shifts has been the concept of "possession-based football," popularized by Guardiola during his time at Barcelona. This strategy emphasizes maintaining possession of the ball for long periods to wear down opponents, create space, and control the tempo of the game. Teams like Barcelona, Manchester City, and Bayern Munich have excelled with this approach, making intricate passes and positioning key to breaking down defensive lines.<?n?n>Another significant tactical shift has been the rise of high-pressing football, popularized by Klopp’s Liverpool and Pochettino’s Tottenham Hotspur. The high press involves teams putting pressure on the opponent high up the pitch, often as soon as they lose possession, to win the ball back quickly. This strategy has led to more exciting, fast-paced games, as teams look to regain control through relentless pressing and quick transitions. High pressing demands exceptional fitness, speed, and coordination, and it’s a tactic that has reshaped how modern football is played.<?n?n>As football continues to evolve, tactics will likely keep changing in response to new challenges. The introduction of video assistant referees (VAR) has also impacted tactical decisions, as teams are more cautious about offside positions and penalties, knowing that they can be reviewed. Additionally, the ever-growing importance of data analytics has given managers more insights into player performance, injuries, and match statistics, allowing for more informed tactical decisions. The future of football tactics looks set to be even more dynamic, with greater emphasis on adaptability, versatility, and the use of technology to outsmart opponents.', '2024-01-01 10:00', NULL, 'default.jpg', 0, 0, false, false, 7, 3),
(10, 'The Global Phenomenon of Football', 'Why It’s the World’s Most Popular Sport', 'Football is widely regarded as the world''s most popular sport, and for good reason. With over 4 billion fans worldwide, the sport transcends cultural, geographic, and social boundaries. From the bustling streets of Rio de Janeiro to the heart of London, football is a universal language that unites people across the globe. The reasons for football’s global appeal are varied, but its simplicity, accessibility, and thrilling nature make it the sport of choice for millions.<?n?n>One of the key factors contributing to football''s popularity is its simplicity. The basic rules of football are easy to understand: two teams compete to score goals, and the team with the most goals wins. This straightforward concept makes the game accessible to people of all ages and skill levels, whether they are playing in a professional league or kicking a ball around in a local park. Unlike sports that require specialized equipment or facilities, football can be played with just a ball and an open space, making it an inclusive sport for all.<?n?n>Football’s international appeal is also tied to its deep-rooted history and cultural significance. The sport has been played in some form for centuries, with its modern version originating in England in the 19th century. Since then, it has spread across continents, becoming a cultural pillar in countries around the world. Major football tournaments, such as the FIFA World Cup, attract millions of viewers from every corner of the globe. The World Cup, held every four years, is the pinnacle of the sport, with teams from diverse nations competing for the ultimate prize. The tournament unites fans from different backgrounds, creating a sense of global camaraderie and pride.<?n?n>The success of international clubs and leagues has also fueled football’s global growth. Iconic teams like Barcelona, Real Madrid, Manchester United, and Bayern Munich have legions of fans worldwide. These clubs have become more than just sports teams; they are symbols of identity and pride for their supporters. The rise of global broadcasting deals and digital platforms has made it easier for fans to watch their favorite teams, regardless of where they live. Social media and online content further amplify the reach of football, with players becoming global superstars with millions of followers.<?n?n>Additionally, football’s ability to bring people together during times of social and political unrest has solidified its place as the world’s most beloved sport. In countries with political instability or economic struggles, football has served as a unifying force, offering hope and entertainment. Major tournaments, like the World Cup or the UEFA Champions League, provide a sense of escape and joy, bringing together people from all walks of life to celebrate their shared love for the game. Football’s power to bring joy and foster community spirit has helped it maintain its position as a global phenomenon.<?n?n>In conclusion, football’s status as the world’s most popular sport is a testament to its simplicity, accessibility, and universal appeal. Whether played on the streets or watched in packed stadiums, the sport has the ability to unite people from all cultures and backgrounds. As the game continues to evolve, football’s global fanbase will likely continue to grow, cementing its place as a symbol of passion, pride, and unity for generations to come.', '2024-01-01 10:00', NULL, 'default.jpg', 0, 0, false, false, 7, 1);

INSERT INTO article_tag (article_id, tag_id) VALUES
(1, 1),
(2, 2),
(3, 3),
(3, 6),
(4, 4),
(5, 5),
(6, 1),
(7, 1),
(7, 4),
(8, 3),
(8, 4),
(9, 7),
(10, 7);

INSERT INTO vote_article (user_id, article_id, type) VALUES
(1, 1, 'Upvote'),
(1, 2, 'Upvote'),
(2, 1, 'Upvote'),
(3, 2, 'Downvote');

INSERT INTO favourite_article (user_id, article_id) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 2);

INSERT INTO check_article (user_id, article_id, context, verdict) VALUES
(1, 2, 'This article is misleading', 'False'),
(1, 1, 'No Fake information have been written', 'True');

INSERT INTO comment (id, content, cmt_date, upvotes, downvotes, is_edited, is_deleted, author_id, article_id) VALUES
(1, 'Great insights!', '2024-01-02 12:00', 2, 0, false, false, 2, 1),
(2, 'I disagree with...', '2024-01-03 13:00', 0, 2, false, false, 3, 1);

INSERT INTO vote_comment (user_id, comment_id, type) VALUES
(1, 1, 'Upvote'),
(1, 2, 'Downvote'),
(2, 1, 'Upvote'),
(3, 2, 'Downvote');

INSERT INTO reply (id, content, rpl_date, upvotes, downvotes, is_edited, is_deleted, author_id, comment_id) VALUES
(1, 'I see your point!', '2024-01-02 12:30', 3, 0, false, false, 1, 2);

INSERT INTO vote_reply (user_id, reply_id, type) VALUES
(1, 1, 'Upvote'),
(2, 1, 'Upvote'),
(3, 1, 'Upvote');

INSERT INTO report (id, description, report_date, is_accepted, reporter_id) VALUES
(1, 'This article is spreading fake news', '2024-01-02 12:00', false, 1),
(2, 'This comment is offensive', '2024-01-03 13:00', false, 1),
(3, 'This user has violent content', '2024-01-03 13:00', false, 2);

INSERT INTO report_user (id, type, report_id, user_id) VALUES
(1, 'Violence or Sexual Content', 3, 2);

INSERT INTO report_article (id, type, report_id, article_id) VALUES
(1, 'Fact Check', 1, 1);

INSERT INTO report_comment (id, type, report_id, comment_id, reply_id) VALUES
(1, 'Harassment', 2, 2, NULL);

INSERT INTO propose_new_tag(id, name, user_id) VALUES
(1, 'Política portuguesa', 1),
(2, 'Guerra na Ucrania', 2);

INSERT INTO appeal_to_unban(id , description, user_id) VALUES
(1, 'I am sorry for my actions', 5);

INSERT INTO ask_to_become_fact_checker(id, user_id) VALUES
(1, 1);

INSERT INTO notifications (id, ntf_date, is_viewed, user_to, user_from) VALUES
(4, '20/9/17 0:00', true, 1, 1),
(5, '23/3/17 0:00', false, 2, 1),
(6, '23/3/17 0:00', false, 1, 2),
(7, '8/10/17 0:00', false, 2, 1),
(8, '20/9/17 0:00', true, 1, 1),
(9, '11/9/21 0:00', false, 2, 1),
(10,'8/10/17 0:00', true, 3, 1);

INSERT INTO upvote_article_notification (id, ntf_id, article_id) VALUES
(1, 4, 1),
(2, 5, 1);

INSERT INTO upvote_comment_notification (id, ntf_id, comment_id) VALUES
(1, 6, 1),
(2, 7, 1);

INSERT INTO upvote_reply_notification (id, ntf_id, reply_id) VALUES
(1, 8, 1),
(2, 9, 1),
(3, 10, 1);
