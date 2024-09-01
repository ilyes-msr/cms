<?php

namespace App\Http\ViewComposers;

use App\Repositories\UserRepository;
use Illuminate\View\View;
use App\Models\Comment;
use App\Models\Post;
use Faker\Core\Number;

class CommentComposer
{
  protected $comments;

  public function __construct(Comment $comments)
  {
    $this->comments = $comments;
  }

  public function compose(View $view)
  {
    return $view->with('recent_comments', $this->comments::with('user', 'post:id')->take(8)->latest()->get());
  }
}
