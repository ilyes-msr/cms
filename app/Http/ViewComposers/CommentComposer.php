<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Comment;

class CommentComposer
{
  protected $comments;

  public function __construct(Comment $comments)
  {
    $this->comments = $comments;
  }

  public function compose(View $view)
  {
    return $view->with('recent_comments', $this->comments::with('user', 'post:id')->where('approved', 1)->take(8)->latest()->get());
  }
}
