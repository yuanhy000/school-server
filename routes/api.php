<?php

use Illuminate\Support\Facades\Route;

Route::get('/user', 'UserController@getUser');

Route::post('/token/get', 'TokenController@getToken');
Route::post('/token/refresh', 'TokenController@refreshToken');
Route::post('/token/clean', 'TokenController@cleanToken');

Route::post('/users/update', 'UserController@updateUserInfo');
Route::post('/users/school/set', 'UserController@setUserSchool');
Route::post('/users/organization/apply', 'UserController@applyOrganization');
Route::post('/users/follow', 'UserController@toggleUserFollow');
Route::post('/users/search/number', 'UserController@searchByNumber');
Route::post('/users/collect', 'UserController@getUserCollectInfo');
Route::post('/users/activity', 'UserController@getUserActivity');
Route::post('/users/notification', 'UserController@getUserNotification');
Route::post('/users/show', 'UserController@getUserShowInfo');
Route::post('/users/history', 'UserController@getUserHistory');
Route::post('/users/follower', 'UserController@getUserFollower');
Route::post('/users/attention', 'UserController@getUserAttention');

Route::post('/information/recommend', 'InformationController@getRecommendInformation');
Route::post('/articles/create', 'ArticleController@createArticle');
Route::post('/articles/detail', 'ArticleController@getArticleDetail');
Route::post('/activities/create', 'ActivityController@createActivity');
Route::post('/activities/detail', 'ActivityController@getActivityDetail');
Route::post('/activities/team/create', 'ActivityController@createActivityTeam');
Route::post('/recruits/create', 'RecruitController@createRecruit');
Route::post('/recruits/detail', 'RecruitController@getRecruitDetail');
Route::post('/news/recommend', 'InformationController@getRecommendNews');
Route::post('/news/detail', 'InformationController@getNewsDetail');

Route::post('/commodities/create', 'CommodityController@createCommodity');
Route::post('/commodities/recommend', 'CommodityController@getRecommendCommodity');
Route::post('/commodities/category', 'CommodityController@getCategoryCommodity');
Route::post('/commodities/detail', 'CommodityController@getCommodityDetail');
Route::post('/commodities/search', 'CommodityController@searchCommodity');

Route::get('/categories/get', 'CategoryController@getCategory');

Route::post('/comments/commodity/create', 'CommentController@createCommodityComment');
Route::post('/comments/article/create', 'CommentController@createArticleComment');
Route::post('/comments/activity/create', 'CommentController@createActivityComment');
Route::post('/comments/recruit/create', 'CommentController@createRecruitComment');
Route::post('/comments/news/create', 'CommentController@createNewsComment');
Route::post('/comments/answer/create', 'CommentController@createAnswerComment');

Route::post('/topics/create', 'TopicController@createTopic');
Route::post('/topics/recommend', 'TopicController@getRecommendTopic');
Route::post('/topics/detail', 'TopicController@getDetailTopic');
Route::post('/answers/create', 'TopicController@createAnswer');
Route::post('/answers/topic', 'TopicController@getTopicAnswers');
Route::post('/answers/recommend', 'TopicController@getRecommendAnswers');
Route::post('/answers/detail', 'TopicController@getDetailAnswer');


Route::post('/likes/article', 'LikeController@toggleArticleLike');
Route::post('/likes/activity', 'LikeController@toggleActivityLike');
Route::post('/likes/recruit', 'LikeController@toggleRecruitLike');
Route::post('/likes/commodity', 'LikeController@toggleCommodityLike');
Route::post('/likes/comment', 'LikeController@toggleCommentLike');
Route::post('/likes/news', 'LikeController@toggleNewsLike');
Route::post('/likes/topic', 'LikeController@toggleTopicLike');
Route::post('/likes/answer', 'LikeController@toggleAnswerLike');

Route::post('/collections/commodity', 'CollectController@toggleCommodityCollect');
Route::post('/collections/article', 'CollectController@toggleArticleCollect');
Route::post('/collections/activity', 'CollectController@toggleActivityCollect');
Route::post('/collections/recruit', 'CollectController@toggleRecruitCollect');
Route::post('/collections/news', 'CollectController@toggleNewsCollect');
Route::post('/collections/topic', 'CollectController@toggleTopicCollect');
Route::post('/collections/answer', 'CollectController@toggleAnswerCollect');

Route::get('/test', 'InformationController@getRecommendInformation');

Route::post('/notifications/delete', 'NotificationController@deleteNotification');


