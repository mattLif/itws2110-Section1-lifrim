# itws2110-Section1-lifrim

Repo - https://github.com/mattLif/itws2110-Section1-lifrim

Hello!

While working on lab 8, I made the following observations about using phpMyAdmin:
Using phpMyAdmin to run SQL commands made it easy to visually verify table structures, inserted rows, and query results after each step. 
Creating tables with proper data types was important for avoiding errors. For example, using INT for primary keys prevented prefix-key problems.
JOIN operations worked correctly once the foreign keys were set up, and phpMyAdmin’s “Browse” and “SQL” tabs made it easy to test queries.
Aggregation functions like AVG() and COUNT() produced useful for getting statistics for courses.

This lab helped reinforce my understanding of SQL fundamentals such as table creation, altering structure, inserting rows, and performing queries across multiple related tables. Using phpMyAdmin provided a more visual approach than the command line, making debugging faster, especially when checking cross-table relationships or verifying inserted data. Because phpMyAdmin is very well documented and user friendly, learning the specific commands to perform the tasks requested by the lab was simple.

Some assumptions I made while working on the lab includes the following:
Sample CRNs, RINs, names, and addresses did not need to match real data (I made up stuff).
Grades were assumed to be integer values between 0 and 100, as no specific grading scale was required.
Each student could be enrolled in multiple courses, and each course could have multiple grades entered.
Student phone numbers were required to be ints, so a phone number had to have an actual value of 2,147,483,647 or less