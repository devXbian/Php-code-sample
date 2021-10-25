<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

##Assignment

**Achievements**

Our customers access their purchased courses via our Course Portal.

As part of this experience users are able to unlock achievements:

Lessons Watched Achievements

- First Lesson Watched
- 5 Lessons Watched
- 10 Lessons Watched
- 25 Lessons Watched
- 50 Lessons Watched

Comments Written Achievements

- First Comment Written
- 3 Comments Written
- 5 Comments Written
- 10 Comment Written
- 20 Comment Written


**Badges**

Users also have a badge, this is determined by the number of achievements they have unlocked.


- Beginner: 0 Achievements
- Intermediate: 4 Achievements
- Advanced: 8 Achievements
- Master: 10 Achievements


##Requirement

**Unlocking Achievements**

You need to write the code that listens for user events and unlocks the relevant achievement. 

For example;

When a user writes a comment for the first time they unlock the “First Comment Written” achievement.

When a user has already unlocked the “First Lesson Watched” achievement by watching a single video and then watches another four videos they unlock the “5 Lessons Watched” achievement.


**AchievementUnlocked Event**

When an achievement is unlocked an AchievementUnlocked event must be fired with a payload of; 

achievement_name (string)
user (User Model)


**BadgeUnlocked Event**

When a user unlocks enough achievement to earn a new badge a BadgeUnlocked event must be fired with a payload of; 

badge_name (string)
user (User Model)



**Achievements Endpoint**

There is an endpoint `users/{user}/achievements` that can be found in the ‘web’ routes file, this must return the following;

unlocked_achievements (string[ ]) 
An array of the user’s unlocked achievements by name

next_available_achievements (string[ ])
An array of the next achievements the user can unlock by name. 

>**Note**: Only the next available achievement should be returned for each group of achievements. 

>**Example**: If the user has unlocked the “5 Lessons Watched” and “First Comment Written” achievements only the “10 Lessons Watched” and “3 Comments Written“ achievements should be returned.

current_badge (string) 
The name of the user’s current badge.

next_badge (string)
The name of the next badge the user can earn.

remaining_to_unlock_next_badge (int)
The number of additional achievements the user must unlock to earn the next badge. 

>**Example**: If a user has unlocked 5 achievements they must unlock an additional 3 achievements to earn the “Advanced” badge.


**Test Coverage**

You should write tests that cover all possible scenarios and would, in a real world project, make you confident there are no bugs and it is safe to deploy to production.

Laravel HTTP tests documentation can be found at the following url:

https://laravel.com/docs/8.x/http-tests


##Additional Information

The project is a standard Laravel 8 application, additional installation documentation can be found at  https://laravel.com/docs/8.x/installation

**User Events**

The course portal fires events when a user carries out specific actions: 

**LessonWatched** 
>Fired when a user watches a lesson.

**CommentWritten**
>Fired when a user writes a comment. 

These already exist in the codebase and can be found in `app/Events`.

Your task is not to implement the logic that fires these events, you can work on the assumption that another part of the system will be responsible for this. 

Your assignment is to just listen for these events and ensure the correct achievements & badges are unlocked as outlined in the previous section of this document. 

**User Model**

The following relationships are available on the user model;

**watched**
>This will return an eloquent relationship for lessons watched by a user.

**comments**
>This will return an eloquent relationship for comments written by a user.




**Meets All Criteria** - The solution meets all the criteria outlined in this document.

**Code Quality** - The code is readable, elegant and could be easily expanded in future (for example, the addition of new achievements or badges)

**Test Coverage** - Your tests cover all possible scenarios and we would feel confident there are no issues deploying your code to production.

##Implementation
**Installation**
1. Clone this repository
2. From the root directory run `composer install`
3. You must have a MySql database running locally
4. Update the database details in ‘.env’ to match your local setup
5. Run `php artisan migrate --seed` to setup the database tables and master data

**Master Data for Achievements and Badges**

Achievements and Badges Master data can be handled through configuration. However, the better approach seems to be through database keeping the scalability of system in mind.

*Achievements* - achievements_master table contains the comments_written count and lessons_watched_count to group the achievements. Both fields together are set as unique, to have the unique achievements for the users. Also, these fields have been taken as reference for the order of achievements

*Badges* - badges_master table contains the achievement_unlocked_count and is set as unique, to have the unique badges for the users. This table also contain the reference of next and previous badge for each record to maintain the order of the badges.
> **Note:** Badges data is also added in config in settings.php which can be utilised in case we have fixed count of badges. 
 
 We have a badge **BEGINNER** with 0 achievements, so ideally as soon as user created in the system, the badge should be unlocked for the user. A UserObserver is created which will always trigger the BadgeUnlocked event whenever User is created.
 
 *LessonWatchedListener* and *CommentWrittenListener* are dispatching the *AchievementUnlocked* event whenever the count of either lessons or comments matches the count with any of the achievements.
 
 *AchievementUnlockedListener* is dispatching the *BadgeUnlocked* event whenever the users total number of achievements matched to any of the remaining Badges.

##Test Coverage
**Feature Testing** and **Unit Testing** with major of the cases have been covered, taking care of many *positive*, *negative* , *transactional* cases in account.

*AchievementTest* covers the feature testing of the \achievements endpoint.

*EventListenerTest* covers the event listeners unit test cases.

##Conclusion
Really enjoyed working on such scenario based task, have taken global use-cases keeping scalability of system in mind. Had many more idea to implement in these use-cases, however due to time constraint, did best to cover all possible scenarios.
>**Please Note:**, I have not thrown exception in any of the Listeners, however, have added error logs and return false, these can be converted to exceptions if required.

>Also, in test cases, I have used hardcoded values in few test-cases considering the known result due to provided master data, however, those can be done directly fetched through master database queries, those are also mentioned there, in case we want to change data according to our need we can comment and utilise those.

Have many more things to explain and share, such as following: 
- my thought-process behind this design 
- what more additions could be done for example- Queues, usage of custom-made Helpers and Facades to have generic methods to update and get User Badges etc.

If you liked the implementation or require any discussion. Feel free to contact me at *nijhawankaran7@gmail.com*. 


**!!CHEERS!!**

