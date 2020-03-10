<?php

namespace App\Policies;

use App\BlogPost;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any blog posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //by default this method returns false
    }

    /**
     * Determine whether the user can view the blog post.
     *
     * @param  \App\User  $user
     * @param  \App\BlogPost  $blogPost
     * @return mixed
     */
    public function view(User $user, BlogPost $blogPost)
    {
        //هذا يعني أن لكل مستخدم أحقية رؤية منشوراته فقط
        //أو يمكن للمدير أيضا رؤية المنشورات أيضا
        return $user->id === $blogPost->user_id || $user->is_admin;
    }

    /**
     * Determine whether the user can create blog posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    //قدرة (صلاحية)  الإنشاء للمنشور
    public function create(User $user)
    {
        //تعطي صلاحية للمدير فقط بالنشر
        // return $user->is_admin;

        return true;
    }

    /**
     * Determine whether the user can update the blog post.
     *
     * @param  \App\User  $user
     * @param  \App\BlogPost  $blogPost
     * @return mixed
     */
    public function update(User $user, BlogPost $blogPost)
    {
        //يعني أن هذا المنشور هو ملك لك
        return $user->id === $blogPost->user_id;
    }

    /**
     * Determine whether the user can delete the blog post.
     *
     * @param  \App\User  $user
     * @param  \App\BlogPost  $blogPost
     * @return mixed
     */
    public function delete(User $user, BlogPost $blogPost)
    {
        //يعني أن هذا المنشور هو ملك لك
        return $user->id === $blogPost->user_id;
    }

    /**
     * Determine whether the user can restore the blog post.
     *
     * @param  \App\User  $user
     * @param  \App\BlogPost  $blogPost
     * @return mixed
     */
    public function restore(User $user, BlogPost $blogPost)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the blog post.
     *
     * @param  \App\User  $user
     * @param  \App\BlogPost  $blogPost
     * @return mixed
     */
    public function forceDelete(User $user, BlogPost $blogPost)
    {
        //
    }
}
