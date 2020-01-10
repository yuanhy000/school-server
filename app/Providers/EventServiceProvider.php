<?php

namespace App\Providers;

use App\Events\ApplyOrganization;
use App\Events\CreateActivity;
use App\Events\CreateAnswer;
use App\Events\CreateArticle;
use App\Events\CreateComment;
use App\Events\CreateCommodity;
use App\Events\CreateReruit;
use App\Events\CreateTeam;
use App\Events\CreateTopic;
use App\Listeners\ApplyOrganization\CreateOrganizationImage;
use App\Listeners\CreateActivity\CreateActivityImage;
use App\Listeners\CreateActivity\SetActivityTemperature;
use App\Listeners\CreateAnswer\CreateAnswerImage;
use App\Listeners\CreateAnswer\SetAnswerTemperature;
use App\Listeners\CreateAnswer\TopicAnswerCountIncrement;
use App\Listeners\CreateArticle\CreateArticleImage;
use App\Listeners\CreateArticle\SetArticleTemperature;
use App\Listeners\CreateArticle\UserIssueIncrement;
use App\Listeners\CreateComment\NotifyReceiver;
use App\Listeners\CreateComment\RelatedActivity;
use App\Listeners\CreateComment\RelatedAnswer;
use App\Listeners\CreateComment\RelatedArticle;
use App\Listeners\CreateComment\RelatedCommodity;
use App\Listeners\CreateComment\RelatedNews;
use App\Listeners\CreateComment\RelatedRecruit;
use App\Listeners\CreateCommodity\CreateCommodityImage;
use App\Listeners\createcommodity\SetCommodityTemperature;
use App\Listeners\CreateRecruit\CreateRecruitImage;
use App\Listeners\createrecruit\SetRecruitTemperature;
use App\Listeners\CreateTeam\NotifyActivityOrganizer;
use App\Listeners\CreateTeam\RelatedTeamUser;
use App\Listeners\CreateTopic\CreateTopicImage;
use App\Listeners\CreateTopic\SetTopicTemperature;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CreateArticle::class => [
            CreateArticleImage::class,
            SetArticleTemperature::class,
            UserIssueIncrement::class
        ],
        CreateCommodity::class => [
            CreateCommodityImage::class,
            SetCommodityTemperature::class
        ],
        CreateComment::class => [
            RelatedCommodity::class,
            RelatedArticle::class,
            RelatedActivity::class,
            RelatedRecruit::class,
            RelatedNews::class,
            RelatedAnswer::class,
            NotifyReceiver::class
        ],
        ApplyOrganization::class => [
            CreateOrganizationImage::class
        ],
        CreateActivity::class => [
            CreateActivityImage::class,
            SetActivityTemperature::class,
            \App\Listeners\CreateActivity\UserIssueIncrement::class
        ],
        CreateTeam::class => [
            RelatedTeamUser::class,
            NotifyActivityOrganizer::class
        ],
        CreateReruit::class => [
            CreateRecruitImage::class,
            SetRecruitTemperature::class,
            \App\Listeners\CreateRecruit\UserIssueIncrement::class
        ],
        CreateTopic::class => [
            CreateTopicImage::class,
            SetTopicTemperature::class,
            \App\Listeners\CreateTopic\UserIssueIncrement::class
        ],
        CreateAnswer::class => [
            CreateAnswerImage::class,
            TopicAnswerCountIncrement::class,
            SetAnswerTemperature::class,
            \App\Listeners\CreateAnswer\UserIssueIncrement::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
