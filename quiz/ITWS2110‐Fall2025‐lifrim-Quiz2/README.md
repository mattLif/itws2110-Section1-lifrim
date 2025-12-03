# itws2110-Section1-lifrim

Repo - https://github.com/mattLif/itws2110-Section1-lifrim

Quiz 2

Design Decisions:
When working on the project information website, the first design decision I had to make was how I wanted to authenticate my users. I added two extra columns to my users table to help securely identify them via hashed salted passwords: passwordHash and passwordSalt. When a user first registers on my register page, they are granted a salt, a randomly generated string of 16 characters. This salt is stored with under their specific passwordSalt and combined with their actual password to generate a their hashed password, which is then stored under passwordHash, avoiding explicit storage of their actual password. Then, whenever a user tries to login using their userID, the php code combines that userID's specific salt with the entered password and hashes it, and sees if that hashed password matches that user's stored hashed password.
Another design decision I made was styling. Although it was not required by the assignment, I wrote a short css stylesheet to enhance my website. I didn't want to make anyhing too fancy, so I just made containers to store forms and text in so it doesn't look like they're just floating text.
Finally, I decided to make project.php 2-columned, so that users can more easily observed their project getting added to the scrollable list of all existing projects.

First Time User, No Database:
In the event that a user accesses my site, and no database currently exists for my projects, I would include and run a prepared setup file like setupDB.txt. After receiving the error that no database exists when the user first tries to access the website, I can run prepared sql statements similar to the ones in setupDB.txt, which will create a blank database (or minimally filled database). After creating the new database, the user would then be redirected to the login page.

Preventing Duplicate Entries:
One way to prevent duplicate entries would be how I implemented the feature that wouldn't allow duplicate names. The SQL code "SELECT COUNT(*) FROM projects WHERE name = ?" returns a count of objects in projects that have the given name. This can be easilt altered to also count projects that have the given description as well: "SELECT COUNT(*) FROM projects WHERE description = ?". If either of these counts are greater than 0, then the form will return an error. Another way to prevent duplicate entries is by using the UNIQUE attribute on each of the attributes a project can have during table creation. This will make it so each column won't allow entries that share identical attributes.

Voting Functionality:
1. I would add a table "votes" to my database.
2. votes will have 4 columns: 
voteId INT AUTO-INCREMENT PRIMARY KEY
voterId VARCHAR(50) ForeignKey(userId) - userId of the person submitting this vote
projectId INT ForeignKey(projectId) - projectId of the project this person is voting on
score INT - the score this person is giving this project (php code will make sure this value ranges to whatever scale suitable)
3. To prevent voting on your own project, I would run the following SQL command, "SELECT COUNT(*) FROM projectMembership WHERE projectId = ? AND memberId = ?". This command will return 1 if this person's memberId is listed under the given projectId, i.e. the project they are currently voting on, and 0 otherwise. If it returns 1, the vote will not be submitted.