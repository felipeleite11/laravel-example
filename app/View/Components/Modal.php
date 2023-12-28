<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $content, $open)
    {
        $this->title = $title;
        $this->content = $content;
        $this->open = $open;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal', [
            'title' => $this->title,
            'content' => $this->content,
            'open' => $this->open
        ]);
    }
}
