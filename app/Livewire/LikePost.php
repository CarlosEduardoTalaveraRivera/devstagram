<?php

namespace App\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    public $post;
    public $isLiked;
    public $likes;

    public function mount($post)
    {
        $this->isLiked = $post->checkLikeByUser(auth()->user());
        $this->likes = $post->likes->count();
    }

    public function like()
    {
        if($this->post->checkLikeByUser(auth()->user())) {
            $this->post->likes()->where('user_id', auth()->user()->id)->delete();
            $this->isLiked = false;
            $this->likes--;
        } else {
            $this->post->likes()->create([
                'user_id' => auth()->user()->id
            ]);
            $this->isLiked = true;
            $this->likes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
