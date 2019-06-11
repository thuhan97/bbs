<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    /**
     * Handle the post "creating" event.
     *
     * @param Post $post
     *
     * @return void
     */
    public function creating(Post $post)
    {
        $post->slug_name = str_slug($post->name);
        $post->has_notify = $post->notify_date !== null;

    }

    /**
     * Handle the post "created" event.
     *
     * @param Post $post
     *
     * @return void
     */
    public function created(Post $post)
    {
        //
    }

    /**
     * Handle the post "updating" event.
     *
     * @param Post $post
     *
     * @return void
     */
    public function updating(Post $post)
    {
        $post->has_notify = $post->notify_date !== null;
    }

    /**
     * Handle the post "updated" event.
     *
     * @param Post $post
     *
     * @return void
     */
    public function updated(Post $post)
    {
        //
    }

    /**
     * Handle the post "deleted" event.
     *
     * @param Post $post
     *
     * @return void
     */
    public function deleted(Post $post)
    {
        //
    }

    /**
     * Handle the post "restored" event.
     *
     * @param Post $post
     *
     * @return void
     */
    public function restored(Post $post)
    {
        //
    }

    /**
     * Handle the post "force deleted" event.
     *
     * @param Post $post
     *
     * @return void
     */
    public function forceDeleted(Post $post)
    {
        //
    }
}
