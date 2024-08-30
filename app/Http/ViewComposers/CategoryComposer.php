<?php

namespace App\Http\ViewComposers;

use App\Repositories\UserRepository;
use Illuminate\View\View;
use App\Models\Category;
use App\Models\Post;

class CategoryComposer
{
  protected $categories;
  protected $posts_number;

  public function __construct(Category $categories, Post $posts_number)
  {
    $this->categories = $categories;
    $this->posts_number = $posts_number;
  }

  public function compose(View $view)
  {
    $view->with('categories', $this->categories->all())->with('posts_number', $this->posts_number->whereApproved(1)->count());
  }
}
